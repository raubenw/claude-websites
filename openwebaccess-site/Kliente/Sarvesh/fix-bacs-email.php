<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

// Fix BACS instructions
$bacs_settings = get_option('woocommerce_bacs_settings', array());
$bacs_settings['instructions'] = "Please make your EFT payment to the following bank account:\n\nBank: First National Bank\nAccount Name: Omshri Pty Ltd\nAccount Type: Business Account\nAccount Number: 63005198840\nBranch: Chatsworth 514\nBranch Code: 222926\nSwift Code: FIRNZAJJ\n\nPlease use your Order ID as the payment reference. Your order will be processed once we have confirmed your payment.";
update_option('woocommerce_bacs_settings', $bacs_settings);
echo "BACS instructions updated.\n";

// Fix email from name
update_option('woocommerce_email_from_name', 'Back on Track Chiropractic & Wellness');
echo "From name set.\n";

// Fix admin email recipient
$new_order_settings = get_option('woocommerce_new_order_settings', array());
$new_order_settings['recipient'] = 'backontrackwellness13@gmail.com';
update_option('woocommerce_new_order_settings', $new_order_settings);
echo "New order email recipient updated.\n";

// Verify
$verify = get_option('woocommerce_bacs_settings');
echo "\nVerify BACS instructions: " . substr($verify['instructions'], 0, 60) . "...\n";
echo "Verify from name: " . get_option('woocommerce_email_from_name') . "\n";

// Clean up
unlink(__FILE__);
