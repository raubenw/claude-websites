/* ========================================
   MeHealth by Mariaan — JavaScript
   Cart, filters, nav & interactions
   WordPress + WooCommerce version
   ======================================== */

document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  // -------- Preloader --------
  const preloader = document.getElementById("preloader");
  if (preloader) {
    window.addEventListener("load", () => {
      setTimeout(() => preloader.classList.add("hidden"), 600);
    });
    setTimeout(() => preloader.classList.add("hidden"), 3000);
  }

  // -------- AOS Init --------
  if (typeof AOS !== "undefined") {
    AOS.init({
      duration: 700,
      once: true,
      offset: 60,
      easing: "ease-out-cubic",
    });
  }

  // -------- Navbar scroll --------
  const navbar = document.getElementById("navbar");
  const announcementBar = document.querySelector(".announcement-bar");

  function handleNavScroll() {
    const scrollY = window.scrollY;
    if (scrollY > 40) {
      navbar.classList.add("scrolled");
      if (announcementBar)
        announcementBar.style.transform = "translateY(-100%)";
    } else {
      navbar.classList.remove("scrolled");
      if (announcementBar) announcementBar.style.transform = "translateY(0)";
    }
  }

  if (announcementBar) {
    announcementBar.style.transition = "transform 0.3s ease";
  }

  window.addEventListener("scroll", handleNavScroll, { passive: true });
  handleNavScroll();

  // -------- Mobile nav toggle --------
  const navToggle = document.getElementById("navToggle");
  const navMenu = document.getElementById("navMenu");
  let menuOverlay = null;

  if (navToggle && navMenu) {
    function openMenu() {
      navMenu.classList.add("open");
      navToggle.classList.add("active");
      navToggle.setAttribute("aria-expanded", "true");

      if (!menuOverlay) {
        menuOverlay = document.createElement("div");
        menuOverlay.style.cssText =
          "position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:998;opacity:0;transition:opacity 0.3s ease;";
        menuOverlay.addEventListener("click", closeMenu);
        document.body.appendChild(menuOverlay);
      }
      requestAnimationFrame(() => (menuOverlay.style.opacity = "1"));
      document.body.style.overflow = "hidden";
    }

    function closeMenu() {
      navMenu.classList.remove("open");
      navToggle.classList.remove("active");
      navToggle.setAttribute("aria-expanded", "false");

      if (menuOverlay) {
        menuOverlay.style.opacity = "0";
        setTimeout(() => {
          menuOverlay?.remove();
          menuOverlay = null;
        }, 300);
      }
      document.body.style.overflow = "";
    }

    navToggle.addEventListener("click", () => {
      navMenu.classList.contains("open") ? closeMenu() : openMenu();
    });

    navMenu.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", closeMenu);
    });

    // Escape key closes mobile menu
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && navMenu.classList.contains("open")) {
        closeMenu();
      }
    });
  }

  // -------- Active nav link on scroll (homepage only) --------
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-link");

  if (sections.length > 0) {
    function updateActiveLink() {
      const scrollY = window.scrollY + 150;

      sections.forEach((section) => {
        const top = section.offsetTop;
        const height = section.offsetHeight;
        const id = section.getAttribute("id");

        if (scrollY >= top && scrollY < top + height) {
          navLinks.forEach((link) => {
            link.classList.remove("active");
            const href = link.getAttribute("href");
            if (href && href.endsWith(`#${id}`)) {
              link.classList.add("active");
            }
          });
        }
      });
    }

    window.addEventListener("scroll", updateActiveLink, { passive: true });
  }

  // -------- Product Filter --------
  const filterBtns = document.querySelectorAll(".filter-btn");
  const productCards = document.querySelectorAll(".product-card");

  filterBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const filter = btn.dataset.filter;

      filterBtns.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      productCards.forEach((card) => {
        const category = card.dataset.category;
        if (filter === "all" || category === filter) {
          card.classList.remove("hidden");
          card.style.opacity = "0";
          card.style.transform = "translateY(20px)";
          requestAnimationFrame(() => {
            card.style.transition = "opacity 0.4s ease, transform 0.4s ease";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
          });
        } else {
          card.classList.add("hidden");
        }
      });
    });
  });

  // Category card clicks
  document.querySelectorAll(".category-card").forEach((card) => {
    card.addEventListener("click", (e) => {
      e.preventDefault();
      const filter = card.dataset.filter;
      if (filter) {
        const btn = document.querySelector(
          `.filter-btn[data-filter="${CSS.escape(filter)}"]`,
        );
        if (btn) btn.click();

        document
          .getElementById("products")
          ?.scrollIntoView({ behavior: "smooth" });
      }
    });
  });

  // -------- Scroll to Top --------
  const scrollTopBtn = document.getElementById("scrollTop");
  if (scrollTopBtn) {
    function toggleScrollTop() {
      if (window.scrollY > 500) {
        scrollTopBtn.classList.add("visible");
      } else {
        scrollTopBtn.classList.remove("visible");
      }
    }

    window.addEventListener("scroll", toggleScrollTop, { passive: true });

    scrollTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // -------- Smooth scroll for anchor links --------
  document.querySelectorAll('a[href*="#"]').forEach((anchor) => {
    anchor.addEventListener("click", (e) => {
      const href = anchor.getAttribute("href");
      // Only handle hash-only or same-page hash links
      if (!href || href === "#") return;
      
      const hashIndex = href.indexOf("#");
      if (hashIndex === -1) return;
      
      const hash = href.substring(hashIndex);
      const target = document.querySelector(hash);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });

  // -------- WooCommerce AJAX Add to Cart feedback --------
  // WooCommerce fires this event when item is added to cart via AJAX
  if (typeof jQuery !== "undefined") {
    jQuery(document.body).on("added_to_cart", function (e, fragments, cart_hash, $button) {
      // Update cart count from fragments
      if (fragments && fragments[".cart-count"]) {
        document.querySelectorAll(".cart-count").forEach((el) => {
          el.textContent = fragments[".cart-count"];
        });
      }

      // Button feedback
      if ($button && $button.length) {
        const btn = $button[0];
        const original = btn.textContent;
        btn.textContent = "✓ Added!";
        btn.style.background = "#4caf50";
        btn.style.borderColor = "#4caf50";

        setTimeout(() => {
          btn.textContent = original;
          btn.style.background = "";
          btn.style.borderColor = "";
        }, 1500);
      }
    });
  }

  // -------- Contact Form (AJAX → WordPress) --------
  const contactForm = document.getElementById("contactForm");
  if (contactForm && typeof mehealth_ajax !== "undefined") {
    contactForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const btn = contactForm.querySelector(".form-submit");
      const msgDiv = document.getElementById("formMessage");
      const originalText = btn.innerHTML;

      btn.innerHTML = "<span>Sending...</span>";
      btn.disabled = true;

      const formData = new FormData(contactForm);
      formData.append("action", "mehealth_contact");
      formData.append("nonce", mehealth_ajax.nonce);

      fetch(mehealth_ajax.ajax_url, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            btn.innerHTML = "<span>✓ Message Sent!</span>";
            btn.style.background = "#4caf50";
            btn.style.borderColor = "#4caf50";
            contactForm.reset();
            if (msgDiv) {
              msgDiv.className = "form-message success";
              msgDiv.textContent = "Thank you! Your message has been sent.";
              msgDiv.style.display = "block";
            }
          } else {
            btn.innerHTML = "<span>✗ Failed to send</span>";
            btn.style.background = "#e74c3c";
            btn.style.borderColor = "#e74c3c";
            if (msgDiv) {
              msgDiv.className = "form-message error";
              msgDiv.textContent = data.data || "Something went wrong. Please try again.";
              msgDiv.style.display = "block";
            }
          }

          setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = "";
            btn.style.borderColor = "";
            btn.disabled = false;
          }, 3000);
        })
        .catch(() => {
          btn.innerHTML = "<span>✗ Network error</span>";
          btn.style.background = "#e74c3c";
          btn.style.borderColor = "#e74c3c";

          setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = "";
            btn.style.borderColor = "";
            btn.disabled = false;
          }, 3000);
        });
    });
  }

  // -------- Parallax on hero image --------
  const heroBgImage = document.querySelector(".hero-bg-image");
  if (heroBgImage && window.innerWidth > 768) {
    window.addEventListener(
      "scroll",
      () => {
        const scrollY = window.scrollY;
        if (scrollY < window.innerHeight) {
          heroBgImage.style.transform = `translateY(${scrollY * 0.3}px)`;
        }
      },
      { passive: true },
    );
  }

  // -------- Lazy image loading --------
  if ("IntersectionObserver" in window) {
    const imgObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.removeAttribute("data-src");
            }
            img.classList.add("loaded");
            imgObserver.unobserve(img);
          }
        });
      },
      { rootMargin: "100px" },
    );

    document.querySelectorAll("img[data-src]").forEach((img) => {
      imgObserver.observe(img);
    });
  }
});
