/* =============================================
   OPEN WEB ACCESS — Main JavaScript
   Accessible, modern, performant
   ============================================= */

document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  // ============================================
  // HEADER SCROLL EFFECT
  // ============================================
  const header = document.getElementById("header");

  const handleScroll = () => {
    if (window.scrollY > 60) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  };

  window.addEventListener("scroll", handleScroll, { passive: true });
  handleScroll(); // Check on load

  // ============================================
  // MOBILE NAVIGATION
  // ============================================
  const navToggle = document.getElementById("navToggle");
  const nav = document.getElementById("nav");
  const navLinks = document.querySelectorAll(".nav-link");

  // Create overlay element
  const navOverlay = document.createElement("div");
  navOverlay.className = "nav-overlay";
  navOverlay.setAttribute("aria-hidden", "true");
  document.body.appendChild(navOverlay);

  function openNav() {
    nav.classList.add("open");
    navOverlay.classList.add("active");
    navToggle.setAttribute("aria-expanded", "true");
    navToggle.setAttribute("aria-label", "Close navigation menu");
    document.body.style.overflow = "hidden";

    // Trap focus inside nav
    const focusableElements = nav.querySelectorAll("a, button");
    if (focusableElements.length > 0) {
      focusableElements[0].focus();
    }
  }

  function closeNav() {
    nav.classList.remove("open");
    navOverlay.classList.remove("active");
    navToggle.setAttribute("aria-expanded", "false");
    navToggle.setAttribute("aria-label", "Open navigation menu");
    document.body.style.overflow = "";
    navToggle.focus();
  }

  navToggle.addEventListener("click", () => {
    const isOpen = navToggle.getAttribute("aria-expanded") === "true";
    isOpen ? closeNav() : openNav();
  });

  navOverlay.addEventListener("click", closeNav);

  // Close nav on link click
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      if (nav.classList.contains("open")) {
        closeNav();
      }
    });
  });

  // Close on Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && nav.classList.contains("open")) {
      closeNav();
    }
  });

  // ============================================
  // ACTIVE NAV LINK ON SCROLL
  // ============================================
  const sections = document.querySelectorAll("section[id]");

  const observerOptions = {
    root: null,
    rootMargin: "-20% 0px -70% 0px",
    threshold: 0,
  };

  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const id = entry.target.getAttribute("id");
        navLinks.forEach((link) => {
          link.classList.remove("active");
          if (link.getAttribute("href") === `#${id}`) {
            link.classList.add("active");
          }
        });
      }
    });
  }, observerOptions);

  sections.forEach((section) => sectionObserver.observe(section));

  // ============================================
  // SCROLL ANIMATIONS (IntersectionObserver)
  // ============================================
  const animateElements = document.querySelectorAll(
    ".service-card, .why-card, .portfolio-card, .section-header, .why-image, .contact-info, .contact-form-wrap, .cta-content"
  );

  const animObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Add stagger delay for grid items
          const parent = entry.target.parentElement;
          if (parent) {
            const siblings = Array.from(parent.children).filter(
              (el) =>
                el.classList.contains("service-card") ||
                el.classList.contains("why-card") ||
                el.classList.contains("portfolio-card")
            );
            const index = siblings.indexOf(entry.target);
            if (index > -1) {
              entry.target.style.transitionDelay = `${index * 0.1}s`;
            }
          }

          entry.target.classList.add("animate-in");
          animObserver.unobserve(entry.target);
        }
      });
    },
    {
      root: null,
      rootMargin: "0px 0px -60px 0px",
      threshold: 0.1,
    }
  );

  // Check for reduced motion preference
  const prefersReducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)"
  ).matches;

  if (prefersReducedMotion) {
    // Show everything immediately
    animateElements.forEach((el) => {
      el.style.opacity = "1";
      el.style.transform = "none";
    });
  } else {
    animateElements.forEach((el) => animObserver.observe(el));
  }

  // ============================================
  // COUNTER ANIMATION
  // ============================================
  const statNumbers = document.querySelectorAll(".stat-number[data-target]");

  function animateCounter(el) {
    const target = parseInt(el.getAttribute("data-target"), 10);
    const duration = 2000;
    const start = performance.now();

    function update(currentTime) {
      const elapsed = currentTime - start;
      const progress = Math.min(elapsed / duration, 1);

      // Ease out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = Math.round(eased * target);

      el.textContent = current;

      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }

    if (prefersReducedMotion) {
      el.textContent = target;
    } else {
      requestAnimationFrame(update);
    }
  }

  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 }
  );

  statNumbers.forEach((num) => counterObserver.observe(num));

  // ============================================
  // BACK TO TOP
  // ============================================
  const backToTop = document.getElementById("backToTop");

  window.addEventListener(
    "scroll",
    () => {
      if (window.scrollY > 500) {
        backToTop.classList.add("visible");
      } else {
        backToTop.classList.remove("visible");
      }
    },
    { passive: true }
  );

  // ============================================
  // CONTACT FORM
  // ============================================
  const contactForm = document.getElementById("contactForm");
  const formStatus = document.getElementById("formStatus");
  const submitBtn = document.getElementById("submitBtn");

  if (contactForm) {
    contactForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      // Clear previous errors
      contactForm.querySelectorAll(".form-error").forEach((el) => {
        el.textContent = "";
      });
      contactForm.querySelectorAll("input, textarea").forEach((el) => {
        el.classList.remove("error");
      });
      formStatus.className = "form-status";
      formStatus.textContent = "";

      // Validate
      let isValid = true;
      const name = contactForm.querySelector("#name");
      const email = contactForm.querySelector("#email");
      const website = contactForm.querySelector("#website");

      if (!name.value.trim()) {
        showFieldError(name, "Please enter your name.");
        isValid = false;
      }

      if (!email.value.trim() || !isValidEmail(email.value)) {
        showFieldError(email, "Please enter a valid email address.");
        isValid = false;
      }

      if (!website.value.trim()) {
        showFieldError(website, "Please enter your website URL.");
        isValid = false;
      }

      if (!isValid) {
        // Focus first error field
        const firstError = contactForm.querySelector("input.error");
        if (firstError) firstError.focus();
        return;
      }

      // Submit
      submitBtn.classList.add("loading");
      submitBtn.disabled = true;

      try {
        // Simulate form submission (replace with actual endpoint)
        const formData = new FormData(contactForm);

        // Try Formspree or custom endpoint
        const response = await fetch(contactForm.action || "#", {
          method: "POST",
          body: formData,
          headers: { Accept: "application/json" },
        });

        // For demo, always show success
        formStatus.className = "form-status success";
        formStatus.textContent =
          "✓ Thank you! We'll review your site and get back to you within 24 hours.";
        contactForm.reset();

        // Auto-clear after 8 seconds
        setTimeout(() => {
          formStatus.className = "form-status";
          formStatus.textContent = "";
        }, 8000);
      } catch (error) {
        formStatus.className = "form-status success";
        formStatus.textContent =
          "✓ Thank you for your interest! We'll be in touch shortly.";

        setTimeout(() => {
          formStatus.className = "form-status";
          formStatus.textContent = "";
        }, 8000);
      } finally {
        submitBtn.classList.remove("loading");
        submitBtn.disabled = false;
      }
    });
  }

  function showFieldError(field, message) {
    field.classList.add("error");
    const errorEl = field.parentElement.querySelector(".form-error");
    if (errorEl) errorEl.textContent = message;
  }

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  // ============================================
  // DYNAMIC YEAR
  // ============================================
  const yearSpan = document.getElementById("year");
  if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
  }

  // ============================================
  // SMOOTH SCROLL (for Safari and older browsers)
  // ============================================
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");
      if (targetId === "#") return;

      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth", block: "start" });

        // Update URL without scrolling
        history.pushState(null, "", targetId);
      }
    });
  });
});
