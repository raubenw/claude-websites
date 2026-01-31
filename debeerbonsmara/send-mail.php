<?php
/**
 * De Beer Bonsmara Contact Form Handler
 * Sends form submissions to subscribe@debeerbonsmara.com
 */

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Configuration
$to_email = 'subscribe@debeerbonsmara.com';
$site_name = 'De Beer Bonsmara';

// Get and sanitize form data
$form_type = isset($_POST['form_type']) ? htmlspecialchars($_POST['form_type']) : 'contact';
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
$subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

// Validate required fields
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address']);
    exit();
}

// Determine email subject and content based on form type
if ($form_type === 'newsletter') {
    // Newsletter subscription
    $email_subject = "[{$site_name}] New Newsletter Subscription";
    $email_body = "
    ========================================
    NEW NEWSLETTER SUBSCRIPTION
    ========================================
    
    Email: {$email}
    Name: " . ($name ? $name : 'Not provided') . "
    
    Submitted: " . date('Y-m-d H:i:s') . "
    IP Address: {$_SERVER['REMOTE_ADDR']}
    
    ========================================
    This person has subscribed to your newsletter.
    ========================================
    ";
} else {
    // Contact form
    if (empty($name)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Please provide your name']);
        exit();
    }
    
    $email_subject = "[{$site_name}] " . ($subject ? $subject : 'New Contact Form Message');
    $email_body = "
    ========================================
    NEW CONTACT FORM MESSAGE
    ========================================
    
    Name: {$name}
    Email: {$email}
    Phone: " . ($phone ? $phone : 'Not provided') . "
    Subject: " . ($subject ? $subject : 'Not provided') . "
    
    MESSAGE:
    ----------------------------------------
    {$message}
    ----------------------------------------
    
    Submitted: " . date('Y-m-d H:i:s') . "
    IP Address: {$_SERVER['REMOTE_ADDR']}
    
    ========================================
    Reply directly to this email to respond.
    ========================================
    ";
}

// Email headers
$headers = [
    'From: noreply@debeerbonsmara.com',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8'
];

// Send email
$mail_sent = mail($to_email, $email_subject, $email_body, implode("\r\n", $headers));

if ($mail_sent) {
    echo json_encode([
        'success' => true, 
        'message' => $form_type === 'newsletter' 
            ? 'Thank you for subscribing! We\'ll keep you updated.' 
            : 'Thank you for your message! We\'ll get back to you soon.'
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Sorry, there was an error sending your message. Please try again or email us directly.']);
}
?>
