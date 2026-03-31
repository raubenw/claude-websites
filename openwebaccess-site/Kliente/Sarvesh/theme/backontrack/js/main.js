/* ============================================
   Back on Track Chiropractic & Wellness
   Main JavaScript (WordPress)
   ============================================ */

(function () {
  "use strict";

  // ---------- Navbar Scroll ----------
  var navbar = document.getElementById("navbar");
  var backToTop = document.getElementById("backToTop");
  var topBar = document.getElementById("topBar");

  function handleScroll() {
    var scrollY = window.scrollY;

    if (topBar) {
      if (scrollY > 80) {
        topBar.classList.add("hidden");
        navbar.classList.add("scrolled");
      } else {
        topBar.classList.remove("hidden");
        navbar.classList.remove("scrolled");
      }
    }

    if (backToTop) {
      if (scrollY > 500) {
        backToTop.classList.add("visible");
      } else {
        backToTop.classList.remove("visible");
      }
    }
  }

  window.addEventListener("scroll", handleScroll, { passive: true });
  handleScroll();

  // ---------- Hero Image Slider ----------
  var heroImages = document.querySelectorAll(".hero-bg-image");
  if (heroImages.length > 1) {
    var currentSlide = 0;
    setInterval(function () {
      heroImages[currentSlide].classList.remove("active");
      currentSlide = (currentSlide + 1) % heroImages.length;
      heroImages[currentSlide].classList.add("active");
    }, 5000);
  }

  // ---------- Back to Top ----------
  if (backToTop) {
    backToTop.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // ---------- Mobile Nav Toggle ----------
  var navToggle = document.getElementById("navToggle");
  var navMenu = document.getElementById("navMenu");

  if (navToggle && navMenu) {
    navToggle.addEventListener("click", function () {
      navToggle.classList.toggle("active");
      navMenu.classList.toggle("active");
      document.body.style.overflow = navMenu.classList.contains("active")
        ? "hidden"
        : "";
    });

    document.querySelectorAll(".nav-link").forEach(function (link) {
      link.addEventListener("click", function () {
        navToggle.classList.remove("active");
        navMenu.classList.remove("active");
        document.body.style.overflow = "";
      });
    });
  }

  // ---------- Smooth Scroll ----------
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener("click", function (e) {
      var href = this.getAttribute("href");
      if (href === "#") return;
      e.preventDefault();
      var target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  });

  // ---------- Scroll Animations ----------
  var animatedElements = document.querySelectorAll(
    ".service-card, .video-card, .info-card, .info-bar-item, .rl-benefit, .icon-card, .about-content, .about-visual, .red-light-content, .red-light-images",
  );

  animatedElements.forEach(function (el) {
    el.classList.add("fade-in");
  });

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.1,
      rootMargin: "0px 0px -40px 0px",
    },
  );

  animatedElements.forEach(function (el) {
    observer.observe(el);
  });

  // ---------- Active Nav Highlight ----------
  var sections = document.querySelectorAll("section[id]");

  function highlightNav() {
    var scrollPos = window.scrollY + 100;
    sections.forEach(function (section) {
      var top = section.offsetTop;
      var height = section.offsetHeight;
      var id = section.getAttribute("id");

      if (scrollPos >= top && scrollPos < top + height) {
        document.querySelectorAll(".nav-link").forEach(function (link) {
          link.classList.remove("active");
          var href = link.getAttribute("href");
          if (href === "#" + id || (href && href.endsWith("#" + id))) {
            link.classList.add("active");
          }
        });
      }
    });
  }

  window.addEventListener("scroll", highlightNav, { passive: true });

  // ---------- Contact Form (WordPress AJAX) ----------
  var contactForm = document.getElementById("contactForm");
  var formStatus = document.getElementById("formStatus");

  if (contactForm && typeof botAjax !== "undefined") {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault();

      // Honeypot check
      var honeypot = contactForm.querySelector('input[name="website"]');
      if (honeypot && honeypot.value) return;

      var submitBtn = contactForm.querySelector('button[type="submit"]');
      var originalText = submitBtn.innerHTML;

      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
      formStatus.className = "form-status sending";
      formStatus.textContent = "Sending your message...";
      formStatus.style.display = "block";

      var formData = new FormData(contactForm);
      formData.append("action", "bot_contact");
      formData.append("nonce", botAjax.nonce);

      fetch(botAjax.ajaxUrl, {
        method: "POST",
        body: formData,
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          if (data.success) {
            formStatus.className = "form-status success";
            formStatus.textContent =
              data.message ||
              "Thank you! Your message has been sent successfully.";
            contactForm.reset();
          } else {
            formStatus.className = "form-status error";
            formStatus.textContent =
              data.message || "Something went wrong. Please try again.";
          }
        })
        .catch(function () {
          formStatus.className = "form-status error";
          formStatus.textContent =
            "Something went wrong. Please try calling us at 066 087 3258 or emailing backontrackwellness13@gmail.com directly.";
        })
        .finally(function () {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
    });
  }

  // ---------- Lazy load YouTube videos ----------
  document
    .querySelectorAll(".video-card:not(.featured-video)")
    .forEach(function (card) {
      var wrapper = card.querySelector(".video-wrapper");
      var iframe = wrapper ? wrapper.querySelector("iframe") : null;
      if (!iframe) return;

      var src = iframe.getAttribute("src");
      var match = src.match(/embed\/([a-zA-Z0-9_-]+)/);
      if (!match) return;

      var videoId = match[1];
      var title = iframe.getAttribute("title") || "Play video";

      var placeholder = document.createElement("div");
      placeholder.className = "video-placeholder";
      placeholder.style.cssText =
        "position:absolute;inset:0;cursor:pointer;background:#000;display:flex;align-items:center;justify-content:center;";
      placeholder.innerHTML =
        '<img src="https://img.youtube.com/vi/' +
        videoId +
        '/hqdefault.jpg" alt="' +
        title +
        '" style="width:100%;height:100%;object-fit:cover;opacity:0.8;">' +
        '<div style="position:absolute;width:68px;height:48px;background:rgba(0,0,0,0.7);border-radius:12px;display:flex;align-items:center;justify-content:center;">' +
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg></div>';

      iframe.remove();
      wrapper.appendChild(placeholder);

      placeholder.addEventListener("click", function () {
        var newIframe = document.createElement("iframe");
        newIframe.src = src + "?autoplay=1";
        newIframe.title = title;
        newIframe.frameBorder = "0";
        newIframe.allow =
          "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
        newIframe.allowFullscreen = true;
        newIframe.style.cssText =
          "position:absolute;top:0;left:0;width:100%;height:100%;";
        placeholder.remove();
        wrapper.appendChild(newIframe);
      });
    });

  // ---- Shop Quantity +/- AJAX Controls ----
  document.querySelectorAll(".shop-product").forEach(function (card) {
    var productId = card.getAttribute("data-product-id");
    if (!productId) return;
    var minusBtn = card.querySelector(".qty-minus");
    var plusBtn = card.querySelector(".qty-plus");
    var qtyDisplay = card.querySelector(".qty-value");
    if (!minusBtn || !plusBtn || !qtyDisplay) return;

    function updateCart(action) {
      minusBtn.disabled = true;
      plusBtn.disabled = true;
      var formData = new FormData();
      formData.append("action", "bot_update_cart");
      formData.append("nonce", botAjax.cartNonce);
      formData.append("product_id", productId);
      formData.append("cart_action", action);

      fetch(botAjax.ajaxUrl, {
        method: "POST",
        body: formData,
        credentials: "same-origin",
      })
        .then(function (r) {
          return r.json();
        })
        .then(function (data) {
          if (data.success) {
            qtyDisplay.textContent = data.qty;
            qtyDisplay.classList.toggle("has-items", data.qty > 0);
            // Update cart link count if present
            var cartLink = document.querySelector(
              ".shop-cart-link .btn-outline",
            );
            if (cartLink && data.cart_total > 0) {
              cartLink.innerHTML =
                '<i class="fas fa-shopping-cart"></i> View Cart (' +
                data.cart_total +
                ")";
            } else if (cartLink) {
              cartLink.innerHTML =
                '<i class="fas fa-shopping-cart"></i> View Cart &amp; Checkout';
            }
          }
        })
        .finally(function () {
          minusBtn.disabled = false;
          plusBtn.disabled = false;
        });
    }

    plusBtn.addEventListener("click", function (e) {
      e.preventDefault();
      updateCart("add");
    });

    minusBtn.addEventListener("click", function (e) {
      e.preventDefault();
      var current = parseInt(qtyDisplay.textContent, 10) || 0;
      if (current > 0) {
        updateCart("remove");
      }
    });
  });
})();
