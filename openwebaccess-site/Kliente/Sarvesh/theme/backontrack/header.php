<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Patient-focused chiropractic care in Kloof, KZN. Dr Sarvesh Maharajh offers manual therapy, rehabilitation, red light therapy and wellness services.">
    <meta name="keywords" content="chiropractor, Kloof, KZN, Dr Sarvesh Maharajh, back pain, spinal adjustment, rehabilitation, red light therapy, wellness, chiropractic">

    <!-- Open Graph -->
    <meta property="og:title" content="Back on Track Chiropractic & Wellness | Dr Sarvesh Maharajh">
    <meta property="og:description" content="Patient-focused chiropractic care. Wellness, Manual therapy, Rehabilitation, Return to normal function.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://backontrackwellness.co.za">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.svg" type="image/svg+xml">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Top Bar -->
    <div class="top-bar" id="topBar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <a href="tel:+27848888308" class="top-bar-item contact-highlight">
                        <i class="fas fa-phone"></i>
                        <span>+27 84 888 8308</span>
                    </a>
                    <a href="mailto:dr.srmaharajh@gmail.com" class="top-bar-item contact-highlight">
                        <i class="fas fa-envelope"></i>
                        <span>dr.srmaharajh@gmail.com</span>
                    </a>
                </div>
                <div class="top-bar-right">
                    <span class="top-bar-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon&ndash;Fri: By Appointment | Sat: By Arrangement</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo">
                <span class="logo-icon"><i class="fas fa-spine"></i></span>
                <div class="logo-text">
                    <span class="logo-name">Back on Track</span>
                    <span class="logo-tagline">Chiropractic &amp; Wellness</span>
                </div>
            </a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="<?php echo esc_url(home_url('/#about')); ?>" class="nav-link">About</a></li>
                <li><a href="<?php echo esc_url(home_url('/#services')); ?>" class="nav-link">Services</a></li>
                <li><a href="<?php echo esc_url(home_url('/#red-light')); ?>" class="nav-link">Red Light Therapy</a></li>
                <li><a href="<?php echo esc_url(home_url('/#videos')); ?>" class="nav-link">Videos</a></li>
                <li><a href="<?php echo esc_url(home_url('/#contact')); ?>" class="nav-link">Contact</a></li>
                <li><a href="<?php echo esc_url(home_url('/#contact')); ?>" class="nav-link nav-cta">Book Appointment</a></li>
            </ul>
        </div>
    </nav>
