<?php
/**
 * Add two supplement products to WooCommerce
 * One-time script - delete after use
 */
define('ABSPATH', dirname(__FILE__) . '/');
require_once ABSPATH . 'wp-load.php';

echo "<h2>Adding Products to WooCommerce</h2><pre>\n";

// Product 1: Lion's Mane
$product1 = new WC_Product_Simple();
$product1->set_name("Lion's Mane Liquid Extract 100ml");
$product1->set_description("Lion's Mane (Hericium erinaceus) liquid extract by Valley Mushroom Farm. Supports cognitive function, memory, immune system, and helps with anxiety. 100ml dropper bottle.");
$product1->set_short_description("For cognitive function, memory, immune system & anxiety. 100ml liquid extract.");
$product1->set_regular_price('400');
$product1->set_status('publish');
$product1->set_catalog_visibility('visible');
$product1->set_manage_stock(false);
$product1->set_stock_status('instock');
$product1->save();
$id1 = $product1->get_id();
echo "Product 1 created: Lion's Mane Liquid Extract 100ml (ID: $id1) - R400\n";

// Product 2: Mushroom Extraction Capsules
$product2 = new WC_Product_Simple();
$product2->set_name("Mushroom Extraction Capsules 0.2g (30 Capsules)");
$product2->set_description("Mushroom Extraction capsules, 0.2g per capsule, 30 capsules per bottle. Helps with stress and anxiety relief. Natural mushroom-based supplement.");
$product2->set_short_description("For stress and anxiety. 0.2g x 30 capsules.");
$product2->set_regular_price('500');
$product2->set_status('publish');
$product2->set_catalog_visibility('visible');
$product2->set_manage_stock(false);
$product2->set_stock_status('instock');
$product2->save();
$id2 = $product2->get_id();
echo "Product 2 created: Mushroom Extraction Capsules 0.2g (ID: $id2) - R500\n";

// Set product images - they need to be in the media library
$upload_dir = wp_upload_dir();
$images = array(
    $id1 => array(
        'source' => get_template_directory() . '/images/lions-mane.jpg',
        'filename' => 'lions-mane.jpg',
        'title' => "Lion's Mane Liquid Extract",
    ),
    $id2 => array(
        'source' => get_template_directory() . '/images/mushroom-capsules.jpg',
        'filename' => 'mushroom-capsules.jpg',
        'title' => 'Mushroom Extraction Capsules',
    ),
);

foreach ($images as $product_id => $img) {
    if (file_exists($img['source'])) {
        $dest = $upload_dir['path'] . '/' . $img['filename'];
        copy($img['source'], $dest);
        
        $attachment = array(
            'post_mime_type' => 'image/jpeg',
            'post_title'    => $img['title'],
            'post_content'  => '',
            'post_status'   => 'inherit',
        );
        
        $attach_id = wp_insert_attachment($attachment, $dest, $product_id);
        
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $dest);
        wp_update_attachment_metadata($attach_id, $attach_data);
        
        set_post_thumbnail($product_id, $attach_id);
        echo "Image set for product $product_id: {$img['filename']} (attachment ID: $attach_id)\n";
    } else {
        echo "WARNING: Image not found at {$img['source']}\n";
    }
}

// Also create a product category for supplements
$term = wp_insert_term('Supplements', 'product_cat', array(
    'description' => 'Natural health supplements available at Back on Track Wellness',
));
if (!is_wp_error($term)) {
    wp_set_object_terms($id1, $term['term_id'], 'product_cat');
    wp_set_object_terms($id2, $term['term_id'], 'product_cat');
    echo "Category 'Supplements' created and assigned to both products\n";
} else {
    // Category might already exist
    $existing = get_term_by('name', 'Supplements', 'product_cat');
    if ($existing) {
        wp_set_object_terms($id1, $existing->term_id, 'product_cat');
        wp_set_object_terms($id2, $existing->term_id, 'product_cat');
        echo "Existing 'Supplements' category assigned to both products\n";
    }
}

echo "\nDone! Verify at WooCommerce > Products.\n";
echo "</pre><p><strong>Delete this file from the server.</strong></p>";
