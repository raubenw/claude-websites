/* ============================================
   SpineAlign Chiropractic - Main JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
  
  // ============================================
  // Preloader
  // ============================================
  const preloader = document.getElementById('preloader');
  
  window.addEventListener('load', function() {
    setTimeout(() => {
      preloader.classList.add('hidden');
    }, 800);
  });

  // ============================================
  // Navbar Scroll Effect
  // ============================================
  const navbar = document.getElementById('navbar');
  const topBar = document.querySelector('.top-bar');
  
  function handleNavbarScroll() {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
      if (topBar) topBar.style.transform = 'translateY(-100%)';
    } else {
      navbar.classList.remove('scrolled');
      if (topBar) topBar.style.transform = 'translateY(0)';
    }
  }
  
  window.addEventListener('scroll', handleNavbarScroll);
  handleNavbarScroll();

  // ============================================
  // Mobile Navigation Toggle
  // ============================================
  const navToggle = document.getElementById('navToggle');
  const navMenu = document.getElementById('navMenu');
  
  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function() {
      navToggle.classList.toggle('active');
      navMenu.classList.toggle('active');
      
      const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', !isExpanded);
    });
    
    // Close menu when clicking a link
    navMenu.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        navToggle.classList.remove('active');
        navMenu.classList.remove('active');
        navToggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // ============================================
  // Smooth Scrolling for Anchor Links
  // ============================================
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;
      
      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        e.preventDefault();
        const navHeight = navbar.offsetHeight + 20;
        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navHeight;
        
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    });
  });

  // ============================================
  // Active Navigation Link Highlighting
  // ============================================
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-link');
  
  function highlightNavLink() {
    const scrollPosition = window.scrollY + 150;
    
    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.offsetHeight;
      const sectionId = section.getAttribute('id');
      
      if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
        navLinks.forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('href') === `#${sectionId}`) {
            link.classList.add('active');
          }
        });
      }
    });
  }
  
  window.addEventListener('scroll', highlightNavLink);

  // ============================================
  // Initialize AOS (Animate On Scroll)
  // ============================================
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      easing: 'ease-out',
      once: true,
      offset: 100,
      disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
    });
  }

  // ============================================
  // Counter Animation
  // ============================================
  const counters = document.querySelectorAll('[data-counter]');
  
  const animateCounter = (counter) => {
    const target = parseFloat(counter.getAttribute('data-counter'));
    const duration = 2000;
    const startTime = performance.now();
    const isFloat = target % 1 !== 0;
    
    const updateCounter = (currentTime) => {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easeProgress = 1 - Math.pow(1 - progress, 3);
      const currentValue = target * easeProgress;
      
      counter.textContent = isFloat ? currentValue.toFixed(1) : Math.floor(currentValue).toLocaleString();
      
      if (progress < 1) {
        requestAnimationFrame(updateCounter);
      } else {
        counter.textContent = isFloat ? target.toFixed(1) : target.toLocaleString();
      }
    };
    
    requestAnimationFrame(updateCounter);
  };
  
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        counterObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });
  
  counters.forEach(counter => counterObserver.observe(counter));

  // ============================================
  // Form Handling with Formspree
  // ============================================
  const contactForm = document.getElementById('contactForm');
  const formMessage = document.getElementById('formMessage');
  
  if (contactForm) {
    contactForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const submitBtn = contactForm.querySelector('.form-submit');
      const originalBtnText = submitBtn.innerHTML;
      
      // Show loading state
      submitBtn.innerHTML = '<span>Sending...</span>';
      submitBtn.disabled = true;
      
      try {
        const formData = new FormData(contactForm);
        const response = await fetch(contactForm.action, {
          method: 'POST',
          body: formData,
          headers: {
            'Accept': 'application/json'
          }
        });
        
        if (response.ok) {
          formMessage.className = 'form-message success';
          formMessage.innerHTML = '✅ Thank you! Your appointment request has been received. We\'ll contact you within 24 hours to confirm.';
          contactForm.reset();
        } else {
          throw new Error('Form submission failed');
        }
      } catch (error) {
        formMessage.className = 'form-message error';
        formMessage.innerHTML = '❌ Sorry, there was a problem sending your message. Please call us directly at +27 11 555 1234.';
      } finally {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
        
        // Scroll to message
        formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Hide message after 10 seconds
        setTimeout(() => {
          formMessage.className = 'form-message';
          formMessage.innerHTML = '';
        }, 10000);
      }
    });
  }

  // ============================================
  // Form Validation Enhancements
  // ============================================
  const phoneInput = document.getElementById('phone');
  
  if (phoneInput) {
    phoneInput.addEventListener('input', function(e) {
      // Allow only numbers, spaces, plus, and parentheses
      let value = e.target.value.replace(/[^\d\s+()-]/g, '');
      e.target.value = value;
    });
  }

  // Set minimum date to today for appointment booking
  const dateInput = document.getElementById('preferred-date');
  if (dateInput) {
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
  }

  // ============================================
  // Scroll to Top Button
  // ============================================
  const scrollTopBtn = document.getElementById('scrollTop');
  
  if (scrollTopBtn) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 500) {
        scrollTopBtn.classList.add('visible');
      } else {
        scrollTopBtn.classList.remove('visible');
      }
    });
    
    scrollTopBtn.addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // ============================================
  // Lazy Loading Images
  // ============================================
  const lazyImages = document.querySelectorAll('img[data-src]');
  
  if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
          imageObserver.unobserve(img);
        }
      });
    }, { rootMargin: '100px' });
    
    lazyImages.forEach(img => imageObserver.observe(img));
  }

  // ============================================
  // WhatsApp Float Button Animation
  // ============================================
  const whatsappFloat = document.querySelector('.whatsapp-float');
  
  if (whatsappFloat) {
    // Add pulse animation periodically
    setInterval(() => {
      whatsappFloat.style.transform = 'scale(1.1)';
      setTimeout(() => {
        whatsappFloat.style.transform = 'scale(1)';
      }, 200);
    }, 5000);
  }

  // ============================================
  // Medical Aid Info Tooltip (optional enhancement)
  // ============================================
  const aidLogos = document.querySelectorAll('.aid-logo');
  
  aidLogos.forEach(logo => {
    logo.style.cursor = 'default';
    logo.setAttribute('title', 'We process claims directly with ' + logo.textContent);
  });

  // ============================================
  // Console Branding
  // ============================================
  console.log('%c🦴 SpineAlign Chiropractic', 'color: #2d6a4f; font-size: 20px; font-weight: bold;');
  console.log('%cWebsite built by Open Web Access', 'color: #666; font-size: 12px;');
  console.log('%chttps://openwebaccess.com', 'color: #0077b6; font-size: 12px;');

});

// ============================================
// Service Worker Registration (for PWA capabilities)
// ============================================
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    // Uncomment to enable service worker
    // navigator.serviceWorker.register('/sw.js');
  });
}
