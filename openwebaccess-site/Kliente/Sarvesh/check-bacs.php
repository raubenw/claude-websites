<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

// Check BACS gateway settings
$bacs = new WC_Gateway_BACS();
echo "=== BACS Gateway Settings ===\n";
echo "Enabled: " . $bacs->enabled . "\n";
echo "Title: " . $bacs->title . "\n";
echo "Description: " . $bacs->description . "\n";
echo "Instructions: " . $bacs->instructions . "\n";

// Check accounts
$accounts = get_option('woocommerce_bacs_accounts', array());
echo "\n=== Bank Accounts ===\n";
foreach ($accounts as $acc) {
    echo "  Bank: " . ($acc['bank_name'] ?? '') . "\n";
    echo "  Name: " . ($acc['account_name'] ?? '') . "\n";
    echo "  Number: " . ($acc['account_number'] ?? '') . "\n";
    echo "  Sort/Branch: " . ($acc['sort_code'] ?? '') . "\n";
    echo "  IBAN: " . ($acc['iban'] ?? '') . "\n";
    echo "  BIC/Swift: " . ($acc['bic'] ?? '') . "\n\n";
}

// Check email settings
echo "=== WooCommerce Email Settings ===\n";
echo "From name: " . get_option('woocommerce_email_from_name') . "\n";
echo "From address: " . get_option('woocommerce_email_from_address') . "\n";

// Check on-hold email
$mailer = WC()->mailer();
$emails = $mailer->get_emails();
foreach ($emails as $email) {
    if ($email->id === 'customer_on_hold_order') {
        echo "\n=== On-Hold Order Email ===\n";
        echo "Enabled: " . $email->enabled . "\n";
        echo "Subject: " . $email->get_subject() . "\n";
        echo "Heading: " . $email->get_heading() . "\n";
    }
    if ($email->id === 'new_order') {
        echo "\n=== New Order Admin Email ===\n";
        echo "Enabled: " . $email->enabled . "\n";
        echo "Recipient: " . $email->recipient . "\n";
    }
}

// Clean up
unlink(__FILE__);
