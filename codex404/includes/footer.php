<footer class="footer">
    <div class="container">

        <p class="footer-text">
            © <?php echo date('Y'); ?>
            <a href="<?= BASE_URL ?>" class="footer-logo-link">
                <img src="<?= BASE_URL ?>logo/logo.png" alt="CodeX404 Logo" class="footer-logo-inline">
            </a>
            . All Rights Reserved.
        </p>

    </div>
</footer>

<!-- JS (AUTO CACHE FIX) -->
<script src="<?= BASE_URL ?>javascript/main.js?v=<?= filemtime(__DIR__ . '/../javascript/main.js'); ?>"></script>
</body>
</html>
