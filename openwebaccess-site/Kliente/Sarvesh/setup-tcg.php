<?php
define('ABSPATH', '/home2/solutions/public_html/website_8cdc39b6/');
define('WPINC', 'wp-includes');
require_once(ABSPATH . 'wp-load.php');

// Set the TCG instance settings with shop details (address, contact)
// API credentials will need to be provided by the user
$instance_id = 1;
$key = "woocommerce_the_courier_guy_{$instance_id}_settings";

$existing = get_option($key, array());
if (!is_array($existing)) $existing = array();

// Pre-fill known shop details
$settings = array_merge($existing, array(
    'title'             => 'The Courier Guy',
    'enabled'           => 'yes',
    'tax_status'        => 'taxable',
    'company_name'      => 'Back on Track Chiropractic & Wellness',
    'shopAddress1'      => 'Vanadium str 10, Mineralis',
    'shopSuburb'        => 'Middelburg',
    'shopCity'          => 'Middelburg',
    'shopState'         => 'MP',
    'shopCountry'       => 'ZA',
    'shopPostalCode'    => '1050',
    'shopPhone'         => '0660873258',
    'shopContactName'   => 'Dr S.R. Maharajh',
    'shopEmail'         => 'backontrackwellness13@gmail.com',
    // Default parcel sizes (small supplements, flyer-size)
    'product_length_per_parcel_1' => '25',
    'product_width_per_parcel_1'  => '15',
    'product_height_per_parcel_1' => '10',
    'product_length_per_parcel_2' => '30',
    'product_width_per_parcel_2'  => '20',
    'product_height_per_parcel_2' => '15',
    'product_length_per_parcel_3' => '40',
    'product_width_per_parcel_3'  => '30',
    'product_height_per_parcel_3' => '20',
));

update_option($key, $settings);

echo "TCG instance settings updated!\n\n";
echo "Settings saved:\n";
foreach ($settings as $k => $v) {
    if (stripos($k, 'secret') !== false || stripos($k, 'token') !== false) {
        echo "  $k = " . (empty($v) ? '[EMPTY - NEEDS TO BE SET]' : '[SET]') . "\n";
    } else {
        echo "  $k = $v\n";
    }
}

echo "\n\n=== STILL MISSING (REQUIRED) ===\n";
echo "The following 3 fields must be set from your Courier Guy / ShipLogic account:\n";
echo "  1. account             = " . (empty($settings['account']) ? '[EMPTY]' : $settings['account']) . "\n";
echo "  2. ship_logic_access_key_id = " . (empty($settings['ship_logic_access_key_id']) ? '[EMPTY]' : $settings['ship_logic_access_key_id']) . "\n";
echo "  3. ship_logic_secret_access_key = " . (empty($settings['ship_logic_secret_access_key']) ? '[EMPTY]' : '[SET]') . "\n";
echo "  4. ship_logic_secret_access_token = " . (empty($settings['ship_logic_secret_access_token']) ? '[EMPTY]' : '[SET]') . "\n";

echo "\nTo get these credentials:\n";
echo "  1. Log in to https://app.shiplogic.com\n";
echo "  2. Go to Settings -> API Keys\n";
echo "  3. Copy the Access Key ID, Secret Access Key, and API Key\n";
echo "  4. Your account number is on your Courier Guy contract/welcome email\n";

unlink(__FILE__);
