/**
 * CodeX404 Solutions — Intelligent AI & Engineering Assistant
 * Handles conversational queries, FAQ retrieval, quick quote intake,
 * WhatsApp escalation, and user-controlled hide / minimize persistence.
 */

document.addEventListener('DOMContentLoaded', () => {
  // DOM Elements
  const wrapper = document.getElementById('codexChatbotWrapper');
  const launcherContainer = document.getElementById('chatbotLauncherContainer');
  const launcherBtn = document.getElementById('chatbotLauncherBtn');
  const launcherTooltip = document.getElementById('chatbotLauncherTooltip');
  const tooltipDismiss = document.getElementById('chatbotTooltipDismiss');
  const quickHideBtn = document.getElementById('chatbotQuickHideBtn');
  const chatWindow = document.getElementById('codexChatWindow');
  const chatMinimizeBtn = document.getElementById('chatMinimizeBtn');
  const chatHideWidgetBtn = document.getElementById('chatHideWidgetBtn');
  const chatCloseBtn = document.getElementById('chatCloseBtn');
  const chatMessagesBody = document.getElementById('chatMessagesBody');
  const chatQuickChips = document.getElementById('chatQuickChips');
  const chatInputForm = document.getElementById('chatInputForm');
  const chatInputText = document.getElementById('chatInputText');
  const chatSendBtn = document.getElementById('chatSendBtn');
  const chatResetBtn = document.getElementById('chatResetBtn');
  const chatRestorePill = document.getElementById('chatbotRestorePill');
  const footerRestoreBtn = document.getElementById('restoreChatbotBtn');

  if (!wrapper || !launcherBtn || !chatWindow) return;

  // Local storage keys
  const STORAGE_KEY_HIDDEN = 'codex_chat_hidden';
  const STORAGE_KEY_TOOLTIP_DISMISSED = 'codex_chat_tooltip_dismissed';
  const SESSION_KEY_MESSAGES = 'codex_chat_messages_v1';

  // State
  let isOpen = false;
  let isAwaitingQuoteDetails = null; // null | 'awaiting_email' | 'awaiting_phone'
  let leadDraft = { name: '', email: '', phone: '', message: '' };

  // --------------------------------------------------------------------------
  // KNOWLEDGE BASE & INTENT ENGINE
  // --------------------------------------------------------------------------
  const KNOWLEDGE_BASE = [
    {
      id: 'services',
      label: '⚡ What services do you offer?',
      keywords: ['service', 'services', 'capabilities', 'what do you do', 'offer', 'solution', 'solutions', 'build', 'web app', 'software', 'mobile', 'ai agent', 'erp', 'saas'],
      reply: `
        <p><strong>CodeX404 Solutions</strong> provides full-spectrum custom software and AI engineering:</p>
        <ul>
          <li><strong>Custom Web Applications:</strong> High-performance enterprise portals, CRM systems, and responsive web platforms.</li>
          <li><strong>Autonomous AI Agents & RAG:</strong> Tailored document search, LLM integrations, and private data retrieval pipelines.</li>
          <li><strong>Mobile App Development:</strong> Native & cross-platform iOS & Android mobile applications.</li>
          <li><strong>Scalable SaaS Platforms:</strong> Multi-tenant SaaS architectures with Stripe/billing automation.</li>
          <li><strong>Custom ERP & School Systems:</strong> Institutional platforms with attendance, fee collection, and grade books.</li>
          <li><strong>Workflow & WhatsApp Automation:</strong> Cloud API pipelines that eliminate manual data entry.</li>
        </ul>
        <p><a href="solutions.php" class="chat-link">Explore Solutions &rarr;</a> &nbsp;|&nbsp; <a href="discovery-call.php" class="chat-link">Book Free Discovery &rarr;</a></p>
      `
    },
    {
      id: 'pricing',
      label: '💰 How does pricing work?',
      keywords: ['price', 'pricing', 'cost', 'how much', 'rate', 'rates', 'fees', 'quote', 'package', 'budget', 'expensive', 'cheap'],
      reply: `
        <p>We work on transparent fixed-milestone pricing with bi-weekly working staging previews. You always know what is being built, when, and for what cost—with zero surprise invoices.</p>
        <p><a href="pricing.php" class="chat-link">Explore Pricing Tiers &rarr;</a> &nbsp;|&nbsp; <a href="contact.php" class="chat-link">Request a Custom Quote &rarr;</a></p>
      `
    },
    {
      id: 'demos',
      label: '🚀 Live demos & portfolio',
      keywords: ['portfolio', 'demo', 'demos', 'examples', 'case study', 'case studies', 'sample', 'work', 'projects'],
      reply: `
        <p>Explore our verified production deliverables, institutional ERPs, booking platforms, and interactive in-browser project demos.</p>
        <p><a href="our-work.php" class="chat-link">Explore Our Work &rarr;</a> &nbsp;|&nbsp; <a href="case-studies.php" class="chat-link">Read Case Studies &rarr;</a></p>
      `
    },
    {
      id: 'discovery',
      label: '📅 Book a discovery call',
      keywords: ['discovery', 'book', 'call', 'meeting', 'schedule', 'talk', 'consultation', 'discuss'],
      reply: `
        <p>We'd love to discuss your technical architecture or MVP scope! Our discovery calls are direct with senior engineering leads — no sales reps.</p>
        <p>We can discuss your goals, existing systems, constraints, and the next steps needed to define a project scope.</p>
        <p><a href="discovery-call.php" class="btn btn-primary btn-sm chat-btn-action">Book 30-Min Discovery Call &rarr;</a></p>
      `
    },
    {
      id: 'contact_eng',
      label: '✉️ Contact engineering directly',
      keywords: ['human', 'person', 'support', 'live person', 'phone', 'contact', 'email', 'talk to someone'],
      reply: `
        <p>Prefer direct communication? Connect directly with our engineering team:</p>
        <p><strong>Email:</strong> <a href="mailto:info@codex404solutions.com" class="chat-link">info@codex404solutions.com</a></p>
        <p><a href="discovery-call.php" class="btn btn-primary btn-sm chat-btn-action">
          Book 30-Min Discovery Call &rarr;
        </a></p>
      `
    },
    {
      id: 'quote',
      label: '📝 Request a quick project quote',
      keywords: ['quote', 'estimate', 'request quote', 'proposal', 'hire', 'start project', 'rfp'],
      reply: `
        <p>Let's get you a tailored estimate! Please type your <strong>work email or phone</strong> along with a brief description of what you're building (e.g., <em>"Web app for logistics, email: name@company.com"</em>), and our team will prepare a scope analysis.</p>
        <p>Or jump straight to our structured inquiry form:</p>
        <p><a href="contact.php" class="chat-link">Submit Detailed Inquiry Form &rarr;</a></p>
      `
    },
    {
      id: 'tech_stack',
      label: '⚙️ What tech stack do you use?',
      keywords: ['stack', 'tech stack', 'technologies', 'php', 'python', 'react', 'node', 'fastapi', 'database', 'mysql', 'postgres', 'docker', 'cloud', 'aws'],
      reply: `
        <p>Our core production tech stack focuses on reliability, speed, and zero bloat:</p>
        <ul>
          <li><strong>Backend:</strong> Modern PHP 8.2+ (strict types, PDO, zero-framework overhead) and Python 3.11+ / FastAPI for AI microservices.</li>
          <li><strong>Frontend:</strong> Modern ES6+ JavaScript, Vanilla CSS / Tailwind, and React/Vue for complex interactive SPAs.</li>
          <li><strong>Data & Storage:</strong> PostgreSQL, MySQL, Redis caching, SQLite embedded engines.</li>
          <li><strong>Infrastructure & AI:</strong> Docker, Nginx, Meta WhatsApp Cloud API, LangChain / LlamaIndex, OpenAI / Claude / Gemini API connectors.</li>
        </ul>
        <p><a href="solutions.php" class="chat-link">Read Architecture Standards &rarr;</a></p>
      `
    },
    {
      id: 'timeline',
      label: '⏱️ How fast can you deliver?',
      keywords: ['timeline', 'turnaround', 'how long', 'how fast', 'deadline', 'delivery', 'weeks', 'days', 'speed'],
      reply: `
        <p>Our agile delivery framework is engineered for predictability and speed:</p>
        <ul>
          <li><strong>Production MVPs:</strong> Typically 6 to 10 weeks delivered in focused two-week sprints.</li>
          <li><strong>Bi-Weekly Demos:</strong> Live staging environments updated every two weeks for testing.</li>
          <li><strong>Guaranteed Roadmaps:</strong> Explicit scope boundaries with 30-day post-launch warranty.</li>
        </ul>
        <p><a href="process.php" class="chat-link">Explore Our 7-Stage Delivery Framework &rarr;</a></p>
      `
    }
  ];

  // --------------------------------------------------------------------------
  // UI CONTROLS & HIDE / MINIMIZE PERSISTENCE
  // --------------------------------------------------------------------------

  // Check if user previously hid the widget
  const isWidgetHidden = () => localStorage.getItem(STORAGE_KEY_HIDDEN) === 'true';

  const setWidgetVisibility = (show) => {
    if (show) {
      localStorage.removeItem(STORAGE_KEY_HIDDEN);
      launcherContainer.style.display = 'flex';
      launcherContainer.classList.remove('widget-hidden');
      chatRestorePill.hidden = true;
    } else {
      localStorage.setItem(STORAGE_KEY_HIDDEN, 'true');
      launcherContainer.style.display = 'none';
      launcherContainer.classList.add('widget-hidden');
      closeChatWindow();
      chatRestorePill.hidden = false;
      showToastNotification('Chat widget hidden. Restore anytime via footer link or the AI Chat tab.');
    }
  };

  // Toast notification for user confirmation
  const showToastNotification = (text) => {
    const existing = document.querySelector('.chat-global-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'chat-global-toast';
    toast.setAttribute('role', 'status');
    toast.innerHTML = `
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
      <span>${text}</span>
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.classList.add('fade-out');
      setTimeout(() => toast.remove(), 400);
    }, 4500);
  };

  // Toggle Chat Window
  const openChatWindow = () => {
    isOpen = true;
    chatWindow.hidden = false;
    chatWindow.classList.add('open');
    launcherBtn.setAttribute('aria-expanded', 'true');
    launcherBtn.classList.add('active');
    if (launcherTooltip) launcherTooltip.style.display = 'none';

    // Focus input or message container
    setTimeout(() => {
      chatInputText.focus();
      scrollMessagesToBottom();
    }, 150);
  };

  const closeChatWindow = () => {
    isOpen = false;
    chatWindow.classList.remove('open');
    launcherBtn.setAttribute('aria-expanded', 'false');
    launcherBtn.classList.remove('active');
    setTimeout(() => {
      if (!isOpen) chatWindow.hidden = true;
    }, 280);
  };

  const toggleChatWindow = () => {
    if (isOpen) {
      closeChatWindow();
    } else {
      openChatWindow();
    }
  };

  // Event Listeners for Launcher & Header controls
  launcherBtn.addEventListener('click', (e) => {
    e.preventDefault();
    toggleChatWindow();
  });

  chatMinimizeBtn.addEventListener('click', (e) => {
    e.preventDefault();
    closeChatWindow();
  });

  chatCloseBtn.addEventListener('click', (e) => {
    e.preventDefault();
    closeChatWindow();
  });

  // Completely Hide Widget
  chatHideWidgetBtn.addEventListener('click', (e) => {
    e.preventDefault();
    setWidgetVisibility(false);
  });

  quickHideBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    setWidgetVisibility(false);
  });

  // Restore Widget buttons (discreet pill and footer link)
  chatRestorePill.addEventListener('click', (e) => {
    e.preventDefault();
    setWidgetVisibility(true);
    openChatWindow();
  });

  if (footerRestoreBtn) {
    footerRestoreBtn.addEventListener('click', (e) => {
      e.preventDefault();
      setWidgetVisibility(true);
      openChatWindow();
    });
  }

  // Dismiss tooltip
  if (tooltipDismiss && launcherTooltip) {
    tooltipDismiss.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      launcherTooltip.style.display = 'none';
      localStorage.setItem(STORAGE_KEY_TOOLTIP_DISMISSED, 'true');
    });

    if (localStorage.getItem(STORAGE_KEY_TOOLTIP_DISMISSED) === 'true') {
      launcherTooltip.style.display = 'none';
    }
  }

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen) {
      closeChatWindow();
    }
  });

  // --------------------------------------------------------------------------
  // MESSAGING & CONVERSATION RENDERING
  // --------------------------------------------------------------------------
  const scrollMessagesToBottom = () => {
    chatMessagesBody.scrollTop = chatMessagesBody.scrollHeight;
  };

  const createMessageElement = (sender, htmlContent, timestamp = null) => {
    const timeStr = timestamp || new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const msgDiv = document.createElement('div');
    msgDiv.className = `chat-msg ${sender === 'bot' ? 'msg-bot' : 'msg-user'}`;
    
    msgDiv.innerHTML = `
      <div class="msg-bubble">
        <div class="msg-text">${htmlContent}</div>
        <span class="msg-time">${timeStr}</span>
      </div>
    `;
    return msgDiv;
  };

  const showTypingIndicator = () => {
    const typingDiv = document.createElement('div');
    typingDiv.className = 'chat-msg msg-bot msg-typing';
    typingDiv.id = 'chatTypingIndicator';
    typingDiv.innerHTML = `
      <div class="msg-bubble">
        <div class="typing-dots">
          <span></span><span></span><span></span>
        </div>
      </div>
    `;
    chatMessagesBody.appendChild(typingDiv);
    scrollMessagesToBottom();
  };

  const hideTypingIndicator = () => {
    const typing = document.getElementById('chatTypingIndicator');
    if (typing) typing.remove();
  };

  const appendBotReply = (htmlContent, delay = 350) => {
    showTypingIndicator();
    setTimeout(() => {
      hideTypingIndicator();
      const el = createMessageElement('bot', htmlContent);
      chatMessagesBody.appendChild(el);
      scrollMessagesToBottom();
      saveChatHistory();
    }, delay);
  };

  const appendUserMessage = (text) => {
    const escaped = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    const el = createMessageElement('user', `<p>${escaped}</p>`);
    chatMessagesBody.appendChild(el);
    scrollMessagesToBottom();
    saveChatHistory();
  };

  // --------------------------------------------------------------------------
  // QUICK ACTION CHIPS
  // --------------------------------------------------------------------------
  const renderQuickChips = () => {
    chatQuickChips.innerHTML = '';
    const initialChips = [
      { id: 'services', text: '⚡ Services' },
      { id: 'pricing', text: '💰 Pricing Models' },
      { id: 'demos', text: '🚀 Live Demos' },
      { id: 'discovery', text: '📅 Book Discovery Call' },
      { id: 'quote', text: '📝 Request a Quote' },
      { id: 'whatsapp', text: '💬 WhatsApp Us' }
    ];

    initialChips.forEach(chip => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'quick-chip-btn';
      btn.textContent = chip.text;
      btn.addEventListener('click', () => {
        handleChipClick(chip.id, chip.text);
      });
      chatQuickChips.appendChild(btn);
    });
  };

  const handleChipClick = (id, label) => {
    appendUserMessage(label);
    const item = KNOWLEDGE_BASE.find(k => k.id === id);
    if (item) {
      appendBotReply(item.reply);
    } else {
      appendBotReply("<p>Let me look into that for you. How can our engineering team assist?</p>");
    }
  };

  // --------------------------------------------------------------------------
  // NLP / QUERY MATCHING ENGINE
  // --------------------------------------------------------------------------
  const processUserQuery = async (query) => {
    const cleanQuery = query.toLowerCase().trim();

    // Check if user is typing an email/contact lead submission
    const emailMatch = cleanQuery.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/i);
    const phoneMatch = cleanQuery.match(/(\+?[0-9]{10,14})/);

    if (emailMatch || isAwaitingQuoteDetails) {
      await handleLeadSubmission(query, emailMatch ? emailMatch[0] : null, phoneMatch ? phoneMatch[0] : null);
      return;
    }

    // Keyword matching against knowledge base
    let bestMatch = null;
    let highestScore = 0;

    KNOWLEDGE_BASE.forEach(entry => {
      let score = 0;
      entry.keywords.forEach(keyword => {
        if (cleanQuery.includes(keyword)) {
          score += keyword.length > 5 ? 2 : 1;
        }
      });
      if (score > highestScore) {
        highestScore = score;
        bestMatch = entry;
      }
    });

    if (bestMatch && highestScore > 0) {
      appendBotReply(bestMatch.reply);
    } else {
      // Fallback friendly reply with guidance & direct options
      const fallbackReply = `
        <p>Thanks for your question! While I'm specialized in CodeX404's engineering capabilities, our lead engineers can answer your exact scenario right away:</p>
        <ul>
          <li><strong>Discovery Call:</strong> <a href="discovery-call" class="chat-link">Book a 30-min architecture review</a></li>
          <li><strong>Email:</strong> <a href="mailto:info@codex404solutions.com" class="chat-link">info@codex404solutions.com</a></li>
          <li><strong>Inquiry Form:</strong> <a href="contact" class="chat-link">Submit detailed requirements</a></li>
        </ul>
        <p>Would you like to explore our <strong>Services</strong>, <strong>Pricing</strong>, or request a <strong>Project Quote</strong>?</p>
      `;
      appendBotReply(fallbackReply);
    }
  };

  // Lead Submission via AJAX to contact.php
  const handleLeadSubmission = async (fullText, detectedEmail, detectedPhone) => {
    showTypingIndicator();

    const csrfToken = document.getElementById('chatCsrfToken') ? document.getElementById('chatCsrfToken').value : '';
    const email = detectedEmail || 'visitor@codex404.chat';
    const name = 'Chatbot Visitor';

    const formData = new FormData();
    formData.append('csrf_token', csrfToken);
    formData.append('name', name);
    formData.append('email', email);
    if (detectedPhone) formData.append('phone', detectedPhone);
    formData.append('subject', 'Chatbot Instant Inquiry');
    formData.append('message', `Inquiry submitted via Chatbot: ${fullText}`);
    formData.append('privacy_consent', '1');

    try {
      const response = await fetch('contact', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const result = await response.json();
      hideTypingIndicator();

      if (result.status === 'success') {
        appendBotReply(`
          <div class="chat-success-card">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div>
              <strong>Inquiry Received!</strong>
              <p style="margin: 0.35rem 0 0; font-size: 0.85rem;">Thank you! Your requirements have been logged with reference code <code>${result.ref || 'CODEX-LEAD'}</code>. Our Solutions Architect will reach out shortly.</p>
            </div>
          </div>
        `, 200);
      } else {
        appendBotReply(`
          <p>Thank you! We've captured your note: <em>"${fullText}"</em>. You can also email us directly at <a href="mailto:info@codex404solutions.com" class="chat-link">info@codex404solutions.com</a> or book a call via <a href="discovery-call" class="chat-link">Discovery Call</a>.</p>
        `, 200);
      }
    } catch (e) {
      hideTypingIndicator();
      appendBotReply(`
        <p>Thank you! Your note has been registered. You can also reach our engineering lead directly via email at <a href="mailto:info@codex404solutions.com" class="chat-link">info@codex404solutions.com</a> or book a <a href="discovery-call" class="chat-link">Discovery Call</a>.</p>
      `, 200);
    }
  };

  // Form Submit Handler
  chatInputForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const query = chatInputText.value.trim();
    if (!query) return;

    appendUserMessage(query);
    chatInputText.value = '';
    processUserQuery(query);
  });

  // Reset Chat Conversation
  chatResetBtn.addEventListener('click', () => {
    sessionStorage.removeItem(SESSION_KEY_MESSAGES);
    initWelcomeConversation();
  });

  // --------------------------------------------------------------------------
  // HISTORY & PERSISTENCE IN SESSIONSTORAGE
  // --------------------------------------------------------------------------
  const saveChatHistory = () => {
    try {
      const messages = [];
      chatMessagesBody.querySelectorAll('.chat-msg:not(.msg-typing)').forEach(node => {
        const isBot = node.classList.contains('msg-bot');
        const text = node.querySelector('.msg-text') ? node.querySelector('.msg-text').innerHTML : '';
        const time = node.querySelector('.msg-time') ? node.querySelector('.msg-time').textContent : '';
        if (text) {
          messages.push({ sender: isBot ? 'bot' : 'user', text, time });
        }
      });
      sessionStorage.setItem(SESSION_KEY_MESSAGES, JSON.stringify(messages.slice(-25)));
    } catch (err) {
      // Storage unavailable or quota exceeded
    }
  };

  const loadChatHistory = () => {
    try {
      const saved = sessionStorage.getItem(SESSION_KEY_MESSAGES);
      if (saved) {
        const messages = JSON.parse(saved);
        if (Array.isArray(messages) && messages.length > 0) {
          chatMessagesBody.innerHTML = '';
          messages.forEach(m => {
            const el = createMessageElement(m.sender, m.text, m.time);
            chatMessagesBody.appendChild(el);
          });
          scrollMessagesToBottom();
          return true;
        }
      }
    } catch (err) {
      // Fallback to welcome
    }
    return false;
  };

  const initWelcomeConversation = () => {
    chatMessagesBody.innerHTML = '';
    const welcomeHtml = `
      <div class="chat-welcome-card">
        <div class="chat-welcome-badge">🚀 Welcome to CodeX404 Solutions</div>
        <p>I'm your <strong>Engineering & Architecture Assistant</strong>. I can answer questions about our bespoke development, AI pipelines, pricing, and live project deliverables.</p>
        <p style="margin-bottom: 0;">Tap any topic below or ask your own question:</p>
      </div>
    `;
    const el = createMessageElement('bot', welcomeHtml);
    chatMessagesBody.appendChild(el);
    renderQuickChips();
    scrollMessagesToBottom();
  };

  // --------------------------------------------------------------------------
  // INITIALIZATION
  // --------------------------------------------------------------------------
  if (isWidgetHidden()) {
    launcherContainer.style.display = 'none';
    launcherContainer.classList.add('widget-hidden');
    chatRestorePill.hidden = false;
  } else {
    launcherContainer.style.display = 'flex';
    chatRestorePill.hidden = true;
  }

  // Load existing history or initialize fresh welcome conversation
  const hasLoadedHistory = loadChatHistory();
  if (!hasLoadedHistory) {
    initWelcomeConversation();
  } else {
    renderQuickChips();
  }
});
