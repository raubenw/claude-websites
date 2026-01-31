/* ============================================
   OPEN WEB ACCESS - MAIN JAVASCRIPT
   ============================================ */

document.addEventListener("DOMContentLoaded", function () {
  // ============================================
  // PRELOADER
  // ============================================
  const preloader = document.getElementById("preloader");
  if (preloader) {
    window.addEventListener("load", () => {
      setTimeout(() => {
        preloader.classList.add("hidden");
      }, 500);
    });
  }

  // ============================================
  // NAVBAR SCROLL EFFECT
  // ============================================
  const navbar = document.getElementById("navbar");
  let lastScroll = 0;

  window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 50) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }

    lastScroll = currentScroll;
  });

  // ============================================
  // MOBILE MENU TOGGLE
  // ============================================
  const navToggle = document.getElementById("navToggle");
  const navMenu = document.getElementById("navMenu");

  if (navToggle && navMenu) {
    navToggle.addEventListener("click", () => {
      navMenu.classList.toggle("active");
      navToggle.classList.toggle("active");

      // Update ARIA
      const isExpanded = navMenu.classList.contains("active");
      navToggle.setAttribute("aria-expanded", isExpanded);
    });

    // Close menu when clicking a link
    navMenu.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", () => {
        navMenu.classList.remove("active");
        navToggle.classList.remove("active");
        navToggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  // ============================================
  // SMOOTH SCROLL FOR ANCHOR LINKS
  // ============================================
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");
      if (targetId === "#") return;

      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        e.preventDefault();
        const navHeight = navbar ? navbar.offsetHeight : 0;
        const targetPosition = targetElement.offsetTop - navHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth",
        });
      }
    });
  });

  // ============================================
  // INITIALIZE AOS (Animate On Scroll)
  // ============================================
  if (typeof AOS !== "undefined") {
    AOS.init({
      duration: 800,
      easing: "ease-out-cubic",
      once: true,
      offset: 50,
      disable: window.matchMedia("(prefers-reduced-motion: reduce)").matches,
    });
  }

  // ============================================
  // CONTACT FORM HANDLING WITH FORMSPREE
  // ============================================
  const contactForm = document.getElementById("contactForm");

  if (contactForm) {
    contactForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const submitBtn = this.querySelector(".form-submit");
      const formMessage = this.querySelector(".form-message");
      const originalBtnText = submitBtn.innerHTML;

      // Disable button and show loading
      submitBtn.disabled = true;
      submitBtn.innerHTML = "<span>Sending...</span>";

      // Hide any existing messages
      if (formMessage) {
        formMessage.style.display = "none";
        formMessage.classList.remove("success", "error");
      }

      // Get form data
      const formData = new FormData(this);

      try {
        // Send to Formspree (replace YOUR_FORM_ID with actual ID)
        const response = await fetch(this.action, {
          method: "POST",
          body: formData,
          headers: {
            Accept: "application/json",
          },
        });

        if (response.ok) {
          // Success
          if (formMessage) {
            formMessage.textContent =
              "✓ Thank you! Your message has been sent successfully. We'll get back to you soon!";
            formMessage.classList.add("success");
            formMessage.style.display = "block";
          }
          this.reset();
        } else {
          throw new Error("Form submission failed");
        }
      } catch (error) {
        // Error
        if (formMessage) {
          formMessage.textContent =
            "✕ Oops! Something went wrong. Please try again or email us directly.";
          formMessage.classList.add("error");
          formMessage.style.display = "block";
        }
      } finally {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
      }
    });
  }

  // ============================================
  // AUDIT FORM HANDLING
  // ============================================
  const auditForm = document.getElementById("auditForm");

  if (auditForm) {
    auditForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const submitBtn = this.querySelector(".form-submit");
      const formMessage = this.querySelector(".form-message");
      const originalBtnText = submitBtn.innerHTML;

      submitBtn.disabled = true;
      submitBtn.innerHTML = "<span>Submitting...</span>";

      if (formMessage) {
        formMessage.style.display = "none";
        formMessage.classList.remove("success", "error");
      }

      const formData = new FormData(this);

      try {
        const response = await fetch(this.action, {
          method: "POST",
          body: formData,
          headers: {
            Accept: "application/json",
          },
        });

        if (response.ok) {
          if (formMessage) {
            formMessage.textContent =
              "✓ Request received! We'll send your website audit report within 24-48 hours.";
            formMessage.classList.add("success");
            formMessage.style.display = "block";
          }
          this.reset();
        } else {
          throw new Error("Form submission failed");
        }
      } catch (error) {
        if (formMessage) {
          formMessage.textContent = "✕ Something went wrong. Please try again.";
          formMessage.classList.add("error");
          formMessage.style.display = "block";
        }
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
      }
    });
  }

  // ============================================
  // COUNTER ANIMATION
  // ============================================
  const counters = document.querySelectorAll("[data-counter]");

  const animateCounter = (el) => {
    const target = parseInt(el.getAttribute("data-counter"));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const updateCounter = () => {
      current += step;
      if (current < target) {
        el.textContent = Math.floor(current);
        requestAnimationFrame(updateCounter);
      } else {
        el.textContent = target;
      }
    };

    updateCounter();
  };

  // Intersection Observer for counters
  if (counters.length > 0) {
    const counterObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (
            entry.isIntersecting &&
            !entry.target.classList.contains("animated")
          ) {
            entry.target.classList.add("animated");
            animateCounter(entry.target);
          }
        });
      },
      { threshold: 0.5 },
    );

    counters.forEach((counter) => counterObserver.observe(counter));
  }

  // ============================================
  // TYPING EFFECT FOR HERO
  // ============================================
  const typingElement = document.querySelector(".typing-text");

  if (typingElement) {
    const words = ["Websites", "Experiences", "Solutions", "Success"];
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    const typeEffect = () => {
      const currentWord = words[wordIndex];

      if (isDeleting) {
        typingElement.textContent = currentWord.substring(0, charIndex - 1);
        charIndex--;
      } else {
        typingElement.textContent = currentWord.substring(0, charIndex + 1);
        charIndex++;
      }

      let typeSpeed = isDeleting ? 50 : 100;

      if (!isDeleting && charIndex === currentWord.length) {
        typeSpeed = 2000; // Pause at end
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        wordIndex = (wordIndex + 1) % words.length;
        typeSpeed = 500; // Pause before next word
      }

      setTimeout(typeEffect, typeSpeed);
    };

    typeEffect();
  }

  // ============================================
  // FORM VALIDATION HELPERS
  // ============================================
  const validateEmail = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  };

  const validateURL = (url) => {
    try {
      new URL(url);
      return true;
    } catch {
      return false;
    }
  };

  // Real-time validation
  document.querySelectorAll('.form-input[type="email"]').forEach((input) => {
    input.addEventListener("blur", function () {
      if (this.value && !validateEmail(this.value)) {
        this.style.borderColor = "var(--error)";
      } else {
        this.style.borderColor = "";
      }
    });
  });

  document.querySelectorAll('.form-input[type="url"]').forEach((input) => {
    input.addEventListener("blur", function () {
      if (this.value && !validateURL(this.value)) {
        this.style.borderColor = "var(--error)";
      } else {
        this.style.borderColor = "";
      }
    });
  });

  // ============================================
  // PORTFOLIO FILTER (if needed)
  // ============================================
  const filterButtons = document.querySelectorAll("[data-filter]");
  const portfolioItems = document.querySelectorAll("[data-category]");

  filterButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const filter = btn.getAttribute("data-filter");

      filterButtons.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      portfolioItems.forEach((item) => {
        const category = item.getAttribute("data-category");
        if (filter === "all" || category === filter) {
          item.style.display = "";
        } else {
          item.style.display = "none";
        }
      });
    });
  });

  // ============================================
  // SCROLL TO TOP BUTTON
  // ============================================
  const scrollTopBtn = document.getElementById("scrollTop");

  if (scrollTopBtn) {
    window.addEventListener("scroll", () => {
      if (window.pageYOffset > 500) {
        scrollTopBtn.classList.add("visible");
      } else {
        scrollTopBtn.classList.remove("visible");
      }
    });

    scrollTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // ============================================
  // LAZY LOADING IMAGES
  // ============================================
  if ("loading" in HTMLImageElement.prototype) {
    // Browser supports lazy loading
    document.querySelectorAll("img[data-src]").forEach((img) => {
      img.src = img.dataset.src;
    });
  } else {
    // Fallback for older browsers
    const lazyImages = document.querySelectorAll("img[data-src]");

    const lazyObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          lazyObserver.unobserve(img);
        }
      });
    });

    lazyImages.forEach((img) => lazyObserver.observe(img));
  }
});
