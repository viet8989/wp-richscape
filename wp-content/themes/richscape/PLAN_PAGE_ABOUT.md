# Plan: VỀ CHÚNG TÔI Page

**Template file:** `page-about.php`
**WordPress slug:** `ve-chung-toi`

---

## Page Sections (top → bottom)

### 1. Page Header
- `VỀ CHÚNG TÔI` — left-aligned `h1` with teal underline accent

### 2. About Card (Intro)
- Dark blue (`#1A2251`) → teal (`#2A9D8F`) gradient background card
- RICHSCAPE logo (white version) centered top
- English tagline: **"As Landscape Creators, We Bring Your Green Visions To Life."**
- Vietnamese company intro paragraph
- `LANDSCAPE CREATOR` spaced-letter footer text

### 3. Vision, Mission & Core Values
- Dark blue (`#1A2251`) full-width background section (same as homepage)
- **Left column:** Vision + Mission (italic teal headings, paragraph text)
- **Right column:** Core Values — numbered list 1–5 in 3+2 grid:
  1. ĐỔI MỚI SÁNG TẠO
  2. CHẤT LƯỢNG
  3. TÔN TRỌNG THIÊN NHIÊN
  4. KHÁCH HÀNG LÀ TRUNG TÂM
  5. ĐÓNG GÓP CỘNG ĐỒNG

### 4. Leadership Section (LEADERS)
Two full-width person cards:
- Top half: landscape photo background + portrait photo (left-aligned)
- Bottom half: dark blue right side — italic teal name, bold caps title, horizontal rule, bio paragraph

**People:**
1. Bui Duy Khanh — MANAGING DIRECTOR
2. Trang Thanh Hoang — VICE MANAGING DIRECTOR

### 5. Members Section (MEMBERS)
- Label: `MEMBERS` — spaced white caps on teal/green gradient background
- Same card layout as Leaders

**People:**
1. Mr. Anthony — SENIOR ADVISOR
2. Truong Thanh Tuan — CONSTRUCTION MANAGER
3. Pham Dinh Hiep — HEAD OF GREEN MAINTENANCE

### 6. Trusted By Section
- White background, italic dark blue *"Trusted by"* heading (Playfair Display)
- 3×3 logo grid (9 logos):
  1. T&T Group
  2. TT Capital
  3. Apache
  4. Newtecons
  5. Hưng Lộc Phát
  6. Unicons (Coteccons Group)
  7. M Village
  8. UTH
  9. Kymdan

### 7. Footer
- Standard `get_footer()`

---

## Implementation Notes

| Item | Approach |
|------|----------|
| Template file | `page-about.php` |
| Team data | Hard-coded in template (no CPT needed) |
| Partner logos | Static images in `assets/images/partners/` |
| Person photos | Static images in `assets/images/team/` |
| CSS | Tailwind utility classes; card styles in `src/input.css` |
| Shared sections | Vision/Mission/Core Values → `template-parts/section-vision-mission.php` (shared with `front-page.php`) |
| Build | `npm run build` then FTP upload |

---

## New Files to Create

```
wp-content/themes/richscape/
├── page-about.php                  ← page template
├── template-parts/
│   ├── section-vision-mission.php  ← extracted from front-page.php (shared)
│   └── section-about-card.php      ← reusable intro card
└── assets/images/
    ├── team/                        ← leader/member photos
    └── partners/                    ← trusted-by logos
```
