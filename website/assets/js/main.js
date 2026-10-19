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
      if (willOpen) {
        navMenu.classList.add('open');
        document.body.classList.add('nav-open');
        navToggleBtn.innerHTML = closeSvg;
      } else {
        navMenu.classList.remove('open');
        document.body.classList.remove('nav-open');
        navToggleBtn.innerHTML = hamburgerSvg;
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
  // 14. Interactive Project Filter Tabs System
  // ======================================================================
  const initProjectFilters = () => {
    const filterButtons = document.querySelectorAll('.project-filter-btn');
    const projectCards = document.querySelectorAll('.project-card');
    if (!filterButtons.length || !projectCards.length) return;

    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const targetCategory = btn.getAttribute('data-filter') || 'all';

        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        projectCards.forEach(card => {
          const cardCat = card.getAttribute('data-category') || '';
          if (targetCategory === 'all' || cardCat.includes(targetCategory)) {
            card.classList.remove('hidden');
            card.style.animation = 'fadeIn 0.35s ease forwards';
          } else {
            card.classList.add('hidden');
          }
        });
      });
    });
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
      'ip': 'Under CodeX404 standard engineering contracts, all source code, database architectures, APIs, and IP are 100% owned by the client upon project delivery. We enforce zero vendor lock-in and provide full repository transfer.',
      'pipeline': 'The multi-channel lead ingestion pipeline operates via serverless webhooks listening to WhatsApp Cloud API and web forms. Messages undergo PII sanitization and deduplication before being queued to CRM endpoints within 1.8 seconds.',
      'erp': 'The School ERP platform is built on PHP 8.4 and MySQL with strict role-based access control (RBAC). It isolates student academic records, fee ledgers, and staff payroll while processing thousands of concurrent transactions.',
      'default': 'CodeX404 Solutions designs, builds, and automates high-performance systems with a strict zero-bug engineering policy, senior-only technical leadership, and transparent milestones.'
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
          <div style="margin-bottom: 0.4rem; color: #34D399; font-weight: 600; font-size: 0.75rem;">
            ● Vector Match: 99.4% confidence (latency: 142ms)
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
            <div style="color: var(--slate); font-size: 0.75rem;">Source: WhatsApp Cloud API &nbsp;•&nbsp; Latency: 1.1s</div>
          `;
          crmLeadList.prepend(crmItem);
          leadCount++;
        }, 900);
      });
    }
  };

  initDemoModal();
});

