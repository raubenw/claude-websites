<?php
/**
 * Back on Track Chiropractic & Wellness - Theme Functions
 */

// Theme Setup
function backontrack_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'backontrack_setup');

// Enqueue styles and scripts
function backontrack_scripts() {
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Raleway:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    
    // Theme stylesheet
    wp_enqueue_style('backontrack-style', get_stylesheet_uri(), array('google-fonts', 'font-awesome'), '1.0');
    
    // Main JS
    wp_enqueue_script('backontrack-main', get_template_directory_uri() . '/js/main.js', array(), '1.0', true);
    
    // Pass AJAX URL to JS
    wp_localize_script('backontrack-main', 'botAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('bot_contact_nonce'),
        'cartNonce' => wp_create_nonce('bot_cart_nonce'),
        'cartUrl' => wc_get_cart_url(),
    ));
}
add_action('wp_enqueue_scripts', 'backontrack_scripts');

// Contact form AJAX handler
function backontrack_contact_form() {
    check_ajax_referer('bot_contact_nonce', 'nonce');

    // Rate limiting via transient
    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    $rate_key = 'bot_contact_' . md5($ip);
    if (get_transient($rate_key)) {
        wp_send_json(array('success' => false, 'message' => 'Please wait a moment before sending another message.'));
    }

    // Honeypot
    if (!empty($_POST['website'])) {
        wp_send_json(array('success' => true, 'message' => 'Thank you for your message!'));
    }

    $firstName = sanitize_text_field($_POST['firstName'] ?? '');
    $lastName  = sanitize_text_field($_POST['lastName'] ?? '');
    $email     = sanitize_email($_POST['email'] ?? '');
    $phone     = sanitize_text_field($_POST['phone'] ?? '');
    $service   = sanitize_text_field($_POST['service'] ?? '');
    $message   = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
        wp_send_json(array('success' => false, 'message' => 'Please fill in all required fields.'));
    }

    if (!is_email($email)) {
        wp_send_json(array('success' => false, 'message' => 'Please enter a valid email address.'));
    }

    $serviceNames = array(
        'chiropractic'   => 'Chiropractic Adjustment',
        'rehabilitation' => 'Rehabilitation',
        'red-light'      => 'Red Light Therapy',
        'posture'        => 'Postural Assessment',
        'wellness'       => 'Wellness Programme',
        'sports'         => 'Sports Injury',
        'other'          => 'Other',
    );
    $serviceName = $serviceNames[$service] ?? 'Not specified';

    $to = 'backontrackwellness13@gmail.com';
    $subject = "New Enquiry from {$firstName} {$lastName} - Back on Track Website";

    $body  = "New website enquiry received:\n\n";
    $body .= "Name: {$firstName} {$lastName}\n";
    $body .= "Email: {$email}\n";
    $body .= "Phone: " . ($phone ?: 'Not provided') . "\n";
    $body .= "Service: {$serviceName}\n\n";
    $body .= "Message:\n{$message}\n\n";
    $body .= "---\n";
    $body .= "Sent from backontrackwellness.co.za contact form\n";

    $headers = array(
        'From: Back on Track <noreply@backontrackwellness.co.za>',
        'Reply-To: ' . $email,
    );

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        set_transient($rate_key, true, 30);
        wp_send_json(array('success' => true, 'message' => 'Thank you! Your message has been sent successfully. Dr Maharajh will get back to you soon.'));
    } else {
        wp_send_json(array('success' => false, 'message' => 'Something went wrong. Please try calling us at 066 087 3258 or emailing backontrackwellness13@gmail.com directly.'));
    }
}
add_action('wp_ajax_bot_contact', 'backontrack_contact_form');
add_action('wp_ajax_nopriv_bot_contact', 'backontrack_contact_form');

// AJAX add/remove cart handler
function backontrack_update_cart() {
    check_ajax_referer('bot_cart_nonce', 'nonce');

    $product_id = absint($_POST['product_id'] ?? 0);
    $action = sanitize_text_field($_POST['cart_action'] ?? '');

    if (!$product_id || !wc_get_product($product_id)) {
        wp_send_json(array('success' => false, 'message' => 'Invalid product.'));
    }

    if ($action === 'add') {
        WC()->cart->add_to_cart($product_id, 1);
    } elseif ($action === 'remove') {
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                if ($cart_item['quantity'] > 1) {
                    WC()->cart->set_quantity($cart_item_key, $cart_item['quantity'] - 1);
                } else {
                    WC()->cart->remove_cart_item($cart_item_key);
                }
                break;
            }
        }
    }

    // Get quantity for this product in cart
    $qty = 0;
    foreach (WC()->cart->get_cart() as $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            $qty = $cart_item['quantity'];
            break;
        }
    }

    wp_send_json(array(
        'success' => true,
        'qty' => $qty,
        'cart_total' => WC()->cart->get_cart_contents_count(),
    ));
}
add_action('wp_ajax_bot_update_cart', 'backontrack_update_cart');
add_action('wp_ajax_nopriv_bot_update_cart', 'backontrack_update_cart');
