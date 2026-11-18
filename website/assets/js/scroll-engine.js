/**
 * CodeX404 Solutions — Scroll & Reveal Engine
 * High-performance IntersectionObserver, Touch Sliders & Progressive Enhancement
 * Ensures all content, counters, and diagrams remain visible if JS is disabled.
 */

(function () {
  'use strict';

  // Mark HTML element for CSS progressive enhancement
  document.documentElement.classList.add('js');

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ==========================================================================
     1. Scroll-Driven Reveal Observer
     ========================================================================== */
  function initScrollReveal() {
    if (!('IntersectionObserver' in window) || prefersReducedMotion) {
      // Fallback: reveal everything immediately
      document.querySelectorAll('.reveal-on-scroll, [data-reveal]').forEach(function (el) {
        el.classList.add('is-revealed');
      });
      return;
    }

    const revealObserver = new IntersectionObserver(
      function (entries, observer) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-revealed');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        root: null,
        rootMargin: '0px 0px -40px 0px',
        threshold: 0.12
      }
    );

    document.querySelectorAll('.reveal-on-scroll, [data-reveal]').forEach(function (el) {
      revealObserver.observe(el);
    });
  }

  /* ==========================================================================
     2. Progressive Counter Animation
     ========================================================================== */
  function initCounters() {
    const counterElements = document.querySelectorAll('[data-counter-target]');
    if (!counterElements.length) return;

    if (!('IntersectionObserver' in window) || prefersReducedMotion) {
      // Elements already contain their static fallback number in the HTML
      return;
    }

    const counterObserver = new IntersectionObserver(
      function (entries, observer) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const el = entry.target;
            const target = parseInt(el.getAttribute('data-counter-target'), 10);
            const prefix = el.getAttribute('data-counter-prefix') || '';
            const suffix = el.getAttribute('data-counter-suffix') || '';
            const duration = 1400; // ms
            const startTime = performance.now();

            function updateCounter(currentTime) {
              const elapsed = currentTime - startTime;
              const progress = Math.min(elapsed / duration, 1);
              // Ease-out cubic
              const easeProgress = 1 - Math.pow(1 - progress, 3);
              const currentVal = Math.floor(easeProgress * target);

              el.textContent = prefix + currentVal.toLocaleString() + suffix;

              if (progress < 1) {
                requestAnimationFrame(updateCounter);
              } else {
                el.textContent = prefix + target.toLocaleString() + suffix;
              }
            }

            requestAnimationFrame(updateCounter);
            observer.unobserve(el);
          }
        });
      },
      { threshold: 0.4 }
    );

    counterElements.forEach(function (el) {
      counterObserver.observe(el);
    });
  }

  /* ==========================================================================
     3. Touch-Friendly Horizontal Industry & Use Case Slider
     ========================================================================== */
  function initHorizontalSlider() {
    const sliderWrap = document.querySelector('.industry-slider-wrap');
    if (!sliderWrap) return;

    const track = sliderWrap.querySelector('.industry-slider-track');
    const prevBtn = sliderWrap.querySelector('.slider-nav-prev');
    const nextBtn = sliderWrap.querySelector('.slider-nav-next');
    const dotsContainer = sliderWrap.querySelector('.slider-pagination-dots');

    if (!track) return;

    const cards = track.querySelectorAll('.industry-slider-card');
    if (!cards.length) return;

    // Create dots if container exists
    if (dotsContainer) {
      dotsContainer.innerHTML = '';
      cards.forEach(function (_, idx) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'slider-dot' + (idx === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Go to slide ' + (idx + 1));
        dot.addEventListener('click', function () {
          scrollToIndex(idx);
        });
        dotsContainer.appendChild(dot);
      });
    }

    function updateActiveDot() {
      if (!dotsContainer) return;
      const scrollLeft = track.scrollLeft;
      const cardWidth = cards[0].offsetWidth + 20; // width + gap
      const activeIdx = Math.round(scrollLeft / cardWidth);
      const dots = dotsContainer.querySelectorAll('.slider-dot');
      dots.forEach(function (dot, i) {
        dot.classList.toggle('active', i === activeIdx);
      });
    }

    function scrollToIndex(idx) {
      const cardWidth = cards[0].offsetWidth + 20;
      track.scrollTo({
        left: idx * cardWidth,
        behavior: prefersReducedMotion ? 'auto' : 'smooth'
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        const cardWidth = cards[0].offsetWidth + 20;
        track.scrollBy({
          left: -cardWidth,
          behavior: prefersReducedMotion ? 'auto' : 'smooth'
        });
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        const cardWidth = cards[0].offsetWidth + 20;
        track.scrollBy({
          left: cardWidth,
          behavior: prefersReducedMotion ? 'auto' : 'smooth'
        });
      });
    }

    track.addEventListener('scroll', updateActiveDot, { passive: true });

    // Auto-scroll loop with pause-on-hover
    let autoScrollInterval = null;
    function startAutoScroll() {
      if (prefersReducedMotion) return;
      stopAutoScroll();
      autoScrollInterval = setInterval(function () {
        const maxScroll = track.scrollWidth - track.clientWidth;
        const cardWidth = cards[0].offsetWidth + 20;
        if (track.scrollLeft >= maxScroll - 10) {
          track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
          track.scrollBy({ left: cardWidth, behavior: 'smooth' });
        }
      }, 5000);
    }

    function stopAutoScroll() {
      if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
        autoScrollInterval = null;
      }
    }

    sliderWrap.addEventListener('mouseenter', stopAutoScroll);
    sliderWrap.addEventListener('mouseleave', startAutoScroll);
    sliderWrap.addEventListener('touchstart', stopAutoScroll, { passive: true });

    startAutoScroll();
  }

  /* ==========================================================================
     4. Reading Progress Bar
     ========================================================================== */
  function initProgressBar() {
    const progressBar = document.getElementById('scroll-progress');
    if (!progressBar) return;

    window.addEventListener(
      'scroll',
      function () {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        progressBar.style.width = Math.min(progress, 100) + '%';
      },
      { passive: true }
    );
  }

  /* ==========================================================================
     Initialization
     ========================================================================== */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      initScrollReveal();
      initCounters();
      initHorizontalSlider();
      initProgressBar();
    });
  } else {
    initScrollReveal();
    initCounters();
    initHorizontalSlider();
    initProgressBar();
  }
})();
