<?php
/**
 * Remove duplicate products - keep only the latest of each
 * One-time script - delete after use
 */
define('ABSPATH', dirname(__FILE__) . '/');
require_once ABSPATH . 'wp-load.php';

echo "<h2>Cleaning Duplicate Products</h2><pre>\n";

$products = wc_get_products(array('limit' => -1, 'orderby' => 'ID', 'order' => 'ASC'));

$seen = array();
$deleted = 0;

foreach ($products as $p) {
    $name = $p->get_name();
    if (isset($seen[$name])) {
        // This is a duplicate - delete the earlier one
        $old_id = $seen[$name];
        wp_delete_post($old_id, true);
        echo "Deleted duplicate: '$name' (ID: $old_id) - keeping ID: {$p->get_id()}\n";
        $deleted++;
    }
    $seen[$name] = $p->get_id();
}

echo "\nDeleted $deleted duplicate(s).\n";

// Show remaining products
$remaining = wc_get_products(array('limit' => -1));
echo "\nRemaining products:\n";
foreach ($remaining as $p) {
    echo "  ID {$p->get_id()}: {$p->get_name()} - R{$p->get_regular_price()}\n";
}

echo "</pre><p><strong>Done! Delete this file.</strong></p>";
