<?php
/**
 * Template Name: Front Page
 * Front page template for Back on Track Chiropractic & Wellness
 */
get_header();
$theme_uri = get_template_directory_uri();
?>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-bg">
            <div class="hero-overlay"></div>
            <img src="<?php echo $theme_uri; ?>/images/hero-1.jpg" alt="" class="hero-bg-image active" aria-hidden="true">
            <img src="<?php echo $theme_uri; ?>/images/hero-2.jpg" alt="" class="hero-bg-image" aria-hidden="true">
            <img src="<?php echo $theme_uri; ?>/images/hero-3.jpg" alt="" class="hero-bg-image" aria-hidden="true">
            <img src="<?php echo $theme_uri; ?>/images/hero-4.jpg" alt="" class="hero-bg-image" aria-hidden="true">
        </div>
        <div class="container hero-content">
            <div class="hero-badge">
                <i class="fas fa-hand-holding-medical"></i>
                Patient-Focused Care
            </div>
            <h1>Get Your Life<br><span class="text-accent">Back on Track</span></h1>
            <p class="hero-subtitle">Chiropractic care, rehabilitation &amp; wellness with Dr Sarvesh Maharajh in Kloof, KwaZulu-Natal</p>
            <div class="hero-actions">
                <a href="#contact" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i>
                    Book Appointment
                </a>
                <a href="#services" class="btn btn-outline">
                    <span>Our Services</span>
                </a>
            </div>
            <div class="hero-features">
                <div class="hero-feature">
                    <span class="hero-feature-icon"><i class="fas fa-check"></i></span>
                    <span>Registered Chiropractor</span>
                </div>
                <div class="hero-feature">
                    <span class="hero-feature-icon"><i class="fas fa-check"></i></span>
                    <span>Medical Aid Accepted</span>
                </div>
                <div class="hero-feature">
                    <span class="hero-feature-icon"><i class="fas fa-check"></i></span>
                    <span>Red Light Therapy</span>
                </div>
            </div>
        </div>
        <div class="hero-scroll">
            <a href="#about" aria-label="Scroll down">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Quick Info Bar -->
    <section class="info-bar">
        <div class="container">
            <div class="info-bar-grid">
                <div class="info-bar-item">
                    <div class="info-bar-icon"><span class="emoji-icon">📍</span></div>
                    <div>
                        <div class="info-bar-title">Visit Us</div>
                        <div class="info-bar-text">16 Pioneer Road, Kloof</div>
                    </div>
                </div>
                <div class="info-bar-item">
                    <div class="info-bar-icon"><i class="fas fa-phone-alt" style="color:#e04040"></i></div>
                    <div>
                        <div class="info-bar-title">Call Us</div>
                        <div class="info-bar-text">066 087 3258</div>
                    </div>
                </div>
                <div class="info-bar-item">
                    <div class="info-bar-icon"><span class="emoji-icon">🕐</span></div>
                    <div>
                        <div class="info-bar-title">Working Hours</div>
                        <div class="info-bar-text">Mon&ndash;Sat: By Appointment</div>
                    </div>
                </div>
                    <div class="info-bar-item">
                    <div class="info-bar-icon"><span class="emoji-icon">📋</span></div>
                    <div>
                        <div class="info-bar-title">Practice No.</div>
                        <div class="info-bar-text">0395129</div>
                    </div>
                </div>
                <div class="info-bar-item">
                    <div class="info-bar-icon"><span class="emoji-icon">💚</span></div>
                    <div>
                        <div class="info-bar-title">Holistic Care</div>
                        <div class="info-bar-text">Chiro, Rehab &amp; Wellness</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about section" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <div class="section-label">
                        <i class="fas fa-stethoscope"></i>
                        About Dr Maharajh
                    </div>
                    <h2>Dedicated to Your <span class="text-accent">Recovery &amp; Wellness</span></h2>
                    <p class="about-lead">Dr Sarvesh Maharajh is a patient-focused chiropractor based in Kloof, KwaZulu-Natal, committed to helping you achieve optimal health and return to normal function.</p>
                    <p>With a comprehensive approach that combines manual therapy, rehabilitation exercises, and cutting-edge treatments like red light therapy, Dr Maharajh addresses the root cause of your pain &mdash; not just the symptoms.</p>
                    <p>Whether you're dealing with chronic back pain, recovering from an injury, or seeking to improve your overall wellness, Back on Track provides personalised treatment plans tailored to your unique needs.</p>
                    <div class="about-features">
                        <div class="feature">
                            <span class="emoji-icon feature-emoji">🎓</span>
                            <span>Manual Therapy &amp; Spinal Adjustments</span>
                        </div>
                        <div class="feature">
                            <span class="emoji-icon feature-emoji">🔬</span>
                            <span>Rehabilitation &amp; Exercise Prescription</span>
                        </div>
                        <div class="feature">
                            <span class="emoji-icon feature-emoji">❤️</span>
                            <span>Red Light &amp; Infrared Therapy</span>
                        </div>
                        <div class="feature">
                            <span class="emoji-icon feature-emoji">📊</span>
                            <span>Ergonomic &amp; Postural Assessment</span>
                        </div>
                    </div>
                    <a href="#contact" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i>
                        Schedule a Consultation
                    </a>
                </div>
                <div class="about-visual">
                    <div class="doctor-profile-card">
                        <div class="profile-image-wrapper">
                            <img src="<?php echo $theme_uri; ?>/images/dr-maharajh-profile.png" alt="Dr S.R. Maharajh - Chiropractor" class="profile-image" loading="lazy">
                        </div>
                        <div class="profile-credentials">
                            <h3 class="profile-name">Dr. S.R. Maharajh</h3>
                            <p class="profile-qualification">M. Tech Chiropractic (DUT)</p>
                            <div class="profile-divider"></div>
                            <div class="profile-reg">
                                <span><i class="fas fa-certificate"></i> Registered Chiropractor</span>
                                <span><i class="fas fa-id-card"></i> Reg No: A10949</span>
                                <span><i class="fas fa-clipboard-check"></i> PR No: 039512</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-quote">
                        <i class="fas fa-quote-left"></i>
                        <p>Helping you return to normal function, pain-free.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services section" id="services">
        <div class="container">
            <div class="section-header">
                <div class="section-label">
                    <i class="fas fa-hand-holding-medical"></i>
                    Our Services
                </div>
                <h2>Comprehensive <span class="text-accent">Care Solutions</span></h2>
                <p>A holistic approach combining hands-on treatment, rehabilitation, and modern therapeutic technologies.</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <span class="emoji-icon">🤲</span>
                    </div>
                    <h3>Chiropractic Adjustments</h3>
                    <p>Precise manual adjustments to restore proper spinal alignment, relieve nerve pressure, and promote natural healing throughout the body.</p>
                    <ul class="service-list">
                        <li>Spinal manipulation</li>
                        <li>Joint mobilisation</li>
                        <li>Soft tissue therapy</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <span class="emoji-icon">🏃</span>
                    </div>
                    <h3>Rehabilitation</h3>
                    <p>Structured exercise programmes designed to strengthen weak areas, improve mobility, and prevent re-injury for long-term results.</p>
                    <ul class="service-list">
                        <li>Core stability training</li>
                        <li>Functional movement</li>
                        <li>Injury recovery</li>
                    </ul>
                </div>
                <div class="service-card featured">
                    <div class="service-badge">Popular</div>
                    <div class="service-icon">
                        <span class="emoji-icon">☀️</span>
                    </div>
                    <h3>Red Light Therapy</h3>
                    <p>Advanced photobiomodulation using red and near-infrared light to accelerate tissue repair, reduce inflammation, and relieve pain.</p>
                    <ul class="service-list">
                        <li>Pain reduction</li>
                        <li>Tissue healing</li>
                        <li>Inflammation control</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <span class="emoji-icon">📋</span>
                    </div>
                    <h3>Postural Assessment</h3>
                    <p>Thorough ergonomic and postural evaluations to identify imbalances and create corrective strategies for daily life and work.</p>
                    <ul class="service-list">
                        <li>Ergonomic advice</li>
                        <li>Posture correction</li>
                        <li>Workplace assessment</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <span class="emoji-icon">❤️</span>
                    </div>
                    <h3>Wellness Programmes</h3>
                    <p>Comprehensive wellness plans addressing physical and mental health, including lifestyle guidance, stress management, and preventive care.</p>
                    <ul class="service-list">
                        <li>Lifestyle coaching</li>
                        <li>Stress management</li>
                        <li>Preventive care</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <span class="emoji-icon">⚡</span>
                    </div>
                    <h3>Sports Injuries</h3>
                    <p>Specialist treatment for sports-related injuries with focused recovery programmes to get athletes back to peak performance safely.</p>
                    <ul class="service-list">
                        <li>Injury assessment</li>
                        <li>Recovery planning</li>
                        <li>Performance rehab</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Red Light Therapy Feature Section -->
    <section class="red-light section" id="red-light">
        <div class="container">
            <div class="red-light-grid">
                <div class="red-light-images">
                    <div class="rl-image-main">
                        <img src="<?php echo $theme_uri; ?>/images/red-light-sessions.jpg" alt="Back on Track red light therapy sessions" loading="lazy">
                    </div>
                </div>
                <div class="red-light-content">
                    <div class="section-label">
                        <i class="fas fa-wand-magic-sparkles"></i>
                        Featured Treatment
                    </div>
                    <h2>Red Light &amp; Infrared <span class="text-accent">Therapy</span></h2>
                    <p class="rl-lead">Experience the healing power of photobiomodulation &mdash; a non-invasive treatment that uses specific wavelengths of light to promote cellular repair and reduce pain.</p>
                    <div class="rl-benefits-image">
                        <img src="<?php echo $theme_uri; ?>/images/benefits-redlight-therapy.jpg" alt="Benefits of red light therapy" loading="lazy">
                    </div>
                    <a href="#contact" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i>
                        Book a Session
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Videos Section -->
    <section class="videos section" id="videos">
        <div class="container">
            <div class="section-header">
                <div class="section-label">
                    <i class="fab fa-youtube"></i>
                    Health &amp; Wellness Tips
                </div>
                <h2>Watch &amp; <span class="text-accent">Learn</span></h2>
                <p>Educational videos from Dr Maharajh on chiropractic care, exercise, posture, and overall wellness.</p>
            </div>
            <div class="videos-grid">
                <div class="video-card featured-video">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube-nocookie.com/embed/fC6Mjb-qmyA" title="Sciatica - symptoms, red flags, treatment" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Sciatica: Symptoms, Red Flags &amp; Treatment</h3>
                        <p>Understanding sciatica, when to seek help, and treatment options available.</p>
                        <span class="video-meta"><i class="fas fa-eye"></i> 422 views</span>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube-nocookie.com/embed/8obxojxLjLg" title="Poor posture and posture correction" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Poor Posture &amp; Correction</h3>
                        <p>How poor posture affects your body and simple ways to correct it.</p>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube-nocookie.com/embed/jl2H06JLseQ" title="Core stability - McGill Big 3" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Core Stability: McGill Big 3</h3>
                        <p>Essential core stability exercises for a strong, healthy back.</p>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube-nocookie.com/embed/gzwYoo8yt1M" title="Levator Scapulae and neck pain" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Levator Scapulae &amp; Neck Pain</h3>
                        <p>Understanding how the levator scapulae muscle contributes to neck pain.</p>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube-nocookie.com/embed/jy7R26fHZG0" title="Low back strength and mobility exercise" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Low Back Strength &amp; Mobility</h3>
                        <p>A great exercise for improving low back strength and mobility.</p>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube-nocookie.com/embed/6cSsa3hAOfU" title="Barefoot Shoes - Whats the hype" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Barefoot Shoes: What's the Hype?</h3>
                        <p>Exploring the science behind barefoot shoes and their benefits.</p>
                    </div>
                </div>
            </div>
            <div class="videos-cta">
                <a href="https://www.youtube.com/@BackOnTrackWellness" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                    <i class="fab fa-youtube"></i>
                    View All Videos on YouTube
                </a>
            </div>
        </div>
    </section>

    <!-- Shop / Products Section -->
    <section class="shop section" id="shop">
        <div class="container">
            <div class="section-header">
                <div class="section-label">
                    <i class="fas fa-shopping-bag"></i>
                    Our Products
                </div>
                <h2>Natural <span class="text-accent">Supplements</span></h2>
                <p>Premium natural health supplements to support your wellness journey.</p>
            </div>
            <div class="shop-grid">
                <?php
                $products = wc_get_products(array(
                    'status'  => 'publish',
                    'limit'   => 6,
                    'orderby' => 'date',
                    'order'   => 'DESC',
                ));
                if ($products) :
                    foreach ($products as $product) :
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'medium');
                        $image_url = $image ? $image[0] : $theme_uri . '/images/placeholder.jpg';
                ?>
                <div class="shop-product" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                    <div class="shop-product-image">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" loading="lazy">
                    </div>
                    <div class="shop-product-info">
                        <h3><?php echo esc_html($product->get_name()); ?></h3>
                        <p class="shop-product-desc"><?php echo esc_html($product->get_short_description()); ?></p>
                        <div class="shop-product-footer">
                            <span class="shop-product-price">R<?php echo esc_html($product->get_price()); ?></span>
                            <div class="shop-qty-controls">
                                <button type="button" class="qty-btn qty-minus" aria-label="Decrease quantity">-</button>
                                <span class="qty-value">0</span>
                                <button type="button" class="qty-btn qty-plus" aria-label="Increase quantity">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div class="shop-cart-link">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-outline">
                    <i class="fas fa-shopping-cart"></i>
                    View Cart &amp; Checkout
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact section" id="contact">
        <div class="container">
            <div class="section-header">
                <div class="section-label">
                    <i class="fas fa-envelope"></i>
                    Get in Touch
                </div>
                <h2>Book Your <span class="text-accent">Appointment</span></h2>
                <p>Ready to start your journey to wellness? Contact us today.</p>
            </div>
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="info-card">
                        <div class="info-icon">
                            <span class="emoji-icon">📍</span>
                        </div>
                        <div>
                            <h4>Location</h4>
                            <p>16 Pioneer Road<br>Kloof, KwaZulu-Natal<br>South Africa, 3610</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt" style="color:#e04040"></i>
                        </div>
                        <div>
                            <h4>Phone</h4>
                            <p><a href="tel:+27660873258">066 087 3258</a></p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <span class="emoji-icon">✉️</span>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p><a href="mailto:backontrackwellness13@gmail.com">backontrackwellness13@gmail.com</a></p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <span class="emoji-icon">🏥</span>
                        </div>
                        <div>
                            <h4>Practice Number</h4>
                            <p>0395129</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <span class="emoji-icon">📸</span>
                        </div>
                        <div>
                            <h4>Instagram</h4>
                            <p><a href="https://www.instagram.com/backontrack_chiro_and_wellness" target="_blank" rel="noopener noreferrer">@backontrack_chiro_and_wellness</a></p>
                        </div>
                    </div>
                    <div class="contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.7!2d30.8281!3d-29.7863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ef7a9c34e2e5e5b%3A0x0!2s16+Pioneer+Road%2C+Kloof%2C+3610!5e0!3m2!1sen!2sza!4v1" width="100%" height="200" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Back on Track Chiropractic location"></iframe>
                    </div>
                </div>
                <div class="contact-form-wrapper">
                    <form id="contactForm" class="contact-form">
                        <h3>Send Us a Message</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required placeholder="Your first name">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required placeholder="Your last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="your@email.com">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+27 XX XXX XXXX">
                        </div>
                        <div class="form-group">
                            <label for="service">Service of Interest</label>
                            <select id="service" name="service">
                                <option value="">Select a service...</option>
                                <option value="chiropractic">Chiropractic Adjustment</option>
                                <option value="rehabilitation">Rehabilitation</option>
                                <option value="red-light">Red Light Therapy</option>
                                <option value="posture">Postural Assessment</option>
                                <option value="wellness">Wellness Programme</option>
                                <option value="sports">Sports Injury</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="4" required placeholder="Tell us about your concern or how we can help..."></textarea>
                        </div>
                        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
                        <button type="submit" class="btn btn-primary btn-full">
                            <i class="fas fa-paper-plane"></i>
                            Send Message
                        </button>
                        <div id="formStatus" class="form-status"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
