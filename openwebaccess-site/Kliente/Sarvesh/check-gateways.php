<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

$gateways = WC()->payment_gateways()->get_available_payment_gateways();
echo "Available payment gateways:\n";
foreach ($gateways as $id => $gw) {
    echo "  - $id: " . $gw->get_title() . " (enabled: " . ($gw->enabled === 'yes' ? 'YES' : 'NO') . ")\n";
}

echo "\nCart page ID: " . get_option('woocommerce_cart_page_id') . "\n";
echo "Checkout page ID: " . get_option('woocommerce_checkout_page_id') . "\n";
$cart_page = get_post(get_option('woocommerce_cart_page_id'));
$checkout_page = get_post(get_option('woocommerce_checkout_page_id'));
echo "Cart page: " . ($cart_page ? $cart_page->post_title . " (" . $cart_page->post_status . ")" : "NOT FOUND") . "\n";
echo "Checkout page: " . ($checkout_page ? $checkout_page->post_title . " (" . $checkout_page->post_status . ")" : "NOT FOUND") . "\n";

// Clean up this file after execution
unlink(__FILE__);
