# Plan: THÔNG TIN - BẢN TIN Pages

Two templates needed: a listing page and a single article detail page.
Note: The Canva design only shows the listing page. The detail page is designed to follow the same layout conventions as the project detail page (`single-projects.php`).

---

## 1. News Listing Page

**Template file:** `page-news.php`
**WordPress slug:** `thong-tin-ban-tin`

### Layout

- **Page title:** `THÔNG TIN - BẢN TIN` — teal, bold, left-aligned with teal underline
- **Article list** — vertical stacked list, each item:
  - Thumbnail image (left, ~40%) + content block (right, ~60%)
  - Article title — teal, bold, uppercase, clickable link
  - Date + view count meta row (icon + text)
  - Short excerpt (1–2 lines)
  - Horizontal rule separator between items

### Articles (5 demo posts)

1. CÁC PHONG CÁCH CẢNH QUAN HIỆN ĐẠI
2. XU HƯỚNG KIẾN TRÚC CẢNH QUAN SAU COVID 19
3. ĐIỀU GÌ CẦN QUAN TÂM KHI THI CÔNG TƯỜNG XANH
4. NHỮNG SAI LẦM DỄ MẮC PHẢI KHI CHỌN CÂY CHO CẢNH QUAN VÙNG BIỂN
5. CÁC LOẠI CÂY KHÔNG CÓ HOA NHƯNG RỰC RỠ CHO KHU VƯỜN CỦA BẠN

> The Canva listing page shows only plain text titles (no thumbnails/dates). The richer list layout above is inferred from common conventions and the project detail sidebar style. Adjust if client provides a revised design.

---

## 2. Single Article Detail Page

**Template file:** `single-post.php` (standard WordPress single post template)
**URL pattern:** `/{post-slug}`

### Layout (mirrors project detail page conventions)

#### Hero Banner
- Full-width background: featured image behind header, ~130px tall, faded overlay

#### Breadcrumb
- `TRANG CHỦ / THÔNG TIN - BẢN TIN / ARTICLE TITLE`
- Light gray bar, small uppercase, last item teal

#### Two-Column Content Area

**Left column (~65%)**
- Article title — bold, dark blue (`#1A2251`), large
- Meta row: calendar icon + date | eye icon + view count
- Featured image — full-width below meta
- Article body (WordPress `the_content()`)
- `LANDSCAPE CREATOR` — spaced-letter teal watermark, centered, at bottom of content

**Right sidebar (~35%)**
- **"Bài viết liên quan"** box (dark blue background):
  - Vertical list of 4 related article thumbnails + titles
  - `XEM THÊM` teal text link at bottom

---

## Implementation Notes

| Item | Approach |
|------|----------|
| Listing template | `page-news.php` — WP_Query for `post` post type, 10 per page, paginated |
| Detail template | `single-post.php` — standard WordPress single |
| Post type | Standard WordPress `post` (no CPT needed) |
| Featured image | Used as hero banner + list thumbnail |
| View counter | Post meta `_post_views`, incremented on load (same pattern as projects) |
| Related posts | Query 4 posts from same category, exclude current |
| Demo content | 5 posts imported via `inc/import-data.php` (extend existing importer) |
| CSS | Tailwind + `src/input.css`; list and article styles match project page |
| Build | `npm run build` then FTP upload |

---

## New Files to Create

```
wp-content/themes/richscape/
├── page-news.php            ← listing page template
├── single-post.php          ← single article detail template
└── assets/images/news/      ← featured images for demo posts
```

## Extend `inc/import-data.php`

Add 5 demo `post` entries with:
- Title (Vietnamese, uppercase)
- Featured image
- Short excerpt
- Body content (2–3 paragraphs)
