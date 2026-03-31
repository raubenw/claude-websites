/* =============================================
   IVORY DENTAL STUDIO — Demo JavaScript
   ============================================= */
(function () {
  "use strict";

  /* ---------- Preloader ---------- */
  window.addEventListener("load", function () {
    var preloader = document.querySelector(".preloader");
    if (preloader) {
      setTimeout(function () {
        preloader.classList.add("loaded");
      }, 600);
    }
    // Init AOS
    if (typeof AOS !== "undefined") {
      AOS.init({
        duration: 700,
        easing: "ease-out-cubic",
        once: true,
        offset: 60,
      });
    }
  });

  /* ---------- Navbar Scroll ---------- */
  var navbar = document.querySelector(".navbar");
  var topBar = document.querySelector(".top-bar");
  function handleScroll() {
    var scrollY = window.scrollY;
    if (navbar) {
      navbar.classList.toggle("scrolled", scrollY > 40);
    }
    if (topBar) {
      topBar.style.transform =
        scrollY > 40 ? "translateY(-100%)" : "translateY(0)";
      topBar.style.transition = "transform .3s ease";
    }
    // Navbar offset
    if (navbar) {
      navbar.style.top =
        scrollY > 40 ? "0" : topBar ? topBar.offsetHeight + "px" : "0";
    }
  }
  // Initial position
  if (navbar && topBar) {
    navbar.style.top = topBar.offsetHeight + "px";
  }
  window.addEventListener("scroll", handleScroll, { passive: true });
  handleScroll();

  /* ---------- Mobile Menu Toggle ---------- */
  var toggle = document.querySelector(".nav-toggle");
  var menu = document.querySelector(".nav-menu");
  if (toggle && menu) {
    toggle.addEventListener("click", function () {
      toggle.classList.toggle("active");
      menu.classList.toggle("active");
      document.body.style.overflow = menu.classList.contains("active")
        ? "hidden"
        : "";
    });
    // Close menu on link click
    var navLinks = menu.querySelectorAll(".nav-link");
    navLinks.forEach(function (link) {
      link.addEventListener("click", function () {
        toggle.classList.remove("active");
        menu.classList.remove("active");
        document.body.style.overflow = "";
      });
    });
  }

  /* ---------- Active Nav Link on Scroll ---------- */
  var sections = document.querySelectorAll("section[id]");
  var navMenuLinks = document.querySelectorAll(".nav-link");
  function setActiveLink() {
    var scrollPos = window.scrollY + 120;
    sections.forEach(function (section) {
      var top = section.offsetTop;
      var height = section.offsetHeight;
      var id = section.getAttribute("id");
      if (scrollPos >= top && scrollPos < top + height) {
        navMenuLinks.forEach(function (link) {
          link.classList.remove("active");
          if (link.getAttribute("href") === "#" + id) {
            link.classList.add("active");
          }
        });
      }
    });
  }
  window.addEventListener("scroll", setActiveLink, { passive: true });

  /* ---------- Hero Slider ---------- */
  var slides = document.querySelectorAll(".hero-slide");
  if (slides.length > 1) {
    var currentSlide = 0;
    setInterval(function () {
      slides[currentSlide].classList.remove("active");
      currentSlide = (currentSlide + 1) % slides.length;
      slides[currentSlide].classList.add("active");
    }, 5000);
  }

  /* ---------- Smooth Scroll ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener("click", function (e) {
      var targetId = this.getAttribute("href");
      if (targetId === "#") return;
      var target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        var offset = navbar ? navbar.offsetHeight + 20 : 80;
        var top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top: top, behavior: "smooth" });
      }
    });
  });

  /* ---------- Testimonial Slider ---------- */
  var track = document.querySelector(".testimonial-track");
  var cards = document.querySelectorAll(".testimonial-card");
  var prevBtn = document.querySelector(".testimonial-btn.prev");
  var nextBtn = document.querySelector(".testimonial-btn.next");
  var dots = document.querySelectorAll(".testimonial-dots .dot");
  var currentTestimonial = 0;

  function goToTestimonial(index) {
    if (index < 0) index = cards.length - 1;
    if (index >= cards.length) index = 0;
    currentTestimonial = index;
    if (track) {
      track.style.transform = "translateX(-" + currentTestimonial * 100 + "%)";
    }
    dots.forEach(function (d, i) {
      d.classList.toggle("active", i === currentTestimonial);
    });
  }

  if (prevBtn)
    prevBtn.addEventListener("click", function () {
      goToTestimonial(currentTestimonial - 1);
    });
  if (nextBtn)
    nextBtn.addEventListener("click", function () {
      goToTestimonial(currentTestimonial + 1);
    });
  dots.forEach(function (dot, i) {
    dot.addEventListener("click", function () {
      goToTestimonial(i);
    });
  });

  // Auto-advance testimonials
  var testimonialTimer = setInterval(function () {
    goToTestimonial(currentTestimonial + 1);
  }, 6000);

  // Pause on hover
  var testimonialSection = document.querySelector(".testimonials-slider");
  if (testimonialSection) {
    testimonialSection.addEventListener("mouseenter", function () {
      clearInterval(testimonialTimer);
    });
    testimonialSection.addEventListener("mouseleave", function () {
      testimonialTimer = setInterval(function () {
        goToTestimonial(currentTestimonial + 1);
      }, 6000);
    });
  }

  /* ---------- Contact Form (Demo) ---------- */
  var form = document.querySelector(".contact-form");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var btn = form.querySelector('button[type="submit"]');
      var originalText = btn.textContent;
      btn.textContent = "Sending...";
      btn.disabled = true;

      // Simulate submission
      setTimeout(function () {
        btn.textContent = "Appointment Requested!";
        btn.style.background = "#38a169";
        form.reset();
        setTimeout(function () {
          btn.textContent = originalText;
          btn.style.background = "";
          btn.disabled = false;
        }, 3000);
      }, 1500);
    });
  }

  /* ---------- Counter Animation (Experience badge) ---------- */
  function animateCounters() {
    var badge = document.querySelector(".about-experience-badge strong");
    if (!badge || badge.dataset.animated) return;

    var rect = badge.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom > 0) {
      badge.dataset.animated = "true";
      var target = parseInt(badge.textContent, 10);
      var current = 0;
      var step = Math.ceil(target / 30);
      var interval = setInterval(function () {
        current += step;
        if (current >= target) {
          current = target;
          clearInterval(interval);
        }
        badge.textContent = current + "+";
      }, 50);
    }
  }
  window.addEventListener("scroll", animateCounters, { passive: true });
})();
