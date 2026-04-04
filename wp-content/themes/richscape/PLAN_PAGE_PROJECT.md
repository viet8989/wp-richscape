# Plan: DỰ ÁN TIÊU BIỂU Pages

Two templates are needed: a listing page and a single project detail page.

---

## 1. Projects Listing Page

**Template file:** `page-projects.php`
**WordPress slug:** `du-an-tieu-bieu`

### Layout

- **Page title:** `DỰ ÁN TIÊU BIỂU` — teal, bold, left-aligned with teal underline
- **3-column photo grid** — each item:
  - Square/tall project photo (clickable → detail page)
  - Project name below as teal underlined link (e.g. `POLARIS - RESORT`)

### Projects (9 items, 3×3 grid)

| # | Name |
|---|------|
| 1 | POLARIS - RESORT |
| 2 | MVILLAGE - TÚ XƯƠNG |
| 3 | MVILLAGE - THI SÁCH |
| 4 | SUMMER SEA - RESORT |
| 5 | HAPPY HOME PARK |
| 6 | MVILLAGE - HỘI AN |
| 7 | JAPAN GARDEN |
| 8 | EMPIRE BALCONY |
| 9 | VANLANG UNIVERSITY |

---

## 2. Project Detail Page

**Template file:** `single-projects.php` (WordPress single CPT template)
**URL pattern:** `/{project-slug}` (e.g. `/polaris`)

### Layout

#### Hero Banner
- Full-width background image (project landscape photo) behind header
- Faded/overlay effect, ~130px tall visible band

#### Breadcrumb
- `TRANG CHỦ / DỰ ÁN / DỰ ÁN ĐÃ THI CÔNG / PROJECT NAME`
- Light gray bar, small uppercase text, last item teal

#### Two-Column Content Area

**Left column (~60%)**
- Project title — bold, dark blue (`#1A2251`), large
- Meta row: date icon + date | eye icon + view count
- Category tag: e.g. "Thiết kế - thi công cảnh quan"
- Address line
- **THÔNG TIN DỰ ÁN** (bold heading, dark):
  - Chủ đầu tư: …
  - Quy mô tổng thể: … m²
  - Diện tích phủ xanh: … m²
  - Phạm vi thực hiện: …
- Description paragraphs (WordPress post content)
- Optional sub-heading (bold): e.g. "Giải pháp cảnh quan toàn diện"
- More description text
- `LANDSCAPE CREATOR` — spaced-letter teal footer watermark, centered

**Right sidebar (~40%)**
- **"Dự án liên quan"** box (dark blue background):
  - 2×2 grid of related project thumbnails
  - Each thumbnail: photo + teal name label below
  - `XEM THÊM` teal text link at bottom center

#### Photo Gallery
- Full-width 3-column masonry grid of project photos
- No captions
- Photos pulled from project's ACF/meta gallery field or post attachments

---

## Implementation Notes

| Item | Approach |
|------|----------|
| Listing template | `page-projects.php` — queries `projects` CPT, 9 per page |
| Detail template | `single-projects.php` — standard WordPress single CPT |
| Project data | `projects` CPT already registered in `functions.php` |
| Hero image | CPT featured image used as hero banner background |
| Project meta fields | ACF custom fields: `project_client`, `project_area_total`, `project_area_green`, `project_scope`, `project_address`, `project_category_tag` |
| Gallery | ACF gallery field `project_gallery` — renders as 3-col masonry |
| Related projects | Query 4 other `projects` posts (exclude current), shown in sidebar |
| View counter | Simple post meta `_project_views`, incremented on each page load |
| CSS | Tailwind + custom styles in `src/input.css` |
| Build | `npm run build` then FTP upload |

---

## New Files to Create

```
wp-content/themes/richscape/
├── page-projects.php        ← listing page template
├── single-projects.php      ← single project detail template
└── assets/images/projects/
    ├── polaris/             ← gallery images
    ├── mvillage-tu-xuong/
    ├── mvillage-thi-sach/
    ├── summer-sea/
    ├── happy-home-park/
    ├── mvillage-hoi-an/
    ├── japan-garden/
    ├── empire-balcony/
    └── vanlang-university/
```

## ACF Fields to Register (in `functions.php`)

```
project_client          (text)
project_area_total      (text)
project_area_green      (text)
project_scope           (text)
project_address         (text)
project_category_tag    (text)
project_gallery         (gallery)
_project_views          (number, auto-incremented)
```
