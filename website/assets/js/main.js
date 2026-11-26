/**
 * CodeX404 Solutions — Main Frontend Engine
 * Aurora Midnight Theme — Particles, Scroll Animations, Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Mobile Menu Drawer
  const navToggleBtn = document.getElementById('navToggleBtn');
  const navMenu = document.getElementById('navMenu');

  if (navToggleBtn && navMenu) {
    const hamburgerSvg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';
    const closeSvg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

    const toggleNav = (openState) => {
      const willOpen = typeof openState === 'boolean' ? openState : !navMenu.classList.contains('open');
      navToggleBtn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      navToggleBtn.setAttribute('aria-label', willOpen ? 'Close navigation menu' : 'Open navigation menu');
      if (willOpen) {
        navMenu.classList.add('open');
        document.body.classList.add('nav-open');
        navToggleBtn.innerHTML = closeSvg;
        const firstLink = navMenu.querySelector('a[href], button:not(:disabled)');
        if (firstLink) requestAnimationFrame(() => firstLink.focus());
      } else {
        const focusWasInMenu = navMenu.contains(document.activeElement);
        navMenu.classList.remove('open');
        document.body.classList.remove('nav-open');
        navToggleBtn.innerHTML = hamburgerSvg;
        if (focusWasInMenu) navToggleBtn.focus();
      }
    };

    navToggleBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      toggleNav();
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (navMenu.classList.contains('open') && !navMenu.contains(e.target) && !navToggleBtn.contains(e.target)) {
        toggleNav(false);
      }
    });

    // Close menu when tapping links inside drawer
    navMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        toggleNav(false);
      });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && navMenu.classList.contains('open')) {
        toggleNav(false);
        return;
      }

      if (e.key === 'Tab' && navMenu.classList.contains('open')) {
        const focusableItems = Array.from(navMenu.querySelectorAll('a[href], button:not(:disabled), [tabindex]:not([tabindex="-1"])'))
          .filter(item => item.getClientRects().length > 0);
        if (!focusableItems.length) {
          e.preventDefault();
          navToggleBtn.focus();
          return;
        }

        const firstItem = focusableItems[0];
        const lastItem = focusableItems[focusableItems.length - 1];
        if (e.shiftKey && document.activeElement === firstItem) {
          e.preventDefault();
          lastItem.focus();
        } else if (!e.shiftKey && document.activeElement === lastItem) {
          e.preventDefault();
          firstItem.focus();
        }
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

  // 3. FAQ Accordion (with keyboard support and ARIA state)
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const questionBtn = item.querySelector('.faq-question');
    const answer = item.querySelector('.faq-answer');

    if (questionBtn && answer) {
      const answerId = answer.id || (questionBtn.id + '-answer');
      if (!answer.id) answer.id = answerId;
      questionBtn.setAttribute('aria-controls', answerId);

      questionBtn.addEventListener('click', () => {
        const nowActive = item.classList.toggle('active');
        questionBtn.setAttribute('aria-expanded', nowActive ? 'true' : 'false');
        answer.style.maxHeight = nowActive ? answer.scrollHeight + 'px' : null;

        // Close other items in same list
        const parentList = item.closest('.faq-list');
        if (parentList) {
          parentList.querySelectorAll('.faq-item').forEach(other => {
            if (other !== item) {
              other.classList.remove('active');
              const otherBtn = other.querySelector('.faq-question');
              if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
              const otherAnswer = other.querySelector('.faq-answer');
              if (otherAnswer) otherAnswer.style.maxHeight = null;
            }
          });
        }
      });

      // Keyboard: Enter / Space to toggle
      questionBtn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          questionBtn.click();
        }
      });
    }
  });

  // 4. Cookie and optional analytics preference management
  const cookieBanner = document.getElementById('cookieBanner');
  const acceptCookieBtn = document.getElementById('acceptCookiesBtn');
  const declineCookieBtn = document.getElementById('declineCookiesBtn');

  if (cookieBanner) {
    let consent = null;
    try {
      consent = localStorage.getItem('codex404_cookie_consent');
    } catch (error) {
      cookieBanner.style.display = 'block';
    }
    if (!consent) cookieBanner.style.display = 'block';

    if (acceptCookieBtn) {
      acceptCookieBtn.addEventListener('click', () => {
        try { localStorage.setItem('codex404_cookie_consent', 'accepted'); } catch (error) {}
        cookieBanner.style.display = 'none';
        if (typeof window.loadCodeX404Analytics === 'function') {
          window.loadCodeX404Analytics();
        }
      });
    }

    if (declineCookieBtn) {
      declineCookieBtn.addEventListener('click', () => {
        try { localStorage.setItem('codex404_cookie_consent', 'declined'); } catch (error) {}
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
    // Keep primary interactive cards (.card, .form-card, .leader-card) and .section-header immediately visible
    const targets = document.querySelectorAll(
      '.process-step, .transform-box, .faq-item, .page-banner, .cta-section-wrap'
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

    // Set initial state only for elements strictly below the current viewport
    const vh = window.innerHeight || 800;
    targets.forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < vh + 40) {
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
        return;
      }
      el.style.opacity = '0';
      el.style.transform = 'translateY(22px)';
      el.style.transition = 'opacity 0.42s cubic-bezier(0.16, 1, 0.3, 1), transform 0.42s cubic-bezier(0.16, 1, 0.3, 1)';
    });

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const parent = entry.target.parentElement;
          const siblings = parent ? Array.from(parent.children).filter(c =>
            targets[Symbol.iterator] ? [...targets].includes(c) : false
          ) : [];
          const siblingIndex = siblings.indexOf(entry.target);
          const delay = siblingIndex >= 0 ? Math.min(siblingIndex * 60, 180) : 0;

          setTimeout(() => {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }, delay);

          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.01,
      rootMargin: '80px 0px 80px 0px'
    });

    targets.forEach(el => {
      if (el.style.opacity !== '1') observer.observe(el);
    });
  };

  // Run scroll animations
  animateElements();

  // ======================================================================
  // 7. Neural Constellation Canvas (Reactive Background Motion)
  // ======================================================================
  const initNeuralCanvas = () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    const canvas = document.getElementById('neural-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = (canvas.width = window.innerWidth);
    let height = (canvas.height = window.innerHeight);
    let particles = [];
    const maxDistance = 145;

    const mouse = {
      x: null,
      y: null,
      radius: 130
    };

    const resize = () => {
      width = canvas.width = window.innerWidth;
      height = canvas.height = window.innerHeight;
    };

    window.addEventListener('mousemove', (e) => {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    }, { passive: true });

    window.addEventListener('mouseout', () => {
      mouse.x = null;
      mouse.y = null;
    });

    window.addEventListener('touchstart', (e) => {
      if (e.touches && e.touches.length > 0) {
        mouse.x = e.touches[0].clientX;
        mouse.y = e.touches[0].clientY;
      }
    }, { passive: true });

    window.addEventListener('touchmove', (e) => {
      if (e.touches && e.touches.length > 0) {
        mouse.x = e.touches[0].clientX;
        mouse.y = e.touches[0].clientY;
      }
    }, { passive: true });

    window.addEventListener('touchend', () => {
      mouse.x = null;
      mouse.y = null;
    });

    window.addEventListener('resize', resize);

    const is3DStage = document.body.classList.contains('has-hero-3d');
    const particleCount = Math.min(Math.floor((width * height) / (is3DStage ? 13200 : 18000)), is3DStage ? 105 : 75);

    const colors = is3DStage
      ? [
          { r: 34, g: 211, b: 238 },  // electric cyan (#22D3EE)
          { r: 11, g: 94, b: 215 },   // CodeX404 royal blue (#0B5ED7)
          { r: 96, g: 165, b: 250 },  // steel sky (#60A5FA)
          { r: 229, g: 231, b: 235 }, // crisp starlight (#E5E7EB)
          { r: 34, g: 211, b: 238 },  // electric cyan weighted
          { r: 255, g: 140, b: 0 }    // electric orange beacon (#FF8C00)
        ]
      : [
          { r: 11, g: 94, b: 215 },   // CodeX404 royal blue (#0B5ED7)
          { r: 34, g: 211, b: 238 },  // electric cyan (#22D3EE)
          { r: 16, g: 185, b: 129 },  // automation green (#10B981)
          { r: 96, g: 165, b: 250 },  // steel sky (#60A5FA)
          { r: 255, g: 140, b: 0 }    // electric orange (#FF8C00)
        ];

    class Particle {
      constructor(idx) {
        this.x = Math.random() * width;
        this.y = Math.random() * height;
        const speedScale = is3DStage ? 0.42 : 0.65;
        this.vx = (Math.random() - 0.5) * speedScale;
        this.vy = (Math.random() - 0.5) * speedScale;
        this.isBeacon = is3DStage && idx % 5 === 0;
        this.baseRadius = this.isBeacon ? (Math.random() * 1.4 + 2.0) : (Math.random() * 1.6 + 0.9);
        this.radius = this.baseRadius;
        this.phase = Math.random() * Math.PI * 2;
        this.twinkleSpeed = 0.018 + Math.random() * 0.025;
        // Keep brand orange rare (~1 in 12 particles) and cool blues/starlight dominant
        this.color = (is3DStage && idx % 12 === 0)
          ? colors[5]
          : colors[Math.floor(Math.random() * (is3DStage ? 5 : colors.length))];
      }

      update() {
        this.x += this.vx;
        this.y += this.vy;
        this.phase += this.twinkleSpeed;

        // Bounce off screen boundaries
        if (this.x < 0 || this.x > width) this.vx = -this.vx;
        if (this.y < 0 || this.y > height) this.vy = -this.vy;

        // React to mouse / touch proximity
        if (mouse.x !== null && mouse.y !== null) {
          const dx = mouse.x - this.x;
          const dy = mouse.y - this.y;
          const dist = Math.sqrt(dx * dx + dy * dy);

          if (dist < mouse.radius) {
            const angle = Math.atan2(dy, dx);
            const force = (mouse.radius - dist) / mouse.radius;
            this.x -= Math.cos(angle) * force * 2.4;
            this.y -= Math.sin(angle) * force * 2.4;
            this.radius = this.baseRadius * 1.55;
          } else {
            this.radius = this.baseRadius;
          }
        }
      }

      draw() {
        const twinkle = is3DStage ? (0.78 + 0.22 * Math.sin(this.phase)) : 1;

        if (this.isBeacon) {
          const haloRadius = this.radius * 6.2;
          const grad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, haloRadius);
          grad.addColorStop(0, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${(0.52 * twinkle).toFixed(3)})`);
          grad.addColorStop(0.42, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${(0.18 * twinkle).toFixed(3)})`);
          grad.addColorStop(1, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, 0)`);
          ctx.beginPath();
          ctx.arc(this.x, this.y, haloRadius, 0, Math.PI * 2);
          ctx.fillStyle = grad;
          ctx.fill();
        }

        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${twinkle.toFixed(3)})`;
        ctx.shadowBlur = is3DStage ? (this.isBeacon ? 16 : 9) : 12;
        ctx.shadowColor = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${is3DStage ? '0.78' : '0.5'})`;
        ctx.fill();
      }
    }

    for (let i = 0; i < particleCount; i++) {
      particles.push(new Particle(i));
    }

    const connectParticles = () => {
      ctx.shadowBlur = 0;
      for (let a = 0; a < particles.length; a++) {
        for (let b = a + 1; b < particles.length; b++) {
          const dx = particles[a].x - particles[b].x;
          const dy = particles[a].y - particles[b].y;
          const dist = Math.sqrt(dx * dx + dy * dy);

          if (dist < maxDistance) {
            const opacity = (1 - dist / maxDistance) * (is3DStage ? 0.3 : 0.28);
            ctx.beginPath();
            ctx.strokeStyle = is3DStage
              ? `rgba(56, 189, 248, ${opacity.toFixed(3)})`
              : `rgba(59, 130, 246, ${opacity})`;
            ctx.lineWidth = is3DStage ? 0.8 : 0.75;
            ctx.moveTo(particles[a].x, particles[a].y);
            ctx.lineTo(particles[b].x, particles[b].y);
            ctx.stroke();
          }
        }
      }
    };

    let animationId;
    const animate = () => {
      ctx.clearRect(0, 0, width, height);
      for (let i = 0; i < particles.length; i++) {
        particles[i].update();
        particles[i].draw();
      }
      connectParticles();
      animationId = requestAnimationFrame(animate);
    };

    animate();
  };

  initNeuralCanvas();

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
  // 9. Smooth Parallax on Hero Visual (disabled when 3D WebGL stage active)
  // ======================================================================
  const heroVisual = document.querySelector('.hero-visual');
  if (heroVisual && !document.body.classList.contains('has-hero-3d')) {
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

  // ======================================================================
  // 11. Interactive Hero Terminal Tab Switcher
  // ======================================================================
  const initTerminalTabs = () => {
    const tabButtons = document.querySelectorAll('.terminal-tab-btn');
    const panes = document.querySelectorAll('.terminal-pane');
    if (!tabButtons.length || !panes.length) return;

    let activeIndex = 0;
    let autoCycleTimer = null;
    let userInteracted = false;

    const switchTab = (index) => {
      tabButtons.forEach((btn, i) => {
        btn.classList.toggle('active', i === index);
        btn.setAttribute('aria-selected', i === index ? 'true' : 'false');
      });
      panes.forEach((pane, i) => {
        pane.classList.toggle('active', i === index);
      });
      activeIndex = index;
    };

    tabButtons.forEach((btn, index) => {
      btn.addEventListener('click', () => {
        userInteracted = true;
        if (autoCycleTimer) clearInterval(autoCycleTimer);
        switchTab(index);
      });
    });

    // Auto-cycle through terminal tabs every 6 seconds unless user manually clicked
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    autoCycleTimer = setInterval(() => {
      if (!userInteracted) {
        const nextIndex = (activeIndex + 1) % tabButtons.length;
        switchTab(nextIndex);
      }
    }, 6000);
  };

  initTerminalTabs();

  // ======================================================================
  // 12. Interactive Case Studies & Projects Slider (Carousel)
  // ======================================================================
  const initCaseStudiesSlider = () => {
    const sliderContainer = document.querySelector('.slider-container[data-slider="case-studies"]');
    if (!sliderContainer) return;

    const track = sliderContainer.querySelector('.slider-track');
    const cards = sliderContainer.querySelectorAll('.slider-card');
    const prevBtn = sliderContainer.querySelector('.slider-prev-btn');
    const nextBtn = sliderContainer.querySelector('.slider-next-btn');
    const dotsContainer = sliderContainer.querySelector('.slider-dots');

    if (!track || !cards.length) return;

    let currentIndex = 0;
    let autoPlayTimer = null;
    let touchStartX = 0;
    let touchEndX = 0;

    const getVisibleCards = () => {
      if (window.innerWidth <= 768) return 1;
      if (window.innerWidth <= 1024) return 2;
      return 3;
    };

    const getMaxIndex = () => {
      const visible = getVisibleCards();
      return Math.max(0, cards.length - visible);
    };

    // Render navigation dots
    const updateDots = () => {
      if (!dotsContainer) return;
      dotsContainer.innerHTML = '';
      const maxIdx = getMaxIndex();
      for (let i = 0; i <= maxIdx; i++) {
        const dot = document.createElement('button');
        dot.className = `slider-dot ${i === currentIndex ? 'active' : ''}`;
        dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
      }
    };

    const updateSlider = () => {
      const maxIdx = getMaxIndex();
      if (currentIndex > maxIdx) currentIndex = maxIdx;
      if (currentIndex < 0) currentIndex = 0;

      const card = cards[0];
      const gap = 24; // 1.5rem
      const cardWidth = card.getBoundingClientRect().width;
      const offset = currentIndex * (cardWidth + gap);

      track.style.transform = `translateX(-${offset}px)`;

      if (prevBtn) prevBtn.disabled = currentIndex === 0;
      if (nextBtn) nextBtn.disabled = currentIndex >= maxIdx;

      // Update dots
      if (dotsContainer) {
        const dots = dotsContainer.querySelectorAll('.slider-dot');
        dots.forEach((dot, idx) => {
          dot.classList.toggle('active', idx === currentIndex);
        });
      }
    };

    const goToSlide = (idx) => {
      currentIndex = idx;
      updateSlider();
    };

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
          currentIndex--;
          updateSlider();
        }
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        if (currentIndex < getMaxIndex()) {
          currentIndex++;
          updateSlider();
        }
      });
    }

    // Touch swipe support
    sliderContainer.addEventListener('touchstart', (e) => {
      touchStartX = e.touches[0].clientX;
    }, { passive: true });

    sliderContainer.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].clientX;
      const diff = touchStartX - touchEndX;
      if (Math.abs(diff) > 50) {
        if (diff > 0 && currentIndex < getMaxIndex()) {
          currentIndex++;
        } else if (diff < 0 && currentIndex > 0) {
          currentIndex--;
        }
        updateSlider();
      }
    }, { passive: true });

    // Auto-advance slider
    const startAutoPlay = () => {
      if (autoPlayTimer) clearInterval(autoPlayTimer);
      autoPlayTimer = setInterval(() => {
        const maxIdx = getMaxIndex();
        if (currentIndex >= maxIdx) {
          currentIndex = 0;
        } else {
          currentIndex++;
        }
        updateSlider();
      }, 5000);
    };

    const stopAutoPlay = () => {
      if (autoPlayTimer) clearInterval(autoPlayTimer);
    };

    sliderContainer.addEventListener('mouseenter', stopAutoPlay);
    sliderContainer.addEventListener('mouseleave', startAutoPlay);

    window.addEventListener('resize', () => {
      updateDots();
      updateSlider();
    });

    updateDots();
    updateSlider();
    startAutoPlay();
  };

  initCaseStudiesSlider();

  // ======================================================================
  // 13. Interactive Project Filter Tabs & 2-Row "View More" System
  // ======================================================================
  const initProjectFilters = () => {
    const filterButtons = document.querySelectorAll('.project-filter-btn');
    const projectCards = document.querySelectorAll('.project-card');
    const toggleBtn = document.getElementById('btnToggleMoreProjects');
    const toggleWrap = document.getElementById('projectsLoadMoreWrap');
    if (!projectCards.length) return;

    const INITIAL_VISIBLE_COUNT = 6; // 3 columns * 2 rows = 6 cards
    let currentCategory = 'all';
    let isExpanded = false;

    const updateProjectsVisibility = () => {
      // Find all cards matching currentCategory
      const matchingCards = [];
      projectCards.forEach(card => {
        const cardCat = card.getAttribute('data-category') || '';
        const matches = currentCategory === 'all' || cardCat.includes(currentCategory);
        if (matches) {
          matchingCards.push(card);
        } else {
          card.classList.add('hidden');
          card.classList.remove('is-overflow-hidden');
        }
      });

      const totalMatching = matchingCards.length;

      // Handle visibility based on 2-row threshold (8 cards) and expanded state
      matchingCards.forEach((card, index) => {
        card.classList.remove('hidden');
        if (toggleBtn && !isExpanded && index >= INITIAL_VISIBLE_COUNT) {
          card.classList.add('is-overflow-hidden');
        } else {
          card.classList.remove('is-overflow-hidden');
          card.style.animation = 'fadeIn 0.35s ease forwards';
        }
      });

      // Update "View More" button text, count badge, and visibility
      if (toggleWrap && toggleBtn) {
        if (totalMatching <= INITIAL_VISIBLE_COUNT) {
          toggleWrap.style.display = 'none';
        } else {
          toggleWrap.style.display = 'flex';
          const textSpan = toggleBtn.querySelector('.btn-more-text');
          const badgeSpan = toggleBtn.querySelector('.btn-more-badge');

          if (isExpanded) {
            toggleBtn.classList.add('is-expanded');
            if (textSpan) textSpan.textContent = 'Show Less Projects';
            if (badgeSpan) badgeSpan.style.display = 'none';
          } else {
            toggleBtn.classList.remove('is-expanded');
            const hiddenCount = totalMatching - INITIAL_VISIBLE_COUNT;
            if (textSpan) textSpan.textContent = 'View More Projects';
            if (badgeSpan) {
              badgeSpan.style.display = 'inline-block';
              badgeSpan.textContent = `+${hiddenCount} More`;
            }
          }
        }
      }
    };

    // Category button clicks
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        currentCategory = btn.getAttribute('data-filter') || 'all';

        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Reset expanded state when switching category filter
        isExpanded = false;
        updateProjectsVisibility();
      });
    });

    // Toggle More button click
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        if (isExpanded) {
          isExpanded = false;
          updateProjectsVisibility();
          // Smoothly scroll back to projects section
          const projectsSection = document.getElementById('work') || document.getElementById('projects');
          if (projectsSection) {
            projectsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }
        } else {
          isExpanded = true;
          updateProjectsVisibility();
        }
      });
    }

    // Initial pass to enforce 2-row visibility
    updateProjectsVisibility();
  };

  initProjectFilters();

  // ======================================================================
  // 15. Live Project Demo Modal & Interactive Simulators
  // ======================================================================
  const initDemoModal = () => {
    const modalOverlay = document.getElementById('projectDemoModal');
    if (!modalOverlay) return;

    const closeBtn = modalOverlay.querySelector('.demo-close-btn');
    const navTabs = modalOverlay.querySelectorAll('.demo-nav-tab');
    const panes = modalOverlay.querySelectorAll('.demo-simulator-pane');
    const triggers = document.querySelectorAll('.btn-demo-trigger');

    const normalizeTarget = (raw) => {
      if (!raw) return 'erp';
      const key = String(raw).toLowerCase().trim();
      if (key === 'healthcare' || key === 'medical' || key === 'clinic') return 'booking';
      if (key === 'commerce' || key === 'catalog' || key === 'ecommerce') return 'b2b';
      if (key === 'ai' || key === 'chat') return 'rag';
      if (key === 'automation' || key === 'webhook' || key === 'crm') return 'wa';
      return key;
    };

    const openModal = (targetKey) => {
      const demoKey = normalizeTarget(targetKey);
      modalOverlay.classList.add('active');
      modalOverlay.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';

      // Switch to targeted tab
      navTabs.forEach(tab => {
        const isTarget = tab.getAttribute('data-demo-target') === demoKey;
        tab.classList.toggle('active', isTarget);
        tab.setAttribute('aria-selected', isTarget ? 'true' : 'false');
      });
      panes.forEach(pane => {
        const isTarget = pane.id === `demo-pane-${demoKey}`;
        pane.classList.toggle('active', isTarget);
      });
    };

    const closeModal = () => {
      modalOverlay.classList.remove('active');
      modalOverlay.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    };

    triggers.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const demoKey = btn.getAttribute('data-demo') || 'erp';
        openModal(demoKey);
      });
      btn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          const demoKey = btn.getAttribute('data-demo') || 'erp';
          openModal(demoKey);
        }
      });
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', closeModal);
    }

    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) closeModal();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
        closeModal();
      }
    });

    navTabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const target = normalizeTarget(tab.getAttribute('data-demo-target'));
        navTabs.forEach(t => {
          const isMatch = t === tab;
          t.classList.toggle('active', isMatch);
          t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
        });
        panes.forEach(p => p.classList.toggle('active', p.id === `demo-pane-${target}`));
      });
    });

    // -------------------------------------------------------------
    // SIMULATOR 1: SCHOOL & CAMPUS ERP (demo_key = 'erp')
    // -------------------------------------------------------------
    const erpStudentSelect = document.getElementById('erpStudentSelect');
    const erpTuitionDisplay = document.getElementById('erpTuitionDisplay');
    const erpLabDisplay = document.getElementById('erpLabDisplay');
    const erpExamDisplay = document.getElementById('erpExamDisplay');
    const erpTotalDue = document.getElementById('erpTotalDue');
    const erpGenerateVoucherBtn = document.getElementById('erpGenerateVoucherBtn');
    const erpDownloadVoucherBtn = document.getElementById('erpDownloadVoucherBtn');
    const erpVoucherSheet = document.getElementById('erpVoucherSheet');

    const updateErpFeePreview = () => {
      if (!erpStudentSelect) return;
      const opt = erpStudentSelect.options[erpStudentSelect.selectedIndex];
      if (!opt) return;

      const tuition = Number(opt.getAttribute('data-tuition') || 12000);
      const lab = Number(opt.getAttribute('data-lab') || 3500);
      const exam = Number(opt.getAttribute('data-exam') || 1500);
      const total = tuition + lab + exam;

      if (erpTuitionDisplay) erpTuitionDisplay.textContent = `₹${tuition.toLocaleString('en-IN')}`;
      if (erpLabDisplay) erpLabDisplay.textContent = `₹${lab.toLocaleString('en-IN')}`;
      if (erpExamDisplay) erpExamDisplay.textContent = `₹${exam.toLocaleString('en-IN')}`;
      if (erpTotalDue) erpTotalDue.textContent = `₹${total.toLocaleString('en-IN')}`;
    };

    if (erpStudentSelect) {
      erpStudentSelect.addEventListener('change', updateErpFeePreview);
    }

    if (erpGenerateVoucherBtn && erpStudentSelect) {
      erpGenerateVoucherBtn.addEventListener('click', () => {
        const opt = erpStudentSelect.options[erpStudentSelect.selectedIndex];
        if (!opt) return;

        const name = opt.getAttribute('data-name') || 'Student';
        const id = opt.getAttribute('data-id') || 'STU-001';
        const grade = opt.getAttribute('data-grade') || 'Grade 11';
        const tuition = Number(opt.getAttribute('data-tuition') || 12000);
        const lab = Number(opt.getAttribute('data-lab') || 3500);
        const exam = Number(opt.getAttribute('data-exam') || 1500);
        const total = tuition + lab + exam;
        const randToken = '#VCH-' + Math.floor(100000 + Math.random() * 900000);

        const vName = document.getElementById('vStudentName');
        const vId = document.getElementById('vStudentId');
        const vGrade = document.getElementById('vStudentGrade');
        const vToken = document.getElementById('vToken');
        const vTuition = document.getElementById('vRowTuition');
        const vLab = document.getElementById('vRowLab');
        const vExam = document.getElementById('vRowExam');
        const vTotal = document.getElementById('vRowTotal');

        if (vName) vName.textContent = name;
        if (vId) vId.textContent = id;
        if (vGrade) vGrade.textContent = grade;
        if (vToken) vToken.textContent = randToken;
        if (vTuition) vTuition.textContent = `₹${tuition.toLocaleString('en-IN')}.00`;
        if (vLab) vLab.textContent = `₹${lab.toLocaleString('en-IN')}.00`;
        if (vExam) vExam.textContent = `₹${exam.toLocaleString('en-IN')}.00`;
        if (vTotal) vTotal.textContent = `₹${total.toLocaleString('en-IN')}.00`;

        if (erpVoucherSheet) {
          erpVoucherSheet.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
          erpVoucherSheet.style.transform = 'scale(1.02)';
          erpVoucherSheet.style.boxShadow = '0 0 25px rgba(56, 189, 248, 0.4)';
          setTimeout(() => {
            erpVoucherSheet.style.transform = '';
            erpVoucherSheet.style.boxShadow = '';
          }, 400);
        }

        const origBtnText = erpGenerateVoucherBtn.innerHTML;
        erpGenerateVoucherBtn.innerHTML = '<span>✓ Official Fee Slip Generated!</span>';
        setTimeout(() => {
          erpGenerateVoucherBtn.innerHTML = origBtnText;
        }, 1800);
      });
    }

    if (erpDownloadVoucherBtn) {
      erpDownloadVoucherBtn.addEventListener('click', () => {
        const origText = erpDownloadVoucherBtn.innerHTML;
        erpDownloadVoucherBtn.innerHTML = '<span>✓ Voucher Slip Ready (Print Simulated)</span>';
        setTimeout(() => {
          erpDownloadVoucherBtn.innerHTML = origText;
        }, 1800);
      });
    }

    // -------------------------------------------------------------
    // SIMULATOR 2: HEALTHCARE CLINICAL OPD (demo_key = 'booking')
    // -------------------------------------------------------------
    const docCards = modalOverlay.querySelectorAll('.doctor-card');
    const slotBtns = modalOverlay.querySelectorAll('.slot-picker-grid .slot-btn');
    const medConfirmBtn = document.getElementById('medConfirmBookingBtn');
    const medPassCard = document.getElementById('medPassCard');

    let currentDoctor = { name: 'Dr. Aris Thorne', dept: 'Cardiology', room: 'OPD Suite 402', fee: '₹800' };
    let currentSlot = '11:00 AM';

    docCards.forEach(card => {
      card.addEventListener('click', () => {
        docCards.forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        currentDoctor = {
          name: card.getAttribute('data-doctor') || 'Specialist Doctor',
          dept: card.getAttribute('data-dept') || 'OPD Specialist',
          room: card.getAttribute('data-room') || 'Suite 101',
          fee: card.getAttribute('data-fee') || '₹800'
        };
      });
    });

    slotBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        if (btn.disabled || btn.classList.contains('disabled')) return;
        slotBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentSlot = btn.getAttribute('data-slot') || btn.textContent.trim();
      });
    });

    if (medConfirmBtn) {
      medConfirmBtn.addEventListener('click', () => {
        const patientInput = document.getElementById('medPatientName');
        const phoneInput = document.getElementById('medPatientPhone');
        const patientName = (patientInput && patientInput.value.trim()) ? patientInput.value.trim() : 'Priya Deshmukh';
        const patientPhone = (phoneInput && phoneInput.value.trim()) ? phoneInput.value.trim() : '+91 98201-44021';

        const randToken = '#OPD-' + Math.floor(100 + Math.random() * 900);
        const passToken = document.getElementById('medTokenNum');
        const passDoctor = document.getElementById('medPassDoctor');
        const passSlot = document.getElementById('medPassSlot');
        const passPatient = document.getElementById('medPassPatient');
        const passRoom = document.getElementById('medPassRoom');
        const passFee = document.getElementById('medPassFee');
        const passPhone = document.getElementById('medPassPhone');

        if (passToken) passToken.textContent = randToken;
        if (passDoctor) passDoctor.textContent = `${currentDoctor.name} (${currentDoctor.dept})`;
        if (passSlot) passSlot.textContent = `Today • ${currentSlot}`;
        if (passPatient) passPatient.textContent = patientName;
        if (passRoom) passRoom.textContent = currentDoctor.room;
        if (passFee) passFee.textContent = `${currentDoctor.fee} (Paid at Counter)`;
        if (passPhone) passPhone.textContent = patientPhone;

        if (medPassCard) {
          medPassCard.style.transition = 'transform 0.25s ease, box-shadow 0.25s ease';
          medPassCard.style.transform = 'scale(1.02)';
          medPassCard.style.boxShadow = '0 0 25px rgba(16, 185, 129, 0.45)';
          setTimeout(() => {
            medPassCard.style.transform = '';
            medPassCard.style.boxShadow = '';
          }, 450);
        }

        const origBtn = medConfirmBtn.innerHTML;
        medConfirmBtn.innerHTML = '<span>✓ Atomic Slot Locked & Ticket Dispatched!</span>';
        setTimeout(() => {
          medConfirmBtn.innerHTML = origBtn;
        }, 2000);
      });
    }

    // -------------------------------------------------------------
    // SIMULATOR 3: AUTOMOTIVE WHEEL FITMENT (demo_key = 'b2b')
    // -------------------------------------------------------------
    const fitMake = document.getElementById('fitMake');
    const fitModel = document.getElementById('fitModel');
    const fitBolt = document.getElementById('fitBolt');
    const fitCb = document.getElementById('fitCb');
    const fitOffset = document.getElementById('fitOffset');
    const fitQueryBtn = document.getElementById('fitQueryBtn');
    const fitResultsList = document.getElementById('fitResultsList');

    const fitCatalog = {
      bmw: [
        { model: 'M4 Competition (G82 Chassis)', bolt: '5x112', cb: '66.6 mm', offset: 'ET20 / ET25', wheels: [
          { name: 'ApexForged Apex-GT 2-Piece Monoblock', specs: 'Front: 19x9.5 ET20 • Rear: 20x10.5 ET25', price: '₹1,85,000', tags: ['TUV Certified', 'Aviation Alloy', 'In Stock (4 Sets)'] },
          { name: 'TrackSpec Competition Lightweight RS', specs: 'Front: 19x9.5 ET20 • Rear: 20x10.5 ET25', price: '₹2,10,000', tags: ['8.9 kg Ultra-Light', 'Satin Carbon Black', 'In Stock (2 Sets)'] }
        ]},
        { model: 'M3 Sedan (G80 Chassis)', bolt: '5x112', cb: '66.6 mm', offset: 'ET20 / ET25', wheels: [
          { name: 'ApexForged Apex-GT 2-Piece Monoblock', specs: 'Front: 19x9.5 ET20 • Rear: 20x10.5 ET25', price: '₹1,85,000', tags: ['TUV Certified', 'In Stock'] },
          { name: 'EvoSport Forged CS Series', specs: 'Front: 19x9.5 ET20 • Rear: 20x10.5 ET25', price: '₹1,98,000', tags: ['Forged T6-6061', 'Bronze Gold'] }
        ]},
        { model: 'M2 Coupe (G87 Chassis)', bolt: '5x112', cb: '66.6 mm', offset: 'ET20 / ET20', wheels: [
          { name: 'ApexForged SprintLine Ultra', specs: 'Front: 19x9.5 ET20 • Rear: 20x10.0 ET20', price: '₹1,75,000', tags: ['CNC Machined', 'Gunmetal'] }
        ]}
      ],
      porsche: [
        { model: '911 GT3 (992 Chassis)', bolt: 'Centerlock', cb: '71.6 mm', offset: 'ET45 / ET50', wheels: [
          { name: 'CupRacer Forged Magnesium Centerlock', specs: 'Front: 20x9.5 ET45 • Rear: 21x12.0 ET50', price: '₹3,40,000', tags: ['FIA Compliant', 'Magnesium Core', 'Track Ready'] },
          { name: 'Stuttgart AeroDesign Monoblock', specs: 'Front: 20x9.0 ET45 • Rear: 21x11.5 ET50', price: '₹2,75,000', tags: ['Aerodisc Option', 'Gloss Silver'] }
        ]},
        { model: 'Cayman GT4 RS (718 Chassis)', bolt: 'Centerlock', cb: '71.6 mm', offset: 'ET50 / ET45', wheels: [
          { name: 'Weissach Motorsport Ultra-Light', specs: 'Front: 20x8.5 ET50 • Rear: 20x11.0 ET45', price: '₹2,95,000', tags: ['Motorsport Spec', 'Forged'] }
        ]}
      ],
      audi: [
        { model: 'RS6 Avant (C8 Chassis)', bolt: '5x112', cb: '66.6 mm', offset: 'ET22 / ET22', wheels: [
          { name: 'Ingolstadt Sport Dynamic V-Spoke', specs: 'All Corners: 22x10.5 ET22 Monoblock', price: '₹2,20,000', tags: ['SUV / Avant Load Rated', 'Titanium Matt'] }
        ]}
      ],
      mercedes: [
        { model: 'AMG GT 63 S (X290)', bolt: '5x112', cb: '66.6 mm', offset: 'ET25 / ET38', wheels: [
          { name: 'Affalterbach Multi-Spoke Forged Edition', specs: 'Front: 21x10.0 ET25 • Rear: 21x11.5 ET38', price: '₹2,60,000', tags: ['High Load Rated', 'Diamond Cut Polish'] }
        ]}
      ]
    };

    const renderFitmentResults = () => {
      if (!fitMake || !fitModel || !fitResultsList) return;
      const makeKey = fitMake.value;
      const makeList = fitCatalog[makeKey] || fitCatalog.bmw;
      const selectedIndex = fitModel.selectedIndex >= 0 ? fitModel.selectedIndex : 0;
      const vehicle = makeList[selectedIndex] || makeList[0];

      if (fitBolt) fitBolt.textContent = vehicle.bolt;
      if (fitCb) fitCb.textContent = vehicle.cb;
      if (fitOffset) fitOffset.textContent = vehicle.offset;

      fitResultsList.innerHTML = vehicle.wheels.map(w => `
        <div class="wheel-result-card">
          <div class="wheel-icon">🛞</div>
          <div class="wheel-info">
            <strong>${w.name}</strong>
            <div class="wheel-sub font-mono">${w.specs}</div>
            <div class="wheel-tags">
              ${w.tags.map(t => `<span class="w-tag ${t.includes('Stock') ? 'green' : ''}">${t}</span>`).join('')}
            </div>
          </div>
          <div class="wheel-pricing">
            <span class="price-val font-mono">${w.price}</span>
            <span class="price-unit">per set of 4</span>
          </div>
        </div>
      `).join('');
    };

    if (fitMake && fitModel) {
      fitMake.addEventListener('change', () => {
        const makeKey = fitMake.value;
        const list = fitCatalog[makeKey] || [];
        fitModel.innerHTML = list.map((v, i) => `<option value="${i}">${v.model}</option>`).join('');
        renderFitmentResults();
      });

      fitModel.addEventListener('change', renderFitmentResults);
    }

    if (fitQueryBtn) {
      fitQueryBtn.addEventListener('click', () => {
        if (fitResultsList) {
          fitResultsList.style.opacity = '0.4';
          fitResultsList.style.transform = 'translateY(6px)';
          setTimeout(() => {
            renderFitmentResults();
            fitResultsList.style.transition = 'all 0.25s ease';
            fitResultsList.style.opacity = '1';
            fitResultsList.style.transform = 'translateY(0)';
          }, 300);
        }
      });
    }

    // -------------------------------------------------------------
    // SIMULATOR 4: ENTERPRISE AI RAG (demo_key = 'rag')
    // -------------------------------------------------------------
    const ragSendBtn = modalOverlay.querySelector('#ragSendBtn');
    const ragInput = modalOverlay.querySelector('#ragInput');
    const ragChatBox = modalOverlay.querySelector('#ragChatBox');
    const ragChips = modalOverlay.querySelectorAll('.rag-chip');

    const cannedRagAnswers = {
      'ip': 'All proprietary application code, database schemas, and intellectual property developed for your engagement are transferred under the terms of your contract with zero proprietary vendor lock-in.',
      'pipeline': 'In production environments, multi-channel lead ingestion pipes integrate WhatsApp Cloud API with HMAC webhook validation, PII anonymization, and transactional MySQL CRM persistence with sub-second execution.',
      'erp': 'The School & Campus ERP architecture uses normalized relational schemas, prepared PDO transactions, and strict role-based access control (RBAC) to ensure tamper-proof student ledgers and instant fee reconciliation.',
      'tech': 'CodeX404 standardizes on PHP 8.2+, MySQL (PDO prepared statements), vanilla CSS tokens, and modern JavaScript with zero heavy runtime overhead, ensuring high Core Web Vitals and zero build bloat.',
      'booking': 'Clinical appointment scheduling implements atomic database row locks (SELECT ... FOR UPDATE) during the booking reservation window to physically prevent concurrent double-booking collisions.',
      'default': 'CodeX404 Solutions engineers bespoke digital assets, web portals, and automation pipelines across three specialized divisions: BUILD (Web & Portals), GROW (Custom CRM & Ingestion), and AUTOMATE (APIs & AI Pipelines).'
    };

    const sendRagMessage = (text) => {
      if (!text || !text.trim() || !ragChatBox) return;
      const clean = text.trim();

      // User Bubble
      const userRow = document.createElement('div');
      userRow.className = 'rag-message-row user';
      userRow.innerHTML = `
        <div class="rag-avatar" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2);">👤</div>
        <div class="rag-msg-bubble user">
          <p>${clean.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>
        </div>
      `;
      ragChatBox.appendChild(userRow);
      ragChatBox.scrollTop = ragChatBox.scrollHeight;

      if (ragInput) ragInput.value = '';

      // AI Loading State
      const aiRow = document.createElement('div');
      aiRow.className = 'rag-message-row ai';
      aiRow.innerHTML = `
        <div class="rag-avatar">🤖</div>
        <div class="rag-msg-bubble">
          <div class="rag-msg-meta">Vector Search Pipeline &bull; Cosine Similarity Match</div>
          <p style="color: #38BDF8; font-family: var(--font-mono); font-size: 0.8rem;">⟳ Retrieving verified enterprise chunks...</p>
        </div>
      `;
      ragChatBox.appendChild(aiRow);
      ragChatBox.scrollTop = ragChatBox.scrollHeight;

      setTimeout(() => {
        let answer = cannedRagAnswers.default;
        let sourceRef = 'docs/specs/codex404-architecture.spec.md (L42-60)';
        const lower = clean.toLowerCase();

        if (lower.includes('ip') || lower.includes('intellectual') || lower.includes('ownership')) {
          answer = cannedRagAnswers.ip;
          sourceRef = 'contracts/ip-assignment-standard.clause.md (§4.1)';
        } else if (lower.includes('pipeline') || lower.includes('whatsapp') || lower.includes('webhook')) {
          answer = cannedRagAnswers.pipeline;
          sourceRef = 'docs/architecture/whatsapp-ingestion-pipeline.spec.md (L18-35)';
        } else if (lower.includes('erp') || lower.includes('school') || lower.includes('campus') || lower.includes('student')) {
          answer = cannedRagAnswers.erp;
          sourceRef = 'docs/architecture/campus-erp-relational-schema.md (L88-112)';
        } else if (lower.includes('tech') || lower.includes('stack') || lower.includes('database') || lower.includes('php')) {
          answer = cannedRagAnswers.tech;
          sourceRef = 'docs/standards/engineering-principles.md (L12-30)';
        } else if (lower.includes('lock') || lower.includes('booking') || lower.includes('doctor') || lower.includes('appointment')) {
          answer = cannedRagAnswers.booking;
          sourceRef = 'docs/architecture/concurrency-slot-locks.spec.md (L5-22)';
        }

        aiRow.innerHTML = `
          <div class="rag-avatar font-mono" style="font-size:0.72rem;font-weight:700;">RAG</div>
          <div class="rag-msg-bubble">
            <div class="rag-msg-meta">Grounded Response &bull; Token Match: 98.4%</div>
            <p>${answer}</p>
            <div style="margin-top: 0.5rem; font-size: 0.72rem; color: #94A3B8; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.4rem; font-family: var(--font-mono);">
              Grounded Source: <code style="color: #38BDF8;">${sourceRef}</code>
            </div>
          </div>
        `;
        ragChatBox.scrollTop = ragChatBox.scrollHeight;
      }, 650);
    };

    if (ragSendBtn && ragInput) {
      ragSendBtn.addEventListener('click', () => sendRagMessage(ragInput.value));
      ragInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          sendRagMessage(ragInput.value);
        }
      });
    }

    ragChips.forEach(chip => {
      chip.addEventListener('click', () => {
        const query = chip.getAttribute('data-prompt') || chip.textContent.trim();
        sendRagMessage(query);
      });
    });

    // -------------------------------------------------------------
    // SIMULATOR 5: WHATSAPP CRM & WEBHOOK (demo_key = 'wa')
    // -------------------------------------------------------------
    const waSimulateBtn = modalOverlay.querySelector('#waSimulateBtn');
    const waChatLog = modalOverlay.querySelector('#waChatLog');
    const crmLeadList = modalOverlay.querySelector('#crmLeadList');

    if (waSimulateBtn && waChatLog && crmLeadList) {
      let waCycle = 0;
      const waScenarios = [
        {
          inbound: 'Hi, we operate a clinic with 4 doctors. Can your booking portal prevent overlapping appointments and send WhatsApp reminders?',
          outbound: 'Yes. Our clinical scheduler incorporates atomic database row-locks (preventing concurrent slot claims) with automated WhatsApp dispatch.',
          ticket: 'CX-8843',
          intent: 'clinical_booking_inquiry',
          endpoint: 'POST /api/webhooks/whatsapp/booking',
          routing: 'Healthcare Systems Desk'
        },
        {
          inbound: 'We need an automated fee voucher and student report card portal for a school with 1,500 students. What is your implementation timeframe?',
          outbound: 'Yes, our Campus ERP engine automates roll numbers, fee breakdown slips, and parent circulars. A solutions architect will share our architecture spec shortly.',
          ticket: 'CX-8844',
          intent: 'campus_erp_scoping',
          endpoint: 'POST /api/webhooks/whatsapp/erp',
          routing: 'Institutional Engineering Desk'
        },
        {
          inbound: 'We need a high-speed automotive wheel catalog with Year/Make/Model PCD fitment filters for our wholesale dealership network.',
          outbound: 'Understood. Our automotive catalog platform features dynamic vehicle PCD/Offset matrix calculations with real-time stock checks.',
          ticket: 'CX-8845',
          intent: 'b2b_catalog_inquiry',
          endpoint: 'POST /api/webhooks/whatsapp/catalog',
          routing: 'Commerce & Fitment Desk'
        }
      ];

      waSimulateBtn.addEventListener('click', () => {
        const scenario = waScenarios[waCycle % waScenarios.length];
        waCycle++;
        const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        // Inbound Bubble
        const inMsg = document.createElement('div');
        inMsg.className = 'wa-msg inbound';
        inMsg.innerHTML = `<p>${scenario.inbound}</p><span class="wa-time">${timeNow}</span>`;
        waChatLog.appendChild(inMsg);
        waChatLog.scrollTop = waChatLog.scrollHeight;

        // Automated Outbound
        setTimeout(() => {
          const outMsg = document.createElement('div');
          outMsg.className = 'wa-msg outbound';
          outMsg.innerHTML = `<p>${scenario.outbound}</p><p style="margin-top: 4px;">Ticket: <strong>#${scenario.ticket}</strong></p><span class="wa-time">${timeNow} • ✓✓</span>`;
          waChatLog.appendChild(outMsg);
          waChatLog.scrollTop = waChatLog.scrollHeight;

          // Prepend Webhook Ingestion Telemetry
          const wpCard = document.createElement('div');
          wpCard.className = 'webhook-payload-item';
          wpCard.innerHTML = `
            <div class="wp-top">
              <span class="wp-endpoint">${scenario.endpoint}</span>
              <span class="wp-status font-mono">200 OK &bull; 14ms</span>
            </div>
            <pre class="wp-code font-mono"><code>{
  "event": "messages.received",
  "ticket_id": "${scenario.ticket}",
  "sender": {
    "phone": "+91 98201-XXXXX",
    "channel": "WhatsApp Cloud API"
  },
  "intent": "${scenario.intent}",
  "crm_status": "LEAD_INGESTED",
  "routing": "${scenario.routing}",
  "timestamp": "${new Date().toISOString()}"
}</code></pre>
          `;
          crmLeadList.prepend(wpCard);
        }, 750);
      });
    }
  };

  // ======================================================================
  // 16. Reading Progress Bar Engine
  // ======================================================================
  const initScrollProgress = () => {
    const bar = document.getElementById('scroll-progress');
    if (!bar) return;

    const onScroll = () => {
      const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
      bar.style.width = `${Math.min(100, Math.max(0, scrolled))}%`;
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  };

  initScrollProgress();

  // ======================================================================
  // 17. Typewriter Hero Animation
  // ======================================================================
  const initTypewriter = () => {
    const el = document.getElementById('typewriter');
    if (!el) return;

    const phrases = [
      'Web platforms · BUILD',
      'Digital marketing · GROW',
      'AI automation · AUTOMATE'
    ];

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      el.textContent = 'BUILD · GROW · AUTOMATE';
      return;
    }

    let phraseIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typeSpeed = 75;

    const type = () => {
      const current = phrases[phraseIndex];
      if (isDeleting) {
        el.textContent = current.substring(0, charIndex - 1);
        charIndex--;
        typeSpeed = 35;
      } else {
        el.textContent = current.substring(0, charIndex + 1);
        charIndex++;
        typeSpeed = 80;
      }

      if (!isDeleting && charIndex === current.length) {
        typeSpeed = 2200; // Hold full phrase
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        phraseIndex = (phraseIndex + 1) % phrases.length;
        typeSpeed = 400;
      }

      setTimeout(type, typeSpeed);
    };

    type();
  };

  initTypewriter();

  // ======================================================================
  // 18. Hero Interactive Terminal Tabs
  // ======================================================================
  const initHeroTerminalTabs = () => {
    const tabBtns = document.querySelectorAll('.terminal-tab-btn');
    const panes = document.querySelectorAll('.terminal-pane');
    if (!tabBtns.length || !panes.length) return;

    tabBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.getAttribute('data-tab');
        tabBtns.forEach(b => {
          const isCurrent = b === btn;
          b.classList.toggle('active', isCurrent);
          b.setAttribute('aria-selected', isCurrent ? 'true' : 'false');
        });
        panes.forEach(pane => {
          pane.classList.toggle('active', pane.id === `pane-${target}`);
        });
      });
    });
  };

  initHeroTerminalTabs();

  // ======================================================================
  // 19. 3D Card Tilt on Mouse Move
  // ======================================================================
  const init3DTilt = () => {
    if (window.innerWidth < 820) return; // Prevent heavy 3D calculations on mobile

    const tiltCards = document.querySelectorAll('.card-tilt, .clean-project-card');
    tiltCards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * -5;
        const rotateY = ((x - centerX) / centerX) * 5;

        card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-4px)`;
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0)';
        card.style.transition = 'transform 0.4s ease';
      });

      card.addEventListener('mouseenter', () => {
        card.style.transition = 'none';
      });
    });
  };

  init3DTilt();

  // ======================================================================
  // 20. Back to Top Floating Button
  // ======================================================================
  const initBackToTop = () => {
    const btn = document.getElementById('backToTopBtn');
    if (!btn) return;

    window.addEventListener('scroll', () => {
      if (window.scrollY > 350) {
        btn.classList.add('visible');
      } else {
        btn.classList.remove('visible');
      }
    }, { passive: true });

    btn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  };

  initBackToTop();

  // ======================================================================
  // 22. Mobile Navigation Dropdown Accordions
  // ======================================================================
  const initMobileDropdowns = () => {
    const toggles = document.querySelectorAll('.nav-dropdown-toggle');
    toggles.forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const parent = toggle.closest('.nav-item-dropdown');
        if (!parent) return;
        const dropdown = parent.querySelector('.nav-dropdown');
        if (!dropdown) return;

        const isExpanded = dropdown.classList.toggle('active');
        toggle.setAttribute('aria-expanded', String(isExpanded));
      });
    });
  };

  initMobileDropdowns();

  // ======================================================================
  // 23. NetNovaz-Style Center-Mode Work Slider
  // ======================================================================
  const initCaseSlider = () => {
    const wrapper = document.getElementById('caseSliderWrapper');
    const track = document.getElementById('caseSliderTrack');
    const prevBtn = document.getElementById('caseSliderPrev');
    const nextBtn = document.getElementById('caseSliderNext');
    const badge = document.getElementById('caseViewBadge');

    if (!wrapper || !track) return;

    const slides = Array.from(track.querySelectorAll('.case-slide-item'));
    if (!slides.length) return;

    let currentIndex = 1; // Center card active on first load (symmetrical peeking on both sides)

    const updateActiveSlide = (index) => {
      slides.forEach((s, idx) => {
        if (idx === index) {
          s.classList.add('is-active-center');
        } else {
          s.classList.remove('is-active-center');
        }
      });
    };

    const scrollToSlide = (index, smooth = true) => {
      if (index < 0) index = slides.length - 1;
      if (index >= slides.length) index = 0;
      currentIndex = index;

      const targetSlide = slides[currentIndex];
      if (!targetSlide) return;

      const trackWidth = track.clientWidth;
      const slideLeft = targetSlide.offsetLeft;
      const slideWidth = targetSlide.offsetWidth;
      const targetScroll = slideLeft - (trackWidth / 2) + (slideWidth / 2);

      track.scrollTo({
        left: targetScroll,
        behavior: smooth ? 'smooth' : 'auto'
      });

      updateActiveSlide(currentIndex);
    };

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        scrollToSlide(currentIndex - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        scrollToSlide(currentIndex + 1);
      });
    }

    // Click on slide to center it
    slides.forEach((slide, idx) => {
      slide.addEventListener('click', (e) => {
        if (currentIndex !== idx) {
          e.preventDefault();
          scrollToSlide(idx);
        }
      });
    });

    // Mouse Drag to Scroll
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let hasMoved = false;

    track.addEventListener('mousedown', (e) => {
      isDown = true;
      hasMoved = false;
      track.classList.add('is-dragging');
      startX = e.pageX - track.offsetLeft;
      scrollLeft = track.scrollLeft;
    });

    track.addEventListener('mouseleave', () => {
      if (!isDown) return;
      isDown = false;
      track.classList.remove('is-dragging');
    });

    track.addEventListener('mouseup', () => {
      if (!isDown) return;
      isDown = false;
      track.classList.remove('is-dragging');
    });

    track.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - track.offsetLeft;
      const walk = (x - startX) * 1.5;
      if (Math.abs(walk) > 5) hasMoved = true;
      track.scrollLeft = scrollLeft - walk;
    });

    // Prevent following links while dragging
    track.querySelectorAll('a').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        if (hasMoved) {
          e.preventDefault();
        }
      });
    });

    // Detect active slide when scrolling stops
    let scrollTimer = null;
    track.addEventListener('scroll', () => {
      clearTimeout(scrollTimer);
      scrollTimer = setTimeout(() => {
        const trackCenter = track.scrollLeft + (track.clientWidth / 2);
        let closestIndex = 0;
        let minDistance = Infinity;

        slides.forEach((slide, idx) => {
          const slideCenter = slide.offsetLeft + (slide.offsetWidth / 2);
          const distance = Math.abs(trackCenter - slideCenter);
          if (distance < minDistance) {
            minDistance = distance;
            closestIndex = idx;
          }
        });

        currentIndex = closestIndex;
        updateActiveSlide(currentIndex);
      }, 50);
    }, { passive: true });

    // Initial alignment on center slide (immediate on load)
    const alignInitial = () => {
      const targetSlide = slides[1] || slides[0];
      if (targetSlide) {
        const trackWidth = track.clientWidth;
        const targetScroll = targetSlide.offsetLeft - (trackWidth / 2) + (targetSlide.offsetWidth / 2);
        track.scrollLeft = targetScroll;
        updateActiveSlide(1);
      }
    };

    alignInitial();
    setTimeout(alignInitial, 60);
    setTimeout(() => { scrollToSlide(1, false); }, 200);
    window.addEventListener('resize', alignInitial, { passive: true });

    // Interactive Mouse View Badge Follower
    if (badge) {
      let mouseX = 0, mouseY = 0;
      let currentX = 0, currentY = 0;
      let isHovered = false;
      let rAF = null;

      const lerp = (start, end, factor) => start + (end - start) * factor;

      const animate = () => {
        currentX = lerp(currentX, mouseX, 0.18);
        currentY = lerp(currentY, mouseY, 0.18);

        const scale = isHovered ? (isDown ? 0.88 : 1) : 0;
        badge.style.transform = `translate3d(${currentX}px, ${currentY}px, 0) translate(-50%, -50%) scale(${scale})`;

        if (!isHovered && Math.abs(currentX - mouseX) < 0.2 && Math.abs(currentY - mouseY) < 0.2) {
          cancelAnimationFrame(rAF);
          rAF = null;
          return;
        }

        rAF = requestAnimationFrame(animate);
      };

      wrapper.addEventListener('mouseenter', () => {
        isHovered = true;
        if (!rAF) rAF = requestAnimationFrame(animate);
      });

      wrapper.addEventListener('mouseleave', () => {
        isHovered = false;
      });

      wrapper.addEventListener('mousemove', (e) => {
        const rect = wrapper.getBoundingClientRect();
        mouseX = e.clientX - rect.left;
        mouseY = e.clientY - rect.top;
        if (!rAF) rAF = requestAnimationFrame(animate);
      });
    }
  };

  // ======================================================================
  // 15b. On-Page System Workflow Simulators (#simulators section)
  // ======================================================================
  const initOnpageSimulators = () => {
    const section = document.getElementById('simulators');
    if (!section) return;

    // --- On-Page RAG Simulator ---
    const ragSendBtn = document.getElementById('onpageRagSendBtn');
    const ragInput = document.getElementById('onpageRagInput');
    const ragChatBox = document.getElementById('onpageRagChatBox');
    const ragChips = section.querySelectorAll('.onpage-rag-chip');

    const cannedRagAnswers = {
      'ip': 'All proprietary application code, database schemas, and intellectual property developed for your engagement are transferred under the terms of your contract with zero proprietary vendor lock-in.',
      'pipeline': 'In production environments, multi-channel lead ingestion pipes integrate WhatsApp Cloud API with HMAC webhook validation, PII anonymization, and transactional MySQL CRM persistence with sub-second execution.',
      'erp': 'The School & Campus ERP architecture uses normalized relational schemas, prepared PDO transactions, and strict role-based access control (RBAC) to ensure tamper-proof student ledgers and instant fee reconciliation.',
      'tech': 'CodeX404 standardizes on PHP 8.2+, MySQL (PDO prepared statements), vanilla CSS tokens, and modern JavaScript with zero heavy runtime overhead, ensuring high Core Web Vitals and zero build bloat.',
      'booking': 'Clinical appointment scheduling implements atomic database row locks (SELECT ... FOR UPDATE) during the booking reservation window to physically prevent concurrent double-booking collisions.',
      'default': 'CodeX404 Solutions engineers bespoke digital assets, web portals, and automation pipelines across three specialized divisions: BUILD (Web & Portals), GROW (Custom CRM & Ingestion), and AUTOMATE (APIs & AI Pipelines).'
    };

    const sendOnpageRagMessage = (text) => {
      if (!text || !text.trim() || !ragChatBox) return;
      const clean = text.trim();

      // User Message Bubble
      const userRow = document.createElement('div');
      userRow.className = 'rag-message-row user';
      userRow.innerHTML = `
        <div class="rag-avatar font-mono" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.18); font-size:0.7rem; font-weight:700;">YOU</div>
        <div class="rag-msg-bubble user">
          <p>${clean.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>
        </div>
      `;
      ragChatBox.appendChild(userRow);
      ragChatBox.scrollTop = ragChatBox.scrollHeight;

      if (ragInput) ragInput.value = '';

      // AI Thinking State
      const aiRow = document.createElement('div');
      aiRow.className = 'rag-message-row ai';
      aiRow.innerHTML = `
        <div class="rag-avatar font-mono" style="font-size:0.72rem;font-weight:700;">RAG</div>
        <div class="rag-msg-bubble">
          <div class="rag-msg-meta">Vector Search Pipeline &bull; Cosine Similarity Match</div>
          <p style="color: #38BDF8; font-family: var(--font-mono); font-size: 0.8rem;">Retrieving verified enterprise chunks...</p>
        </div>
      `;
      ragChatBox.appendChild(aiRow);
      ragChatBox.scrollTop = ragChatBox.scrollHeight;

      setTimeout(() => {
        let answer = cannedRagAnswers.default;
        let sourceRef = 'docs/specs/codex404-architecture.spec.md (L42-60)';
        const lower = clean.toLowerCase();

        if (lower.includes('ip') || lower.includes('intellectual') || lower.includes('ownership')) {
          answer = cannedRagAnswers.ip;
          sourceRef = 'contracts/ip-assignment-standard.clause.md (§4.1)';
        } else if (lower.includes('pipeline') || lower.includes('whatsapp') || lower.includes('webhook')) {
          answer = cannedRagAnswers.pipeline;
          sourceRef = 'docs/architecture/whatsapp-ingestion-pipeline.spec.md (L18-35)';
        } else if (lower.includes('erp') || lower.includes('school') || lower.includes('campus') || lower.includes('student')) {
          answer = cannedRagAnswers.erp;
          sourceRef = 'docs/architecture/campus-erp-relational-schema.md (L88-112)';
        } else if (lower.includes('tech') || lower.includes('stack') || lower.includes('database') || lower.includes('php')) {
          answer = cannedRagAnswers.tech;
          sourceRef = 'docs/standards/engineering-principles.md (L12-30)';
        } else if (lower.includes('lock') || lower.includes('booking') || lower.includes('doctor') || lower.includes('appointment')) {
          answer = cannedRagAnswers.booking;
          sourceRef = 'docs/architecture/concurrency-slot-locks.spec.md (L5-22)';
        }

        aiRow.innerHTML = `
          <div class="rag-avatar font-mono" style="font-size:0.72rem;font-weight:700;">RAG</div>
          <div class="rag-msg-bubble">
            <div class="rag-msg-meta">Grounded Response &bull; Token Match: 98.4%</div>
            <p>${answer}</p>
            <div style="margin-top: 0.5rem; font-size: 0.72rem; color: #94A3B8; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.4rem; font-family: var(--font-mono);">
              Grounded Source: <code style="color: #38BDF8;">${sourceRef}</code>
            </div>
          </div>
        `;
        ragChatBox.scrollTop = ragChatBox.scrollHeight;
      }, 500);
    };

    if (ragSendBtn && ragInput) {
      ragSendBtn.addEventListener('click', () => sendOnpageRagMessage(ragInput.value));
      ragInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          sendOnpageRagMessage(ragInput.value);
        }
      });
    }

    ragChips.forEach(chip => {
      chip.addEventListener('click', () => {
        const query = chip.getAttribute('data-prompt') || chip.textContent.trim();
        sendOnpageRagMessage(query);
      });
    });

    // --- On-Page WhatsApp CRM Simulator ---
    const waSimulateBtn = document.getElementById('onpageWaSimulateBtn');
    const waChatLog = document.getElementById('onpageWaChatLog');
    const crmLeadList = document.getElementById('onpageCrmLeadList');

    if (waSimulateBtn && waChatLog && crmLeadList) {
      let waCycle = 0;
      const waScenarios = [
        {
          inbound: 'Hi, we operate a clinic with 4 doctors. Can your booking portal prevent overlapping appointments and send WhatsApp reminders?',
          outbound: 'Yes. Our clinical scheduler incorporates atomic database row-locks (preventing concurrent slot claims) with automated WhatsApp dispatch.',
          ticket: 'CX-8843',
          intent: 'clinical_booking_inquiry',
          endpoint: 'POST /api/webhooks/whatsapp/booking',
          routing: 'Healthcare Systems Desk'
        },
        {
          inbound: 'We need an automated fee voucher and student report card portal for a school with 1,500 students. What is your implementation timeframe?',
          outbound: 'Yes, our Campus ERP engine automates roll numbers, fee breakdown slips, and parent circulars. A solutions architect will share our architecture spec shortly.',
          ticket: 'CX-8844',
          intent: 'campus_erp_scoping',
          endpoint: 'POST /api/webhooks/whatsapp/erp',
          routing: 'Institutional Engineering Desk'
        },
        {
          inbound: 'We need a high-speed automotive wheel catalog with Year/Make/Model PCD fitment filters for our wholesale dealership network.',
          outbound: 'Understood. Our automotive catalog platform features dynamic vehicle PCD/Offset matrix calculations with real-time stock checks.',
          ticket: 'CX-8845',
          intent: 'b2b_catalog_inquiry',
          endpoint: 'POST /api/webhooks/whatsapp/catalog',
          routing: 'Commerce & Fitment Desk'
        }
      ];

      waSimulateBtn.addEventListener('click', () => {
        const scenario = waScenarios[waCycle % waScenarios.length];
        waCycle++;
        const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        // Inbound Bubble
        const inMsg = document.createElement('div');
        inMsg.className = 'wa-msg inbound';
        inMsg.innerHTML = `<p>${scenario.inbound}</p><span class="wa-time">${timeNow}</span>`;
        waChatLog.appendChild(inMsg);
        waChatLog.scrollTop = waChatLog.scrollHeight;

        // Automated Outbound
        setTimeout(() => {
          const outMsg = document.createElement('div');
          outMsg.className = 'wa-msg outbound';
          outMsg.innerHTML = `<p>${scenario.outbound}</p><p style="margin-top: 4px;">Ticket: <strong>#${scenario.ticket}</strong></p><span class="wa-time">${timeNow} &bull; ✓✓</span>`;
          waChatLog.appendChild(outMsg);
          waChatLog.scrollTop = waChatLog.scrollHeight;

          // Prepend Webhook Ingestion Telemetry
          const wpCard = document.createElement('div');
          wpCard.className = 'webhook-payload-item';
          wpCard.innerHTML = `
            <div class="wp-top">
              <span class="wp-endpoint">${scenario.endpoint}</span>
              <span class="wp-status font-mono">200 OK &bull; 14ms</span>
            </div>
            <pre class="wp-code font-mono"><code>{
  "event": "messages.received",
  "ticket_id": "${scenario.ticket}",
  "sender": "+91 98201-XXXXX",
  "intent": "${scenario.intent}",
  "crm_status": "LEAD_INGESTED",
  "routing": "${scenario.routing}",
  "timestamp": "${new Date().toISOString()}"
}</code></pre>
          `;
          crmLeadList.prepend(wpCard);
        }, 550);
      });
    }
  };

  initCaseSlider();

  initDemoModal();
  initOnpageSimulators();
});

