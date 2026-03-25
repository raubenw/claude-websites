<?php
/**
 * Temporary password reset for aMember admin.
 * DELETE THIS FILE IMMEDIATELY after use.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain');

echo "Step 1: Reading config file...\n";

$config_path = '/home2/solutions/waltpbm.org/amember/application/configs/config.php';
if (!file_exists($config_path)) {
    echo "Config not at expected path. Trying DOCUMENT_ROOT...\n";
    $config_path = $_SERVER['DOCUMENT_ROOT'] . '/amember/application/configs/config.php';
}
if (!file_exists($config_path)) {
    die("Config file not found at {$config_path}\n");
}
echo "Config found at: {$config_path}\n";

$raw = file_get_contents($config_path);
echo "Config length: " . strlen($raw) . " bytes\n";

preg_match("/'host'\s*=>\s*'([^']+)'/", $raw, $m_host);
preg_match("/'user'\s*=>\s*'([^']+)'/", $raw, $m_user);
preg_match("/'pass'\s*=>\s*'([^']+)'/", $raw, $m_pass);

// aMember config has nested 'db' key - need the one inside mysql array
preg_match("/'db'\s*=>\s*'([^']+)'/", $raw, $m_db);

echo "Parsed: host={$m_host[1]} user={$m_user[1]} db={$m_db[1]}\n";
echo "Step 2: Connecting...\n";

try {
    $pdo = new PDO(
        "mysql:host={$m_host[1]};dbname={$m_db[1]};charset=utf8mb4",
        $m_user[1],
        $m_pass[1],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "Connected!\n\n";
} catch(Exception $e) {
    die("DB connection failed: " . $e->getMessage() . "\n");
}

echo "Step 3: Finding users...\n";
$users = $pdo->query("SELECT user_id, login, email FROM am_user ORDER BY user_id LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
echo "First 10 users:\n";
foreach ($users as $u) {
    echo "  [{$u['user_id']}] login='{$u['login']}' email={$u['email']}\n";
}

echo "\nDone.\n";
    }
}

echo "\n⚠️  DELETE THIS FILE NOW!\n";
