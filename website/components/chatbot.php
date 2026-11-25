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
<aside class="codex-chatbot-wrapper" id="codexChatbotWrapper" aria-label="Interactive CodeX404 Assistant">

    <!-- 1. Floating Launcher Button (Bottom Right) -->
    <div class="chatbot-launcher-container" id="chatbotLauncherContainer">
        <!-- Floating Prompt Bubble / Tooltip -->
        <div class="chatbot-launcher-tooltip" id="chatbotLauncherTooltip" role="tooltip">
            <span>Need an estimate or architecture review?</span>
            <button type="button" class="tooltip-dismiss" id="chatbotTooltipDismiss" aria-label="Dismiss message">&times;</button>
        </div>

        <button type="button" 
                class="chatbot-launcher-btn" 
                id="chatbotLauncherBtn" 
                aria-haspopup="dialog" 
                aria-expanded="false" 
                aria-controls="codexChatWindow" 
                aria-label="Open CodeX404 AI & Engineering Assistant" 
                title="Chat with CodeX404 Assistant">
            <span class="chatbot-pulse-ring" aria-hidden="true"></span>
            
            <!-- Default Bot Icon -->
            <span class="launcher-icon launcher-icon-open" aria-hidden="true">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    <path d="M8 9h8"></path>
                    <path d="M8 13h5"></path>
                </svg>
            </span>

            <!-- Close (X) Icon when open -->
            <span class="launcher-icon launcher-icon-close" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </span>

            <!-- Active Online Indicator -->
            <span class="chatbot-status-dot" aria-hidden="true"></span>
        </button>

        <!-- Subtle Fast-Hide Button next to launcher -->
        <button type="button" 
                class="chatbot-quick-hide-btn" 
                id="chatbotQuickHideBtn" 
                title="Hide chat widget" 
                aria-label="Hide chat widget from screen">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- 2. Interactive Chat Window -->
    <div class="codex-chat-window" id="codexChatWindow" role="dialog" aria-modal="false" aria-labelledby="chatWindowTitle" hidden>
        
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar-wrap">
                    <div class="chat-avatar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                            <circle cx="12" cy="5" r="2"></circle>
                            <path d="M12 7v4"></path>
                            <line x1="8" y1="16" x2="8" y2="16"></line>
                            <line x1="16" y1="16" x2="16" y2="16"></line>
                        </svg>
                    </div>
                    <span class="avatar-live-indicator" title="Online & ready"></span>
                </div>
                <div>
                    <h3 class="chat-title" id="chatWindowTitle">CodeX404 Assistant</h3>
                    <p class="chat-subtitle">Engineering & Architecture Guide</p>
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

                <!-- Hide Completely Button -->
                <button type="button" 
                        class="chat-header-btn hide-action" 
                        id="chatHideWidgetBtn" 
                        title="Hide floating widget completely" 
                        aria-label="Hide chat widget completely">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
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
                       placeholder="Ask about services, pricing, tech stack..." 
                       maxlength="300"
                       required>
                
                <button type="submit" 
                        class="chat-send-btn" 
                        id="chatSendBtn" 
                        aria-label="Send message" 
                        title="Send message">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
            
            <div class="chat-input-footer">
                <span class="chat-brand-tag">⚡ CodeX404 AI Assistant</span>
                <button type="button" class="chat-reset-link" id="chatResetBtn" title="Start new conversation">Clear Chat</button>
            </div>
        </form>
    </div>

    <!-- 3. Discreet Restore Tab (Shown only when floating launcher is completely hidden) -->
    <button type="button" 
            class="chatbot-restore-pill" 
            id="chatbotRestorePill" 
            title="Restore AI Assistant widget" 
            aria-label="Restore CodeX404 AI Assistant widget" 
            hidden>
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span>AI Chat</span>
    </button>
</aside>
