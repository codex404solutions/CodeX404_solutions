document.addEventListener('DOMContentLoaded', function () {
        // View Task Output Modal Handler
        const outputModalEl = document.getElementById('modalViewOutput');
        if (outputModalEl) {
            const outputModal = new bootstrap.Modal(outputModalEl);
            document.querySelectorAll('.btn-view-task-output').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('outputModalTitle').textContent = this.dataset.title || 'Agent Output';
                    document.getElementById('outputModalAgent').textContent = 'Executed by ' + (this.dataset.agent || 'Specialist Agent');
                    document.getElementById('outputModalBody').textContent = this.dataset.output || 'No output recorded.';
                    outputModal.show();
                });
            });
        }

        // Pre-fill Dispatch Modal when clicked from an Agent card or Lead row
        const modalDispatch = document.getElementById('modalDispatchAgent');
        if (modalDispatch) {
            modalDispatch.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                const agentSlug = button.getAttribute('data-agent-slug');
                if (agentSlug) {
                    const select = document.getElementById('dispatchAgentSelect');
                    if (select) select.value = agentSlug;
                }

                const leadId = button.getAttribute('data-lead-id');
                if (leadId) {
                    const leadSelect = document.getElementById('dispatchLeadSelect');
                    if (leadSelect) leadSelect.value = leadId;
                }
            });
        }

        // =========================================================
        // Bootstrap 5.3 Theme Switcher (Combo / Dark / Light / Auto)
        // =========================================================
        const getStoredTheme = () => localStorage.getItem('codex_crm_theme');
        const setStoredTheme = theme => localStorage.setItem('codex_crm_theme', theme);
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

            const textEl = document.getElementById('bd-theme-crm-text');
            const iconEl = document.querySelector('#bd-theme-crm .theme-icon-active');
            if (textEl) textEl.textContent = label;
            if (iconEl) iconEl.className = iconClass;

            const mobileTextEl = document.getElementById('bd-theme-mobile-text');
            const mobileIconEl = document.querySelector('#bd-theme-mobile .theme-icon-active');
            if (mobileTextEl) mobileTextEl.textContent = label;
            if (mobileIconEl) mobileIconEl.className = iconClass;

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
        // Real-Time Multi-Currency Conversion Engine
        // =========================================================
        const getStoredCurrency = () => localStorage.getItem('codex_crm_currency') || 'USD';
        const setStoredCurrency = cur => localStorage.setItem('codex_crm_currency', cur);

        const formatMoney = (amountUsd, targetCurrency) => {
            const rates = window.CODEX_EXCHANGE_RATES || {};
            const rate = parseFloat(rates[targetCurrency]) || 1.0;
            const meta = (window.CODEX_CURRENCIES && window.CODEX_CURRENCIES[targetCurrency]) || { symbol: '$', locale: 'en-US' };
            const converted = Math.round(amountUsd * rate);

            try {
                const formatted = new Intl.NumberFormat(meta.locale || 'en-US', {
                    maximumFractionDigits: 0
                }).format(converted);
                return `${meta.symbol}${formatted}`;
            } catch (err) {
                return `${meta.symbol}${converted.toLocaleString()}`;
            }
        };

        const formatBudgetRange = (rawBudget, targetCurrency) => {
            if (!rawBudget || typeof rawBudget !== 'string') return rawBudget;
            const rates = window.CODEX_EXCHANGE_RATES || {};
            const rate = parseFloat(rates[targetCurrency]) || 1.0;
            const meta = (window.CODEX_CURRENCIES && window.CODEX_CURRENCIES[targetCurrency]) || { symbol: '$', locale: 'en-US' };

            return rawBudget.replace(/\$\s*([\d,]+)/g, (match, p1) => {
                const num = parseFloat(p1.replace(/,/g, ''));
                if (isNaN(num)) return match;
                const converted = Math.round(num * rate);
                try {
                    const formatted = new Intl.NumberFormat(meta.locale || 'en-US', {
                        maximumFractionDigits: 0
                    }).format(converted);
                    return `${meta.symbol}${formatted}`;
                } catch (e) {
                    return `${meta.symbol}${converted.toLocaleString()}`;
                }
            });
        };

        const applyCurrency = (currencyCode) => {
            const currencies = window.CODEX_CURRENCIES || {};
            const cur = currencies[currencyCode] || { symbol: '$', flag: '🇺🇸', name: 'US Dollar' };

            const flagEl = document.getElementById('bd-currency-flag');
            const codeEl = document.getElementById('bd-currency-code');
            const symEl = document.getElementById('bd-currency-symbol');
            if (flagEl) flagEl.textContent = cur.flag;
            if (codeEl) codeEl.textContent = currencyCode;
            if (symEl) symEl.textContent = cur.symbol;

            const mFlagEl = document.getElementById('bd-currency-mobile-flag');
            const mTextEl = document.getElementById('bd-currency-mobile-text');
            const mSymEl = document.getElementById('bd-currency-mobile-symbol');
            if (mFlagEl) mFlagEl.textContent = cur.flag;
            if (mTextEl) mTextEl.innerHTML = `<strong>${currencyCode}</strong> &bull; ${cur.name}`;
            if (mSymEl) mSymEl.textContent = cur.symbol;

            document.querySelectorAll('[data-crm-currency]').forEach(item => {
                if (item.getAttribute('data-crm-currency') === currencyCode) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            document.querySelectorAll('.currency-val').forEach(el => {
                const usd = parseFloat(el.getAttribute('data-usd') || '0');
                el.textContent = formatMoney(usd, currencyCode);
            });

            document.querySelectorAll('.currency-budget').forEach(el => {
                const raw = el.getAttribute('data-raw-budget') || el.textContent;
                el.textContent = formatBudgetRange(raw, currencyCode);
            });

            document.querySelectorAll('.currency-label-code').forEach(el => {
                el.textContent = currencyCode;
            });
        };

        document.querySelectorAll('[data-crm-currency]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const selected = btn.getAttribute('data-crm-currency');
                setStoredCurrency(selected);
                applyCurrency(selected);
            });
        });

        const initialCurrency = getStoredCurrency();
        applyCurrency(initialCurrency);

        (async () => {
            try {
                const res = await fetch('api/v1/rates');
                if (res.ok) {
                    const data = await res.json();
                    if (data && data.rates) {
                        window.CODEX_EXCHANGE_RATES = data.rates;
                        applyCurrency(getStoredCurrency());
                        const tickerEl = document.getElementById('crm-currency-ticker');
                        if (tickerEl && data.rates.INR && data.rates.EUR && data.rates.GBP) {
                            tickerEl.innerHTML = `1 USD = ₹${parseFloat(data.rates.INR).toFixed(2)} &bull; €${parseFloat(data.rates.EUR).toFixed(2)} &bull; £${parseFloat(data.rates.GBP).toFixed(2)}`;
                        }
                    }
                }
            } catch (err) {
                // Silently fallback to server-injected rates
            }
        })();

        // =========================================================
        // Autonomous Agent Slider Controller (Used on Dashboard)
        // =========================================================
        const agentViewport = document.getElementById('agentsSliderViewport');
        const agentTrack = document.getElementById('agentsSliderTrack');
        const agentPrev = document.getElementById('agentSliderPrevBtn');
        const agentNext = document.getElementById('agentSliderNextBtn');
        const agentAutoToggle = document.getElementById('agentSliderAutoToggle');
        const agentAutoIcon = document.getElementById('agentSliderAutoIcon');
        const agentAutoText = document.getElementById('agentSliderAutoText');
        const agentDotsContainer = document.getElementById('agentsSliderDots');

        if (agentTrack && agentViewport) {
            const agentCards = agentTrack.querySelectorAll('.agent-slider-card');
            let curAgentIdx = 0;
            let isAgentAutoPlaying = true;
            let agentAutoTimer = null;

            const getAgentItemsPerPage = () => {
                const w = window.innerWidth;
                if (w < 640) return 1;
                if (w < 1100) return 2;
                return 3;
            };

            const getAgentMaxIdx = () => {
                const perPage = getAgentItemsPerPage();
                return Math.max(0, agentCards.length - perPage);
            };

            const renderAgentDots = () => {
                if (!agentDotsContainer) return;
                agentDotsContainer.innerHTML = '';
                const max = getAgentMaxIdx();
                if (max <= 0) return;

                for (let i = 0; i <= max; i++) {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'agent-dot' + (i === curAgentIdx ? ' active' : '');
                    dot.setAttribute('aria-label', `Go to agent slide ${i + 1}`);
                    dot.addEventListener('click', () => {
                        curAgentIdx = i;
                        updateAgentSlider();
                        resetAgentTimer();
                    });
                    agentDotsContainer.appendChild(dot);
                }
            };

            const updateAgentSlider = () => {
                const max = getAgentMaxIdx();
                if (curAgentIdx > max) curAgentIdx = max;
                if (curAgentIdx < 0) curAgentIdx = 0;

                const first = agentCards[0];
                if (!first) return;

                const cardW = first.offsetWidth;
                const gap = 16;
                const offset = curAgentIdx * (cardW + gap);
                agentTrack.style.transform = `translateX(-${offset}px)`;

                if (agentDotsContainer) {
                    const dots = agentDotsContainer.querySelectorAll('.agent-dot');
                    dots.forEach((d, idx) => {
                        d.classList.toggle('active', idx === curAgentIdx);
                    });
                }
            };

            const nextAgent = () => {
                const max = getAgentMaxIdx();
                curAgentIdx = (curAgentIdx >= max) ? 0 : curAgentIdx + 1;
                updateAgentSlider();
            };

            const prevAgent = () => {
                const max = getAgentMaxIdx();
                curAgentIdx = (curAgentIdx <= 0) ? max : curAgentIdx - 1;
                updateAgentSlider();
            };

            if (agentNext) {
                agentNext.addEventListener('click', () => {
                    nextAgent();
                    resetAgentTimer();
                });
            }

            if (agentPrev) {
                agentPrev.addEventListener('click', () => {
                    prevAgent();
                    resetAgentTimer();
                });
            }

            const startAgentTimer = () => {
                if (agentAutoTimer) clearInterval(agentAutoTimer);
                if (isAgentAutoPlaying && agentCards.length > getAgentItemsPerPage()) {
                    agentAutoTimer = setInterval(nextAgent, 5000);
                }
            };

            const resetAgentTimer = () => {
                startAgentTimer();
            };

            if (agentAutoToggle) {
                agentAutoToggle.addEventListener('click', () => {
                    isAgentAutoPlaying = !isAgentAutoPlaying;
                    if (isAgentAutoPlaying) {
                        if (agentAutoIcon) agentAutoIcon.className = 'bi bi-pause-fill';
                        if (agentAutoText) agentAutoText.textContent = 'Pause Slider';
                        startAgentTimer();
                    } else {
                        if (agentAutoIcon) agentAutoIcon.className = 'bi bi-play-fill';
                        if (agentAutoText) agentAutoText.textContent = 'Play Slider';
                        if (agentAutoTimer) clearInterval(agentAutoTimer);
                    }
                });
            }

            agentViewport.addEventListener('mouseenter', () => {
                if (agentAutoTimer) clearInterval(agentAutoTimer);
            });

            agentViewport.addEventListener('mouseleave', () => {
                if (isAgentAutoPlaying) startAgentTimer();
            });

            let tStartX = 0;
            let tEndX = 0;

            agentViewport.addEventListener('touchstart', (e) => {
                tStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            agentViewport.addEventListener('touchend', (e) => {
                tEndX = e.changedTouches[0].screenX;
                const diff = tStartX - tEndX;
                if (Math.abs(diff) > 40) {
                    if (diff > 0) {
                        nextAgent();
                    } else {
                        prevAgent();
                    }
                    resetAgentTimer();
                }
            }, { passive: true });

            renderAgentDots();
            updateAgentSlider();
            startAgentTimer();

            window.addEventListener('resize', () => {
                renderAgentDots();
                updateAgentSlider();
            });
        }
    });