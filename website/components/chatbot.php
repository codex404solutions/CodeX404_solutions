<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/security.php';

$csrfToken = generate_csrf_token();
?>
<!-- ==========================================================================
     CODEX404 INTERACTIVE AI & ENGINEERING CHATBOT
     - Replaces floating WhatsApp overlay with full conversational assistant
     - Includes direct WhatsApp escalation button inside chat
     - Allows users to minimize, close, or completely hide the floating widget at will
     - Persists user hide/show preference across navigation via localStorage
     ========================================================================== -->
<aside class="codex-chatbot-wrapper" id="codexChatbotWrapper"
    data-base-url="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>"
    data-email="<?= htmlspecialchars(COMPANY_EMAIL, ENT_QUOTES, 'UTF-8') ?>"
    aria-label="CodeX404 Help Desk">

    <!-- 1. Single Sleek AI Chat Launcher Pill (Bottom Right) -->
    <div class="chatbot-launcher-container" id="chatbotLauncherContainer">
        <button type="button" 
                class="chatbot-launcher-btn" 
                id="chatbotLauncherBtn" 
                aria-haspopup="dialog" 
                aria-expanded="false" 
                aria-controls="codexChatWindow" 
                aria-label="Open CodeX404 AI Chat" 
                title="Open AI Chat">
            <span class="launcher-icon launcher-icon-open" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </span>

            <span class="launcher-icon launcher-icon-close" aria-hidden="true">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </span>

            <span class="launcher-pill-label">AI Chat</span>
        </button>
    </div>

    <!-- 2. Interactive Chat Window -->
    <div class="codex-chat-window" id="codexChatWindow" role="dialog" aria-modal="false" aria-labelledby="chatWindowTitle" hidden>
        
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar-wrap">
                    <div class="chat-avatar">
                        <img src="<?= asset('images/logo/favicon-32x32.png') ?>" alt="CodeX404" width="22" height="22">
                    </div>
                    <span class="avatar-live-indicator" title="Online & ready"></span>
                </div>
                <div>
                    <h3 class="chat-title" id="chatWindowTitle">CodeX404 Help Desk</h3>
                    <p class="chat-subtitle">Ask us anything &middot; Online</p>
                </div>
            </div>

            <div class="chat-header-actions">
                <!-- Email Escalation button -->
                <a href="mailto:<?= COMPANY_EMAIL ?>" 
                   class="chat-header-btn email-action" 
                   title="Send email directly to engineers" 
                   aria-label="Email engineering team directly">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </a>

                <!-- Minimize Button -->
                <button type="button" 
                        class="chat-header-btn" 
                        id="chatMinimizeBtn" 
                        title="Minimize chat" 
                        aria-label="Minimize chat window">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>

                <!-- Close Button -->
                <button type="button" 
                        class="chat-header-btn" 
                        id="chatCloseBtn" 
                        title="Close chat window" 
                        aria-label="Close chat window">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Notification Banner (shown when widget is hidden or reset) -->
        <div class="chat-hide-alert" id="chatHideAlert" hidden>
            <span>Widget hidden. Click "AI Chatbot" in the footer anytime to restore.</span>
            <button type="button" id="chatDismissAlertBtn" class="alert-dismiss-btn">&times;</button>
        </div>

        <!-- Chat Conversation Messages Area -->
        <div class="chat-messages-body" id="chatMessagesBody" tabindex="0" role="log" aria-live="polite">
            <!-- Messages rendered dynamically via chatbot.js -->
        </div>

        <!-- Chat Suggested Quick Action Chips -->
        <div class="chat-quick-chips" id="chatQuickChips" aria-label="Suggested questions">
            <!-- Populated via chatbot.js -->
        </div>

        <!-- Chat Input Form -->
        <form class="chat-input-form" id="chatInputForm" autocomplete="off">
            <input type="hidden" name="csrf_token" id="chatCsrfToken" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            
            <div class="chat-input-wrapper">
                <label for="chatInputText" class="sr-only">Type your question or message</label>
                <input type="text"
                       id="chatInputText"
                       class="chat-input-text"
                       placeholder="Ask a simple question or share your idea..."
                       maxlength="400"
                       required>

                <button type="submit"
                        class="chat-send-btn"
                        id="chatSendBtn"
                        aria-label="Send message"
                        title="Send">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>

            <div class="chat-input-footer">
                <span class="chat-brand-tag">Direct team support</span>
                <button type="button" class="chat-reset-link" id="chatResetBtn" title="Start new conversation">Start over</button>
            </div>
        </form>
    </div>
</aside>
