/* ============================================
   DE BEER BONSMARA - MAIN JAVASCRIPT
   Modern Farm Website JS
   ============================================ */

document.addEventListener("DOMContentLoaded", function () {
  // ============================================
  // PRELOADER
  // ============================================
  const preloader = document.getElementById("preloader");

  window.addEventListener("load", function () {
    setTimeout(() => {
      preloader.classList.add("hidden");
    }, 1000);
  });

  // ============================================
  // NAVIGATION
  // ============================================
  const navbar = document.getElementById("navbar");
  const navToggle = document.getElementById("navToggle");
  const navMenu = document.getElementById("navMenu");
  const navLinks = document.querySelectorAll(".nav-link");

  // Scroll Effect for Navbar
  window.addEventListener("scroll", function () {
    if (window.scrollY > 100) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });

  // Mobile Menu Toggle
  navToggle.addEventListener("click", function () {
    navToggle.classList.toggle("active");
    navMenu.classList.toggle("active");
  });

  // Close menu on link click
  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      navToggle.classList.remove("active");
      navMenu.classList.remove("active");
    });
  });

  // Active link on scroll
  const sections = document.querySelectorAll("section[id]");

  function highlightNavLink() {
    const scrollY = window.pageYOffset;

    sections.forEach((section) => {
      const sectionHeight = section.offsetHeight;
      const sectionTop = section.offsetTop - 200;
      const sectionId = section.getAttribute("id");
      const navLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);

      if (navLink) {
        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
          navLink.classList.add("active");
        } else {
          navLink.classList.remove("active");
        }
      }
    });
  }

  window.addEventListener("scroll", highlightNavLink);

  // ============================================
  // SMOOTH SCROLL
  // ============================================
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));

      if (target) {
        const offsetTop = target.offsetTop - 80;
        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        });
      }
    });
  });

  // ============================================
  // AOS (Animate On Scroll) INITIALIZATION
  // ============================================
  if (typeof AOS !== "undefined") {
    AOS.init({
      duration: 800,
      easing: "ease-out-cubic",
      once: true,
      offset: 50,
      disable: "mobile",
    });
  }

  // ============================================
  // SCROLL TO TOP BUTTON
  // ============================================
  const scrollTopBtn = document.getElementById("scrollTop");

  window.addEventListener("scroll", function () {
    if (window.scrollY > 500) {
      scrollTopBtn.classList.add("visible");
    } else {
      scrollTopBtn.classList.remove("visible");
    }
  });

  scrollTopBtn.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });

  // ============================================
  // NEWSLETTER POPUP
  // ============================================
  const newsletterPopup = document.getElementById("newsletterPopup");
  const popupClose = document.getElementById("popupClose");
  const popupOverlay = document.querySelector(".popup-overlay");

  // Show popup after delay (only once per session)
  if (!sessionStorage.getItem("popupShown")) {
    setTimeout(() => {
      newsletterPopup.classList.add("active");
      sessionStorage.setItem("popupShown", "true");
    }, 5000);
  }

  // Close popup
  function closePopup() {
    newsletterPopup.classList.remove("active");
  }

  popupClose.addEventListener("click", closePopup);
  popupOverlay.addEventListener("click", closePopup);

  // Close on escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && newsletterPopup.classList.contains("active")) {
      closePopup();
    }
  });

  // Newsletter form submit
  const newsletterForm = document.getElementById("newsletterForm");
  if (newsletterForm) {
    newsletterForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const emailInput = this.querySelector('input[type="email"]');
      const email = emailInput.value;
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.innerHTML;

      // Show loading state
      submitBtn.innerHTML = "Subscribing...";
      submitBtn.disabled = true;

      try {
        const formData = new FormData();
        formData.append("form_type", "newsletter");
        formData.append("email", email);

        const response = await fetch("send-mail.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        if (result.success) {
          // Show success message
          this.innerHTML = `
            <div style="text-align: center; padding: 20px;">
              <span style="font-size: 48px;">🎉</span>
              <p style="color: var(--brown-dark); font-weight: 600; margin-top: 15px;">
                Thanks for subscribing!
              </p>
              <p style="color: var(--brown-light); font-size: 14px;">
                We'll keep you updated with farm news.
              </p>
            </div>
          `;
          // Close popup after delay
          setTimeout(closePopup, 3000);
        } else {
          alert(
            result.message || "Sorry, there was an error. Please try again.",
          );
          submitBtn.innerHTML = originalBtnText;
          submitBtn.disabled = false;
        }
      } catch (error) {
        console.error("Newsletter error:", error);
        alert("Sorry, there was an error. Please try again.");
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
      }
    });
  }

  // ============================================
  // CONTACT FORM
  // ============================================
  const contactForm = document.getElementById("contactForm");

  if (contactForm) {
    contactForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;

      // Show loading state
      submitBtn.innerHTML = "<span>Sending...</span>";
      submitBtn.disabled = true;

      try {
        const formData = new FormData(this);
        formData.append("form_type", "contact");

        const response = await fetch("send-mail.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        if (result.success) {
          submitBtn.innerHTML = "<span>✓ Message Sent!</span>";
          submitBtn.style.background = "var(--green)";
          submitBtn.style.color = "white";

          // Reset form
          this.reset();

          // Reset button after delay
          setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.style.background = "";
            submitBtn.style.color = "";
            submitBtn.disabled = false;
          }, 3000);
        } else {
          alert(
            result.message || "Sorry, there was an error sending your message.",
          );
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        }
      } catch (error) {
        console.error("Contact form error:", error);
        alert(
          "Sorry, there was an error. Please try again or email us directly at subscribe@debeerbonsmara.com",
        );
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
      }
    });
  }

  // ============================================
  // PRODUCT CARD 3D TILT EFFECT
  // ============================================
  const productCards = document.querySelectorAll(".product-card, .shop-item");

  productCards.forEach((card) => {
    card.addEventListener("mousemove", function (e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = (y - centerY) / 20;
      const rotateY = (centerX - x) / 20;

      this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
    });

    card.addEventListener("mouseleave", function () {
      this.style.transform = "";
    });
  });

  // ============================================
  // PARALLAX EFFECT FOR HERO
  // ============================================
  const heroBg = document.querySelector(".hero-bg");

  if (heroBg) {
    window.addEventListener("scroll", function () {
      const scrolled = window.pageYOffset;
      const rate = scrolled * 0.3;
      heroBg.style.transform = `translateY(${rate}px)`;
    });
  }

  // ============================================
  // COUNTER ANIMATION
  // ============================================
  function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        element.textContent = target + "+";
        clearInterval(timer);
      } else {
        element.textContent = Math.floor(current) + "+";
      }
    }, 16);
  }

  // Animate counters when visible
  const expNumber = document.querySelector(".exp-number");
  if (expNumber) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(expNumber, 40, 2000);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 },
    );

    observer.observe(expNumber);
  }

  // ============================================
  // IMAGE LAZY LOADING EFFECT
  // ============================================
  const images = document.querySelectorAll("img");

  const imageObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("loaded");
          imageObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1, rootMargin: "50px" },
  );

  images.forEach((img) => {
    img.style.opacity = "0";
    img.style.transition = "opacity 0.5s ease";

    if (img.complete) {
      img.style.opacity = "1";
    } else {
      img.addEventListener("load", function () {
        this.style.opacity = "1";
      });
      imageObserver.observe(img);
    }
  });

  // ============================================
  // MAGNETIC BUTTON EFFECT
  // ============================================
  const magneticBtns = document.querySelectorAll(".btn-primary, .btn-cart");

  magneticBtns.forEach((btn) => {
    btn.addEventListener("mousemove", function (e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      this.style.transform = `translate(${x * 0.2}px, ${y * 0.2}px)`;
    });

    btn.addEventListener("mouseleave", function () {
      this.style.transform = "";
    });
  });

  // ============================================
  // TEXT SCRAMBLE EFFECT (for hero title)
  // ============================================
  class TextScramble {
    constructor(el) {
      this.el = el;
      this.chars = "!<>-_\\/[]{}—=+*^?#________";
      this.update = this.update.bind(this);
    }

    setText(newText) {
      const oldText = this.el.innerText;
      const length = Math.max(oldText.length, newText.length);
      const promise = new Promise((resolve) => (this.resolve = resolve));
      this.queue = [];

      for (let i = 0; i < length; i++) {
        const from = oldText[i] || "";
        const to = newText[i] || "";
        const start = Math.floor(Math.random() * 40);
        const end = start + Math.floor(Math.random() * 40);
        this.queue.push({ from, to, start, end });
      }

      cancelAnimationFrame(this.frameRequest);
      this.frame = 0;
      this.update();
      return promise;
    }

    update() {
      let output = "";
      let complete = 0;

      for (let i = 0, n = this.queue.length; i < n; i++) {
        let { from, to, start, end, char } = this.queue[i];

        if (this.frame >= end) {
          complete++;
          output += to;
        } else if (this.frame >= start) {
          if (!char || Math.random() < 0.28) {
            char = this.randomChar();
            this.queue[i].char = char;
          }
          output += `<span class="scramble">${char}</span>`;
        } else {
          output += from;
        }
      }

      this.el.innerHTML = output;

      if (complete === this.queue.length) {
        this.resolve();
      } else {
        this.frameRequest = requestAnimationFrame(this.update);
        this.frame++;
      }
    }

    randomChar() {
      return this.chars[Math.floor(Math.random() * this.chars.length)];
    }
  }

  // ============================================
  // CURSOR FOLLOWER (Optional - Fancy Effect)
  // ============================================
  const cursor = document.createElement("div");
  cursor.className = "custom-cursor";
  cursor.innerHTML =
    '<div class="cursor-dot"></div><div class="cursor-outline"></div>';
  document.body.appendChild(cursor);

  // Add cursor styles
  const cursorStyles = document.createElement("style");
  cursorStyles.textContent = `
        .custom-cursor {
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 99999;
            mix-blend-mode: difference;
        }
        .cursor-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #C9A227;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }
        .cursor-outline {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid rgba(201, 162, 39, 0.5);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.1s ease-out;
        }
        .custom-cursor.hover .cursor-outline {
            width: 60px;
            height: 60px;
            border-color: #C9A227;
        }
        @media (max-width: 768px) {
            .custom-cursor { display: none; }
        }
    `;
  document.head.appendChild(cursorStyles);

  let mouseX = 0,
    mouseY = 0;
  let outlineX = 0,
    outlineY = 0;

  document.addEventListener("mousemove", function (e) {
    mouseX = e.clientX;
    mouseY = e.clientY;

    cursor.querySelector(".cursor-dot").style.left = mouseX + "px";
    cursor.querySelector(".cursor-dot").style.top = mouseY + "px";
  });

  function animateCursor() {
    outlineX += (mouseX - outlineX) * 0.15;
    outlineY += (mouseY - outlineY) * 0.15;

    cursor.querySelector(".cursor-outline").style.left = outlineX + "px";
    cursor.querySelector(".cursor-outline").style.top = outlineY + "px";

    requestAnimationFrame(animateCursor);
  }
  animateCursor();

  // Add hover effect to interactive elements
  const hoverElements = document.querySelectorAll(
    "a, button, .product-card, .shop-item",
  );
  hoverElements.forEach((el) => {
    el.addEventListener("mouseenter", () => cursor.classList.add("hover"));
    el.addEventListener("mouseleave", () => cursor.classList.remove("hover"));
  });

  // ============================================
  // TYPING EFFECT FOR HERO SUBTITLE
  // ============================================
  function typeEffect(element, text, speed = 50) {
    let i = 0;
    element.textContent = "";

    function type() {
      if (i < text.length) {
        element.textContent += text.charAt(i);
        i++;
        setTimeout(type, speed);
      }
    }

    type();
  }

  // Initialize typing effect after preloader
  setTimeout(() => {
    const heroSubtitle = document.querySelector(".hero-subtitle");
    if (heroSubtitle) {
      const originalText = heroSubtitle.textContent;
      typeEffect(heroSubtitle, originalText, 80);
    }
  }, 1500);

  // ============================================
  // RIPPLE EFFECT ON BUTTONS
  // ============================================
  document.querySelectorAll(".btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      const x = e.clientX - e.target.offsetLeft;
      const y = e.clientY - e.target.offsetTop;

      const ripple = document.createElement("span");
      ripple.style.cssText = `
                position: absolute;
                background: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                left: ${x}px;
                top: ${y}px;
                width: 20px;
                height: 20px;
                margin-left: -10px;
                margin-top: -10px;
            `;

      this.style.position = "relative";
      this.style.overflow = "hidden";
      this.appendChild(ripple);

      setTimeout(() => ripple.remove(), 600);
    });
  });

  // Add ripple animation
  const rippleStyles = document.createElement("style");
  rippleStyles.textContent = `
        @keyframes ripple {
            to {
                transform: scale(20);
                opacity: 0;
            }
        }
    `;
  document.head.appendChild(rippleStyles);

  // ============================================
  // CONSOLE WELCOME MESSAGE
  // ============================================
  console.log(
    `
    %c🐄 De Beer Bonsmara Website
    %cPremium Cattle • Grass • Honey
    
    Built with ❤️
    `,
    "font-size: 24px; font-weight: bold; color: #C9A227;",
    "font-size: 14px; color: #4A3728;",
  );
});
