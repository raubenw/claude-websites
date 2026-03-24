<?php
/**
 * WALT Membership Verification Tool
 * For ALD-WALT-NAALT 2026 Joint Conference
 * 
 * Authorized conference organizers can verify whether someone
 * is an active WALT member (eligible for reduced registration rate).
 * 
 * Built by DijiSol Solutions - March 2026
 */

session_start();

// ─── Configuration ───────────────────────────────────────────

// Access code for conference organizers (change as needed)
define('ACCESS_CODE', 'WALT-ALD-2026');

// Session timeout in seconds (2 hours)
define('SESSION_TIMEOUT', 7200);

// Rate limiting: max lookups per session per hour
define('MAX_LOOKUPS_PER_HOUR', 60);

// WALT membership product IDs (not webinars/events)
define('MEMBERSHIP_PRODUCT_IDS', [1, 2, 3, 4, 7]);

// ─── Database Connection ─────────────────────────────────────

function get_db_connection() {
    static $pdo = null;
    if ($pdo !== null) return $pdo;
    
    $config_path = $_SERVER['DOCUMENT_ROOT'] . '/amember/application/configs/config.php';
    if (!file_exists($config_path)) {
        return null;
    }
    
    $config = include($config_path);
    $db = $config['db']['mysql'];
    
    $pdo = new PDO(
        "mysql:host={$db['host']};dbname={$db['db']};charset=utf8mb4",
        $db['user'],
        $db['pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
    
    return $pdo;
}

// ─── Functions ───────────────────────────────────────────────

/**
 * Check if a user has active membership by email.
 */
function check_membership_by_email($email) {
    $pdo = get_db_connection();
    if (!$pdo) {
        return ['error' => 'Unable to connect to membership system'];
    }
    
    // Find user by email
    $stmt = $pdo->prepare("SELECT user_id, email, name_f, name_l FROM am_user WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) {
        return [
            'found' => false,
            'active' => false,
            'message' => 'No member found with that email address.',
        ];
    }
    
    // Check for active membership access
    $access = get_active_membership($pdo, $user['user_id']);
    
    if ($access) {
        return [
            'found' => true,
            'active' => true,
            'email_masked' => mask_email($user['email']),
            'membership_tier' => $access['product_title'],
            'expire_date' => $access['expire_date'],
            'message' => 'Active WALT member',
        ];
    }
    
    return [
        'found' => true,
        'active' => false,
        'email_masked' => mask_email($user['email']),
        'message' => 'Member found but subscription is not currently active.',
    ];
}

/**
 * Search for users by name and check their membership.
 */
function check_membership_by_name($name) {
    $pdo = get_db_connection();
    if (!$pdo) {
        return ['error' => 'Unable to connect to membership system'];
    }
    
    $parts = preg_split('/\s+/', trim($name), 2);
    
    if (count($parts) >= 2) {
        // First + last name search
        $stmt = $pdo->prepare("
            SELECT user_id, email, name_f, name_l FROM am_user 
            WHERE name_f LIKE ? AND name_l LIKE ?
            LIMIT 10
        ");
        $stmt->execute(['%' . $parts[0] . '%', '%' . $parts[1] . '%']);
    } else {
        // Single name - search in both first and last name
        $stmt = $pdo->prepare("
            SELECT user_id, email, name_f, name_l FROM am_user 
            WHERE name_f LIKE ? OR name_l LIKE ?
            LIMIT 10
        ");
        $stmt->execute(['%' . $parts[0] . '%', '%' . $parts[0] . '%']);
    }
    
    $users = $stmt->fetchAll();
    
    if (empty($users)) {
        return [
            'found' => false,
            'message' => 'No member found with that name.',
        ];
    }
    
    $members = [];
    foreach ($users as $user) {
        $access = get_active_membership($pdo, $user['user_id']);
        $members[] = [
            'name' => trim($user['name_f'] . ' ' . $user['name_l']),
            'email_masked' => mask_email($user['email']),
            'active' => $access !== null,
            'membership_tier' => $access ? $access['product_title'] : null,
            'expire_date' => $access ? $access['expire_date'] : null,
        ];
    }
    
    return [
        'found' => true,
        'members' => $members,
    ];
}

/**
 * Get active membership access for a user.
 * Returns the membership tier info or null if no active membership.
 */
function get_active_membership($pdo, $user_id) {
    $placeholders = implode(',', array_fill(0, count(MEMBERSHIP_PRODUCT_IDS), '?'));
    $params = array_merge([$user_id], MEMBERSHIP_PRODUCT_IDS);
    
    $stmt = $pdo->prepare("
        SELECT a.begin_date, a.expire_date, p.title AS product_title
        FROM am_access a
        JOIN am_product p ON a.product_id = p.product_id
        WHERE a.user_id = ?
          AND a.product_id IN ($placeholders)
          AND a.begin_date <= CURDATE()
          AND a.expire_date >= CURDATE()
        ORDER BY a.expire_date DESC
        LIMIT 1
    ");
    $stmt->execute($params);
    
    return $stmt->fetch() ?: null;
}

/**
 * Mask an email address for privacy (show first 2 chars + domain).
 */
function mask_email($email) {
    $parts = explode('@', $email);
    if (count($parts) !== 2) return '***';
    $local = $parts[0];
    $masked = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 3));
    return $masked . '@' . $parts[1];
}

/**
 * Rate limiting check.
 */
function check_rate_limit() {
    if (!isset($_SESSION['lookup_times'])) {
        $_SESSION['lookup_times'] = [];
    }
    
    $now = time();
    // Remove entries older than 1 hour
    $_SESSION['lookup_times'] = array_filter(
        $_SESSION['lookup_times'],
        function($t) use ($now) { return ($now - $t) < 3600; }
    );
    
    if (count($_SESSION['lookup_times']) >= MAX_LOOKUPS_PER_HOUR) {
        return false;
    }
    
    $_SESSION['lookup_times'][] = $now;
    return true;
}

// ─── Session & Auth Handling ─────────────────────────────────

// Check session timeout
if (isset($_SESSION['auth_time']) && (time() - $_SESSION['auth_time']) > SESSION_TIMEOUT) {
    session_destroy();
    session_start();
}

$is_authenticated = !empty($_SESSION['authenticated']);
$error = '';
$result = null;
$search_query = '';
$search_type = 'email';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['access_code'])) {
    $submitted_code = trim($_POST['access_code'] ?? '');
    if (hash_equals(ACCESS_CODE, $submitted_code)) {
        $_SESSION['authenticated'] = true;
        $_SESSION['auth_time'] = time();
        $is_authenticated = true;
    } else {
        $error = 'Invalid access code. Please try again.';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

// Handle membership lookup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_query']) && $is_authenticated) {
    if (!check_rate_limit()) {
        $error = 'Too many lookups. Please wait before trying again.';
    } else {
        $search_query = trim($_POST['search_query'] ?? '');
        $search_type = ($_POST['search_type'] ?? 'email') === 'name' ? 'name' : 'email';
        
        if (empty($search_query)) {
            $error = 'Please enter an email address or name to search.';
        } elseif ($search_type === 'email') {
            if (!filter_var($search_query, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                $result = check_membership_by_email($search_query);
            }
        } else {
            if (strlen($search_query) < 2) {
                $error = 'Please enter at least 2 characters for name search.';
            } else {
                $result = check_membership_by_name($search_query);
            }
        }
    }
}

// ─── CSRF Token ──────────────────────────────────────────────
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>WALT Membership Verification</title>
    <style>
        :root {
            --walt-blue: #1a3a5c;
            --walt-blue-light: #2c5a8f;
            --walt-gold: #c9a227;
            --walt-green: #28a745;
            --walt-red: #dc3545;
            --walt-orange: #fd7e14;
            --walt-gray: #6c757d;
            --walt-light: #f8f9fa;
            --walt-border: #dee2e6;
            --shadow: 0 4px 24px rgba(0,0,0,0.08);
            --radius: 12px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 520px;
        }

        .card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--walt-blue) 0%, var(--walt-blue-light) 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .card-header img {
            width: 80px;
            height: auto;
            margin-bottom: 12px;
        }

        .card-header h1 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .card-header p {
            font-size: 0.85rem;
            opacity: 0.85;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--walt-blue);
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--walt-border);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        input:focus {
            border-color: var(--walt-blue-light);
            box-shadow: 0 0 0 3px rgba(44, 90, 143, 0.15);
        }

        .search-type-toggle {
            display: flex;
            gap: 0;
            margin-bottom: 18px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--walt-border);
        }

        .search-type-toggle label {
            flex: 1;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            background: var(--walt-light);
            margin: 0;
            font-size: 0.85rem;
            transition: all 0.2s;
            border: none;
        }

        .search-type-toggle input {
            display: none;
        }

        .search-type-toggle input:checked + label {
            background: var(--walt-blue);
            color: white;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--walt-blue) 0%, var(--walt-blue-light) 100%);
            color: white;
        }

        .btn-logout {
            display: inline-block;
            padding: 6px 14px;
            font-size: 0.8rem;
            background: transparent;
            color: var(--walt-gray);
            border: 1px solid var(--walt-border);
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 16px;
        }

        .btn-logout:hover {
            background: var(--walt-light);
            color: var(--walt-red);
            border-color: var(--walt-red);
        }

        /* Result styles */
        .result {
            margin-top: 24px;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid;
        }

        .result-active {
            background: #f0fff4;
            border-color: var(--walt-green);
        }

        .result-inactive {
            background: #fff8e1;
            border-color: var(--walt-orange);
        }

        .result-notfound {
            background: #fff5f5;
            border-color: var(--walt-red);
        }

        .result-error {
            background: #fff5f5;
            border-color: var(--walt-red);
        }

        .result-icon {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .result h3 {
            font-size: 1.05rem;
            margin-bottom: 4px;
        }

        .result p {
            font-size: 0.9rem;
            color: var(--walt-gray);
        }

        .result .member-name {
            font-weight: 600;
            color: #333;
        }

        .result .member-email {
            font-size: 0.8rem;
            color: var(--walt-gray);
        }

        .member-list {
            list-style: none;
            padding: 0;
        }

        .member-list li {
            padding: 12px 0;
            border-bottom: 1px solid var(--walt-border);
        }

        .member-list li:last-child {
            border-bottom: none;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-active {
            background: var(--walt-green);
            color: white;
        }

        .badge-inactive {
            background: var(--walt-orange);
            color: white;
        }

        .error-msg {
            background: #fff5f5;
            color: var(--walt-red);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 18px;
            border: 1px solid #fecdd3;
        }

        .footer {
            text-align: center;
            padding: 16px;
            font-size: 0.75rem;
            color: var(--walt-gray);
        }

        .conference-badge {
            display: inline-block;
            background: var(--walt-gold);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>WALT Membership Verification</h1>
                <p>
                    <span class="conference-badge">ALD-WALT-NAALT 2026</span>
                    <br>Conference Registration Eligibility Check
                </p>
            </div>

            <div class="card-body">
                <?php if (!$is_authenticated): ?>
                    <!-- ─── Login Form ─── -->
                    <p style="font-size: 0.9rem; color: var(--walt-gray); margin-bottom: 20px;">
                        This tool is restricted to authorized conference organizers.
                        Enter your access code to proceed.
                    </p>

                    <?php if ($error): ?>
                        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" autocomplete="off">
                        <div class="form-group">
                            <label for="access_code">Access Code</label>
                            <input type="password" id="access_code" name="access_code" 
                                   placeholder="Enter your access code" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary">Verify Access</button>
                    </form>

                <?php else: ?>
                    <!-- ─── Membership Lookup Form ─── -->
                    <?php if ($error): ?>
                        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" autocomplete="off">
                        <div class="search-type-toggle">
                            <input type="radio" name="search_type" value="email" id="type-email" 
                                   <?php echo $search_type === 'email' ? 'checked' : ''; ?>>
                            <label for="type-email">Search by Email</label>
                            <input type="radio" name="search_type" value="name" id="type-name"
                                   <?php echo $search_type === 'name' ? 'checked' : ''; ?>>
                            <label for="type-name">Search by Name</label>
                        </div>

                        <div class="form-group">
                            <label for="search_query" id="search-label">
                                <?php echo $search_type === 'name' ? 'Member Name' : 'Member Email'; ?>
                            </label>
                            <input type="text" id="search_query" name="search_query" 
                                   placeholder="<?php echo $search_type === 'name' ? 'e.g. John Smith' : 'e.g. member@example.com'; ?>"
                                   value="<?php echo htmlspecialchars($search_query); ?>"
                                   required autofocus>
                        </div>

                        <button type="submit" class="btn btn-primary">Check Membership</button>
                    </form>

                    <?php if ($result): ?>
                        <?php if (isset($result['error'])): ?>
                            <div class="result result-error">
                                <div class="result-icon">&#9888;</div>
                                <h3>System Error</h3>
                                <p><?php echo htmlspecialchars($result['error']); ?></p>
                            </div>

                        <?php elseif (isset($result['members'])): ?>
                            <!-- Multiple results (name search) -->
                            <?php 
                            $has_active = false;
                            foreach ($result['members'] as $m) {
                                if ($m['active']) { $has_active = true; break; }
                            }
                            ?>
                            <div class="result <?php echo $has_active ? 'result-active' : 'result-inactive'; ?>">
                                <div class="result-icon"><?php echo $has_active ? '&#9989;' : '&#9888;'; ?></div>
                                <h3><?php echo count($result['members']); ?> member(s) found</h3>
                                <ul class="member-list">
                                    <?php foreach ($result['members'] as $member): ?>
                                        <li>
                                            <span class="member-name"><?php echo htmlspecialchars($member['name']); ?></span>
                                            <span class="member-email"><?php echo htmlspecialchars($member['email_masked']); ?></span>
                                            <br>
                                            <span class="status-badge <?php echo $member['active'] ? 'badge-active' : 'badge-inactive'; ?>">
                                                <?php echo $member['active'] ? '&#10003; Active Member' : '&#10007; Not Active'; ?>
                                            </span>
                                            <?php if ($member['active'] && !empty($member['membership_tier'])): ?>
                                                <span style="font-size: 0.8rem; color: var(--walt-gray); margin-left: 8px;">
                                                    <?php echo htmlspecialchars($member['membership_tier']); ?>
                                                    <?php if (!empty($member['expire_date'])): ?>
                                                        (until <?php echo htmlspecialchars($member['expire_date']); ?>)
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        <?php elseif ($result['found'] && !empty($result['active'])): ?>
                            <div class="result result-active">
                                <div class="result-icon">&#9989;</div>
                                <h3>Active WALT Member</h3>
                                <p>This person has an active WALT membership and is eligible for the reduced conference registration rate.</p>
                                <p class="member-email" style="margin-top: 8px;"><?php echo htmlspecialchars($result['email_masked']); ?></p>
                                <?php if (!empty($result['membership_tier'])): ?>
                                    <p style="margin-top: 6px; font-size: 0.85rem; color: #333;">
                                        <strong>Tier:</strong> <?php echo htmlspecialchars($result['membership_tier']); ?>
                                        <?php if (!empty($result['expire_date'])): ?>
                                            &mdash; <strong>Valid until:</strong> <?php echo htmlspecialchars($result['expire_date']); ?>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                        <?php elseif ($result['found'] && empty($result['active'])): ?>
                            <div class="result result-inactive">
                                <div class="result-icon">&#9888;</div>
                                <h3>Membership Not Active</h3>
                                <p><?php echo htmlspecialchars($result['message']); ?></p>
                                <p class="member-email" style="margin-top: 8px;"><?php echo htmlspecialchars($result['email_masked']); ?></p>
                            </div>

                        <?php else: ?>
                            <div class="result result-notfound">
                                <div class="result-icon">&#10060;</div>
                                <h3>Not Found</h3>
                                <p><?php echo htmlspecialchars($result['message']); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div style="text-align: center;">
                        <a href="?logout=1" class="btn-logout">Log Out</a>
                    </div>

                <?php endif; ?>
            </div>

            <div class="footer">
                &copy; <?php echo date('Y'); ?> World Association for PhotobiomoduLation Therapy
            </div>
        </div>
    </div>

    <script>
        // Toggle search type and update label/placeholder
        document.querySelectorAll('input[name="search_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var label = document.getElementById('search-label');
                var input = document.getElementById('search_query');
                if (this.value === 'name') {
                    label.textContent = 'Member Name';
                    input.placeholder = 'e.g. John Smith';
                    input.type = 'text';
                } else {
                    label.textContent = 'Member Email';
                    input.placeholder = 'e.g. member@example.com';
                    input.type = 'email';
                }
                input.value = '';
                input.focus();
            });
        });
    </script>
</body>
</html>
