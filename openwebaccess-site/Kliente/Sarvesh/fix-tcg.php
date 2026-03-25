<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

// 1. Update store address to new one
update_option('woocommerce_store_address', 'Vanadium str 10, Mineralis');
update_option('woocommerce_store_address_2', '');
update_option('woocommerce_store_city', 'Middelburg');
update_option('woocommerce_store_postcode', '1050');
update_option('woocommerce_default_country', 'ZA:MP'); // Mpumalanga
update_option('woocommerce_store_state', 'MP');

echo "Store address updated:\n";
echo "  Address: " . get_option('woocommerce_store_address') . "\n";
echo "  City: " . get_option('woocommerce_store_city') . "\n";
echo "  Postcode: " . get_option('woocommerce_store_postcode') . "\n";
echo "  Country: " . get_option('woocommerce_default_country') . "\n\n";

// 2. Check The Courier Guy plugin files for settings structure
$tcg_path = ABSPATH . 'wp-content/plugins/the-courier-guy/';
echo "=== TCG PLUGIN FILES ===\n";
if (is_dir($tcg_path)) {
    // Find the main settings/admin class
    $files = glob($tcg_path . '*.php');
    foreach ($files as $f) {
        echo basename($f) . "\n";
    }
    echo "\nSubfolders:\n";
    $dirs = glob($tcg_path . '*', GLOB_ONLYDIR);
    foreach ($dirs as $d) {
        echo "  " . basename($d) . "/\n";
    }
    
    // Look for settings class
    echo "\n=== SEARCHING FOR SETTINGS/ADMIN CLASS ===\n";
    $search_dirs = array($tcg_path, $tcg_path . 'Core/', $tcg_path . 'app/', $tcg_path . 'includes/', $tcg_path . 'src/', $tcg_path . 'Shipping/');
    foreach ($search_dirs as $dir) {
        if (is_dir($dir)) {
            $php_files = glob($dir . '*.php');
            foreach ($php_files as $pf) {
                echo "  " . str_replace($tcg_path, '', $pf) . "\n";
            }
        }
    }
} else {
    echo "TCG plugin directory not found!\n";
}

// 3. Check the shipping method class for required settings fields
echo "\n=== TCG SHIPPING METHOD FORM FIELDS ===\n";
$shipping_methods = WC()->shipping()->get_shipping_methods();
foreach ($shipping_methods as $id => $method) {
    if (strpos($id, 'courier') !== false) {
        echo "Method: $id (" . get_class($method) . ")\n";
        if (method_exists($method, 'get_form_fields')) {
            $fields = $method->get_form_fields();
            echo "Form fields:\n";
            foreach ($fields as $key => $field) {
                $type = isset($field['type']) ? $field['type'] : 'text';
                $title = isset($field['title']) ? $field['title'] : $key;
                $desc = isset($field['description']) ? $field['description'] : '';
                echo "  [$type] $key: $title";
                if ($desc) echo " -- $desc";
                echo "\n";
            }
        }
        if (method_exists($method, 'get_instance_form_fields')) {
            $ifields = $method->get_instance_form_fields();
            echo "\nInstance form fields:\n";
            foreach ($ifields as $key => $field) {
                $type = isset($field['type']) ? $field['type'] : 'text';
                $title = isset($field['title']) ? $field['title'] : $key;
                echo "  [$type] $key: $title\n";
            }
        }
    }
}

// 4. Also check for any TCG-specific options table entries
global $wpdb;
echo "\n=== ALL TCG/COURIER OPTIONS ===\n";
$results = $wpdb->get_results("SELECT option_name FROM {$wpdb->prefix}options WHERE option_name LIKE '%courier%' OR option_name LIKE '%tcg%' OR option_name LIKE '%shiplogic%'", ARRAY_A);
foreach ($results as $r) {
    echo "  " . $r['option_name'] . "\n";
}

// Check TCG plugin version
$plugin_data = get_file_data($tcg_path . 'TheCourierGuy.php', array('Version' => 'Version'));
echo "\nTCG Plugin version: " . ($plugin_data['Version'] ?? 'unknown') . "\n";

unlink(__FILE__);
