# CodeX404 Solutions — Design System and UX Specification

**Design reference:** User-provided CodeX404 logo and homepage screenshot  
**Brand architecture:** BUILD · GROW · AUTOMATE  
**Design direction:** Premium futuristic engineering studio  
**Status:** Preserve existing implementation values after audit; values below are semantic guidance, not a mandate to overwrite current CSS.

---

## 1. Design objective

Redesign the information architecture and page content while retaining the existing CodeX404 visual identity.

The website should feel like one premium technology company with three service divisions—not three unrelated microsites and not a generic marketing template.

## 2. Existing visual identity to preserve

From the supplied homepage reference:
- Deep navy/black background.
- Subtle grid and connected-node/particle background.
- White, high-contrast typography.
- Blue and cyan highlights.
- Purple and magenta gradient accents.
- Rounded cards with fine borders.
- Soft glow around important CTAs.
- Terminal-style technical panel.
- Modern engineering aesthetic.
- Existing CodeX404 logo.

The existing hero composition is approved by the user. Preserve its layout and overall visual character. Change copy and content only where needed unless an accessibility or responsive defect requires a controlled adjustment.

## 3. Division accents

Use the logo's division cues:

| Division | Accent | Purpose |
|---|---|---|
| BUILD | Blue | Engineering, development, product creation |
| GROW | Purple | Marketing, discovery, visibility and growth |
| AUTOMATE | Green | AI, integrations, workflows and efficiency |

Shared components may continue using the established cyan/blue/purple/magenta gradient.

Do not use division accents as full-page backgrounds. Use them for icons, labels, card details, small lines, badges and selected CTAs.

## 4. Design tokens

First inspect the existing CSS variables, Tailwind configuration, theme provider or equivalent.

Do not overwrite existing values without comparison.

Suggested semantic tokens if a gap exists:
- `--color-bg-primary`: deep navy/black.
- `--color-bg-secondary`: slightly lighter navy.
- `--color-surface`: elevated dark surface.
- `--color-text-primary`: near-white.
- `--color-text-secondary`: muted cool grey.
- `--color-border`: subtle blue-grey.
- `--color-accent-cyan`: cyan.
- `--color-accent-blue`: blue.
- `--color-accent-purple`: purple.
- `--color-accent-magenta`: magenta.
- `--color-build`: blue.
- `--color-grow`: purple.
- `--color-automate`: green.

Use a consistent spacing scale, typography scale, radius scale and shadow system.

## 5. Typography

- Preserve the existing font if it is readable and performant.
- Use clear hierarchy: hero, section title, card title, body and caption.
- Keep body text comfortable on mobile.
- Avoid long all-caps paragraphs.
- Use monospace only for terminal/technical UI, not ordinary long-form body text.
- Ensure text remains readable over particles and gradients.

## 6. Background and effects

- Keep the grid/network visual subtle.
- Ensure decorative particles do not compete with text.
- Effects must not block pointer interaction.
- Avoid excessive blur and animation.
- Use CSS or existing lightweight implementation where practical.
- Respect `prefers-reduced-motion`.
- Avoid continuous animations that cause high CPU or battery use.
- Provide a fallback background if animation fails.

## 7. Header and navigation

Desktop:
- Existing logo at left.
- Clear navigation.
- Division navigation grouped logically.
- Contact/project CTA visible.
- Dropdowns keyboard accessible.

Mobile:
- No horizontal overflow.
- Clear menu control and accessible expanded state.
- Menu does not permanently cover hero CTA.
- Touch targets comfortably sized.
- Focus management for open/closed navigation.

## 8. Homepage composition

Recommended sequence:
1. Header.
2. Hero preserving current composition.
3. Technology/capability strip.
4. BUILD, GROW, AUTOMATE cards.
5. Business problem/solution section.
6. Featured work.
7. Why CodeX404.
8. Industries.
9. Delivery process.
10. Technology and capabilities.
11. Leadership.
12. Verified testimonials, if available.
13. FAQs.
14. Final CTA.
15. Footer.

The first viewport must communicate the company's overall offer and provide an obvious next action.

## 9. Division page design

Each division page should have:
- Division-specific accent.
- Clear headline and summary.
- Service cards.
- Business challenges.
- Process.
- Related project examples.
- FAQs.
- CTA.

Keep the shared page structure consistent, but tailor visuals and content to the division.

## 10. Service card design

A service card should contain:
- Service name.
- Plain-language outcome.
- Short explanation.
- 2–4 capability examples.
- Link to detailed page.

Avoid overcrowding cards with long bullet lists.

## 11. Portfolio design

- Use genuine project screenshots.
- Keep aspect ratios consistent.
- Provide accessible image descriptions.
- Label project type.
- Add division and industry filters only if usable.
- Do not make filter controls inaccessible.
- Avoid fake metrics and decorative client logos without permission.

## 12. Forms

- Clear labels.
- Visible required/optional state.
- Inline validation.
- Helpful error messages.
- Keyboard navigation.
- Clear consent language.
- Success state after server confirmation.
- No decorative input fields without functionality.

## 13. Responsive breakpoints

Test at:
- 320px
- 375px
- 425px
- 768px
- 1024px
- 1440px
- 1920px

Use the existing breakpoint system if one exists. Do not add arbitrary breakpoints without need.

## 14. Accessibility

- Semantic landmarks.
- Correct heading order.
- Keyboard access.
- Visible focus.
- Contrast checks.
- Alt text.
- Accessible labels.
- Reduced-motion support.
- Avoid color-only status.
- Dialog and menu focus handling.
- Form errors announced appropriately.

## 15. Design QA

Check:
- Hero clipping.
- CTA overlap.
- Chat widget overlap.
- Header height.
- Horizontal overflow.
- Text contrast.
- Card alignment.
- Image cropping.
- Mobile menu.
- Footer stacking.
- Motion performance.
- Reduced-motion behavior.

## 16. Design acceptance criteria

The redesign is successful when:
- The screenshot's visual identity remains recognisable.
- BUILD, GROW and AUTOMATE have clear visual differentiation.
- All pages feel part of one brand.
- The homepage hero remains strong.
- Mobile content is readable and usable.
- No visual effects obstruct functionality.
- Accessibility and performance are not sacrificed for decoration.
