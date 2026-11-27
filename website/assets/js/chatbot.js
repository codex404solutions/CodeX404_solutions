/**
 * CodeX404 Solutions — Help Desk & Customer Assistant
 * Simple, clear answers, interactive message/quote intake, and full route awareness.
 */

document.addEventListener('DOMContentLoaded', () => {
  const wrapper = document.getElementById('codexChatbotWrapper');
  const launcherBtn = document.getElementById('chatbotLauncherBtn');
  const launcherContainer = document.getElementById('chatbotLauncherContainer');
  const chatWindow = document.getElementById('codexChatWindow');
  const chatMinimizeBtn = document.getElementById('chatMinimizeBtn');
  const chatCloseBtn = document.getElementById('chatCloseBtn');
  const chatMessagesBody = document.getElementById('chatMessagesBody');
  const chatQuickChips = document.getElementById('chatQuickChips');
  const chatInputForm = document.getElementById('chatInputForm');
  const chatInputText = document.getElementById('chatInputText');
  const chatResetBtn = document.getElementById('chatResetBtn');

  if (!wrapper || !launcherBtn || !chatWindow || !chatInputForm || !chatInputText) return;

  const baseUrl = (wrapper.dataset.baseUrl || '/').replace(/\/?$/, '/');
  const companyEmail = wrapper.dataset.email || 'info@codex404solutions.com';
  const SESSION_KEY_MESSAGES = 'codex_chat_messages_v2';

  let isOpen = false;
  let intakeState = null; // null | 'awaiting_message_or_email' | 'awaiting_email'
  let leadNoteBuffer = '';

  const pageLink = (slug) => `${baseUrl}${String(slug).replace(/^\/+/, '')}`;
  const escapeHtml = (str) => String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');

  // --------------------------------------------------------------------------
  // PLAIN-ENGLISH KNOWLEDGE BASE
  // --------------------------------------------------------------------------
  const KNOWLEDGE_BASE = [
    {
      id: 'greeting',
      keywords: ['hi', 'hello', 'hey', 'good morning', 'good afternoon', 'good evening', 'namaste', 'assalam', 'hola'],
      reply: () => `
        <p>Hello! Glad you stopped by.</p>
        <p>What are you looking to build or improve right now? Tell me in plain words—like a website, mobile app, marketing/SEO, or AI helper—or tap one of the quick topics below.</p>
      `
    },
    {
      id: 'services',
      keywords: ['service', 'services', 'what do you do', 'offer', 'capabilities', 'solution', 'solutions', 'help me'],
      reply: () => `
        <p>We help businesses in three clear areas:</p>
        <ul>
          <li><strong>Build:</strong> Websites, business portals, online stores, and mobile apps made from scratch.</li>
          <li><strong>Grow:</strong> Better Google search rankings (SEO), online ads, and higher website sales.</li>
          <li><strong>Automate:</strong> AI chat helpers, auto-replies, and tools that cut out repetitive manual work.</li>
        </ul>
        <p><a href="${pageLink('solutions')}" class="chat-link">See all services &rarr;</a> &nbsp;|&nbsp; <a href="${pageLink('contact')}" class="chat-link">Start a project &rarr;</a></p>
      `
    },
    {
      id: 'build_software',
      keywords: ['website', 'web app', 'software', 'saas', 'mobile app', 'android', 'ios', 'crm', 'erp', 'portal', 'ecommerce', 'store', 'custom'],
      reply: () => `
        <p>Yes—we design and build custom websites, customer/admin portals, booking systems, e-commerce sites, and mobile apps tailored to how your business actually runs.</p>
        <p>Small business sites usually take <strong>2–4 weeks</strong>, while full custom systems take <strong>6–10 weeks</strong> with weekly progress previews.</p>
        <p><a href="${pageLink('build')}" class="chat-link">See software services &rarr;</a> &nbsp;|&nbsp; <a href="${pageLink('contact?topic=project&division=BUILD')}" class="chat-link">Ask about a build &rarr;</a></p>
      `
    },
    {
      id: 'grow_marketing',
      keywords: ['seo', 'google', 'marketing', 'ads', 'digital', 'traffic', 'rank', 'leads', 'conversion', 'social'],
      reply: () => `
        <p>Our <strong>Grow</strong> team helps your website show up higher on Google, run focused ad campaigns, and turn more visitors into real calls and inquiries.</p>
        <p><a href="${pageLink('grow')}" class="chat-link">See growth services &rarr;</a> &nbsp;|&nbsp; <a href="${pageLink('contact?topic=service&division=GROW')}" class="chat-link">Ask about SEO &amp; ads &rarr;</a></p>
      `
    },
    {
      id: 'ai_automation',
      keywords: ['ai', 'chatbot', 'agent', 'agents', 'automate', 'automation', 'whatsapp', 'workflow', 'rag', 'bot'],
      reply: () => `
        <p>Our <strong>Automate</strong> team builds practical AI tools—like customer support bots trained on your documents, WhatsApp notifications, and automatic CRM/email updates—so your staff saves hours every week.</p>
        <p><a href="${pageLink('automate')}" class="chat-link">See automation tools &rarr;</a> &nbsp;|&nbsp; <a href="${pageLink('contact?topic=service&division=AUTOMATE')}" class="chat-link">Ask about AI &rarr;</a></p>
      `
    },
    {
      id: 'pricing',
      keywords: ['price', 'pricing', 'cost', 'how much', 'rate', 'rates', 'fee', 'fees', 'budget', 'package', 'packages', 'cheap', 'expensive'],
      reply: () => `
        <p>We charge per agreed step (<strong>fixed milestones</strong>), so you always know the exact cost before work starts—with no surprise bills.</p>
        <ul>
          <li><strong>Smaller sites &amp; automations:</strong> Under $5,000</li>
          <li><strong>Custom portals, apps &amp; growth plans:</strong> $5,000–$15,000+</li>
        </ul>
        <p><a href="${pageLink('pricing')}" class="chat-link">View pricing guide &rarr;</a> &nbsp;|&nbsp; <a href="${pageLink('contact?topic=project')}" class="chat-link">Get an estimate &rarr;</a></p>
      `
    },
    {
      id: 'demos',
      keywords: ['portfolio', 'demo', 'demos', 'examples', 'case study', 'case studies', 'sample', 'work', 'projects', 'built'],
      reply: () => `
        <p>You can inspect real websites and live interactive demos we built for clinics, schools, retail businesses, and booking teams.</p>
        <p><a href="${pageLink('our-work')}" class="chat-link">Browse past work &rarr;</a> &nbsp;|&nbsp; <a href="${pageLink('case-studies')}" class="chat-link">Read case studies &rarr;</a></p>
      `
    },
    {
      id: 'timeline',
      keywords: ['timeline', 'turnaround', 'how long', 'how fast', 'deadline', 'delivery', 'weeks', 'days', 'process', 'steps'],
      reply: () => `
        <p>We work in simple 2-week steps where you test real progress on a live preview link—never disappearing for months:</p>
        <ul>
          <li><strong>Focused website or automation:</strong> 2–4 weeks</li>
          <li><strong>Full custom web/mobile system:</strong> 6–10 weeks</li>
        </ul>
        <p><a href="${pageLink('process')}" class="chat-link">See how we work &rarr;</a></p>
      `
    },
    {
      id: 'discovery',
      keywords: ['discovery', 'book', 'call', 'meeting', 'schedule', 'talk', 'consultation', 'discuss', 'zoom'],
      reply: () => `
        <p>You can book a free 30-minute call straight with an engineer—no pushy sales script. We will listen to your goal and share honest next steps.</p>
        <p><a href="${pageLink('discovery-call')}" class="btn btn-primary btn-sm chat-btn-action">Book a free call &rarr;</a></p>
      `
    },
    {
      id: 'partnership',
      keywords: ['partner', 'partnership', 'agency', 'white label', 'referral', 'collaborate', 'resell'],
      reply: () => `
        <p>We partner with agencies and consultants for white-label web/software delivery, referral channels, and technical integrations.</p>
        <p><a href="${pageLink('contact?topic=partnership')}" class="chat-link">Open partnership form &rarr;</a></p>
      `
    },
    {
      id: 'careers',
      keywords: ['job', 'jobs', 'career', 'careers', 'intern', 'internship', 'hiring', 'apply', 'vacancy', 'role', 'roles'],
      reply: () => `
        <p>Looking to join CodeX404? Check our open roles and internships or track an application you already submitted:</p>
        <p><a href="${pageLink('careers')}" class="chat-link">View open roles &rarr;</a> &nbsp;|&nbsp; <a href="${pageLink('careers/candidate-portal')}" class="chat-link">Applicant portal &rarr;</a></p>
      `
    },
    {
      id: 'security',
      keywords: ['security', 'safe', 'privacy', 'nda', 'confidential', 'data', 'trust'],
      reply: () => `
        <p>Your idea and data stay strictly yours. We sign NDAs upfront and store all logins and inquiries securely with encryption.</p>
        <p><a href="${pageLink('security')}" class="chat-link">Security overview &rarr;</a></p>
      `
    },
    {
      id: 'contact_eng',
      keywords: ['human', 'person', 'support', 'phone', 'email', 'location', 'where', 'hours', 'timing', 'reach'],
      reply: () => `
        <p>You can reach our team directly anytime (India/APAC, GCC, UK/EU &amp; US overlap):</p>
        <p><strong>Email:</strong> <a href="mailto:${escapeHtml(companyEmail)}" class="chat-link">${escapeHtml(companyEmail)}</a></p>
        <p><a href="${pageLink('contact?topic=general')}" class="chat-link">Send a contact note &rarr;</a></p>
      `
    }
  ];

  // --------------------------------------------------------------------------
  // UI OPEN / CLOSE / HELPERS
  // --------------------------------------------------------------------------
  const scrollMessagesToBottom = () => {
    chatMessagesBody.scrollTop = chatMessagesBody.scrollHeight;
  };

  const openChatWindow = () => {
    isOpen = true;
    chatWindow.hidden = false;
    chatWindow.classList.add('open');
    launcherBtn.setAttribute('aria-expanded', 'true');
    launcherBtn.classList.add('active');
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
    }, 260);
  };

  launcherBtn.addEventListener('click', (e) => {
    e.preventDefault();
    isOpen ? closeChatWindow() : openChatWindow();
  });
  if (chatMinimizeBtn) chatMinimizeBtn.addEventListener('click', (e) => { e.preventDefault(); closeChatWindow(); });
  if (chatCloseBtn) chatCloseBtn.addEventListener('click', (e) => { e.preventDefault(); closeChatWindow(); });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen) closeChatWindow();
  });

  // --------------------------------------------------------------------------
  // MESSAGE RENDERING & HISTORY
  // --------------------------------------------------------------------------
  const createMessageElement = (sender, htmlContent, timestamp = null) => {
    const timeStr = timestamp || new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const msgDiv = document.createElement('div');
    msgDiv.className = `chat-msg ${sender === 'bot' ? 'msg-bot' : 'msg-user'}`;
    msgDiv.innerHTML = `
      <div class="msg-bubble">
        <div class="msg-text">${htmlContent}</div>
        <span class="msg-time">${escapeHtml(timeStr)}</span>
      </div>
    `;
    return msgDiv;
  };

  const showTypingIndicator = () => {
    hideTypingIndicator();
    const typingDiv = document.createElement('div');
    typingDiv.className = 'chat-msg msg-bot msg-typing';
    typingDiv.id = 'chatTypingIndicator';
    typingDiv.innerHTML = `
      <div class="msg-bubble">
        <div class="typing-dots"><span></span><span></span><span></span></div>
      </div>
    `;
    chatMessagesBody.appendChild(typingDiv);
    scrollMessagesToBottom();
  };

  const hideTypingIndicator = () => {
    const typing = document.getElementById('chatTypingIndicator');
    if (typing) typing.remove();
  };

  const saveChatHistory = () => {
    try {
      const messages = [];
      chatMessagesBody.querySelectorAll('.chat-msg:not(.msg-typing)').forEach(node => {
        const isBot = node.classList.contains('msg-bot');
        const text = node.querySelector('.msg-text') ? node.querySelector('.msg-text').innerHTML : '';
        const time = node.querySelector('.msg-time') ? node.querySelector('.msg-time').textContent : '';
        if (text) messages.push({ sender: isBot ? 'bot' : 'user', text, time });
      });
      sessionStorage.setItem(SESSION_KEY_MESSAGES, JSON.stringify(messages.slice(-25)));
    } catch (err) {}
  };

  const appendBotReply = (htmlContent, delay = 220) => {
    showTypingIndicator();
    setTimeout(() => {
      hideTypingIndicator();
      const el = createMessageElement('bot', htmlContent);
      chatMessagesBody.appendChild(el);
      scrollMessagesToBottom();
      saveChatHistory();
    }, delay);
  };

  const appendBotImmediate = (htmlContent) => {
    hideTypingIndicator();
    const el = createMessageElement('bot', htmlContent);
    chatMessagesBody.appendChild(el);
    scrollMessagesToBottom();
    saveChatHistory();
  };

  const appendUserMessage = (text) => {
    const el = createMessageElement('user', `<p>${escapeHtml(text)}</p>`);
    chatMessagesBody.appendChild(el);
    scrollMessagesToBottom();
    saveChatHistory();
  };

  // --------------------------------------------------------------------------
  // QUICK CHIPS (Simple plain-English labels, zero emojis)
  // --------------------------------------------------------------------------
  const renderQuickChips = () => {
    if (!chatQuickChips) return;
    chatQuickChips.innerHTML = '';
    const chips = [
      { id: 'services', label: 'What we do' },
      { id: 'pricing', label: 'Pricing' },
      { id: 'demos', label: 'Past work' },
      { id: 'discovery', label: 'Book a call' },
      { id: 'quote', label: 'Send a message' }
    ];

    chips.forEach(chip => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'quick-chip-btn';
      btn.textContent = chip.label;
      btn.addEventListener('click', () => handleChipClick(chip.id, chip.label));
      chatQuickChips.appendChild(btn);
    });
  };

  const handleChipClick = (id, label) => {
    appendUserMessage(label);
    if (id === 'quote') {
      intakeState = 'awaiting_message_or_email';
      leadNoteBuffer = '';
      appendBotReply(`
        <p>Sure! Just type <strong>what you need</strong> and your <strong>email address</strong> (for example: <em>"Need a company website, me@company.com"</em>).</p>
        <p>Or use our <a href="${pageLink('contact')}" class="chat-link">full Contact page &rarr;</a></p>
      `);
      return;
    }

    intakeState = null;
    const item = KNOWLEDGE_BASE.find(k => k.id === id);
    if (item) {
      appendBotReply(item.reply());
    }
  };

  // --------------------------------------------------------------------------
  // REAL MESSAGE / LEAD SUBMISSION -> contact_messages DB
  // --------------------------------------------------------------------------
  const handleLeadSubmission = async (fullText, detectedEmail, detectedPhone) => {
    showTypingIndicator();

    const csrfToken = document.getElementById('chatCsrfToken') ? document.getElementById('chatCsrfToken').value : '';
    const formData = new FormData();
    formData.append('csrf_token', csrfToken);
    formData.append('inquiry_category', 'general');
    formData.append('inquiry_area', 'general_info');
    formData.append('name', 'Website Visitor');
    formData.append('email', detectedEmail);
    if (detectedPhone) formData.append('phone', detectedPhone);
    formData.append('subject', 'Live Chat Message');
    formData.append('message', fullText);
    formData.append('privacy_consent', '1');

    try {
      const response = await fetch(pageLink('contact'), {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const result = await response.json();

      if (result && result.status === 'success') {
        intakeState = null;
        leadNoteBuffer = '';
        appendBotImmediate(`
          <div class="chat-success-card">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" style="flex-shrink:0; margin-top:2px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div>
              <strong>Message sent!</strong>
              <p style="margin: 4px 0 0; font-size: 0.82rem;">We saved your note (Ref: <code>${escapeHtml(result.ref || 'SAVED')}</code>) and will reply to <strong>${escapeHtml(detectedEmail)}</strong> soon.</p>
            </div>
          </div>
        `);
      } else {
        appendBotImmediate(`
          <p>We could not send that automatically (${escapeHtml(result?.message || 'please check your email format')}). You can email us directly at <a href="mailto:${escapeHtml(companyEmail)}" class="chat-link">${escapeHtml(companyEmail)}</a> or use the <a href="${pageLink('contact')}" class="chat-link">Contact form</a>.</p>
        `);
      }
    } catch (e) {
      appendBotImmediate(`
        <p>Connection hiccup—please reach us at <a href="mailto:${escapeHtml(companyEmail)}" class="chat-link">${escapeHtml(companyEmail)}</a> or <a href="${pageLink('contact')}" class="chat-link">Contact page</a>.</p>
      `);
    }
  };

  // --------------------------------------------------------------------------
  // SIMPLE INTENT ENGINE + 2-STEP MESSAGE INTAKE
  // --------------------------------------------------------------------------
  const processUserQuery = async (query) => {
    const cleanQuery = query.toLowerCase().trim();
    const emailMatch = query.match(/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/);
    const phoneMatch = query.match(/(\+?[0-9][0-9\s\-]{7,16})/);

    if (emailMatch) {
      const combinedText = leadNoteBuffer ? `${leadNoteBuffer} — Contact: ${query}` : query;
      const safeMsg = combinedText.length >= 10 ? combinedText : `Chat inquiry from visitor (${query})`;
      await handleLeadSubmission(safeMsg, emailMatch[0], phoneMatch ? phoneMatch[0].trim() : null);
      return;
    }

    if (intakeState === 'awaiting_message_or_email') {
      leadNoteBuffer = query;
      intakeState = 'awaiting_email';
      appendBotReply(`
        <p>Got it! What <strong>email address</strong> should our team reply to?</p>
      `);
      return;
    }

    if (intakeState === 'awaiting_email') {
      appendBotReply(`
        <p>Please include a valid email address (for example: <em>name@company.com</em>) so we can reply to your note, or open our <a href="${pageLink('contact')}" class="chat-link">Contact form</a>.</p>
      `);
      return;
    }

    // Score knowledge base entries using whole-word / phrase matching
    let bestMatch = null;
    let highestScore = 0;

    KNOWLEDGE_BASE.forEach(entry => {
      let score = 0;
      entry.keywords.forEach(keyword => {
        if (keyword.includes(' ')) {
          if (cleanQuery.includes(keyword)) score += 3;
        } else {
          const rx = new RegExp(`\\b${keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}\\b`, 'i');
          if (rx.test(cleanQuery)) score += 2;
        }
      });
      if (score > highestScore) {
        highestScore = score;
        bestMatch = entry;
      }
    });

    if (bestMatch && highestScore > 0) {
      appendBotReply(bestMatch.reply());
      return;
    }

    // Friendly, non-jargon fallback that also offers to pass the message along
    leadNoteBuffer = query;
    intakeState = 'awaiting_email';
    appendBotReply(`
      <p>Good question! I can pass <em>"${escapeHtml(query)}"</em> straight to our team—just type your <strong>email address</strong> below so they can reply to you.</p>
      <p>Or choose what you need: <a href="${pageLink('solutions')}" class="chat-link">Services</a> &middot; <a href="${pageLink('pricing')}" class="chat-link">Pricing</a> &middot; <a href="${pageLink('discovery-call')}" class="chat-link">Book a call</a></p>
    `);
  };

  chatInputForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const query = chatInputText.value.trim();
    if (!query) return;

    appendUserMessage(query);
    chatInputText.value = '';
    processUserQuery(query);
  });

  if (chatResetBtn) {
    chatResetBtn.addEventListener('click', () => {
      sessionStorage.removeItem(SESSION_KEY_MESSAGES);
      intakeState = null;
      leadNoteBuffer = '';
      initWelcomeConversation();
    });
  }

  const loadChatHistory = () => {
    try {
      const saved = sessionStorage.getItem(SESSION_KEY_MESSAGES);
      if (saved) {
        const messages = JSON.parse(saved);
        if (Array.isArray(messages) && messages.length > 0) {
          chatMessagesBody.innerHTML = '';
          messages.forEach(m => chatMessagesBody.appendChild(createMessageElement(m.sender, m.text, m.time)));
          scrollMessagesToBottom();
          return true;
        }
      }
    } catch (err) {}
    return false;
  };

  const initWelcomeConversation = () => {
    chatMessagesBody.innerHTML = '';
    const welcomeHtml = `
      <div class="chat-welcome-card">
        <div class="chat-welcome-badge">Online Support</div>
        <p>Hi! I can explain what CodeX404 builds, how pricing works, show real examples, or send your question straight to our team.</p>
        <p style="margin-bottom: 0;">Pick a quick topic below or type in plain words:</p>
      </div>
    `;
    chatMessagesBody.appendChild(createMessageElement('bot', welcomeHtml));
    renderQuickChips();
    scrollMessagesToBottom();
  };

  if (launcherContainer) {
    launcherContainer.style.display = 'flex';
    launcherContainer.classList.remove('widget-hidden');
  }

  if (!loadChatHistory()) {
    initWelcomeConversation();
  } else {
    renderQuickChips();
  }
});
