<?php
/**
 * MeHealth WooCommerce Product Management Script
 * One-time use — delete after running.
 * 
 * Actions:
 * 1. Remove (draft) "Essential Oil Gift Package (Lavender & Wintergreen)" and "dōTERRA Essential Oil 15ml"
 * 2. Add CPTG prefix to all essential oil short descriptions
 * 3. Reorder products by category groups
 * 4. Set Organo coffee product image
 */

// Bootstrap WordPress
define('ABSPATH', dirname(__FILE__) . '/');
require_once ABSPATH . 'wp-load.php';

if (!function_exists('wc_get_products')) {
    die('WooCommerce not active.');
}

$results = [];

// ── 1. Remove (set to draft) specific products ──────────────────────
$remove_patterns = [
    'Lavender & Wintergreen',   // "Essential Oil Gift Package (Lavender & Wintergreen)"
    'dōTERRA Essential Oils'    // The generic dōTERRA Essential Oils product
];

$all_products = wc_get_products(['status' => 'publish', 'limit' => -1]);

foreach ($all_products as $product) {
    $name = $product->get_name();
    foreach ($remove_patterns as $pattern) {
        if (stripos($name, $pattern) !== false) {
            wp_update_post([
                'ID' => $product->get_id(),
                'post_status' => 'draft',
            ]);
            $results[] = "DRAFTED: '{$name}' (ID {$product->get_id()})";
            break;
        }
    }
}

// ── 2. Add CPTG prefix to essential oil short descriptions ──────────
$cptg_prefix = "Premium CPTG Certified Pure Tested Grade essential oils. ";

// Refresh products list (published only)
$products = wc_get_products(['status' => 'publish', 'limit' => -1]);

// Oil product name patterns (essential oils only, not creams/containers)
$oil_keywords = ['dōTERRA', 'doterra', 'Essential Oil', 'Roller Bottle', 'Tea Tree Essential'];

foreach ($products as $product) {
    $name = $product->get_name();
    $is_oil = false;
    
    foreach ($oil_keywords as $keyword) {
        if (stripos($name, $keyword) !== false) {
            $is_oil = true;
            break;
        }
    }
    
    if ($is_oil) {
        $desc = $product->get_short_description();
        // Don't add prefix if it already has it
        if (stripos($desc, 'CPTG Certified') === false) {
            $new_desc = $cptg_prefix . $desc;
            $product->set_short_description($new_desc);
            $product->save();
            $results[] = "CPTG PREFIX added to: '{$name}'";
        } else {
            $results[] = "CPTG PREFIX already present on: '{$name}' — skipped";
        }
    }
}

// ── 3. Reorder products by category groups ──────────────────────────
// Group order: Oils → Creams/Containers → Diffusers → Coffee & Wellness → Other
$order_map = [];
$menu_order = 1;

// Refresh
$products = wc_get_products(['status' => 'publish', 'limit' => -1]);

// Classify each product
$groups = [
    'oils'       => [],
    'creams'     => [],
    'diffusers'  => [],
    'coffee'     => [],
    'other'      => [],
];

foreach ($products as $product) {
    $name = strtolower($product->get_name());
    $id = $product->get_id();
    
    if (strpos($name, 'diffuser') !== false) {
        $groups['diffusers'][] = $product;
    } elseif (strpos($name, 'coffee') !== false || strpos($name, 'mushroom') !== false || 
              strpos($name, 'reishi') !== false || strpos($name, 'latte') !== false ||
              strpos($name, 'organo') !== false || strpos($name, 'alkaline') !== false) {
        $groups['coffee'][] = $product;
    } elseif (strpos($name, 'cream') !== false || strpos($name, '50ml') !== false || 
              strpos($name, '100ml') !== false || strpos($name, 'face') !== false) {
        $groups['creams'][] = $product;
    } elseif (strpos($name, 'doterra') !== false || strpos($name, 'dōterra') !== false || 
              strpos($name, 'essential oil') !== false || strpos($name, 'tea tree') !== false ||
              strpos($name, 'roller') !== false || strpos($name, 'breathe') !== false ||
              strpos($name, 'oregano') !== false && strpos($name, 'latte') === false) {
        $groups['oils'][] = $product;
    } else {
        $groups['other'][] = $product;
    }
}

// Assign menu_order within each group
foreach (['oils', 'creams', 'diffusers', 'coffee', 'other'] as $group) {
    foreach ($groups[$group] as $product) {
        wp_update_post([
            'ID' => $product->get_id(),
            'menu_order' => $menu_order,
        ]);
        $results[] = "ORDER #{$menu_order} [{$group}]: '{$product->get_name()}'";
        $menu_order++;
    }
}

// ── 4. Set Organo coffee product image ──────────────────────────────
// Find the Organo coffee product
$organo_product = null;
foreach ($products as $product) {
    $name = strtolower($product->get_name());
    if (strpos($name, 'organo') !== false || strpos($name, 'latte') !== false) {
        $organo_product = $product;
        break;
    }
}

if ($organo_product) {
    // Check if image already uploaded
    $existing_image = $organo_product->get_image_id();
    
    // Upload the image file
    $image_path = ABSPATH . 'wp-content/uploads/organo-latte.jpg';
    
    if (file_exists($image_path)) {
        $attachment = [
            'post_mime_type' => 'image/jpeg',
            'post_title'     => 'Premium Quality Latte Organo',
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];
        
        $attach_id = wp_insert_attachment($attachment, $image_path, $organo_product->get_id());
        
        if (!is_wp_error($attach_id)) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $attach_data = wp_generate_attachment_metadata($attach_id, $image_path);
            wp_update_attachment_metadata($attach_id, $attach_data);
            
            set_post_thumbnail($organo_product->get_id(), $attach_id);
            $results[] = "IMAGE SET: Organo coffee product image updated (attachment {$attach_id})";
        } else {
            $results[] = "IMAGE ERROR: " . $attach_id->get_error_message();
        }
    } else {
        $results[] = "IMAGE NOT FOUND: {$image_path} — upload organo-latte.jpg to wp-content/uploads/ first";
    }
} else {
    $results[] = "ORGANO PRODUCT NOT FOUND — check product names";
}

// ── Output results ──────────────────────────────────────────────────
header('Content-Type: text/plain');
echo "MeHealth Product Management Results\n";
echo str_repeat('=', 50) . "\n\n";
foreach ($results as $r) {
    echo "• {$r}\n";
}
echo "\n" . str_repeat('=', 50) . "\n";
echo "Done. Total actions: " . count($results) . "\n";
echo "\n⚠️  DELETE THIS FILE IMMEDIATELY after verifying results.\n";
