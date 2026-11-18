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

    const particleCount = Math.min(Math.floor((width * height) / 18000), 75);

    const colors = [
      { r: 6, g: 214, b: 160 },   // cyan-green (#06D6A0)
      { r: 59, g: 130, b: 246 },  // electric blue (#3B82F6)
      { r: 139, g: 92, b: 246 },  // violet (#8B5CF6)
      { r: 56, g: 189, b: 248 },  // sky blue (#38BDF8)
      { r: 236, g: 72, b: 153 }   // pink (#EC4899)
    ];

    class Particle {
      constructor() {
        this.x = Math.random() * width;
        this.y = Math.random() * height;
        this.vx = (Math.random() - 0.5) * 0.65;
        this.vy = (Math.random() - 0.5) * 0.65;
        this.baseRadius = Math.random() * 2 + 1;
        this.radius = this.baseRadius;
        this.color = colors[Math.floor(Math.random() * colors.length)];
      }

      update() {
        this.x += this.vx;
        this.y += this.vy;

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
            this.x -= Math.cos(angle) * force * 2.8;
            this.y -= Math.sin(angle) * force * 2.8;
            this.radius = this.baseRadius * 1.5;
          } else {
            this.radius = this.baseRadius;
          }
        }
      }

      draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = `rgb(${this.color.r}, ${this.color.g}, ${this.color.b})`;
        ctx.shadowBlur = 12;
        ctx.shadowColor = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, 0.5)`;
        ctx.fill();
      }
    }

    for (let i = 0; i < particleCount; i++) {
      particles.push(new Particle());
    }

    const connectParticles = () => {
      for (let a = 0; a < particles.length; a++) {
        for (let b = a + 1; b < particles.length; b++) {
          const dx = particles[a].x - particles[b].x;
          const dy = particles[a].y - particles[b].y;
          const dist = Math.sqrt(dx * dx + dy * dy);

          if (dist < maxDistance) {
            const opacity = (1 - dist / maxDistance) * 0.28;
            ctx.beginPath();
            ctx.strokeStyle = `rgba(59, 130, 246, ${opacity})`;
            ctx.lineWidth = 0.75;
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
  // 13. Interactive Card Spotlight Glow (Follows Cursor)
  // ======================================================================
  const initCardSpotlights = () => {
    const cards = document.querySelectorAll('.card, .slider-card, .process-step, .testimonial-card');
    cards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
      });
    });
  };

  initCardSpotlights();

  // ======================================================================
  // 14. Interactive Project Filter Tabs & 2-Row "View More" System
  // ======================================================================
  const initProjectFilters = () => {
    const filterButtons = document.querySelectorAll('.project-filter-btn');
    const projectCards = document.querySelectorAll('.project-card');
    const toggleBtn = document.getElementById('btnToggleMoreProjects');
    const toggleWrap = document.getElementById('projectsLoadMoreWrap');
    if (!projectCards.length) return;

    const INITIAL_VISIBLE_COUNT = 8; // 4 cards in a row * 2 rows = 8 cards
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

    const openModal = (demoKey) => {
      modalOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';

      // Switch to targeted tab
      if (demoKey) {
        navTabs.forEach(tab => {
          const isTarget = tab.getAttribute('data-demo-target') === demoKey;
          tab.classList.toggle('active', isTarget);
        });
        panes.forEach(pane => {
          const isTarget = pane.id === `demo-pane-${demoKey}`;
          pane.classList.toggle('active', isTarget);
        });
      }
    };

    const closeModal = () => {
      modalOverlay.classList.remove('active');
      document.body.style.overflow = '';
    };

    triggers.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const demoKey = btn.getAttribute('data-demo') || 'rag';
        openModal(demoKey);
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
        const target = tab.getAttribute('data-demo-target');
        navTabs.forEach(t => t.classList.toggle('active', t === tab));
        panes.forEach(p => p.classList.toggle('active', p.id === `demo-pane-${target}`));
      });
    });

    // --- Simulator 1: AI RAG Assistant Sandbox ---
    const ragSendBtn = document.getElementById('ragSendBtn');
    const ragInput = document.getElementById('ragInput');
    const ragChatBox = document.getElementById('ragChatBox');
    const ragChips = document.querySelectorAll('.rag-chip');

    const cannedRagAnswers = {
      'ip': 'Ownership, licensing, and handoff terms are defined in the signed agreement for each engagement.',
      'pipeline': 'In production deployments, multi-channel lead ingestion pipelines can integrate WhatsApp Cloud API and web forms with PII sanitization, deduplication, and CRM endpoint routing.',
      'erp': 'The School ERP platform is built on PHP and MySQL with strict role-based access control (RBAC). It isolates student academic records, fee ledgers, and staff payroll.',
      'default': 'CodeX404 Solutions designs, builds, and automates high-performance software systems across our three core divisions: BUILD, GROW, and AUTOMATE.'
    };

    const sendRagMessage = (text) => {
      if (!text.trim() || !ragChatBox) return;

      // Add user bubble
      const userBubble = document.createElement('div');
      userBubble.className = 'chat-bubble user';
      userBubble.textContent = text;
      ragChatBox.appendChild(userBubble);
      ragChatBox.scrollTop = ragChatBox.scrollHeight;

      if (ragInput) ragInput.value = '';

      // Add loading state
      const aiBubble = document.createElement('div');
      aiBubble.className = 'chat-bubble ai';
      aiBubble.innerHTML = '<span style="color: #38BDF8;">🤖 Searching private enterprise vectors...</span>';
      ragChatBox.appendChild(aiBubble);
      ragChatBox.scrollTop = ragChatBox.scrollHeight;

      setTimeout(() => {
        let answer = cannedRagAnswers.default;
        const lower = text.toLowerCase();
        if (lower.includes('ip') || lower.includes('ownership')) answer = cannedRagAnswers.ip;
        else if (lower.includes('pipeline') || lower.includes('lead') || lower.includes('whatsapp')) answer = cannedRagAnswers.pipeline;
        else if (lower.includes('erp') || lower.includes('school') || lower.includes('student')) answer = cannedRagAnswers.erp;

        aiBubble.innerHTML = `
          <div style="margin-bottom: 0.4rem; color: #38BDF8; font-weight: 600; font-size: 0.75rem;">
            ◈ Semantic Vector Simulation (Sample Match)
          </div>
          <div>${answer}</div>
          <div style="margin-top: 0.5rem; font-size: 0.72rem; color: var(--slate-dark); border-top: 1px solid rgba(255,255,255,0.06); padding-top: 0.35rem;">
            Source: <code>docs/architecture/client-ip-and-security.spec.md (L14-29)</code>
          </div>
        `;
        ragChatBox.scrollTop = ragChatBox.scrollHeight;
      }, 750);
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
        const query = chip.getAttribute('data-prompt') || chip.textContent;
        sendRagMessage(query);
      });
    });

    // --- Simulator 2: WhatsApp Lead Pipeline Sandbox ---
    const waSimulateBtn = document.getElementById('waSimulateBtn');
    const waChatLog = document.getElementById('waChatLog');
    const crmLeadList = document.getElementById('crmLeadList');

    if (waSimulateBtn && waChatLog && crmLeadList) {
      let leadCount = 1;
      waSimulateBtn.addEventListener('click', () => {
        const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        // Add inbound message
        const inMsg = document.createElement('div');
        inMsg.style.cssText = 'background: #202C33; color: #E9EDEF; padding: 8px 12px; border-radius: 8px; margin-bottom: 8px; font-size: 0.85rem; max-width: 85%;';
        inMsg.innerHTML = `<strong>Lead #${leadCount}:</strong> Hi, we need a custom CRM + AI customer support for our 35-person sales team. Can you quote? <div style="font-size: 0.7rem; color: #8696A0; text-align: right;">${timeNow}</div>`;
        waChatLog.appendChild(inMsg);
        waChatLog.scrollTop = waChatLog.scrollHeight;

        // Auto automated reply after 900ms
        setTimeout(() => {
          const outMsg = document.createElement('div');
          outMsg.style.cssText = 'background: #005C4B; color: #E9EDEF; padding: 8px 12px; border-radius: 8px; margin-bottom: 8px; font-size: 0.85rem; max-width: 85%; margin-left: auto;';
          outMsg.innerHTML = `<strong>CodeX404 Auto-Agent:</strong> Thank you! We received your custom CRM inquiry. Our solutions architect is reviewing your requirements and will reply shortly. Reference: #LD-${1040 + leadCount}. <div style="font-size: 0.7rem; color: #8696A0; text-align: right;">${timeNow}</div>`;
          waChatLog.appendChild(outMsg);
          waChatLog.scrollTop = waChatLog.scrollHeight;

          // Add to CRM board
          const crmItem = document.createElement('div');
          crmItem.style.cssText = 'background: rgba(11, 20, 38, 0.9); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 6px; padding: 10px; margin-bottom: 8px; font-size: 0.8rem;';
          crmItem.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
              <strong style="color: #38BDF8;">Custom CRM Inquiry #${1040 + leadCount}</strong>
              <span style="background: rgba(16, 185, 129, 0.2); color: #34D399; font-size: 0.7rem; padding: 2px 6px; border-radius: 4px;">QUALIFIED</span>
            </div>
            <div style="color: var(--slate); font-size: 0.75rem;">Channel: Simulated Inbound Lead &nbsp;•&nbsp; Status: Mock Payload Captured</div>
          `;
          crmLeadList.prepend(crmItem);
          leadCount++;
        }, 900);
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
  // 21. Interactive ROI & System Efficiency Calculator
  // ======================================================================
  const initRoiCalculator = () => {
    const teamSlider = document.getElementById('roiTeamSlider');
    const hoursSlider = document.getElementById('roiHoursSlider');
    const teamVal = document.getElementById('roiTeamVal');
    const hoursVal = document.getElementById('roiHoursVal');
    const savingsVal = document.getElementById('roiSavingsVal');
    const hoursSavedVal = document.getElementById('roiHoursSavedVal');
    const timelineVal = document.getElementById('roiTimelineVal');

    if (!teamSlider || !hoursSlider) return;

    const calculate = () => {
      const team = parseInt(teamSlider.value, 10) || 12;
      const hours = parseInt(hoursSlider.value, 10) || 10;

      if (teamVal) teamVal.textContent = `${team} Engineers / Staff`;
      if (hoursVal) hoursVal.textContent = `${hours} hrs / week / person`;

      // 50 working weeks/year, average blended wage $45/hr, 75% automated recovery
      const totalHoursWasted = team * hours * 50;
      const savedHours = Math.round(totalHoursWasted * 0.75);
      const dollarSavings = Math.round(savedHours * 45);

      if (hoursSavedVal) hoursSavedVal.textContent = `~${savedHours.toLocaleString()} hrs / yr*`;
      if (savingsVal) savingsVal.textContent = `~$${dollarSavings.toLocaleString()}*`;
      if (timelineVal) {
        timelineVal.textContent = 'Milestone Scoped';
      }
    };

    teamSlider.addEventListener('input', calculate);
    hoursSlider.addEventListener('input', calculate);
    calculate();
  };

  initRoiCalculator();

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

  initDemoModal();
});

