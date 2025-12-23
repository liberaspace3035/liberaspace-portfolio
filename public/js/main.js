// ============================================
// Global Configuration
// ============================================
const CONFIG = {
  reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
  particleCount: 50,
  particleSpeed: 0.5,
};

// ============================================
// Navigation
// ============================================
function initNavigation() {
  const nav = document.getElementById('nav');
  const navToggle = document.getElementById('navToggle');
  const navMenu = document.getElementById('navMenu');
  const navLinks = document.querySelectorAll('.nav-link');

  // Mobile menu toggle
  if (navToggle) {
    navToggle.addEventListener('click', () => {
      navMenu.classList.toggle('active');
      navToggle.classList.toggle('active');
    });
  }

  // Close mobile menu when clicking a link
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navMenu.classList.remove('active');
      navToggle.classList.remove('active');
    });
  });

  // Scroll effect on navigation
  let lastScroll = 0;
  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > 100) {
      nav.classList.add('scrolled');
    } else {
      nav.classList.remove('scrolled');
    }

    lastScroll = currentScroll;
  });

  // Active link highlighting
  const sections = document.querySelectorAll('section[id]');
  
  function highlightActiveSection() {
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
      const sectionHeight = section.offsetHeight;
      const sectionTop = section.offsetTop - 100;
      const sectionId = section.getAttribute('id');
      
      if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
        navLinks.forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('href') === `#${sectionId}`) {
            link.classList.add('active');
          }
        });
      }
    });
  }

  window.addEventListener('scroll', highlightActiveSection);
  highlightActiveSection(); // Initial check
}

// ============================================
// Smooth Scroll
// ============================================
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href === '#' || !href) return;
      
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const navHeight = document.getElementById('nav').offsetHeight;
        const targetPosition = target.offsetTop - navHeight;
        
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    });
  });
}

// ============================================
// Particle Animation
// ============================================
function initParticleAnimation() {
  if (CONFIG.reducedMotion) return;

  const canvas = document.getElementById('particleCanvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  const particles = [];
  
  // Set canvas size
  function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  
  resizeCanvas();
  window.addEventListener('resize', resizeCanvas);

  // Particle class
  class Particle {
    constructor() {
      this.reset();
      this.y = Math.random() * canvas.height;
    }

    reset() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * canvas.height;
      this.size = Math.random() * 2 + 1;
      this.speedX = (Math.random() - 0.5) * CONFIG.particleSpeed;
      this.speedY = (Math.random() - 0.5) * CONFIG.particleSpeed;
      this.opacity = Math.random() * 0.5 + 0.2;
    }

    update() {
      this.x += this.speedX;
      this.y += this.speedY;

      if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
      if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
    }

    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(99, 102, 241, ${this.opacity})`;
      ctx.fill();
    }
  }

  // Create particles
  for (let i = 0; i < CONFIG.particleCount; i++) {
    particles.push(new Particle());
  }

  // Connect particles
  function connectParticles() {
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < 150) {
          ctx.beginPath();
          ctx.strokeStyle = `rgba(99, 102, 241, ${0.2 * (1 - distance / 150)})`;
          ctx.lineWidth = 1;
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }
  }

  // Animation loop
  function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    particles.forEach(particle => {
      particle.update();
      particle.draw();
    });
    
    connectParticles();
    requestAnimationFrame(animate);
  }

  animate();
}

// ============================================
// Counter Animation
// ============================================
function initCounterAnimation() {
  const counters = document.querySelectorAll('.stat-number[data-target]');
  
  const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const counter = entry.target;
        const target = parseInt(counter.getAttribute('data-target'));
        animateCounter(counter, target);
        observer.unobserve(counter);
      }
    });
  }, observerOptions);

  counters.forEach(counter => {
    observer.observe(counter);
  });
}

function animateCounter(element, target) {
  if (CONFIG.reducedMotion) {
    element.textContent = target;
    return;
  }

  let current = 0;
  const increment = target / 50;
  const duration = 2000;
  const stepTime = duration / 50;

  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      element.textContent = target;
      clearInterval(timer);
    } else {
      element.textContent = Math.floor(current);
    }
  }, stepTime);
}

// ============================================
// Intersection Observer for Animations
// ============================================
function initScrollAnimations() {
  if (CONFIG.reducedMotion) {
    document.querySelectorAll('.service-card, .portfolio-item, .about-card').forEach(el => {
      el.style.opacity = '1';
      el.style.transform = 'translateY(0)';
    });
    return;
  }

  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }, index * 100);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observe elements
  document.querySelectorAll('.service-card, .portfolio-item, .about-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
  });
}

// ============================================
// Form Handling
// ============================================
function initContactForm() {
  const form = document.getElementById('contactForm');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<span>Sending...</span>';
    
    // Simulate form submission (replace with actual API call)
    setTimeout(() => {
      // Show success message
      submitButton.innerHTML = '<span>Message Sent!</span>';
      submitButton.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
      
      // Reset form
      form.reset();
      
      // Reset button after 3 seconds
      setTimeout(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
        submitButton.style.background = '';
      }, 3000);
    }, 1500);
  });
}

// ============================================
// Cursor Effect (Optional Enhancement)
// ============================================
function initCursorEffect() {
  if (CONFIG.reducedMotion || window.innerWidth < 768) return;

  const cursor = document.createElement('div');
  cursor.className = 'custom-cursor';
  cursor.style.cssText = `
    width: 20px;
    height: 20px;
    border: 2px solid rgba(99, 102, 241, 0.5);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 9999;
    transition: transform 0.1s ease;
    display: none;
  `;
  document.body.appendChild(cursor);

  const cursorDot = document.createElement('div');
  cursorDot.className = 'custom-cursor-dot';
  cursorDot.style.cssText = `
    width: 4px;
    height: 4px;
    background: rgba(99, 102, 241, 0.8);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 9999;
    transition: transform 0.05s ease;
    display: none;
  `;
  document.body.appendChild(cursorDot);

  let mouseX = 0;
  let mouseY = 0;
  let cursorX = 0;
  let cursorY = 0;
  let dotX = 0;
  let dotY = 0;

  document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    cursor.style.display = 'block';
    cursorDot.style.display = 'block';
  });

  function animateCursor() {
    cursorX += (mouseX - cursorX) * 0.1;
    cursorY += (mouseY - cursorY) * 0.1;
    dotX += (mouseX - dotX) * 0.3;
    dotY += (mouseY - dotY) * 0.3;

    cursor.style.left = cursorX + 'px';
    cursor.style.top = cursorY + 'px';
    cursorDot.style.left = dotX + 'px';
    cursorDot.style.top = dotY + 'px';

    requestAnimationFrame(animateCursor);
  }

  animateCursor();

  // Hover effects
  document.querySelectorAll('a, button, .btn').forEach(el => {
    el.addEventListener('mouseenter', () => {
      cursor.style.transform = 'scale(1.5)';
      cursor.style.borderColor = 'rgba(99, 102, 241, 0.8)';
    });
    el.addEventListener('mouseleave', () => {
      cursor.style.transform = 'scale(1)';
      cursor.style.borderColor = 'rgba(99, 102, 241, 0.5)';
    });
  });
}

// ============================================
// Parallax Effect
// ============================================
function initParallax() {
  if (CONFIG.reducedMotion) return;

  const parallaxElements = document.querySelectorAll('.gradient-orb');
  
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    
    parallaxElements.forEach((element, index) => {
      const speed = 0.3 + (index * 0.1);
      const yPos = -(scrolled * speed);
      element.style.transform = `translateY(${yPos}px)`;
    });
  });
}

// ============================================
// Initialize Everything
// ============================================
document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  initSmoothScroll();
  initParticleAnimation();
  initCounterAnimation();
  initScrollAnimations();
  initContactForm();
  initCursorEffect();
  initParallax();
});

// ============================================
// Performance Optimization
// ============================================
// Throttle function for scroll events
function throttle(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Apply throttling to scroll-heavy functions
window.addEventListener('scroll', throttle(() => {
  // Scroll-based animations can be added here
}, 16));
