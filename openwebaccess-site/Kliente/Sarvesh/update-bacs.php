<?php
/**
 * Update WooCommerce BACS (EFT) bank account details
 * One-time script - delete after use
 */

// Bootstrap WordPress
define('ABSPATH', dirname(__FILE__) . '/');
require_once ABSPATH . 'wp-load.php';

// New bank details from image
$accounts = array(
    array(
        'account_name'   => 'Omshri Pty Ltd',
        'account_number' => '63005198840',
        'bank_name'      => 'First National Bank',
        'sort_code'      => '222926',
        'iban'           => '',
        'bic'            => 'FIRNZAJJ',
    ),
);

// Update the BACS accounts option
update_option('woocommerce_bacs_accounts', $accounts);

// Also ensure BACS gateway is enabled with proper settings
$bacs_settings = get_option('woocommerce_bacs_settings', array());

// Show current state
echo "<h2>WooCommerce BACS (EFT) Bank Details Updated</h2>";
echo "<pre>";
echo "Bank: First National Bank\n";
echo "Account Name: Omshri Pty Ltd\n";
echo "Account Type: Business Account\n";
echo "Account Number: 63005198840\n";
echo "Branch: Chatsworth 514\n";
echo "Branch Code: 222926\n";
echo "Swift Code: FIRNZAJJ\n\n";

echo "BACS Gateway Status: " . ($bacs_settings['enabled'] ?? 'not set') . "\n";

// Enable the gateway if not already
if (empty($bacs_settings['enabled']) || $bacs_settings['enabled'] !== 'yes') {
    $bacs_settings['enabled'] = 'yes';
    $bacs_settings['title'] = $bacs_settings['title'] ?? 'EFT Payment';
    $bacs_settings['description'] = $bacs_settings['description'] ?? 'Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will be processed once the funds have cleared in our account.';
    update_option('woocommerce_bacs_settings', $bacs_settings);
    echo "BACS Gateway: ENABLED\n";
}

// Verify
$saved = get_option('woocommerce_bacs_accounts');
echo "\nVerification - Saved accounts:\n";
print_r($saved);
echo "</pre>";

echo "<p><strong>Done! Delete this file from the server.</strong></p>";
