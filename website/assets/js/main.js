/**
 * CodeX404 Solutions — Main Frontend Engine
 * Aurora Midnight Theme — Particles, Scroll Animations, Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Mobile Menu Drawer
  const navToggleBtn = document.getElementById('navToggleBtn');
  const navMenu = document.getElementById('navMenu');

  if (navToggleBtn && navMenu) {
    navToggleBtn.addEventListener('click', () => {
      const isExpanded = navToggleBtn.getAttribute('aria-expanded') === 'true';
      navToggleBtn.setAttribute('aria-expanded', !isExpanded);
      navMenu.classList.toggle('open');
      document.body.classList.toggle('nav-open');
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!navMenu.contains(e.target) && !navToggleBtn.contains(e.target) && navMenu.classList.contains('open')) {
        navMenu.classList.remove('open');
        navToggleBtn.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
      }
    });
  }

  // 2. Header Scroll Elevation
  const siteHeader = document.querySelector('.site-header');
  if (siteHeader) {
    const handleScroll = () => {
      if (window.scrollY > 30) {
        siteHeader.classList.add('scrolled');
      } else {
        siteHeader.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  // 3. FAQ Accordion
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const questionBtn = item.querySelector('.faq-question');
    const answer = item.querySelector('.faq-answer');

    if (questionBtn && answer) {
      questionBtn.addEventListener('click', () => {
        const isActive = item.classList.contains('active');

        // Close other items in same list
        const parentList = item.closest('.faq-list');
        if (parentList) {
          parentList.querySelectorAll('.faq-item').forEach(other => {
            if (other !== item) {
              other.classList.remove('active');
              const otherAnswer = other.querySelector('.faq-answer');
              if (otherAnswer) otherAnswer.style.maxHeight = null;
            }
          });
        }

        if (isActive) {
          item.classList.remove('active');
          answer.style.maxHeight = null;
        } else {
          item.classList.add('active');
          answer.style.maxHeight = answer.scrollHeight + 'px';
        }
      });
    }
  });

  // 4. Cookie Consent Management (GDPR Compliance)
  const cookieBanner = document.getElementById('cookieBanner');
  const acceptCookieBtn = document.getElementById('acceptCookiesBtn');
  const declineCookieBtn = document.getElementById('declineCookiesBtn');

  if (cookieBanner) {
    const consent = localStorage.getItem('codex404_cookie_consent');
    if (!consent) {
      cookieBanner.style.display = 'block';
    }

    if (acceptCookieBtn) {
      acceptCookieBtn.addEventListener('click', () => {
        localStorage.setItem('codex404_cookie_consent', 'accepted');
        cookieBanner.style.display = 'none';
      });
    }

    if (declineCookieBtn) {
      declineCookieBtn.addEventListener('click', () => {
        localStorage.setItem('codex404_cookie_consent', 'declined');
        cookieBanner.style.display = 'none';
      });
    }
  }

  // 5. Portfolio & Solutions Filter Tabs
  const filterButtons = document.querySelectorAll('.filter-btn');
  const filterCards = document.querySelectorAll('[data-category]');

  if (filterButtons.length && filterCards.length) {
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.getAttribute('data-filter');
        filterCards.forEach(card => {
          const category = card.getAttribute('data-category');
          if (filter === 'all' || category === filter) {
            card.style.display = '';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  }

  // ======================================================================
  // 6. Scroll-Triggered Fade-In Animations (IntersectionObserver)
  // ======================================================================
  const animateElements = () => {
    // Animate sections, cards, steps, and other key elements
    const targets = document.querySelectorAll(
      '.card, .process-step, .leader-card, .transform-box, .form-card, ' +
      '.section-header, .hero-content, .hero-visual, .faq-item, ' +
      '.page-banner, .cta-section-wrap'
    );

    if (!targets.length) return;

    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
      targets.forEach(el => {
        el.style.opacity = '1';
        el.style.transform = 'none';
      });
      return;
    }

    // Set initial state
    targets.forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(28px)';
      el.style.transition = 'opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
    });

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          // Add stagger delay for siblings
          const parent = entry.target.parentElement;
          const siblings = parent ? Array.from(parent.children).filter(c => 
            targets[Symbol.iterator] ? [...targets].includes(c) : false
          ) : [];
          const siblingIndex = siblings.indexOf(entry.target);
          const delay = siblingIndex >= 0 ? siblingIndex * 80 : 0;

          setTimeout(() => {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }, delay);

          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.12,
      rootMargin: '0px 0px -40px 0px'
    });

    targets.forEach(el => observer.observe(el));
  };

  // Run scroll animations
  animateElements();

  // ======================================================================
  // 7. Floating Particle System (Canvas)
  // ======================================================================
  const initParticles = () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    const canvas = document.createElement('canvas');
    canvas.id = 'particleCanvas';
    canvas.style.cssText = 'position:fixed;inset:0;z-index:0;pointer-events:none;';
    document.body.prepend(canvas);

    const ctx = canvas.getContext('2d');
    let w, h;
    let particles = [];
    const PARTICLE_COUNT = Math.min(50, Math.floor(window.innerWidth / 30));

    const colors = [
      'rgba(59, 130, 246, 0.3)',   // blue
      'rgba(139, 92, 246, 0.25)',  // violet
      'rgba(236, 72, 153, 0.2)',   // magenta
      'rgba(6, 214, 160, 0.25)',   // cyan-green
      'rgba(34, 211, 238, 0.2)',   // cyan
      'rgba(249, 115, 22, 0.15)',  // orange
    ];

    const resize = () => {
      w = canvas.width = window.innerWidth;
      h = canvas.height = window.innerHeight;
    };

    class Particle {
      constructor() {
        this.reset();
      }
      reset() {
        this.x = Math.random() * w;
        this.y = Math.random() * h;
        this.size = Math.random() * 2.5 + 0.5;
        this.speedX = (Math.random() - 0.5) * 0.4;
        this.speedY = (Math.random() - 0.5) * 0.3;
        this.color = colors[Math.floor(Math.random() * colors.length)];
        this.opacity = Math.random() * 0.5 + 0.2;
        this.pulseSpeed = Math.random() * 0.02 + 0.005;
        this.pulsePhase = Math.random() * Math.PI * 2;
      }
      update(t) {
        this.x += this.speedX;
        this.y += this.speedY;
        this.opacity = 0.2 + Math.sin(t * this.pulseSpeed + this.pulsePhase) * 0.15;

        if (this.x < -10) this.x = w + 10;
        if (this.x > w + 10) this.x = -10;
        if (this.y < -10) this.y = h + 10;
        if (this.y > h + 10) this.y = -10;
      }
      draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.globalAlpha = this.opacity;
        ctx.fill();

        // Subtle glow
        if (this.size > 1.5) {
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.size * 3, 0, Math.PI * 2);
          ctx.fillStyle = this.color;
          ctx.globalAlpha = this.opacity * 0.1;
          ctx.fill();
        }
      }
    }

    resize();
    window.addEventListener('resize', resize);

    for (let i = 0; i < PARTICLE_COUNT; i++) {
      particles.push(new Particle());
    }

    let frame = 0;
    const animate = () => {
      ctx.clearRect(0, 0, w, h);
      ctx.globalAlpha = 1;
      frame++;

      particles.forEach(p => {
        p.update(frame);
        p.draw();
      });

      // Draw connections between nearby particles
      ctx.globalAlpha = 0.06;
      for (let i = 0; i < particles.length; i++) {
        for (let j = i + 1; j < particles.length; j++) {
          const dx = particles[i].x - particles[j].x;
          const dy = particles[i].y - particles[j].y;
          const dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < 150) {
            ctx.beginPath();
            ctx.moveTo(particles[i].x, particles[i].y);
            ctx.lineTo(particles[j].x, particles[j].y);
            ctx.strokeStyle = particles[i].color;
            ctx.globalAlpha = 0.03 * (1 - dist / 150);
            ctx.lineWidth = 0.5;
            ctx.stroke();
          }
        }
      }

      requestAnimationFrame(animate);
    };

    animate();
  };

  initParticles();

  // ======================================================================
  // 8. Animated Counter (for stat numbers)
  // ======================================================================
  const animateCounters = () => {
    const counters = document.querySelectorAll('[data-count]');
    if (!counters.length) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const target = parseInt(entry.target.getAttribute('data-count'));
          const suffix = entry.target.getAttribute('data-suffix') || '';
          let current = 0;
          const increment = target / 40;
          const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
              current = target;
              clearInterval(timer);
            }
            entry.target.textContent = Math.floor(current) + suffix;
          }, 30);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    counters.forEach(el => observer.observe(el));
  };

  animateCounters();

  // ======================================================================
  // 9. Smooth Parallax on Hero Visual
  // ======================================================================
  const heroVisual = document.querySelector('.hero-visual');
  if (heroVisual) {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReducedMotion) {
      window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        if (scrolled < window.innerHeight) {
          heroVisual.style.transform = `translateY(${scrolled * 0.08}px)`;
        }
      }, { passive: true });
    }
  }

  // ======================================================================
  // 10. Magnetic Hover Effect on Buttons
  // ======================================================================
  const magneticBtns = document.querySelectorAll('.btn-primary');
  if (magneticBtns.length) {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReducedMotion) {
      magneticBtns.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
          const rect = btn.getBoundingClientRect();
          const x = e.clientX - rect.left - rect.width / 2;
          const y = e.clientY - rect.top - rect.height / 2;
          btn.style.transform = `translate(${x * 0.1}px, ${y * 0.15}px)`;
        });
        btn.addEventListener('mouseleave', () => {
          btn.style.transform = '';
        });
      });
    }
  }
});
