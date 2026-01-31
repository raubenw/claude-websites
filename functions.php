<?php
/*================================================
# Load the Parent theme style.css file
================================================*/
function dt_enqueue_styles() {
    $parenthandle = 'divi-style'; 
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') 
    );
}
add_action( 'wp_enqueue_scripts', 'dt_enqueue_styles' );

/*================================================
# Custom: Show "per lb" only if product is in Meat category  - Werner 09/20/2025 @ 07h35
================================================*/
add_filter( 'woocommerce_get_price_html', 'wb_change_product_html', 10, 2 );
function wb_change_product_html( $price, $product ) {
    if ( has_term( 'Meat', 'product_cat', $product->get_id() ) ) {
        return '<span class="amount">' . $price . ' per lb</span>';
    }
    return $price;
}

add_filter( 'woocommerce_cart_item_price', 'wb_change_product_price_cart', 10, 3 );
function wb_change_product_price_cart( $price, $cart_item, $cart_item_key ) {
    if ( has_term( 'Meat', 'product_cat', $cart_item['product_id'] ) ) {
        return $price . ' per lb';
    }
    return $price;
}

add_filter( 'woocommerce_checkout_cart_item_quantity', 'wb_checkout_review', 10, 3 );
function wb_checkout_review ( $quantity, $cart_item, $cart_item_key ) {
    if ( has_term( 'Meat', 'product_cat', $cart_item['product_id'] ) ) {
        return ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . ' lb </strong>';
    }
    return ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>';
}


/*================================================
# Custom: Add + / – buttons to WooCommerce quantity fields
# and include robust JS on all front-end pages (Divi-friendly)
================================================*/

// Add minus button before quantity input
add_action( 'woocommerce_before_quantity_input_field', 'divi_add_quantity_minus_button' );
function divi_add_quantity_minus_button() {
    echo '<button type="button" class="minus" aria-label="Decrease quantity">-</button>';
}

// Add plus button after quantity input
add_action( 'woocommerce_after_quantity_input_field', 'divi_add_quantity_plus_button' );
function divi_add_quantity_plus_button() {
    echo '<button type="button" class="plus" aria-label="Increase quantity">+</button>';
}

// Add JS functionality for + / - buttons (prints on all front-end pages)
add_action( 'wp_footer', 'divi_custom_quantity_buttons_script' );
function divi_custom_quantity_buttons_script() {
    // Only print on frontend (not in admin)
    if ( is_admin() ) return;
    ?>
    <script type="text/javascript">
    (function($){
        "use strict";

        function decimalsCount(step){
            if (step === undefined || step === 'any') return 0;
            var s = step.toString();
            if (s.indexOf('.') === -1) return 0;
            return s.split('.')[1].length;
        }

        // delegated click handler (works for dynamic / Divi-inserted content)
        $('body').on('click', '.quantity .plus, .quantity .minus', function(e){
            e.preventDefault();
            var $btn = $(this),
                $qty = $btn.closest('.quantity').find('.qty');

            if ( !$qty.length ) return;

            var current = parseFloat( $qty.val() );
            if ( isNaN(current) ) current = 0;

            var stepAttr = $qty.attr('step');
            var step = ( stepAttr && stepAttr !== 'any' ) ? parseFloat(stepAttr) : 1;
            var decimals = decimalsCount(step);

            var max = parseFloat( $qty.attr('max') );
            var min = parseFloat( $qty.attr('min') );

            var newVal = current + ( $btn.hasClass('plus') ? step : -step );

            if ( !isNaN(max) && newVal > max ) newVal = max;
            if ( !isNaN(min) && newVal < min ) newVal = min;

            // set value with proper decimals
            if ( decimals > 0 ) {
                $qty.val( newVal.toFixed(decimals) );
            } else {
                // avoid decimals if step is integer
                $qty.val( parseInt(newVal,10) );
            }

            // trigger change so WooCommerce updates (fragments / totals / AJAX)
            $qty.trigger('change');

            // update button disabled states (optional)
            updateQtyButtons($btn.closest('.quantity'));
        });

        // Update plus/minus disabled state depending on min/max
        function updateQtyButtons($scope){
            $scope = $scope || $('.quantity');
            $scope.each(function(){
                var $wrap = $(this),
                    $input = $wrap.find('.qty'),
                    $plus = $wrap.find('.plus'),
                    $minus = $wrap.find('.minus');

                if ( !$input.length ) return;

                var val = parseFloat( $input.val() );
                if ( isNaN(val) ) val = 0;
                var max = parseFloat( $input.attr('max') );
                var min = parseFloat( $input.attr('min') );

                if ( !isNaN(max) && val >= max ) {
                    $plus.prop('disabled', true).attr('aria-disabled','true');
                } else {
                    $plus.prop('disabled', false).attr('aria-disabled','false');
                }

                if ( !isNaN(min) && val <= min ) {
                    $minus.prop('disabled', true).attr('aria-disabled','true');
                } else {
                    $minus.prop('disabled', false).attr('aria-disabled','false');
                }
            });
        }

        // Initial call for any quantities present on page load
        $(document).ready(function(){
            updateQtyButtons();
        });

        // Keep buttons in sync when user types in the box
        $('body').on('change input', '.quantity .qty', function(){
            updateQtyButtons( $(this).closest('.quantity') );
        });

    })(jQuery);
    </script>
    <?php
}


/*================================================
# DE BEER BONSMARA - Premium Website Effects
# Added: January 2026
# Scroll animations, preloader, scroll-to-top, etc.
================================================*/
add_action( 'wp_footer', 'debeer_premium_effects_script', 20 );
function debeer_premium_effects_script() {
    if ( is_admin() ) return;
    ?>
    <script type="text/javascript">
    (function(){
        'use strict';

        // Wait for DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            initScrollAnimations();
            initScrollToTop();
            initPreloader();
            initImageEffects();
            initProductCardEffects();
        });

        /**
         * 1. SCROLL-TRIGGERED ANIMATIONS
         */
        function initScrollAnimations() {
            // Add animation classes to Divi modules
            var animateOnScroll = document.querySelectorAll(
                '.et_pb_blurb, .et_pb_image, .et_pb_text, .et_pb_shop, ' +
                '.et_pb_row, .et_pb_testimonial, .et_pb_contact_form, ' +
                '.et_pb_gallery_item, .woocommerce ul.products li.product'
            );

            // Assign animation classes
            animateOnScroll.forEach(function(el, index) {
                if (!el.classList.contains('no-animate') && !el.classList.contains('db-fade-up') && !el.classList.contains('db-slide-left') && !el.classList.contains('db-slide-right')) {
                    el.classList.add('db-fade-up');
                }
            });

            // Intersection Observer for scroll animations
            var observerOptions = {
                root: null,
                rootMargin: '0px 0px -80px 0px',
                threshold: 0.1
            };

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.db-fade-up, .db-scale-in, .db-slide-left, .db-slide-right, .db-stagger-children')
                .forEach(function(el) { observer.observe(el); });
        }

        /**
         * 2. SCROLL TO TOP BUTTON
         */
        function initScrollToTop() {
            // Create button
            var scrollBtn = document.createElement('button');
            scrollBtn.className = 'db-scroll-top';
            scrollBtn.innerHTML = '↑';
            scrollBtn.setAttribute('aria-label', 'Scroll to top');
            document.body.appendChild(scrollBtn);

            // Show/hide based on scroll position
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 500) {
                    scrollBtn.classList.add('visible');
                } else {
                    scrollBtn.classList.remove('visible');
                }
            });

            // Scroll to top on click
            scrollBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        /**
         * 3. PRELOADER
         */
        function initPreloader() {
            // Create preloader
            var preloader = document.createElement('div');
            preloader.className = 'db-preloader';
            preloader.innerHTML = '<div class="db-preloader-spinner"></div><div class="db-preloader-text">De Beer Bonsmara</div>';
            document.body.prepend(preloader);

            // Hide when page loads
            window.addEventListener('load', function() {
                setTimeout(function() {
                    preloader.classList.add('hidden');
                    setTimeout(function() { 
                        if (preloader.parentNode) {
                            preloader.parentNode.removeChild(preloader); 
                        }
                    }, 500);
                }, 300);
            });
        }

        /**
         * 4. IMAGE LAZY EFFECTS
         */
        function initImageEffects() {
            var images = document.querySelectorAll('.et_pb_image img, .et_shop_image img');

            var imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'scale(1)';
                    }
                });
            }, { threshold: 0.1 });

            images.forEach(function(img) {
                img.style.opacity = '0';
                img.style.transform = 'scale(0.95)';
                img.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                imageObserver.observe(img);
            });
        }

        /**
         * 5. PRODUCT CARD 3D TILT EFFECT
         */
        function initProductCardEffects() {
            var productCards = document.querySelectorAll(
                '.woocommerce ul.products li.product, .et_pb_shop .et_pb_shop_item'
            );

            productCards.forEach(function(card) {
                card.addEventListener('mousemove', function(e) {
                    var rect = card.getBoundingClientRect();
                    var x = e.clientX - rect.left;
                    var y = e.clientY - rect.top;
                    var centerX = rect.width / 2;
                    var centerY = rect.height / 2;
                    var rotateX = (y - centerY) / 25;
                    var rotateY = (centerX - x) / 25;

                    card.style.transform = 'perspective(1000px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) translateY(-10px)';
                });

                card.addEventListener('mouseleave', function() {
                    card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
                });
            });
        }

    })();
    </script>
    <?php
}