/**
 * DE BEER BONSMARA - Premium JavaScript Effects
 * World-Class Farm Website Enhancements
 * Version: 2.0
 */

(function () {
  "use strict";

  // Wait for DOM to be ready
  document.addEventListener("DOMContentLoaded", function () {
    initScrollAnimations();
    initParallaxEffects();
    initSmoothScrolling();
    initScrollToTop();
    initHeaderEffects();
    initImageLazyEffects();
    initCounterAnimations();
    initProductCardEffects();
    initMagneticButtons();
    initCursorEffects();
    initTypewriterEffect();
    initPreloader();
  });

  /**
   * 1. SCROLL-TRIGGERED ANIMATIONS
   * Animate elements as they enter the viewport
   */
  function initScrollAnimations() {
    // Add animation classes to Divi modules
    const animateOnScroll = document.querySelectorAll(
      ".et_pb_blurb, .et_pb_image, .et_pb_text, .et_pb_shop, " +
        ".et_pb_row, .et_pb_testimonial, .et_pb_contact_form, " +
        ".et_pb_gallery_item, .woocommerce-loop-product",
    );

    // Assign animation classes based on position
    animateOnScroll.forEach((el, index) => {
      if (!el.classList.contains("no-animate")) {
        const animationType = index % 3;
        switch (animationType) {
          case 0:
            el.classList.add("db-fade-up");
            break;
          case 1:
            el.classList.add("db-slide-left");
            break;
          case 2:
            el.classList.add("db-slide-right");
            break;
        }
      }
    });

    // Intersection Observer for scroll animations
    const observerOptions = {
      root: null,
      rootMargin: "0px 0px -100px 0px",
      threshold: 0.1,
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          // Optional: stop observing after animation
          // observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    document
      .querySelectorAll(
        ".db-fade-up, .db-scale-in, .db-slide-left, .db-slide-right, .db-stagger-children",
      )
      .forEach((el) => observer.observe(el));
  }

  /**
   * 2. PARALLAX EFFECTS
   * Smooth parallax scrolling for background images
   */
  function initParallaxEffects() {
    const parallaxElements = document.querySelectorAll(
      ".et_pb_section_parallax, .parallax-bg",
    );

    if (parallaxElements.length === 0) return;

    let ticking = false;

    function updateParallax() {
      const scrolled = window.pageYOffset;

      parallaxElements.forEach((el) => {
        const speed = el.dataset.parallaxSpeed || 0.5;
        const rect = el.getBoundingClientRect();
        const inView = rect.bottom > 0 && rect.top < window.innerHeight;

        if (inView) {
          const yPos = (scrolled - el.offsetTop) * speed;
          el.style.backgroundPositionY = `${yPos}px`;
        }
      });

      ticking = false;
    }

    window.addEventListener("scroll", () => {
      if (!ticking) {
        requestAnimationFrame(updateParallax);
        ticking = true;
      }
    });
  }

  /**
   * 3. SMOOTH SCROLLING
   * Enhanced smooth scroll for anchor links
   */
  function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        const href = this.getAttribute("href");

        if (href === "#" || href === "#0") return;

        const target = document.querySelector(href);

        if (target) {
          e.preventDefault();

          const headerOffset = 100;
          const elementPosition = target.getBoundingClientRect().top;
          const offsetPosition =
            elementPosition + window.pageYOffset - headerOffset;

          window.scrollTo({
            top: offsetPosition,
            behavior: "smooth",
          });
        }
      });
    });
  }

  /**
   * 4. SCROLL TO TOP BUTTON
   */
  function initScrollToTop() {
    // Create button
    const scrollBtn = document.createElement("div");
    scrollBtn.className = "db-scroll-top";
    scrollBtn.innerHTML = "↑";
    scrollBtn.setAttribute("aria-label", "Scroll to top");
    document.body.appendChild(scrollBtn);

    // Show/hide based on scroll position
    window.addEventListener("scroll", () => {
      if (window.pageYOffset > 500) {
        scrollBtn.classList.add("visible");
      } else {
        scrollBtn.classList.remove("visible");
      }
    });

    // Scroll to top on click
    scrollBtn.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }

  /**
   * 5. HEADER EFFECTS
   * Dynamic header styling on scroll
   */
  function initHeaderEffects() {
    const header = document.getElementById("main-header");

    if (!header) return;

    let lastScroll = 0;

    window.addEventListener("scroll", () => {
      const currentScroll = window.pageYOffset;

      // Add/remove scrolled class
      if (currentScroll > 100) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }

      // Hide header on scroll down, show on scroll up
      if (currentScroll > lastScroll && currentScroll > 300) {
        header.style.transform = "translateY(-100%)";
      } else {
        header.style.transform = "translateY(0)";
      }

      lastScroll = currentScroll;
    });
  }

  /**
   * 6. IMAGE LAZY LOADING EFFECTS
   * Add reveal animations to images
   */
  function initImageLazyEffects() {
    const images = document.querySelectorAll(
      ".et_pb_image img, .et_shop_image img, .woocommerce-loop-product img",
    );

    const imageObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("loaded");
            entry.target.style.opacity = "1";
            entry.target.style.transform = "scale(1)";
          }
        });
      },
      { threshold: 0.1 },
    );

    images.forEach((img) => {
      img.style.opacity = "0";
      img.style.transform = "scale(0.95)";
      img.style.transition = "opacity 0.6s ease, transform 0.6s ease";
      imageObserver.observe(img);
    });
  }

  /**
   * 7. COUNTER ANIMATIONS
   * Animate number counters when visible
   */
  function initCounterAnimations() {
    const counters = document.querySelectorAll(
      ".et_pb_number_counter .percent",
    );

    const counterObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            counterObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 },
    );

    counters.forEach((counter) => counterObserver.observe(counter));

    function animateCounter(element) {
      const target =
        parseInt(element.dataset.width) || parseInt(element.textContent);
      const duration = 2000;
      const step = target / (duration / 16);
      let current = 0;

      const timer = setInterval(() => {
        current += step;
        if (current >= target) {
          element.textContent = target;
          clearInterval(timer);
        } else {
          element.textContent = Math.floor(current);
        }
      }, 16);
    }
  }

  /**
   * 8. PRODUCT CARD EFFECTS
   * Enhanced hover interactions
   */
  function initProductCardEffects() {
    const productCards = document.querySelectorAll(
      ".woocommerce ul.products li.product, .et_pb_shop .et_pb_shop_item",
    );

    productCards.forEach((card) => {
      // 3D tilt effect on hover
      card.addEventListener("mousemove", (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = (y - centerY) / 20;
        const rotateY = (centerX - x) / 20;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
      });

      card.addEventListener("mouseleave", () => {
        card.style.transform =
          "perspective(1000px) rotateX(0) rotateY(0) translateY(0)";
      });
    });
  }

  /**
   * 9. MAGNETIC BUTTONS
   * Buttons that follow cursor slightly
   */
  function initMagneticButtons() {
    const buttons = document.querySelectorAll(
      ".et_pb_button, .add_to_cart_button",
    );

    buttons.forEach((btn) => {
      btn.addEventListener("mousemove", (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;

        btn.style.transform = `translate(${x * 0.2}px, ${y * 0.2}px)`;
      });

      btn.addEventListener("mouseleave", () => {
        btn.style.transform = "translate(0, 0)";
      });
    });
  }

  /**
   * 10. CUSTOM CURSOR EFFECTS (Optional - Premium Feel)
   */
  function initCursorEffects() {
    // Only on desktop
    if (window.innerWidth < 1024) return;

    // Create custom cursor elements
    const cursor = document.createElement("div");
    cursor.className = "db-cursor";
    cursor.innerHTML =
      '<div class="db-cursor-dot"></div><div class="db-cursor-ring"></div>';
    document.body.appendChild(cursor);

    const dot = cursor.querySelector(".db-cursor-dot");
    const ring = cursor.querySelector(".db-cursor-ring");

    // Add styles
    const style = document.createElement("style");
    style.textContent = `
            .db-cursor {
                pointer-events: none;
                position: fixed;
                z-index: 99999;
            }
            .db-cursor-dot {
                position: fixed;
                width: 8px;
                height: 8px;
                background: var(--db-gold, #C9A227);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: transform 0.1s ease;
            }
            .db-cursor-ring {
                position: fixed;
                width: 40px;
                height: 40px;
                border: 2px solid rgba(201, 162, 39, 0.5);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: all 0.15s ease;
            }
            .db-cursor-hover .db-cursor-ring {
                width: 60px;
                height: 60px;
                border-color: var(--db-gold, #C9A227);
                background: rgba(201, 162, 39, 0.1);
            }
            .db-cursor-hover .db-cursor-dot {
                transform: translate(-50%, -50%) scale(0.5);
            }
        `;
    document.head.appendChild(style);

    // Track cursor movement
    document.addEventListener("mousemove", (e) => {
      dot.style.left = e.clientX + "px";
      dot.style.top = e.clientY + "px";
      ring.style.left = e.clientX + "px";
      ring.style.top = e.clientY + "px";
    });

    // Add hover effect on interactive elements
    const hoverElements = document.querySelectorAll(
      "a, button, .et_pb_button, input, .clickable",
    );
    hoverElements.forEach((el) => {
      el.addEventListener("mouseenter", () =>
        cursor.classList.add("db-cursor-hover"),
      );
      el.addEventListener("mouseleave", () =>
        cursor.classList.remove("db-cursor-hover"),
      );
    });
  }

  /**
   * 11. TYPEWRITER EFFECT
   * For hero headlines (optional)
   */
  function initTypewriterEffect() {
    const elements = document.querySelectorAll(".db-typewriter");

    elements.forEach((el) => {
      const text = el.textContent;
      el.textContent = "";
      el.style.visibility = "visible";

      let i = 0;
      const speed = 80;

      function type() {
        if (i < text.length) {
          el.textContent += text.charAt(i);
          i++;
          setTimeout(type, speed);
        }
      }

      // Start typing when element is visible
      const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
          type();
          observer.disconnect();
        }
      });
      observer.observe(el);
    });
  }

  /**
   * 12. PRELOADER
   */
  function initPreloader() {
    // Check if preloader exists
    let preloader = document.querySelector(".db-preloader");

    if (!preloader) {
      // Create preloader
      preloader = document.createElement("div");
      preloader.className = "db-preloader";
      preloader.innerHTML = `
                <div class="db-preloader-content">
                    <div class="db-preloader-spinner"></div>
                    <div class="db-preloader-text">De Beer Bonsmara</div>
                </div>
            `;
      document.body.prepend(preloader);

      // Add styles
      const style = document.createElement("style");
      style.textContent = `
                .db-preloader-text {
                    margin-top: 20px;
                    font-family: 'Playfair Display', Georgia, serif;
                    font-size: 1.5rem;
                    color: #C9A227;
                    letter-spacing: 0.1em;
                }
            `;
      document.head.appendChild(style);
    }

    // Hide preloader when page is loaded
    window.addEventListener("load", () => {
      setTimeout(() => {
        preloader.classList.add("hidden");
        setTimeout(() => preloader.remove(), 500);
      }, 500);
    });
  }

  /**
   * 13. ADD TO CART ANIMATION
   */
  function initAddToCartAnimation() {
    document.body.addEventListener("click", (e) => {
      if (e.target.classList.contains("add_to_cart_button")) {
        const btn = e.target;
        btn.classList.add("adding");

        setTimeout(() => {
          btn.classList.remove("adding");
          btn.classList.add("added");

          // Create floating cart animation
          const cart = document.createElement("div");
          cart.className = "db-flying-cart";
          cart.innerHTML = "🛒";
          cart.style.cssText = `
                        position: fixed;
                        left: ${e.clientX}px;
                        top: ${e.clientY}px;
                        font-size: 30px;
                        z-index: 9999;
                        animation: flyToCart 0.8s ease forwards;
                    `;
          document.body.appendChild(cart);

          setTimeout(() => cart.remove(), 800);
        }, 1000);
      }
    });

    // Add animation keyframes
    const style = document.createElement("style");
    style.textContent = `
            @keyframes flyToCart {
                to {
                    top: 20px;
                    right: 50px;
                    opacity: 0;
                    transform: scale(0.3);
                }
            }
            .add_to_cart_button.adding {
                animation: pulse 0.5s ease infinite;
            }
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
        `;
    document.head.appendChild(style);
  }

  /**
   * 14. SMOOTH REVEAL FOR SECTIONS
   */
  function initSectionReveal() {
    const sections = document.querySelectorAll(".et_pb_section");

    sections.forEach((section, index) => {
      section.style.opacity = "0";
      section.style.transform = "translateY(30px)";
      section.style.transition = `opacity 0.8s ease ${index * 0.1}s, transform 0.8s ease ${index * 0.1}s`;
    });

    // Reveal on load
    window.addEventListener("load", () => {
      sections.forEach((section) => {
        section.style.opacity = "1";
        section.style.transform = "translateY(0)";
      });
    });
  }

  /**
   * 15. NAVBAR ACTIVE STATE INDICATOR
   */
  function initNavbarIndicator() {
    const navLinks = document.querySelectorAll("#top-menu > li > a");

    // Create indicator element
    const indicator = document.createElement("span");
    indicator.className = "db-nav-indicator";
    indicator.style.cssText = `
            position: absolute;
            bottom: 0;
            height: 3px;
            background: linear-gradient(90deg, #C9A227, #E8D48A);
            border-radius: 3px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        `;

    const nav = document.querySelector("#top-menu");
    if (nav) {
      nav.style.position = "relative";
      nav.appendChild(indicator);

      navLinks.forEach((link) => {
        link.addEventListener("mouseenter", function () {
          const rect = this.getBoundingClientRect();
          const navRect = nav.getBoundingClientRect();
          indicator.style.width = rect.width + "px";
          indicator.style.left = rect.left - navRect.left + "px";
          indicator.style.opacity = "1";
        });
      });

      nav.addEventListener("mouseleave", () => {
        indicator.style.opacity = "0";
      });
    }
  }

  // Initialize additional effects
  initAddToCartAnimation();
  initNavbarIndicator();
})();

/**
 * GSAP-like Animation Helper (Lightweight)
 * For more complex animations without loading GSAP
 */
class DBAnimate {
  static fadeIn(element, duration = 600, delay = 0) {
    element.style.opacity = "0";
    element.style.transition = `opacity ${duration}ms ease ${delay}ms`;
    setTimeout(() => (element.style.opacity = "1"), 10);
  }

  static slideUp(element, duration = 600, delay = 0) {
    element.style.opacity = "0";
    element.style.transform = "translateY(40px)";
    element.style.transition = `all ${duration}ms cubic-bezier(0.4, 0, 0.2, 1) ${delay}ms`;
    setTimeout(() => {
      element.style.opacity = "1";
      element.style.transform = "translateY(0)";
    }, 10);
  }

  static stagger(elements, animation, staggerDelay = 100) {
    elements.forEach((el, i) => {
      animation(el, 600, i * staggerDelay);
    });
  }
}

// Export for use
window.DBAnimate = DBAnimate;
