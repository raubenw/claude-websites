<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌿</text></svg>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Skip Link -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Preloader -->
    <div class="preloader" id="preloader" aria-hidden="true">
        <div class="preloader-content">
            <div class="preloader-leaf">🌿</div>
            <div class="preloader-text">MeHealth</div>
        </div>
    </div>

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        <div class="container">
            <p>💛 Handmade with love in South Africa 🇿🇦</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
        <div class="container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="MeHealth - Home">
                <span class="nav-logo-icon">🌿</span>
                <span class="nav-logo-text">Me<span>Health</span></span>
            </a>

            <ul class="nav-menu" id="navMenu" role="menubar">
                <li role="none"><a href="<?php echo esc_url(home_url('/#home')); ?>" class="nav-link" role="menuitem">Home</a></li>
                <li role="none"><a href="<?php echo esc_url(home_url('/#about')); ?>" class="nav-link" role="menuitem">Our Story</a></li>
                <li role="none">
                    <?php if (function_exists('wc_get_page_permalink')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="nav-link" role="menuitem">Shop</a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/#products')); ?>" class="nav-link" role="menuitem">Shop</a>
                    <?php endif; ?>
                </li>
                <li role="none"><a href="<?php echo esc_url(home_url('/#testimonials')); ?>" class="nav-link" role="menuitem">Reviews</a></li>
                <li role="none"><a href="<?php echo esc_url(home_url('/#contact')); ?>" class="nav-link" role="menuitem">Contact</a></li>
            </ul>

            <div class="nav-actions">
                <?php if (function_exists('WC')) : ?>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-btn" aria-label="Shopping cart">
                    <span class="cart-icon">🛒</span>
                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
                <?php endif; ?>
            </div>

            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content">
