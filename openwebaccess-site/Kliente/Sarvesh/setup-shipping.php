<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

// ============================================================
// 1. DEACTIVATE The Courier Guy + Shippo plugins
// ============================================================
$active_plugins = get_option('active_plugins', array());
$deactivated = array();
foreach ($active_plugins as $i => $plugin) {
    if (stripos($plugin, 'courier') !== false || stripos($plugin, 'shippo') !== false) {
        $deactivated[] = $plugin;
        unset($active_plugins[$i]);
    }
}
$active_plugins = array_values($active_plugins);
update_option('active_plugins', $active_plugins);
echo "=== DEACTIVATED PLUGINS ===\n";
foreach ($deactivated as $d) echo "  - $d\n";

// ============================================================
// 2. DELETE old shipping zone "Everywhere" and its methods
// ============================================================
global $wpdb;
$prefix = $wpdb->prefix;

// Remove old zone methods
$wpdb->query("DELETE FROM {$prefix}woocommerce_shipping_zone_methods");
// Remove old zones
$wpdb->query("DELETE FROM {$prefix}woocommerce_shipping_zones");
// Remove old zone locations
$wpdb->query("DELETE FROM {$prefix}woocommerce_shipping_zone_locations");
echo "\nOld shipping zones cleared.\n";

// ============================================================
// 3. CREATE SHIPPING ZONES BY PROVINCE
// ============================================================

// Zone 1: Mpumalanga (local - cheapest)
$wpdb->insert("{$prefix}woocommerce_shipping_zones", array(
    'zone_name' => 'Mpumalanga (Local)',
    'zone_order' => 1
));
$zone1_id = $wpdb->insert_id;
$wpdb->insert("{$prefix}woocommerce_shipping_zone_locations", array(
    'zone_id' => $zone1_id,
    'location_code' => 'ZA:MP',
    'location_type' => 'state'
));
$wpdb->insert("{$prefix}woocommerce_shipping_zone_methods", array(
    'zone_id' => $zone1_id,
    'method_id' => 'flat_rate',
    'method_order' => 1,
    'is_enabled' => 1
));
$mp_instance = $wpdb->insert_id;
update_option("woocommerce_flat_rate_{$mp_instance}_settings", array(
    'title' => 'Standard Delivery (Mpumalanga)',
    'tax_status' => 'taxable',
    'cost' => '80',
));
echo "\nZone: Mpumalanga (Local) - R80 flat rate (instance $mp_instance)\n";

// Zone 2: Gauteng
$wpdb->insert("{$prefix}woocommerce_shipping_zones", array(
    'zone_name' => 'Gauteng',
    'zone_order' => 2
));
$zone2_id = $wpdb->insert_id;
$wpdb->insert("{$prefix}woocommerce_shipping_zone_locations", array(
    'zone_id' => $zone2_id,
    'location_code' => 'ZA:GT',
    'location_type' => 'state'
));
$wpdb->insert("{$prefix}woocommerce_shipping_zone_methods", array(
    'zone_id' => $zone2_id,
    'method_id' => 'flat_rate',
    'method_order' => 1,
    'is_enabled' => 1
));
$gt_instance = $wpdb->insert_id;
update_option("woocommerce_flat_rate_{$gt_instance}_settings", array(
    'title' => 'Standard Delivery (Gauteng)',
    'tax_status' => 'taxable',
    'cost' => '100',
));
echo "Zone: Gauteng - R100 flat rate (instance $gt_instance)\n";

// Zone 3: KwaZulu-Natal
$wpdb->insert("{$prefix}woocommerce_shipping_zones", array(
    'zone_name' => 'KwaZulu-Natal',
    'zone_order' => 3
));
$zone3_id = $wpdb->insert_id;
$wpdb->insert("{$prefix}woocommerce_shipping_zone_locations", array(
    'zone_id' => $zone3_id,
    'location_code' => 'ZA:NL',
    'location_type' => 'state'
));
$wpdb->insert("{$prefix}woocommerce_shipping_zone_methods", array(
    'zone_id' => $zone3_id,
    'method_id' => 'flat_rate',
    'method_order' => 1,
    'is_enabled' => 1
));
$kzn_instance = $wpdb->insert_id;
update_option("woocommerce_flat_rate_{$kzn_instance}_settings", array(
    'title' => 'Standard Delivery (KZN)',
    'tax_status' => 'taxable',
    'cost' => '120',
));
echo "Zone: KwaZulu-Natal - R120 flat rate (instance $kzn_instance)\n";

// Zone 4: Rest of South Africa (Limpopo, North West, Free State, Western Cape, Eastern Cape, Northern Cape)
$wpdb->insert("{$prefix}woocommerce_shipping_zones", array(
    'zone_name' => 'Rest of South Africa',
    'zone_order' => 4
));
$zone4_id = $wpdb->insert_id;
$rest_provinces = array('ZA:LP', 'ZA:NW', 'ZA:FS', 'ZA:WC', 'ZA:EC', 'ZA:NC');
foreach ($rest_provinces as $prov) {
    $wpdb->insert("{$prefix}woocommerce_shipping_zone_locations", array(
        'zone_id' => $zone4_id,
        'location_code' => $prov,
        'location_type' => 'state'
    ));
}
$wpdb->insert("{$prefix}woocommerce_shipping_zone_methods", array(
    'zone_id' => $zone4_id,
    'method_id' => 'flat_rate',
    'method_order' => 1,
    'is_enabled' => 1
));
$rest_instance = $wpdb->insert_id;
update_option("woocommerce_flat_rate_{$rest_instance}_settings", array(
    'title' => 'Standard Delivery',
    'tax_status' => 'taxable',
    'cost' => '150',
));
echo "Zone: Rest of SA (LP, NW, FS, WC, EC, NC) - R150 flat rate (instance $rest_instance)\n";

// Also add free local pickup option to Mpumalanga zone
$wpdb->insert("{$prefix}woocommerce_shipping_zone_methods", array(
    'zone_id' => $zone1_id,
    'method_id' => 'local_pickup',
    'method_order' => 2,
    'is_enabled' => 1
));
$pickup_instance = $wpdb->insert_id;
update_option("woocommerce_local_pickup_{$pickup_instance}_settings", array(
    'title' => 'Collect from Practice (Free)',
    'tax_status' => 'taxable',
    'cost' => '0',
));
echo "Zone: Mpumalanga - Local Pickup added (Free)\n";

// ============================================================
// 4. CLEAR WooCommerce transients so changes take effect
// ============================================================
delete_transient('wc_shipping_method_count_legacy');
$wpdb->query("DELETE FROM {$prefix}options WHERE option_name LIKE '%_transient_wc_%'");
WC_Cache_Helper::invalidate_cache_group('shipping');
echo "\nWooCommerce shipping cache cleared.\n";

// ============================================================
// 5. VERIFY
// ============================================================
echo "\n=== VERIFICATION ===\n";
$zones = $wpdb->get_results("SELECT z.zone_id, z.zone_name, COUNT(m.instance_id) as methods FROM {$prefix}woocommerce_shipping_zones z LEFT JOIN {$prefix}woocommerce_shipping_zone_methods m ON z.zone_id = m.zone_id GROUP BY z.zone_id", ARRAY_A);
foreach ($zones as $z) {
    echo "Zone: {$z['zone_name']} ({$z['methods']} method(s))\n";
    $methods = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$prefix}woocommerce_shipping_zone_methods WHERE zone_id = %d", $z['zone_id']), ARRAY_A);
    foreach ($methods as $m) {
        $skey = "woocommerce_{$m['method_id']}_{$m['instance_id']}_settings";
        $s = get_option($skey, array());
        $cost = isset($s['cost']) ? 'R' . $s['cost'] : 'Free';
        echo "  -> {$s['title']} ($cost)\n";
    }
}

echo "\nDone! Flat rate shipping zones are now active.\n";

unlink(__FILE__);
