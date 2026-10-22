# CodeX404 Solutions — Redesign Deployment Record

Deployment date: 2026-10-21

## Deployed

- `website/index.php` — new homepage
- `website/pricing.php` — new pricing page
- `website/blog.php` — new insights page
- `website/includes/header-v2.php` — versioned redesign shell
- `website/includes/footer-v2.php` — versioned redesign footer
- `website/assets/css/v2-tokens.css` — redesign styles

## Backups

- `website/index.php.bak`
- `website/includes/header.php.bak`
- `website/includes/footer.php.bak`
- `website/assets/css/main.css.bak`
- `website/assets/css/responsive.css.bak`

The legacy header/footer and CSS remain in place for the rest of the site. The redesigned homepage, pricing page, and blog page use the versioned `v2` shell.

## Rollback

To roll back the homepage only:

```text
Copy website/index.php.bak over website/index.php.
```

Then restore the old include references in the homepage from `header-v2.php` / `footer-v2.php` to `header.php` / `footer.php`.

To remove the new pages, delete `website/pricing.php`, `website/blog.php`, `website/includes/header-v2.php`, `website/includes/footer-v2.php`, and `website/assets/css/v2-tokens.css` after confirming no other page references them.
