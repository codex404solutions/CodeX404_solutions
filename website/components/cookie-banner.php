<?php
declare(strict_types=1);
?>
<div class="cookie-banner" id="cookieBanner" role="dialog" aria-label="Cookie consent options">
    <div class="cookie-content">
        <strong>Privacy & Cookie Preferences</strong>
        <p style="margin: 6px 0 0; font-size: 0.825rem; color: var(--slate);">
            We use essential cookies to maintain security and anonymous analytics to understand site performance. No third-party marketing cookies are loaded without your consent. Read our <a href="<?= url('privacy.php') ?>" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a>.
        </p>
    </div>
    <div class="cookie-actions">
        <button type="button" class="btn btn-primary btn-sm" id="acceptCookiesBtn">Accept Cookies</button>
        <button type="button" class="btn btn-secondary btn-sm" id="declineCookiesBtn">Essential Only</button>
    </div>
</div>
