<?php
/**
 * Contact Form Handler
 * Back on Track Chiropractic & Wellness
 */

header('Content-Type: application/json; charset=utf-8');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Rate limiting via session
session_start();
$now = time();
if (isset($_SESSION['last_submit']) && ($now - $_SESSION['last_submit']) < 30) {
    echo json_encode(['success' => false, 'message' => 'Please wait a moment before sending another message.']);
    exit;
}

// Honeypot check
if (!empty($_POST['website'])) {
    echo json_encode(['success' => true, 'message' => 'Thank you for your message!']);
    exit;
}

// Sanitize inputs
$firstName = trim(strip_tags($_POST['firstName'] ?? ''));
$lastName  = trim(strip_tags($_POST['lastName'] ?? ''));
$email     = trim(strip_tags($_POST['email'] ?? ''));
$phone     = trim(strip_tags($_POST['phone'] ?? ''));
$service   = trim(strip_tags($_POST['service'] ?? ''));
$message   = trim(strip_tags($_POST['message'] ?? ''));

// Validate required fields
if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// Validate lengths
if (strlen($firstName) > 100 || strlen($lastName) > 100 || strlen($email) > 200 || strlen($message) > 5000) {
    echo json_encode(['success' => false, 'message' => 'Input exceeds maximum allowed length.']);
    exit;
}

// Prevent header injection
foreach ([$firstName, $lastName, $email, $phone] as $field) {
    if (preg_match('/[\r\n]/', $field)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input detected.']);
        exit;
    }
}

// Service mapping
$serviceNames = [
    'chiropractic'   => 'Chiropractic Adjustment',
    'rehabilitation' => 'Rehabilitation',
    'red-light'      => 'Red Light Therapy',
    'posture'        => 'Postural Assessment',
    'wellness'       => 'Wellness Programme',
    'sports'         => 'Sports Injury',
    'other'          => 'Other',
];
$serviceName = $serviceNames[$service] ?? 'Not specified';

// Build email
$to = 'dr.srmaharajh@gmail.com';
$subject = "New Enquiry from {$firstName} {$lastName} - Back on Track Website";

$body  = "New website enquiry received:\n\n";
$body .= "Name: {$firstName} {$lastName}\n";
$body .= "Email: {$email}\n";
$body .= "Phone: " . ($phone ?: 'Not provided') . "\n";
$body .= "Service: {$serviceName}\n\n";
$body .= "Message:\n{$message}\n\n";
$body .= "---\n";
$body .= "Sent from backontrackwellness.co.za contact form\n";
$body .= "Date: " . date('Y-m-d H:i:s') . "\n";

$headers  = "From: noreply@backontrackwellness.co.za\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "X-Mailer: BackOnTrack-Contact-Form\r\n";

// Send email
$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    $_SESSION['last_submit'] = $now;
    echo json_encode(['success' => true, 'message' => 'Thank you! Your message has been sent successfully. Dr Maharajh will get back to you soon.']);
} else {
    echo json_encode(['success' => false, 'message' => 'There was an issue sending your message. Please try calling us at +27 84 888 8308.']);
}
