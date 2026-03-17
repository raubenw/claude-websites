<?php
/**
 * WooCommerce page wrapper template.
 * Provides consistent styling for all WooCommerce pages (shop, cart, checkout, my-account).
 */
get_header();
?>

<section class="woocommerce-page-content" style="padding-top: 140px; padding-bottom: 80px; min-height: 60vh;">
    <div class="container">
        <?php woocommerce_content(); ?>
    </div>
</section>

<?php get_footer(); ?>
