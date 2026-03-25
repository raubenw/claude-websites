<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

echo "=== THE COURIER GUY SETTINGS ===\n\n";

// Check all TCG-related options
global $wpdb;
$results = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->prefix}options WHERE option_name LIKE '%courier%' OR option_name LIKE '%tcg%' OR option_name LIKE '%shiplogic%' OR option_name LIKE '%the_courier_guy%'", ARRAY_A);

echo "TCG Options found: " . count($results) . "\n\n";
foreach ($results as $row) {
    $val = $row['option_value'];
    if (strlen($val) > 500) {
        $val = substr($val, 0, 500) . '... [truncated]';
    }
    echo $row['option_name'] . " = " . $val . "\n\n";
}

// Check WooCommerce shipping zones
echo "\n=== SHIPPING ZONES ===\n";
$zones = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_shipping_zones", ARRAY_A);
echo "Zones: " . count($zones) . "\n";
foreach ($zones as $z) {
    echo "  Zone #{$z['zone_id']}: {$z['zone_name']} (order: {$z['zone_order']})\n";
}

// Check shipping zone methods  
echo "\n=== SHIPPING ZONE METHODS ===\n";
$methods = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_shipping_zone_methods", ARRAY_A);
echo "Methods: " . count($methods) . "\n";
foreach ($methods as $m) {
    echo "  Zone {$m['zone_id']} -> Method: {$m['method_id']} (instance: {$m['instance_id']}, enabled: {$m['is_enabled']})\n";
}

// Check if TCG plugin is active
$active_plugins = get_option('active_plugins', array());
echo "\n=== ACTIVE PLUGINS (courier related) ===\n";
foreach ($active_plugins as $p) {
    if (stripos($p, 'courier') !== false || stripos($p, 'tcg') !== false || stripos($p, 'ship') !== false) {
        echo "  $p\n";
    }
}

// Check WooCommerce shipping settings
echo "\n=== WOOCOMMERCE SHIPPING SETTINGS ===\n";
echo "Store address: " . get_option('woocommerce_store_address') . "\n";
echo "Store address 2: " . get_option('woocommerce_store_address_2') . "\n";
echo "Store city: " . get_option('woocommerce_store_city') . "\n";
echo "Store postcode: " . get_option('woocommerce_store_postcode') . "\n";
echo "Store state: " . get_option('woocommerce_store_state') . "\n";
echo "Store country: " . get_option('woocommerce_default_country') . "\n";
echo "Currency: " . get_option('woocommerce_currency') . "\n";

// Check TCG shipping method settings (stored as woocommerce_the_courier_guy_X_settings)
echo "\n=== TCG METHOD INSTANCE SETTINGS ===\n";
foreach ($methods as $m) {
    if (strpos($m['method_id'], 'courier') !== false || strpos($m['method_id'], 'tcg') !== false) {
        $key = "woocommerce_{$m['method_id']}_{$m['instance_id']}_settings";
        $settings = get_option($key, array());
        echo "Settings key: $key\n";
        if (is_array($settings)) {
            foreach ($settings as $k => $v) {
                if (stripos($k, 'pass') !== false || stripos($k, 'secret') !== false) {
                    echo "  $k = [REDACTED]\n";
                } else {
                    echo "  $k = $v\n";
                }
            }
        }
        echo "\n";
    }
}

// Check main TCG settings option
echo "\n=== MAIN TCG SETTINGS ===\n";
$tcg_settings = get_option('woocommerce_the_courier_guy_settings', array());
if (is_array($tcg_settings) && !empty($tcg_settings)) {
    foreach ($tcg_settings as $k => $v) {
        if (stripos($k, 'pass') !== false || stripos($k, 'secret') !== false || stripos($k, 'key') !== false) {
            echo "  $k = " . (empty($v) ? '[EMPTY]' : '[SET - ' . strlen($v) . ' chars]') . "\n";
        } else {
            echo "  $k = $v\n";
        }
    }
} else {
    echo "  No settings found or empty\n";
}

unlink(__FILE__);
