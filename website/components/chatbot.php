<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/security.php';

$whatsappUrl = defined('COMPANY_WHATSAPP_URL') 
    ? COMPANY_WHATSAPP_URL 
    : 'https://wa.me/917717747620?text=Hi%20CodeX404%20Solutions%2C%20I%20would%20like%20to%20discuss%20a%20software%2Fengineering%20project.';
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
            <span>👋 Need an estimate or have questions?</span>
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
                <!-- Direct WhatsApp Escalation button -->
                <a href="<?= htmlspecialchars($whatsappUrl, ENT_QUOTES, 'UTF-8') ?>" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="chat-header-btn whatsapp-action" 
                   title="Open direct WhatsApp conversation" 
                   aria-label="Chat on WhatsApp with an engineer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
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
