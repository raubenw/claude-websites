<?php
/**
 * MeHealth Contact Form Handler
 * Bootstraps WordPress to use wp_mail() for sending contact form emails.
 * 
 * Expects POST with: name, email, subject, message
 */

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Load WordPress
$wp_load = dirname(__FILE__) . '/../../../wp-load.php';
if (!file_exists($wp_load)) {
    // Try alternate common paths
    $wp_load = dirname(__FILE__) . '/../../wp-load.php';
}
if (!file_exists($wp_load)) {
    $wp_load = $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
}
if (!file_exists($wp_load)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server configuration error.']);
    exit;
}

require_once $wp_load;

// Set JSON header
header('Content-Type: application/json');

// Sanitize inputs
$name    = isset($_POST['name'])    ? sanitize_text_field($_POST['name'])    : '';
$email   = isset($_POST['email'])   ? sanitize_email($_POST['email'])       : '';
$subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : 'General Inquiry';
$message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!is_email($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// Map subject values to readable labels
$subject_labels = [
    'product-inquiry' => 'Product Inquiry',
    'custom-order'    => 'Custom Order',
    'wholesale'       => 'Wholesale Inquiry',
    'other'           => 'Other',
];
$subject_label = isset($subject_labels[$subject]) ? $subject_labels[$subject] : ucfirst($subject);

// Get admin email (WordPress site admin)
$admin_email = get_option('admin_email');

// Build email
$email_subject = sprintf('[MeHealth] %s from %s', $subject_label, $name);

$email_body = sprintf(
    "New contact form submission from MeHealth:\n\n" .
    "Name: %s\n" .
    "Email: %s\n" .
    "Subject: %s\n\n" .
    "Message:\n%s\n\n" .
    "---\n" .
    "Sent from mehealth.co.za contact form on %s",
    $name,
    $email,
    $subject_label,
    $message,
    date('Y-m-d H:i:s')
);

$headers = [
    'From: MeHealth <noreply@mehealth.co.za>',
    sprintf('Reply-To: %s <%s>', $name, $email),
];

// Send email via WordPress wp_mail
$sent = wp_mail($admin_email, $email_subject, $email_body, $headers);

if ($sent) {
    // Optional: store in database for record keeping
    global $wpdb;
    $table = $wpdb->prefix . 'mehealth_contacts';

    // Create table if it doesn't exist
    $wpdb->query("CREATE TABLE IF NOT EXISTS `{$table}` (
        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `subject` VARCHAR(255) DEFAULT '',
        `message` TEXT NOT NULL,
        `submitted_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $wpdb->insert($table, [
        'name'    => $name,
        'email'   => $email,
        'subject' => $subject_label,
        'message' => $message,
    ], ['%s', '%s', '%s', '%s']);

    echo json_encode(['success' => true, 'message' => 'Thanks for your message! Mariaan will get back to you soon.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try WhatsApp instead.']);
}
