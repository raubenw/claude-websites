<?php
/**
 * DijiSol Waitlist Subscriber Handler
 * 
 * Bootstraps WordPress, stores subscriber emails in a custom table,
 * and sends a notification email to the site admin.
 * 
 * Place this file in the WordPress root directory (same level as wp-config.php).
 */

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Set JSON response header
header('Content-Type: application/json; charset=utf-8');

// Load WordPress (gives us $wpdb, wp_mail, sanitize_email, etc.)
define('SHORTINIT', false);
require_once __DIR__ . '/wp-load.php';

// ─── Read and validate input ─────────────────────────────────────────

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['email'])) {
    wp_send_json(['success' => false, 'message' => 'Email address is required.'], 400);
}

$email = sanitize_email($input['email']);

if (!is_email($email)) {
    wp_send_json(['success' => false, 'message' => 'Please provide a valid email address.'], 400);
}

// ─── Ensure the subscribers table exists ─────────────────────────────

global $wpdb;
$table_name = $wpdb->prefix . 'dijisol_subscribers';

// Create table if it doesn't exist (runs only once, then skipped)
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        subscribed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        ip_address VARCHAR(45) DEFAULT NULL,
        status VARCHAR(20) DEFAULT 'active',
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

// ─── Check for duplicate ─────────────────────────────────────────────

$existing = $wpdb->get_var(
    $wpdb->prepare("SELECT id FROM $table_name WHERE email = %s", $email)
);

if ($existing) {
    wp_send_json(['success' => true, 'message' => "You're already on the list! We'll keep you posted."]);
}

// ─── Insert new subscriber ──────────────────────────────────────────

$ip = $_SERVER['REMOTE_ADDR'] ?? '';

$inserted = $wpdb->insert(
    $table_name,
    [
        'email'         => $email,
        'subscribed_at' => current_time('mysql'),
        'ip_address'    => sanitize_text_field($ip),
        'status'        => 'active',
    ],
    ['%s', '%s', '%s', '%s']
);

if (!$inserted) {
    wp_send_json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
}

// ─── Send notification email to admin ────────────────────────────────

$admin_email = get_option('admin_email');
$subscriber_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");

$subject = 'New DijiSol Waitlist Subscriber!';
$body    = "New subscriber: $email\n\n"
         . "Total active subscribers: $subscriber_count\n"
         . "Subscribed at: " . current_time('mysql') . "\n"
         . "IP: $ip\n";

wp_mail($admin_email, $subject, $body);

// ─── Success response ────────────────────────────────────────────────

wp_send_json(['success' => true, 'message' => "Welcome aboard! You're subscriber #$subscriber_count."]);
