<?php
/**
 * MeHealth Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

/* ---------- Theme Setup ---------- */
function mehealth_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mehealth'),
    ));
}
add_action('after_setup_theme', 'mehealth_setup');

/* ---------- Enqueue Scripts & Styles ---------- */
function mehealth_scripts() {
    // Google Fonts
    wp_enqueue_style('mehealth-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Nunito+Sans:wght@300;400;500;600;700&display=swap', array(), null);

    // AOS Animations
    wp_enqueue_style('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
    wp_enqueue_script('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);

    // Theme styles
    wp_enqueue_style('mehealth-style', get_stylesheet_uri(), array(), '1.0.0');

    // Theme script
    wp_enqueue_script('mehealth-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);

    // Pass WC data to JS
    if (function_exists('WC')) {
        wp_localize_script('mehealth-main', 'mehealth_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'cart_url' => wc_get_cart_url(),
            'nonce'    => wp_create_nonce('mehealth-nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'mehealth_scripts');

/* ---------- WooCommerce Customizations ---------- */

// Remove default WC styles we don't need (we style ourselves)
add_filter('woocommerce_enqueue_styles', function($styles) {
    unset($styles['woocommerce-layout']);
    return $styles;
});

// Cart fragment for AJAX cart count update
function mehealth_cart_count_fragment($fragments) {
    $fragments['.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'mehealth_cart_count_fragment');

// Customize "Add to Cart" button text
add_filter('woocommerce_product_add_to_cart_text', function() {
    return 'Add to Cart';
});

// Custom product categories on install
function mehealth_create_product_categories() {
    if (get_option('mehealth_categories_created')) return;

    if (!taxonomy_exists('product_cat')) return;

    $cats = array(
        'oils'     => 'Oils & Creams',
        'wellness' => 'Coffee & Wellness',
    );

    foreach ($cats as $slug => $name) {
        if (!term_exists($slug, 'product_cat')) {
            wp_insert_term($name, 'product_cat', array('slug' => $slug));
        }
    }

    update_option('mehealth_categories_created', true);
}
add_action('init', 'mehealth_create_product_categories', 20);

/* ---------- WooCommerce EFT Payment Customization ---------- */

// Customize the BACS (bank transfer) email with order reference info
add_action('woocommerce_email_after_order_table', function($order) {
    if ($order->get_payment_method() === 'bacs') {
        echo '<h3 style="margin-top:20px;">EFT Payment Instructions</h3>';
        echo '<p>Please use your order number <strong>#' . $order->get_order_number() . '</strong> as your payment reference.</p>';
        echo '<p>Once we receive your payment, we will process and ship your order.</p>';
        echo '<p>Mariaan will send you an invoice with the product total and shipping costs.</p>';
    }
}, 10, 1);

/* ---------- Contact Form Handler (AJAX) ---------- */
function mehealth_handle_contact() {
    check_ajax_referer('mehealth-nonce', 'nonce');

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? 'General Inquiry');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    $subject_labels = array(
        'product-inquiry' => 'Product Inquiry',
        'custom-order'    => 'Custom Order',
        'wholesale'       => 'Wholesale Inquiry',
        'other'           => 'Other',
    );
    $subject_label = $subject_labels[$subject] ?? ucfirst($subject);

    $admin_email = get_option('admin_email');
    $email_subject = sprintf('[MeHealth] %s from %s', $subject_label, $name);
    $email_body = sprintf(
        "New contact form submission from MeHealth:\n\nName: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s\n\n---\nSent from mehealth.co.za on %s",
        $name, $email, $subject_label, $message, current_time('Y-m-d H:i:s')
    );

    $headers = array(
        'From: MeHealth <noreply@mehealth.co.za>',
        sprintf('Reply-To: %s <%s>', $name, $email),
    );

    $sent = wp_mail($admin_email, $email_subject, $email_body, $headers);

    if ($sent) {
        wp_send_json_success(array('message' => 'Thanks for your message! Mariaan will get back to you soon.'));
    } else {
        wp_send_json_error(array('message' => 'Something went wrong. Please try WhatsApp instead.'));
    }
}
add_action('wp_ajax_mehealth_contact', 'mehealth_handle_contact');
add_action('wp_ajax_nopriv_mehealth_contact', 'mehealth_handle_contact');

/* ---------- Widget Areas ---------- */
function mehealth_widgets_init() {
    register_sidebar(array(
        'name'          => 'Shop Sidebar',
        'id'            => 'shop-sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'mehealth_widgets_init');

/* ---------- Custom Image Sizes ---------- */
add_image_size('product-card', 600, 520, true);
add_image_size('hero-bg', 1920, 1080, true);

/* ---------- Enable WooCommerce AJAX add to cart on custom pages ---------- */
add_filter('woocommerce_is_ajax', '__return_true');

// Ensure WC scripts load on front page for AJAX add-to-cart
function mehealth_enqueue_wc_scripts() {
    if (is_front_page() && function_exists('WC')) {
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'mehealth_enqueue_wc_scripts');

/* ---------- WooCommerce AJAX add to cart params for front page ---------- */
function mehealth_wc_add_to_cart_params() {
    if (is_front_page() && function_exists('WC')) {
        wp_localize_script('wc-add-to-cart', 'wc_add_to_cart_params', array(
            'ajax_url'                => WC()->ajax_url(),
            'wc_ajax_url'             => WC_AJAX::get_endpoint('%%endpoint%%'),
            'i18n_view_cart'          => esc_attr__('View cart', 'woocommerce'),
            'cart_url'                => apply_filters('woocommerce_add_to_cart_redirect', wc_get_cart_url(), null),
            'is_cart'                 => '',
            'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'mehealth_wc_add_to_cart_params', 20);
