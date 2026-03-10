/* ========================================
   LUMIÈRE PHOTOGRAPHY – Main JS
   ======================================== */

document.addEventListener("DOMContentLoaded", () => {
  /* ---------- Preloader ---------- */
  const preloader = document.querySelector(".preloader");
  if (preloader) {
    window.addEventListener("load", () => {
      preloader.classList.add("hidden");
    });
    // Fallback: hide after 4s even if images stall
    setTimeout(() => preloader.classList.add("hidden"), 4000);
  }

  /* ---------- AOS Init ---------- */
  if (typeof AOS !== "undefined") {
    AOS.init({
      duration: 800,
      once: true,
      offset: 80,
      easing: "ease-out-cubic",
    });
  }

  /* ---------- Navbar scroll ---------- */
  const navbar = document.querySelector(".navbar");
  const handleNavScroll = () => {
    if (!navbar) return;
    navbar.classList.toggle("scrolled", window.scrollY > 60);
  };
  window.addEventListener("scroll", handleNavScroll, { passive: true });
  handleNavScroll();

  /* ---------- Mobile nav toggle ---------- */
  const navToggle = document.querySelector(".nav-toggle");
  const navMenu = document.querySelector(".nav-menu");

  if (navToggle && navMenu) {
    navToggle.addEventListener("click", () => {
      navToggle.classList.toggle("active");
      navMenu.classList.toggle("open");
      document.body.style.overflow = navMenu.classList.contains("open")
        ? "hidden"
        : "";
    });

    // Close menu on link click
    navMenu.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", () => {
        navToggle.classList.remove("active");
        navMenu.classList.remove("open");
        document.body.style.overflow = "";
      });
    });
  }

  /* ---------- Hero Slider ---------- */
  const heroSlides = document.querySelectorAll(".hero-slide");
  let currentSlide = 0;
  let heroInterval;

  function showHeroSlide(index) {
    heroSlides.forEach((s) => s.classList.remove("active"));
    currentSlide =
      ((index % heroSlides.length) + heroSlides.length) % heroSlides.length;
    heroSlides[currentSlide].classList.add("active");
  }

  function startHeroAutoplay() {
    if (heroSlides.length < 2) return;
    heroInterval = setInterval(() => showHeroSlide(currentSlide + 1), 6000);
  }

  if (heroSlides.length) {
    showHeroSlide(0);
    startHeroAutoplay();
  }

  /* ---------- Portfolio Filter ---------- */
  const filterBtns = document.querySelectorAll(".filter-btn");
  const portfolioItems = document.querySelectorAll(".portfolio-item");

  filterBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      filterBtns.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      const filter = btn.getAttribute("data-filter");

      portfolioItems.forEach((item) => {
        if (filter === "all" || item.getAttribute("data-category") === filter) {
          item.classList.remove("hidden");
        } else {
          item.classList.add("hidden");
        }
      });
    });
  });

  /* ---------- Lightbox ---------- */
  const lightbox = document.querySelector(".lightbox");
  const lightboxImg = document.getElementById("lightbox-img");
  const lightboxCaption = document.querySelector(".lightbox-caption");
  const lightboxClose = document.querySelector(".lightbox-close");
  const lightboxPrev = document.querySelector(".lightbox-prev");
  const lightboxNext = document.querySelector(".lightbox-next");

  let lightboxImages = [];
  let lightboxIndex = 0;

  function collectLightboxImages() {
    lightboxImages = [];
    document
      .querySelectorAll(".portfolio-item:not(.hidden)")
      .forEach((item) => {
        const img = item.querySelector("img");
        const overlay = item.querySelector(".portfolio-overlay");
        const title = overlay ? overlay.querySelector("h3") : null;
        if (img) {
          lightboxImages.push({
            src: img.src,
            caption: title ? title.textContent : "",
          });
        }
      });
  }

  function openLightbox(index) {
    collectLightboxImages();
    if (!lightboxImages.length) return;
    lightboxIndex = index;
    updateLightbox();
    lightbox.classList.add("active");
    document.body.style.overflow = "hidden";
  }

  function closeLightbox() {
    lightbox.classList.remove("active");
    document.body.style.overflow = "";
  }

  function updateLightbox() {
    if (!lightboxImages.length) return;
    lightboxIndex =
      ((lightboxIndex % lightboxImages.length) + lightboxImages.length) %
      lightboxImages.length;
    lightboxImg.src = lightboxImages[lightboxIndex].src;
    lightboxImg.alt = lightboxImages[lightboxIndex].caption;
    lightboxCaption.textContent = lightboxImages[lightboxIndex].caption;
  }

  // Click handlers
  document.querySelectorAll(".portfolio-item").forEach((item, i) => {
    item.addEventListener("click", () => openLightbox(i));
  });

  if (lightboxClose) lightboxClose.addEventListener("click", closeLightbox);
  if (lightboxPrev)
    lightboxPrev.addEventListener("click", () => {
      lightboxIndex--;
      updateLightbox();
    });
  if (lightboxNext)
    lightboxNext.addEventListener("click", () => {
      lightboxIndex++;
      updateLightbox();
    });

  // Keyboard navigation
  document.addEventListener("keydown", (e) => {
    if (!lightbox || !lightbox.classList.contains("active")) return;
    if (e.key === "Escape") closeLightbox();
    if (e.key === "ArrowLeft") {
      lightboxIndex--;
      updateLightbox();
    }
    if (e.key === "ArrowRight") {
      lightboxIndex++;
      updateLightbox();
    }
  });

  // Close on overlay click
  if (lightbox) {
    lightbox.addEventListener("click", (e) => {
      if (e.target === lightbox) closeLightbox();
    });
  }

  /* ---------- Testimonial Slider ---------- */
  const testimonialTrack = document.querySelector(".testimonial-track");
  const testimonialCards = document.querySelectorAll(".testimonial-card");
  const prevBtn = document.querySelector(".testimonial-btn.prev");
  const nextBtn = document.querySelector(".testimonial-btn.next");
  const dots = document.querySelectorAll(".testimonial-dots .dot");
  let testimonialIndex = 0;
  let testimonialTimer;

  function goToTestimonial(index) {
    testimonialIndex =
      ((index % testimonialCards.length) + testimonialCards.length) %
      testimonialCards.length;
    if (testimonialTrack) {
      testimonialTrack.style.transform = `translateX(-${
        testimonialIndex * 100
      }%)`;
    }
    dots.forEach((d, i) =>
      d.classList.toggle("active", i === testimonialIndex),
    );
  }

  function startTestimonialAutoplay() {
    if (testimonialCards.length < 2) return;
    testimonialTimer = setInterval(
      () => goToTestimonial(testimonialIndex + 1),
      7000,
    );
  }

  function resetTestimonialAutoplay() {
    clearInterval(testimonialTimer);
    startTestimonialAutoplay();
  }

  if (prevBtn)
    prevBtn.addEventListener("click", () => {
      goToTestimonial(testimonialIndex - 1);
      resetTestimonialAutoplay();
    });
  if (nextBtn)
    nextBtn.addEventListener("click", () => {
      goToTestimonial(testimonialIndex + 1);
      resetTestimonialAutoplay();
    });
  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      goToTestimonial(i);
      resetTestimonialAutoplay();
    });
  });

  if (testimonialCards.length) {
    goToTestimonial(0);
    startTestimonialAutoplay();
  }

  /* ---------- Smooth scroll for anchor links ---------- */
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", (e) => {
      const target = document.querySelector(anchor.getAttribute("href"));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });

  /* ---------- Contact Form (demo) ---------- */
  const contactForm = document.querySelector(".contact-form");
  if (contactForm) {
    contactForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const btn = contactForm.querySelector('button[type="submit"]');
      const originalText = btn.textContent;
      btn.textContent = "Message Sent!";
      btn.disabled = true;
      btn.style.opacity = "0.7";
      setTimeout(() => {
        btn.textContent = originalText;
        btn.disabled = false;
        btn.style.opacity = "";
        contactForm.reset();
      }, 3000);
    });
  }

  /* ---------- Active nav highlight on scroll ---------- */
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-link");

  const observerOpts = {
    root: null,
    rootMargin: "-30% 0px -50% 0px",
    threshold: 0,
  };

  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const id = entry.target.id;
        navLinks.forEach((link) => {
          link.classList.toggle(
            "active",
            link.getAttribute("href") === `#${id}`,
          );
        });
      }
    });
  }, observerOpts);

  sections.forEach((sec) => sectionObserver.observe(sec));
});
