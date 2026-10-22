</main>
<footer class="footer">
  <div class="container footer-grid">
    <div>© <?= date('Y') ?> CodeX404 Solutions. Built for businesses that want durable digital assets.</div>
    <div><a href="https://www.linkedin.com/company/codex404solutions">LinkedIn</a><a href="https://x.com/codex404sol">X</a><a href="https://codex404solutions.online/">Current site</a></div>
  </div>
</footer>
<script>
(() => {
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('#site-nav');
  if (!toggle || !nav) return;
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', String(open));
  });
})();
</script>
</body>
</html>
