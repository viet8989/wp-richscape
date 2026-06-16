# RICHSCAPE — Fix design-QA bugs from `RICHSCAPE_bugs.pdf`

## Context

The client sent `RICHSCAPE_bugs.pdf` — a design-QA document (Vietnamese) comparing the live
WordPress site against the canonical Canva design. It defines a strict 2-colour palette and a
4-font brand system, then lists per-section deviations on the home page and the About / Services /
Projects pages. The goal of this work is to bring the theme into line with the brand spec:

- **Palette (only these 2 colours for the whole site):**
  - XANH LAM (blue) `#264191`
  - XANH NGỌC (teal) `#02ad83`
- **Brand fonts (by role):**
  - **UTM AVO** → general info & titles (nav, page/section titles, hero tagline, project/service headings)
  - **PWS Cratchedfont** → large section labels (e.g. "LANDSCAPE CREATOR", "DỊCH VỤ")
  - **Utile Semibold** → English text & staff names (no diacritics)
  - **Area Extended** → Vietnamese body text

Plus concrete bug fixes: a literal `<br />` showing in the hero tagline, a CTA button rename,
underline styling, a logo white-edge issue, the Vision/Mission block proportions, and converting
the project gallery from "open image in new tab" to a swipe **lightbox**.

### Decisions / prerequisites
- **GLightbox** (lightweight, no jQuery) for the project-gallery lightbox (bug #9 image idea).
- **UTM AVO is NOT in the repo or the webfontkit** (verified — kit has Area Extended, PWS
  Cratchedfont, Utile Semibold, Manrope, Minion Pro, Arial Bold only). The plan registers a
  `'UTM AVO'` `@font-face` + Tailwind `font-utm` family with a serif fallback so everything degrades
  gracefully, **but the client must drop a UTM AVO webfont** (`woff2`/`woff`) into
  `wp-content/themes/richscape/fonts/` for full fidelity. Until then, UTM-AVO items render in the
  fallback. ⚠️ Prerequisite to mark UTM-AVO bugs fully "done".

---

## Part 1 — Colour system (only 2 colours)

Collapse every brand colour/accent to the 2-colour palette. Map:

| Current hex | → New | Notes |
|---|---|---|
| `#2A9D8F` (teal) | `#02ad83` | brand teal |
| `#1A2251` (darkblue) | `#264191` | brand blue |
| `#5FD9C3` (light-teal accent) | `#02ad83` | service-card number/border/button |
| `#00C7A3` (`--rbs-teal`/dot-active) | `#02ad83` | banner slider |
| `#0A2342` (`--rbs-navy`) | `#264191` | banner slider |
| `#1eaf87` (services title/underline) | `#264191` | per bug #8.2 service titles are **blue** |

Keep `#808080` graytext (neutral body copy, not a brand colour).

Files to update (search-and-replace the hexes above, plus the named Tailwind colours):
- `tailwind.config.js` lines 9–10 — `teal: '#02ad83'`, `darkblue: '#264191'`.
- `style.css` `:root` vars `--rs-teal`, `--rs-darkblue`.
- `assets/css/richscape-banner-slider.css` — `:root` `--rbs-*` (lines 7–16), `.cv-badge` (l.226),
  `.cv-line` rgba, `.about-card-inner` gradient (l.182).
- Inline gradients/hex in PHP: `front-page.php`, `template-parts/section-about-card.php`,
  `template-parts/section-about-card-page.php`, `template-parts/content-service-card.php`,
  `page-about.php`, `page-contact.php`, `page-services.php`, `archive-services.php`,
  `single-projects.php`, `single-services.php`.

Gradients (`#264191 → #02ad83`) stay as gradients — they're built from the 2 palette colours.

---

## Part 2 — Font system (register + apply by role)

### Register fonts — `src/input.css` (`@font-face`) + `tailwind.config.js` (`fontFamily`)
Add/confirm `@font-face` for all brand fonts pointing at `fonts/`:
- `'UTM AVO'` → `fonts/utm-avo-webfont.woff2|woff` (file to be supplied), `font-display: swap`,
  fallback `serif`.
- `'PWS Cratchedfont'` → `fonts/pwscratchedfont-webfont.woff2|woff`.
- `'Utile Semibold'` (exists) and `'Area Extended'` (exists; also wire regular/semibold weights
  available in `fonts/`).

Add Tailwind families: `utm: ['"UTM AVO"','serif']`, `pws: ['"PWS Cratchedfont"','cursive']`
(keep existing `utile`, `display`(=Area Extended)).

### Apply by role
- `font-utm` → `.main-navigation a` (input.css l.52), all page/section titles (DỊCH VỤ, DỰ ÁN,
  Về Chúng Tôi), hero tagline, service-card titles, project titles.
- `font-pws` → large labels: "LANDSCAPE CREATOR", "DỊCH VỤ" section heading, "VỀ CHÚNG TÔI" hero label.
- `font-utile` → staff name + role on About page.
- `font-display` (Area Extended) → Vietnamese body blocks (Vision/Mission text).

---

## Part 3 — Per-section fixes (numbered to the PDF)

**#1 Header colours** — top gradient bar + floating buttons: covered by Part 1 (now `#264191→#02ad83`).

**#2 Nav font** — `.main-navigation a` → `font-utm` (input.css l.51–53).

**#3 Hero card** (`template-parts/section-about-card.php`):
- **Bug: literal `<br />`** — l.17 change `echo nl2br( esc_html( $tagline ) );` →
  `echo wp_kses_post( $tagline );` (admin already saves via `wp_kses_post`, so `<br>` is safe/allowed).
- "VỀ CHÚNG TÔI" label → `font-pws`, palette colour, larger.
- Tagline (3 lines) → `font-utm` bold, white, larger.
- "LANDSCAPE CREATOR" footer → `font-pws`.

**#4 Vision/Mission** (`template-parts/section-vision-mission.php`):
- Headings (Vision/Mission/Core Values) → `font-utile` bold, larger (keep teal `#02ad83` —
  legible on the blue bg, matches Canva).
- Body paragraphs → `font-display` (Area Extended), white.
- Section bg → blue `#264191` (via Part 1).
- **Proportion**: reduce vertical padding/height so the block reads ~**3:1** width:height
  (currently ~2:1) — adjust `py-20` / `.vm-grid` spacing in `richscape-banner-slider.css`.

**#5 Services (home)** (`front-page.php` + `template-parts/content-service-card.php`):
- "DỊCH VỤ" heading → `font-pws`, teal `#02ad83`.
- **CTA rename**: "DỰ ÁN LIÊN QUAN" → **"XEM THÊM"** (front-page mock card ~l.86 AND
  `content-service-card.php` l.66).
- Card border (currently `rgba(95,217,195,.25)`) → blue `#264191`; number badge → palette (Part 1).

**#6 About page hero** (`page-about.php` + `template-parts/section-about-card-page.php`):
- "Về Chúng Tôi" heading → `font-utm` bold teal, larger; **underline** → thin (1–2px),
  **gradient** (blue→teal), width = text width (`inline-block`/`w-fit`), tight to text
  (replace `h-1 bg-teal w-full` at page-about.php l.16).
- **Logo white edge** — logo is cropped in a 60px box with `margin-top:-16px` exposing edges.
  Fix: remove the overflow crop/negative-margin hack, render the full logo at correct size; ensure
  a transparent-background logo asset (flag asset swap if the PNG has a white matte).
- English tagline → `font-utm`; "LANDSCAPE CREATOR" → `font-pws` white.
- Card gradient/border → palette (Part 1).

**#7 About page team member** (`page-about.php` members loop):
- Staff name → `font-utile`, teal (already utile italic; confirm + Part 1 colour).
- "MANAGING DIRECTOR" role → change `font-manrope` → `font-utile`, white.

**#8 Services page** (`page-services.php`, `archive-services.php`, `single-services.php`):
- **Underline runs the full length of the text** — replace fixed `max-w-[280px] h-[2px]`
  (page-services.php l.34) with text-width underline (`inline-block` + `border-b`, or `w-fit`).
- Service titles → `font-utm` bold, blue `#264191`.

**#9 Projects page** (`page-projects.php`, `archive-projects.php`, `single-projects.php`):
- "DỰ ÁN" title + project titles ("POLARIS – RESORT") → `font-utm` bold, blue `#264191`
  (single-projects.php h1 l.87, currently Montserrat 900).
- **Lightbox** (gallery) — see Part 4.

---

## Part 4 — Project gallery lightbox (GLightbox)

`single-projects.php` gallery (l.180–189) currently wraps images in
`<a href target="_blank">` → opens image in a new tab. Convert to a swipe lightbox:
1. Vendor GLightbox CSS+JS into `assets/vendor/glightbox/` (or enqueue from CDN); enqueue in
   `functions.php` only on `is_singular('projects')`.
2. Add `class="glightbox"` + `data-gallery="project-gallery"` to the gallery `<a>` tags; keep
   `href` = full-size image, drop `target="_blank"`.
3. Init `GLightbox({ selector: '.glightbox' })` in a small inline/enqueued script.

---

## Build & deploy
1. `cd wp-content/themes/richscape && npm run build` (recompiles `assets/css/tailwind.css`).
2. Upload changed files (incl. new font + GLightbox vendor files):
   `cd ~/Dropbox/wp-richscape && python3 ~/Dropbox/AutoUploadFTPbyGitStatus/auto_upload_ftp.py --server richscape`
3. Hard-refresh the live site.

## Verification
- **Colours**: grep the theme for old hexes (`#2A9D8F`, `#1A2251`, `#5FD9C3`, `#00C7A3`,
  `#0A2342`, `#1eaf87`) → none remain except intended gradients of the 2 palette colours.
- **Fonts**: DevTools → confirm computed `font-family` on nav, titles, tagline, labels, staff
  name. (UTM-AVO items show fallback until the font file is added.)
- **Hero `<br />`**: tagline wraps on two lines, no literal `<br />` text.
- **CTA**: service cards read "XEM THÊM".
- **About**: heading underline is thin/gradient/text-width; logo has no white edge.
- **Vision/Mission**: block is wider/shorter (~3:1).
- **Services/Projects**: titles are blue UTM-AVO; service underline matches text width.
- **Lightbox**: click a project gallery image → overlay slideshow with prev/next & swipe (no new tab).
- Spot-check on mobile widths.
