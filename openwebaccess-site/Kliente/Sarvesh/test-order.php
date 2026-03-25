<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

// ============================================================
// CREATE A TEST ORDER to trigger WooCommerce emails
// ============================================================

// Build the order
$order = wc_create_order();

// Add products
$order->add_product(wc_get_product(23), 2); // 2x Lion's Mane @ R400
$order->add_product(wc_get_product(24), 1); // 1x Mushroom Caps @ R500

// Set addresses
$address = array(
    'first_name' => 'Werner',
    'last_name'  => 'Raubenheimer',
    'email'      => 'werner@dijisol.com',
    'phone'      => '+27843177073',
    'address_1'  => 'Birkin Valley Estate',
    'city'       => 'Ermelo',
    'state'      => 'MP',
    'postcode'   => '2351',
    'country'    => 'ZA',
);
$order->set_address($address, 'billing');
$order->set_address($address, 'shipping');

// Add shipping
$shipping = new WC_Order_Item_Shipping();
$shipping->set_method_title('Standard Delivery (Mpumalanga)');
$shipping->set_method_id('flat_rate');
$shipping->set_total(80);
$order->add_item($shipping);

// Set payment method to BACS
$order->set_payment_method('bacs');
$order->set_payment_method_title('EFT Payment');

// Calculate totals
$order->calculate_totals();

// Set status to on-hold (this is what BACS does - triggers the emails)
$order->update_status('on-hold', 'Test order - EFT awaiting payment.');

$order_id = $order->get_id();
$order_total = $order->get_total();

echo "=== TEST ORDER CREATED ===\n\n";
echo "Order ID: #$order_id\n";
echo "Order Total: R$order_total\n";
echo "Status: on-hold (awaiting EFT payment)\n";
echo "Payment Method: EFT Payment (BACS)\n\n";

// Now let's also capture what the emails contain
echo "=== EMAIL RECIPIENTS ===\n";
$mailer = WC()->mailer();
$emails = $mailer->get_emails();

echo "\nConfigured emails:\n";
foreach ($emails as $email_id => $email) {
    $enabled = $email->is_enabled() ? 'YES' : 'NO';
    $recipient = method_exists($email, 'get_recipient') ? $email->get_recipient() : 'customer';
    echo "  [$enabled] {$email->id}: {$email->title} -> $recipient\n";
}

// Manually trigger the on-hold email to make sure it sends
echo "\n=== TRIGGERING EMAILS ===\n";

// New order email (to admin)
if (isset($emails['WC_Email_New_Order'])) {
    $emails['WC_Email_New_Order']->trigger($order_id, $order);
    echo "New Order email triggered -> " . $emails['WC_Email_New_Order']->get_recipient() . "\n";
}

// On-hold email (to customer) - includes BACS bank details
if (isset($emails['WC_Email_Customer_On_Hold_Order'])) {
    $emails['WC_Email_Customer_On_Hold_Order']->trigger($order_id, $order);
    echo "Customer On-Hold email triggered -> " . $address['email'] . "\n";
}

// Let's also render the customer email HTML so you can see it
echo "\n=== CUSTOMER EMAIL PREVIEW ===\n";
echo "View the customer email at: " . admin_url("admin.php?page=wc-settings&tab=email") . "\n";
echo "Or visit: " . $order->get_checkout_order_received_url() . "\n";

// Generate the email HTML for preview
echo "\n=== THANK YOU PAGE URL ===\n";
echo $order->get_checkout_order_received_url() . "\n";

echo "\n=== ORDER DETAILS ===\n";
echo "Items:\n";
foreach ($order->get_items() as $item) {
    echo "  - {$item->get_name()} x{$item->get_quantity()} = R{$item->get_total()}\n";
}
echo "Shipping: R" . $order->get_shipping_total() . "\n";
echo "Total: R" . $order->get_total() . "\n";

echo "\n\nEmails have been sent to:\n";
echo "  Admin: backontrackwellness13@gmail.com (New Order notification)\n";
echo "  Customer: werner@dijisol.com (On-Hold order with bank details)\n";
echo "\nCheck both inboxes to see the emails!\n";

echo "\nTo delete this test order later, order ID is: $order_id\n";

unlink(__FILE__);
