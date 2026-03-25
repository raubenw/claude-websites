<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

echo "=== UPDATING STORE ADDRESS ===\n";
update_option('woocommerce_store_address', 'Vanadium str 10');
update_option('woocommerce_store_address_2', 'Mineralis');
update_option('woocommerce_store_city', 'Middelburg');
update_option('woocommerce_store_postcode', '1050');
update_option('woocommerce_default_country', 'ZA:MP');

echo "Store address: " . get_option('woocommerce_store_address') . "\n";
echo "Store address 2: " . get_option('woocommerce_store_address_2') . "\n";
echo "Store city: " . get_option('woocommerce_store_city') . "\n";
echo "Store postcode: " . get_option('woocommerce_store_postcode') . "\n";
echo "Store country: " . get_option('woocommerce_default_country') . "\n";

echo "\n=== SHIPPING ZONES ===\n";
$zones = WC_Shipping_Zones::get_zones();
echo "Number of zones: " . count($zones) . "\n";
foreach ($zones as $zone) {
    echo "  Zone: " . $zone['zone_name'] . " (ID: " . $zone['id'] . ")\n";
    echo "  Locations: ";
    foreach ($zone['zone_locations'] as $loc) {
        echo $loc->code . " (" . $loc->type . "), ";
    }
    echo "\n";
    echo "  Methods:\n";
    foreach ($zone['shipping_methods'] as $method) {
        echo "    - " . $method->id . ": " . $method->title . " (enabled: " . ($method->enabled === 'yes' ? 'YES' : 'NO') . ")\n";
    }
}

// Check zone 0 (rest of the world)
$zone0 = new WC_Shipping_Zone(0);
echo "\n  Zone: Rest of the World (ID: 0)\n";
$methods0 = $zone0->get_shipping_methods();
echo "  Methods:\n";
foreach ($methods0 as $method) {
    echo "    - " . $method->id . ": " . $method->title . " (enabled: " . ($method->enabled === 'yes' ? 'YES' : 'NO') . ")\n";
}

echo "\n=== ACTIVE PLUGINS ===\n";
$plugins = get_option('active_plugins');
foreach ($plugins as $p) {
    if (stripos($p, 'courier') !== false || stripos($p, 'ship') !== false) {
        echo "  $p\n";
    }
}

echo "\n=== ALL SHIPPING METHODS ===\n";
$all_methods = WC()->shipping()->get_shipping_methods();
foreach ($all_methods as $id => $method) {
    echo "  $id: " . $method->get_method_title() . " (enabled: " . ($method->enabled === 'yes' ? 'YES' : 'NO') . ")\n";
}

echo "\n=== COURIER GUY OPTIONS ===\n";
global $wpdb;
$cg_options = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE '%courier%' OR option_name LIKE '%tcg%' LIMIT 30");
foreach ($cg_options as $opt) {
    $val = strlen($opt->option_value) > 200 ? substr($opt->option_value, 0, 200) . '...' : $opt->option_value;
    echo "  {$opt->option_name}: $val\n";
}

echo "\n=== SELLING LOCATIONS ===\n";
echo "Allowed countries: " . get_option('woocommerce_allowed_countries') . "\n";
echo "Ship to countries: " . get_option('woocommerce_ship_to_countries') . "\n";
echo "Calc shipping: " . get_option('woocommerce_calc_shipping') . "\n";

// Clean up
unlink(__FILE__);
