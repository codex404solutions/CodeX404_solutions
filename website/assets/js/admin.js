document.addEventListener('DOMContentLoaded', function () {
            // =========================================================
            // Real-Time Filter & Search (For Deliverables Table)
            // =========================================================
            const searchInput = document.getElementById('projectSearch');
            const statusPillBtns = document.querySelectorAll('.filter-pill-btn');
            const categoryFilter = document.getElementById('categoryFilter');
            const rows = document.querySelectorAll('.project-row');
            const counterText = document.getElementById('tableCounterText');

            // Read URL parameter if prefiltered
            const urlParams = new URLSearchParams(window.location.search);
            const initialFilterParam = urlParams.get('filter');
            let currentStatus = (initialFilterParam === 'published' || initialFilterParam === 'active') ? 'active' : ((initialFilterParam === 'draft') ? 'draft' : 'all');
            let currentCategory = 'all';

            function filterRows() {
                if (!rows.length) return;
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                let visibleCount = 0;

                rows.forEach(row => {
                    const searchBlob = row.getAttribute('data-search') || '';
                    const status = row.getAttribute('data-status') || '';
                    const category = row.getAttribute('data-category') || '';

                    const matchesQuery = query === '' || searchBlob.includes(query);
                    const matchesStatus = currentStatus === 'all' || status === currentStatus;
                    const matchesCategory = currentCategory === 'all' || category === currentCategory;

                    if (matchesQuery && matchesStatus && matchesCategory) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (counterText) {
                    counterText.innerHTML = `Showing <strong>${visibleCount}</strong> of <strong>${rows.length}</strong> deliverables`;
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterRows);
            }

            const sidebarStatusBtns = document.querySelectorAll('.sidebar-status-filter');

            // Apply initial status if present from query
            if (currentStatus !== 'all') {
                statusPillBtns.forEach(b => {
                    b.classList.toggle('active', b.getAttribute('data-filter-status') === currentStatus);
                });
                sidebarStatusBtns.forEach(b => {
                    const target = currentStatus === 'active' ? 'published' : currentStatus;
                    b.classList.toggle('active', b.getAttribute('data-status-filter') === target);
                });
                filterRows();
            }

            statusPillBtns.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    if (this.tagName === 'A' && this.getAttribute('href') && !this.getAttribute('href').startsWith('#')) {
                        return; // Let standard link navigate
                    }
                    e.preventDefault();
                    statusPillBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentStatus = this.getAttribute('data-filter-status') || 'all';

                    // Sync sidebar active state
                    sidebarStatusBtns.forEach(b => {
                        const target = currentStatus === 'active' ? 'published' : currentStatus;
                        b.classList.toggle('active', b.getAttribute('data-status-filter') === target);
                    });

                    filterRows();
                });
            });

            sidebarStatusBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetStatus = this.getAttribute('data-status-filter') || 'all';
                    currentStatus = (targetStatus === 'published') ? 'active' : targetStatus;

                    sidebarStatusBtns.forEach(b => {
                        b.classList.toggle('active', b.getAttribute('data-status-filter') === targetStatus);
                    });

                    statusPillBtns.forEach(b => {
                        b.classList.toggle('active', b.getAttribute('data-filter-status') === currentStatus);
                    });

                    filterRows();

                    const tableEl = document.getElementById('portfolio-table');
                    if (tableEl) {
                        tableEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            if (categoryFilter) {
                categoryFilter.addEventListener('change', function () {
                    currentCategory = this.value;
                    filterRows();
                });
            }

            // =========================================================
            // Preview Modal Data Hydration
            // =========================================================
            document.querySelectorAll('.btn-preview-project').forEach(btn => {
                btn.addEventListener('click', function () {
                    const titleEl = document.getElementById('previewTitle');
                    const catEl = document.getElementById('previewCategory');
                    const hostEl = document.getElementById('previewHost');
                    const probEl = document.getElementById('previewProblem');
                    const solEl = document.getElementById('previewSolution');

                    if (titleEl) titleEl.textContent = this.dataset.title || 'Project';
                    if (catEl) catEl.textContent = this.dataset.category || 'Software';
                    if (hostEl) hostEl.textContent = this.dataset.host || 'system.codex404solutions.online';
                    if (probEl) probEl.textContent = this.dataset.problem || 'No description provided.';
                    if (solEl) solEl.textContent = this.dataset.solution || 'No solution recorded.';

                    const stat1Val = document.getElementById('previewStat1Val');
                    const stat1Lbl = document.getElementById('previewStat1Lbl');
                    const stat2Val = document.getElementById('previewStat2Val');
                    const stat2Lbl = document.getElementById('previewStat2Lbl');
                    const stat3Val = document.getElementById('previewStat3Val');
                    const stat3Lbl = document.getElementById('previewStat3Lbl');

                    if (stat1Val) stat1Val.textContent = this.dataset.stat1Val || '-';
                    if (stat1Lbl) stat1Lbl.textContent = this.dataset.stat1Lbl || 'Metric 1';
                    if (stat2Val) stat2Val.textContent = this.dataset.stat2Val || '-';
                    if (stat2Lbl) stat2Lbl.textContent = this.dataset.stat2Lbl || 'Metric 2';
                    if (stat3Val) stat3Val.textContent = this.dataset.stat3Val || '-';
                    if (stat3Lbl) stat3Lbl.textContent = this.dataset.stat3Lbl || 'Metric 3';

                    const liveLink = document.getElementById('previewLiveLink');
                    if (liveLink) {
                        if (this.dataset.liveUrl) {
                            liveLink.href = this.dataset.liveUrl;
                            liveLink.classList.remove('d-none');
                        } else {
                            liveLink.classList.add('d-none');
                        }
                    }

                    const tagsContainer = document.getElementById('previewTags');
                    if (tagsContainer) {
                        tagsContainer.innerHTML = '';
                        try {
                            const tags = JSON.parse(this.dataset.tags || '[]');
                            tags.forEach(t => {
                                const span = document.createElement('span');
                                span.className = 'badge bg-secondary-subtle text-muted border border-secondary-subtle';
                                span.textContent = t;
                                tagsContainer.appendChild(span);
                            });
                        } catch (e) { }
                    }
                });
            });

            // =========================================================
            // Delete Modal Hydration
            // =========================================================
            document.querySelectorAll('.btn-delete-project').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id || '';
                    const title = this.dataset.title || '';
                    const deleteTitle = document.getElementById('deleteProjectTitle');
                    const deleteId = document.getElementById('deleteProjectId');
                    const deleteInputId = document.getElementById('deleteProjectInputId');

                    if (deleteTitle) deleteTitle.textContent = title;
                    if (deleteId) deleteId.textContent = 'ID: ' + id;
                    if (deleteInputId) deleteInputId.value = id;
                });
            });

            // =========================================================
            // Interactive Deliverables Slider Controller
            // =========================================================
            const sliderViewport = document.getElementById('deliverablesSliderViewport');
            const sliderTrack = document.getElementById('deliverablesSliderTrack');
            const prevBtn = document.getElementById('sliderPrevBtn');
            const nextBtn = document.getElementById('sliderNextBtn');
            const autoToggle = document.getElementById('sliderAutoToggle');
            const autoIcon = document.getElementById('sliderAutoIcon');
            const autoText = document.getElementById('sliderAutoText');
            const dotsContainer = document.getElementById('deliverablesSliderDots');

            if (sliderTrack && sliderViewport) {
                const cards = sliderTrack.querySelectorAll('.slider-card-item');
                let currentIndex = 0;
                let isAutoPlaying = true;
                let autoPlayTimer = null;

                const getItemsPerPage = () => {
                    const w = window.innerWidth;
                    if (w < 640) return 1;
                    if (w < 1024) return 2;
                    return 3;
                };

                const getMaxIndex = () => {
                    const perPage = getItemsPerPage();
                    return Math.max(0, cards.length - perPage);
                };

                const renderDots = () => {
                    if (!dotsContainer) return;
                    dotsContainer.innerHTML = '';
                    const max = getMaxIndex();
                    if (max <= 0) return;

                    for (let i = 0; i <= max; i++) {
                        const dot = document.createElement('button');
                        dot.type = 'button';
                        dot.className = 'slider-dot' + (i === currentIndex ? ' active' : '');
                        dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                        dot.addEventListener('click', () => {
                            currentIndex = i;
                            updateSlider();
                            resetTimer();
                        });
                        dotsContainer.appendChild(dot);
                    }
                };

                const updateSlider = () => {
                    const max = getMaxIndex();
                    if (currentIndex > max) currentIndex = max;
                    if (currentIndex < 0) currentIndex = 0;

                    const firstCard = cards[0];
                    if (!firstCard) return;

                    const cardWidth = firstCard.offsetWidth;
                    const gap = 16;
                    const offset = currentIndex * (cardWidth + gap);
                    sliderTrack.style.transform = `translateX(-${offset}px)`;

                    if (dotsContainer) {
                        const dots = dotsContainer.querySelectorAll('.slider-dot');
                        dots.forEach((d, idx) => {
                            d.classList.toggle('active', idx === currentIndex);
                        });
                    }
                };

                const nextSlide = () => {
                    const max = getMaxIndex();
                    currentIndex = (currentIndex >= max) ? 0 : currentIndex + 1;
                    updateSlider();
                };

                const prevSlide = () => {
                    const max = getMaxIndex();
                    currentIndex = (currentIndex <= 0) ? max : currentIndex - 1;
                    updateSlider();
                };

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        nextSlide();
                        resetTimer();
                    });
                }

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        prevSlide();
                        resetTimer();
                    });
                }

                const startTimer = () => {
                    if (autoPlayTimer) clearInterval(autoPlayTimer);
                    if (isAutoPlaying && cards.length > getItemsPerPage()) {
                        autoPlayTimer = setInterval(nextSlide, 4500);
                    }
                };

                const resetTimer = () => {
                    startTimer();
                };

                if (autoToggle) {
                    autoToggle.addEventListener('click', () => {
                        isAutoPlaying = !isAutoPlaying;
                        if (isAutoPlaying) {
                            if (autoIcon) autoIcon.className = 'bi bi-pause-fill';
                            if (autoText) autoText.textContent = 'Pause Slider';
                            startTimer();
                        } else {
                            if (autoIcon) autoIcon.className = 'bi bi-play-fill';
                            if (autoText) autoText.textContent = 'Play Slider';
                            if (autoPlayTimer) clearInterval(autoPlayTimer);
                        }
                    });
                }

                sliderViewport.addEventListener('mouseenter', () => {
                    if (autoPlayTimer) clearInterval(autoPlayTimer);
                });

                sliderViewport.addEventListener('mouseleave', () => {
                    if (isAutoPlaying) startTimer();
                });

                // Touch & Swipe gestures
                let touchStartX = 0;
                let touchEndX = 0;

                sliderViewport.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                sliderViewport.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    const diff = touchStartX - touchEndX;
                    if (Math.abs(diff) > 40) {
                        if (diff > 0) {
                            nextSlide();
                        } else {
                            prevSlide();
                        }
                        resetTimer();
                    }
                }, { passive: true });

                renderDots();
                updateSlider();
                startTimer();

                window.addEventListener('resize', () => {
                    renderDots();
                    updateSlider();
                });
            }

            // =========================================================
            // Dual-Theme Switcher (Combo, Dark, Light, Auto)
            // =========================================================
            const getStoredTheme = () => localStorage.getItem('codex_admin_theme');
            const setStoredTheme = theme => localStorage.setItem('codex_admin_theme', theme);
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme();
                if (storedTheme) return storedTheme;
                return 'combo';
            };

            const updateThemeUI = (theme) => {
                let label = 'Dark & Light';
                let iconClass = 'bi bi-circle-half text-primary theme-icon-active';

                if (theme === 'combo') {
                    label = 'Dark & Light';
                    iconClass = 'bi bi-circle-half text-primary theme-icon-active';
                } else if (theme === 'light') {
                    label = 'Light';
                    iconClass = 'bi bi-sun-fill text-warning theme-icon-active';
                } else if (theme === 'dark') {
                    label = 'Dark';
                    iconClass = 'bi bi-moon-stars-fill text-info theme-icon-active';
                } else {
                    label = 'Auto';
                    iconClass = 'bi bi-laptop text-secondary theme-icon-active';
                }

                const textEl = document.getElementById('bd-theme-admin-text');
                const iconEl = document.querySelector('#bd-theme-admin .theme-icon-active');
                if (textEl) textEl.textContent = label;
                if (iconEl) iconEl.className = iconClass;

                document.querySelectorAll('[data-bs-theme-value]').forEach(el => {
                    if (el.getAttribute('data-bs-theme-value') === theme) {
                        el.classList.add('active');
                    } else {
                        el.classList.remove('active');
                    }
                });
            };

            const applyTheme = (theme) => {
                const effectiveTheme = (theme === 'auto')
                    ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                    : theme;
                document.documentElement.setAttribute('data-bs-theme', effectiveTheme);
                updateThemeUI(theme);
            };

            applyTheme(getPreferredTheme());

            document.querySelectorAll('[data-bs-theme-value]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const selected = btn.getAttribute('data-bs-theme-value');
                    setStoredTheme(selected);
                    applyTheme(selected);
                });
            });

            window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', () => {
                const stored = getStoredTheme();
                if (!stored || stored === 'auto') {
                    applyTheme('auto');
                }
            });

            // =========================================================
            // Obsidian Cursor Spotlight Lighting (rAF-throttled)
            // =========================================================
            const LIT_ADMIN_SELECTOR = [
                '.admin-hero-banner',
                '.admin-status-strip',
                '.admin-profile-card',
                '.stat-card',
                '.action-hub-card',
                '.admin-card',
                '.slider-card-item',
                '.cx-panel',
                '.cx-subpanel',
                '.admin-footer',
                '.admin-sidebar-bridge-link',
                '.modal-content'
            ].join(', ');

            let pendingTarget = null;
            let pendingX = 0;
            let pendingY = 0;
            let spotlightRafId = 0;

            function flushAdminSpotlight() {
                spotlightRafId = 0;
                let node = pendingTarget instanceof Element ? pendingTarget.closest(LIT_ADMIN_SELECTOR) : null;
                while (node) {
                    const rect = node.getBoundingClientRect();
                    if (rect.width > 0 && rect.height > 0) {
                        const px = (((pendingX - rect.left) / rect.width) * 100).toFixed(1);
                        const py = (((pendingY - rect.top) / rect.height) * 100).toFixed(1);
                        node.style.setProperty('--spot-x', `${px}%`);
                        node.style.setProperty('--spot-y', `${py}%`);
                    }
                    node = node.parentElement ? node.parentElement.closest(LIT_ADMIN_SELECTOR) : null;
                }
            }

            document.addEventListener('pointermove', (e) => {
                if (e.pointerType === 'touch') return;
                pendingTarget = e.target;
                pendingX = e.clientX;
                pendingY = e.clientY;
                if (!spotlightRafId) {
                    spotlightRafId = requestAnimationFrame(flushAdminSpotlight);
                }
            }, { passive: true });

            // =========================================================
            // Standard Admin Keyboard Shortcuts (/ or Ctrl+K to search)
            // =========================================================
            document.addEventListener('keydown', (e) => {
                const activeTag = document.activeElement ? document.activeElement.tagName : '';
                const isTyping = activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT' || (document.activeElement && document.activeElement.isContentEditable);

                if ((e.key === '/' && !isTyping) || ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k')) {
                    const targetSearch = document.querySelector('#projectSearch, input[type="search"], input[name="q"]');
                    if (targetSearch) {
                        e.preventDefault();
                        targetSearch.focus();
                        targetSearch.select();
                    }
                } else if (e.key === 'Escape' && document.activeElement && document.activeElement.id === 'projectSearch' && document.activeElement.value !== '') {
                    document.activeElement.value = '';
                    document.activeElement.dispatchEvent(new Event('input'));
                }
            });
        });