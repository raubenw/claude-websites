<?php
/**
 * Template Name: Front Page
 * The homepage template for MeHealth theme.
 */
get_header();
?>

      <!-- Hero Section -->
      <section class="hero" id="home" aria-label="Welcome to MeHealth">
        <div class="hero-bg">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/hero.jpg" alt="" class="hero-bg-image" aria-hidden="true" />
          <div class="hero-overlay"></div>
        </div>

        <div class="container">
          <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <span class="hero-badge">🌱 M&amp;E Pure Essential Oils — Live Healthy, Be Happy</span>

            <h1 class="hero-title">
              Live Healthy,<br />
              <span class="highlight">Be Happy</span>
            </h1>

            <p class="hero-description">
              Discover Mariaan's collection of premium dōTERRA essential oils,
              handmade natural creams, and mushroom-infused coffee. Pure
              wellness for body and mind.
            </p>

            <div class="hero-buttons">
              <a href="#products" class="btn btn-primary btn-lg">
                <span>Shop Now</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
              </a>
              <a href="#about" class="btn btn-outline-light btn-lg">
                <span>Our Story</span>
              </a>
            </div>

            <div class="hero-trust">
              <div class="trust-item"><span>🧴</span> <span>Essential Oils</span></div>
              <div class="trust-item"><span>🍃</span> <span>All Natural</span></div>
              <div class="trust-item"><span>�</span> <span>Made with Love</span></div>
            </div>
          </div>
        </div>
      </section>

      <!-- Featured Categories -->
      <section class="categories" aria-label="Product categories">
        <div class="container">
          <div class="categories-grid">
            <a href="<?php echo esc_url(home_url('/#products')); ?>" class="category-card" data-aos="fade-up" data-aos-delay="100" data-filter="oils">
              <div class="category-image">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/category-oils.jpg" alt="Essential oils and handmade creams" />
              </div>
              <div class="category-info">
                <h3>Oils &amp; Creams</h3>
                <p>Pure essential oils &amp; handmade skincare</p>
              </div>
            </a>
            <a href="<?php echo esc_url(home_url('/#products')); ?>" class="category-card" data-aos="fade-up" data-aos-delay="200" data-filter="wellness">
              <div class="category-image">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/category-wellness.jpg" alt="Mushroom coffee and wellness products" />
              </div>
              <div class="category-info">
                <h3>Coffee &amp; Wellness</h3>
                <p>Fuel your mind &amp; body naturally</p>
              </div>
            </a>
          </div>
        </div>
      </section>

      <!-- About Section -->
      <section class="about" id="about" aria-labelledby="about-title">
        <div class="container">
          <div class="about-grid">
            <div class="about-images" data-aos="fade-right">
              <div class="about-image-main">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/mariaan.jpg" alt="Mariaan - M&amp;E Pure Essential Oils" />
              </div>
              <div class="about-badge">
                <span class="badge-icon">💚</span>
                <span class="badge-text">Made with<br />Love</span>
              </div>
            </div>

            <div class="about-content" data-aos="fade-left">
              <span class="section-eyebrow">Our Story</span>
              <h2 class="section-title" id="about-title">
                Meet <span class="highlight">Mariaan</span>
              </h2>

              <p class="about-text">
                What started as a passion for natural wellness has grown into
                M&amp;E Pure Essential Oils — Mariaan's brand dedicated to
                bringing you the best in essential oils, handcrafted creams, and
                functional wellness products.
              </p>
              <p class="about-text">
                As a proud dōTERRA agent, Mariaan brings you CPTG Certified
                Pure Tested Grade essential oils alongside her own handmade
                creams and premium mushroom coffee — known for incredible health
                benefits including enhanced focus, immune support, and natural
                energy.
              </p>

              <div class="about-values">
                <div class="value-item">
                  <span class="value-icon">🌸</span>
                  <div>
                    <strong>Natural Ingredients</strong>
                    <span>Only the purest, ethically sourced ingredients</span>
                  </div>
                </div>
                <div class="value-item">
                  <span class="value-icon">👩‍🍳</span>
                  <div>
                    <strong>Small Batch</strong>
                    <span>Every product made fresh in small quantities</span>
                  </div>
                </div>
                <div class="value-item">
                  <span class="value-icon">🍄</span>
                  <div>
                    <strong>Functional Wellness</strong>
                    <span>Products that nourish inside and out</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Products Section -->
      <section class="products" id="products" aria-labelledby="products-title">
        <div class="container">
          <div class="text-center">
            <span class="section-eyebrow" data-aos="fade-up">Shop</span>
            <h2 class="section-title" id="products-title" data-aos="fade-up" data-aos-delay="100">
              Our <span class="highlight">Products</span>
            </h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
              Handcrafted with care. Each product is made in small batches to ensure the highest quality.
            </p>
          </div>

          <!-- Filter Buttons -->
          <div class="product-filters" data-aos="fade-up" data-aos-delay="250">
            <button class="filter-btn active" data-filter="all">All Products</button>
            <button class="filter-btn" data-filter="oils">Oils &amp; Creams</button>
            <button class="filter-btn" data-filter="wellness">Coffee &amp; Wellness</button>
          </div>

          <div class="products-grid">
            <?php
            if (function_exists('wc_get_products')) {
                $products = wc_get_products(array(
                    'status'  => 'publish',
                    'limit'   => 20,
                    'orderby' => 'menu_order',
                    'order'   => 'ASC',
                ));

                if (!empty($products)) {
                    $delay = 100;
                    foreach ($products as $product) {
                        $image_url = wp_get_attachment_url($product->get_image_id());
                        if (!$image_url) {
                            $image_url = wc_placeholder_img_src();
                        }
                        
                        // Determine category for filtering
                        $terms = get_the_terms($product->get_id(), 'product_cat');
                        $category_slug = 'oils';
                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                if (in_array($term->slug, array('oils', 'wellness'))) {
                                    $category_slug = $term->slug;
                                    break;
                                }
                            }
                        }
                        
                        // Get tag for badge
                        $tags = get_the_terms($product->get_id(), 'product_tag');
                        $tag_label = '';
                        $tag_class = '';
                        if ($tags && !is_wp_error($tags)) {
                            $tag_name = strtolower($tags[0]->name);
                            if ($tag_name === 'bestseller') {
                                $tag_label = 'Bestseller';
                            } elseif ($tag_name === 'popular') {
                                $tag_label = 'Popular';
                            } elseif ($tag_name === 'new') {
                                $tag_label = 'New';
                                $tag_class = ' tag-new';
                            }
                        }
                        
                        $price = $product->get_price();
                        $size = $product->get_attribute('size');
                        ?>
                        <article class="product-card" data-category="<?php echo esc_attr($category_slug); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
                          <div class="product-image">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" />
                            <?php if ($tag_label) : ?>
                            <span class="product-tag<?php echo esc_attr($tag_class); ?>"><?php echo esc_html($tag_label); ?></span>
                            <?php endif; ?>
                          </div>
                          <div class="product-info">
                            <h3 class="product-name"><?php echo esc_html($product->get_name()); ?></h3>
                            <p class="product-desc"><?php echo esc_html($product->get_short_description()); ?></p>
                            <?php if ($size) : ?>
                            <div class="product-meta">
                              <span class="product-size"><?php echo esc_html($size); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="product-footer">
                              <?php if ($price && $price > 0) : ?>
                              <span class="product-price">R<?php echo esc_html(number_format((float)$price, 0)); ?></span>
                              <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" 
                                 data-quantity="1" 
                                 class="btn btn-primary btn-sm add_to_cart_button ajax_add_to_cart" 
                                 data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                                 data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
                                 aria-label="Add <?php echo esc_attr($product->get_name()); ?> to cart">
                                Add to Cart
                              </a>
                              <?php else : ?>
                              <span class="product-price price-contact">Contact for Price</span>
                              <a href="https://wa.me/27847640549?text=<?php echo urlencode('Hi Mariaan, I\'m interested in ' . $product->get_name()); ?>" 
                                 class="btn btn-outline btn-sm" target="_blank" rel="noopener">
                                Enquire
                              </a>
                              <?php endif; ?>
                            </div>
                          </div>
                        </article>
                        <?php
                        $delay += 50;
                        if ($delay > 300) $delay = 100;
                    }
                } else {
                    // Fallback: no products yet
                    echo '<p class="text-center" style="grid-column: 1 / -1; padding: 2rem;">Products coming soon! Check back shortly.</p>';
                }
            }
            ?>
          </div>

          <?php if (function_exists('wc_get_page_permalink')) : ?>
          <div class="text-center" style="margin-top: 3rem;">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-outline btn-lg">View All Products</a>
          </div>
          <?php endif; ?>
        </div>
      </section>

      <!-- Benefits Banner -->
      <section class="benefits" aria-label="Why choose MeHealth">
        <div class="container">
          <div class="benefits-grid">
            <div class="benefit-item" data-aos="fade-up" data-aos-delay="100">
              <span class="benefit-icon">🌿</span>
              <h3>100% Natural</h3>
              <p>No parabens, no chemicals — just pure natural goodness</p>
            </div>
            <div class="benefit-item" data-aos="fade-up" data-aos-delay="200">
              <span class="benefit-icon">🤲</span>
              <h3>Handcrafted</h3>
              <p>Creams made by hand, oils sourced with care</p>
            </div>
            <div class="benefit-item" data-aos="fade-up" data-aos-delay="300">
              <span class="benefit-icon">🍄</span>
              <h3>Functional</h3>
              <p>Essential oils, mushroom coffee &amp; alkaline water for wellness</p>
            </div>
            <div class="benefit-item" data-aos="fade-up" data-aos-delay="400">
              <span class="benefit-icon">�</span>
              <h3>Made with Love</h3>
              <p>Handmade wellness products crafted with care in South Africa</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Testimonials Section -->
      <section class="testimonials" id="testimonials" aria-labelledby="testimonials-title">
        <div class="container">
          <div class="text-center">
            <span class="section-eyebrow" data-aos="fade-up">Reviews</span>
            <h2 class="section-title" id="testimonials-title" data-aos="fade-up" data-aos-delay="100">
              What Our Customers <span class="highlight">Say</span>
            </h2>
          </div>

          <div class="testimonials-grid">
            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
              <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
              <p class="testimonial-text">
                "The Lavender &amp; Wintergreen Gift Set is absolutely divine!
                The oils are so pure you can tell immediately. I use them every
                night. I'll never go back to synthetic products."
              </p>
              <div class="testimonial-author">
                <div class="testimonial-avatar">A</div>
                <div class="testimonial-info"><strong>Anrike V.</strong><span>Verified Buyer</span></div>
              </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
              <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
              <p class="testimonial-text">
                "I was skeptical about mushroom coffee, but the Reishi blend
                changed my mind! I feel calmer, sleep better, and don't get that
                afternoon crash anymore. Amazing product, Mariaan!"
              </p>
              <div class="testimonial-author">
                <div class="testimonial-avatar">J</div>
                <div class="testimonial-info"><strong>Johan M.</strong><span>Verified Buyer</span></div>
              </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
              <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
              <p class="testimonial-text">
                "The Tea Tree oil cleared up my son's skin issues that no
                pharmacy product could fix. Mariaan is so passionate about what
                she does and it shows in every product. Highly recommend!"
              </p>
              <div class="testimonial-author">
                <div class="testimonial-avatar">S</div>
                <div class="testimonial-info"><strong>Suzanne d.P.</strong><span>Verified Buyer</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Instagram / Social Proof -->
      <section class="social-proof" aria-label="Follow us">
        <div class="container text-center">
          <span class="section-eyebrow" data-aos="fade-up">Follow Along</span>
          <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">
            <span class="highlight">@mehealth_sa</span>
          </h2>
          <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
            Follow Mariaan's journey on social media for recipes, behind-the-scenes, and wellness tips.
          </p>
          <div class="social-grid" data-aos="fade-up" data-aos-delay="300">
            <div class="social-item">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/social-1.jpg" alt="Essential oil gift set" />
            </div>
            <div class="social-item">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/social-2.jpg" alt="Mushroom coffee benefits" />
            </div>
            <div class="social-item">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/social-3.jpg" alt="dōTERRA essential oils" />
            </div>
            <div class="social-item">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/social-4.jpg" alt="Alkaline water" />
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section class="contact" id="contact" aria-labelledby="contact-title">
        <div class="container">
          <div class="text-center">
            <span class="section-eyebrow" data-aos="fade-up">Get In Touch</span>
            <h2 class="section-title" id="contact-title" data-aos="fade-up" data-aos-delay="100">
              Contact <span class="highlight">Mariaan</span>
            </h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
              Have a question about our products or want to place a custom order? Get in touch!
            </p>
          </div>

          <div class="contact-grid">
            <div class="contact-info-cards" data-aos="fade-right">
              <div class="contact-card">
                <span class="contact-icon">📱</span>
                <div><strong>WhatsApp</strong><p><a href="https://wa.me/27847640549">+27 84 764 0549</a></p></div>
              </div>
              <div class="contact-card">
                <span class="contact-icon">✉️</span>
                <div><strong>Email</strong><p><a href="mailto:mariaan@mehealth.co.za">mariaan@mehealth.co.za</a></p></div>
              </div>
              <div class="contact-card">
                <span class="contact-icon">📍</span>
                <div><strong>Location</strong><p>Middelburg, Mpumalanga<br />South Africa</p></div>
              </div>
              <div class="contact-card">
                <span class="contact-icon">🕐</span>
                <div><strong>Order Hours</strong><p>Mon - Fri: 8:00 - 17:00<br />Sat: 9:00 - 13:00</p></div>
              </div>
            </div>

            <form class="contact-form" id="contactForm" data-aos="fade-left">
              <h3 class="form-title">Send a Message</h3>
              <?php wp_nonce_field('mehealth_contact', 'contact_nonce'); ?>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="name">Full Name <span class="required">*</span></label>
                  <input type="text" id="name" name="name" class="form-input" required />
                </div>
                <div class="form-group">
                  <label class="form-label" for="email">Email <span class="required">*</span></label>
                  <input type="email" id="email" name="email" class="form-input" required />
                </div>
              </div>
              <div class="form-group">
                <label class="form-label" for="subject">Subject</label>
                <select id="subject" name="subject" class="form-select">
                  <option value="">Choose a topic...</option>
                  <option value="product-inquiry">Product Inquiry</option>
                  <option value="custom-order">Custom Order</option>
                  <option value="wholesale">Wholesale Inquiry</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label" for="message">Message <span class="required">*</span></label>
                <textarea id="message" name="message" class="form-textarea" rows="5" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-lg form-submit">
                <span>Send Message</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
              </button>
              <div class="form-message" id="formMessage" style="display:none;"></div>
            </form>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="cta" aria-label="Call to action">
        <div class="container">
          <div class="cta-content" data-aos="fade-up">
            <h2 class="cta-title">Ready to Go Natural?</h2>
            <p class="cta-text">
              Browse Mariaan's handcrafted collection and discover the difference that pure, natural ingredients make.
            </p>
            <div class="cta-buttons">
              <a href="#products" class="btn btn-white btn-lg">Shop Now</a>
              <a href="https://wa.me/27847640549" class="btn btn-outline-white btn-lg" target="_blank" rel="noopener">WhatsApp Us</a>
            </div>
          </div>
        </div>
      </section>

<?php get_footer(); ?>
