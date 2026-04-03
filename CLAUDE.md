# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a custom WordPress theme (`richscape`) for a Vietnamese landscape design company (RICHSCAPE). Only the theme directory is tracked in this repository — WordPress core is managed separately.

**Repository path:** `wp-content/themes/richscape/`

**Design reference:** https://testky.my.canva.site/richscape-web/ — this Canva site is the canonical design source. The WordPress theme is a faithful implementation of it.

**Live site:** https://deepskyblue-alpaca-301704.hostingersite.com/ — hosted on Hostinger. Deployment is via FTP (not local). There is no local WordPress installation; changes are deployed by uploading theme files over FTP.

## Development Setup

All build commands run from inside the theme directory:

```bash
cd wp-content/themes/richscape
npm install        # first time only
npm run dev        # watch mode — recompiles on PHP file changes
npm run build      # production build (minified)
```

Tailwind CSS source is in `src/input.css`. The compiled output goes to `assets/css/tailwind.css` (gitignored — must be built before deploying). `tailwind.config.js` in the theme root holds custom colors and fonts.

The theme registers two custom post types and auto-imports demo data on first `admin_init`. After editing, build the CSS (`npm run build`) and upload changed files to the server via FTP.

## Theme Architecture

### Custom Post Types
- **Services** (`services`) — landscape services offered
- **Projects** (`projects`) — completed project showcase

Both CPTs are registered in `functions.php` and displayed on `front-page.php`.

### Template Structure
- `front-page.php` — main landing page, the only real template; queries both CPTs with fallback mock data if no posts exist
- `header.php` — fixed header, mobile hamburger menu JS
- `footer.php` — company info, floating Zalo/Messenger buttons, back-to-top
- `inc/import-data.php` — runs on `admin_init`, creates 4 demo Services and 4 demo Projects + nav menu; guarded by `richscape_demo_imported` option to prevent re-import
- `template-parts/content-service-card.php` and `template-parts/project-item.php` — currently empty placeholders

### Styling
- Tailwind CSS compiled via CLI (`npm run build`); config in `tailwind.config.js`, source in `src/input.css`, output to `assets/css/tailwind.css`
- Custom Tailwind colors: `teal` (`#2A9D8F`), `darkblue` (`#1A2251`), `graytext` (`#808080`)
- Custom fonts registered in Tailwind config: `font-sans` → Montserrat, `font-serif` → Playfair Display, `font-body` → Open Sans — loaded from Google Fonts in `header.php`
- Base styles and nav menu styles live in `src/input.css`

### Language
All user-facing content is in Vietnamese. Keep this consistent when adding new content.

## Page Layout & Design Reference

The Canva design is a single scrollable landing page with these sections in order:

### 1. Header (fixed)
- Thin gradient top bar: dark blue (`#1A2251`) → teal (`#2A9D8F`)
- White bar below: logo left, nav center, teal search icon right
- Nav items: TRANG CHỦ, VỀ CHÚNG TÔI, DỊCH VỤ, DỰ ÁN TIÊU BIỂU, THÔNG TIN - BẢN TIN, LIÊN HỆ

### 2. Hero Section
- Full-width image slider (with prev/next arrows, dot indicators at bottom-right)
- Gradient overlay card bottom-left (dark blue → teal): teal "VỀ CHÚNG TÔI" label, English tagline ("As Landscape Creators, We Bring Your Green Visions To Life."), Vietnamese company intro paragraph, "LANDSCAPE CREATOR" footer text

### 3. Vision, Mission & Core Values (dark blue `#1A2251` background)
- Left column: **Vision** and **Mission** text blocks (italic teal headings)
- Right column: **Core Values** — 5 numbered items in a 3+2 grid:
  1. ĐỔI MỚI SÁNG TẠO
  2. CHẤT LƯỢNG
  3. TÔN TRỌNG THIÊN NHIÊN
  4. KHÁCH HÀNG LÀ TRUNG TÂM
  5. ĐÓNG GÓP CỘNG ĐỒNG

### 4. Services Section ("DỊCH VỤ")
- Section title left-aligned with teal underline
- 4 cards in a horizontal row, each card has: gradient dark blue/teal background, numbered badge (1–4), service icon, multi-line title, description, photo image, "DỰ ÁN LIÊN QUAN" CTA button at bottom
- Cards (in order):
  1. THIẾT KẾ THI CÔNG CẢNH QUAN
  2. CHIẾU SÁNG & TƯỚI TỰ ĐỘNG
  3. ĐÀI PHUN NƯỚC / HỒ BƠI / HỒ CẢNH
  4. CHĂM SÓC BẢO TRÌ CẢNH QUAN

### 5. Featured Projects ("DỰ ÁN TIÊU BIỂU")
- Section title left-aligned (teal), "XEM TẤT CẢ" button centered below title
- 2×2 image grid with project name overlays:
  - POLARIS – RESORT
  - SUMMER SEA – RESORT
  - MVILLAGE – TÚ XƯƠNG
  - MVILLAGE – THI SÁCH

### 6. Footer ("LIÊN HỆ")
- Gradient background (dark blue left → teal right)
- Left block: company legal info (tên chính thức, tên viết tắt, tên quốc tế, mã số thuế)
- Center: RICHSCAPE logo
- Right block: THÔNG TIN LIÊN HỆ — phone, email, address

### Floating UI Elements (fixed, right side)
- Zalo button (green circle)
- Phone button (teal circle)
- Messenger button (teal circle)
- Back-to-top arrow (gray)

## Demo Data Reset

To re-trigger demo data import, delete the `richscape_demo_imported` option from the WordPress database (`wp_options` table) or via WP-CLI:

```bash
wp option delete richscape_demo_imported
```

Then visit any admin page to trigger `admin_init`.
