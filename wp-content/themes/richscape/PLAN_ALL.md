# PLAN_ALL.md — Richscape WordPress Theme — Kế Hoạch Tổng Thể

**Design gốc:** https://testky.my.canva.site/richscape-web/  
**Live site:** https://deepskyblue-alpaca-301704.hostingersite.com/  
**Deploy:** FTP upload sau mỗi lần `npm run build`

> **Nguyên tắc kiến trúc:** Mọi nội dung text và ảnh đều phải quản lý được qua WP Admin — không hardcode trong PHP template.

---

## Mục lục

0. [Data Architecture — Kiến trúc dữ liệu động](#0-data-architecture)
1. [Shared Components (Dùng chung)](#1-shared-components)
2. [Trang Chủ — `front-page.php`](#2-trang-chủ)
3. [Về Chúng Tôi — `page-about.php`](#3-về-chúng-tôi)
4. [Dịch Vụ — `page-services.php`](#4-dịch-vụ)
5. [Dự Án — `page-projects.php` + `single-projects.php`](#5-dự-án)
6. [Thông Tin - Bản Tin — `page-news.php` + `single-post.php`](#6-thông-tin---bản-tin)
7. [Liên Hệ — `page-contact.php`](#7-liên-hệ)
8. [CPT Archive Pages](#8-cpt-archive-pages)
9. [Admin & Data Import](#9-admin--data-import)
10. [Tổng hợp TODO](#10-tổng-hợp-todo)
11. [Cây thư mục file mới cần tạo](#11-cây-thư-mục)

---

## 0. Data Architecture

Toàn bộ nội dung được chia thành 4 nguồn, tất cả đều chỉnh sửa được qua WP Admin:

---

### 0.1 ACF Options Page — Dữ liệu toàn site

**WP Admin → Richscape Options**  
Đăng ký bằng `acf_add_options_page()` trong `functions.php`.  
Đọc trong template bằng: `get_field('field_name', 'option')`

| Field name | Label | Type | Dùng ở |
|---|---|---|---|
| `logo_header` | Logo Header | Image | `header.php` |
| `logo_footer` | Logo Footer | Image | `footer.php` |
| `company_name_full` | Tên đầy đủ | Text | Footer col 1 |
| `company_name_abbr` | Tên viết tắt | Text | Footer col 1 |
| `company_name_intl` | Tên quốc tế | Text | Footer col 1 |
| `company_tax_id` | Mã số thuế | Text | Footer col 1 |
| `contact_phone` | Điện thoại | Text | Footer col 3, Contact page |
| `contact_email` | Email | Email | Footer col 3, Contact page |
| `contact_address` | Địa chỉ | Textarea | Footer col 3, Contact page |
| `social_zalo_url` | Zalo URL | URL | Footer floating button |
| `social_messenger_url` | Messenger URL | URL | Footer floating button |
| `about_tagline_en` | English Tagline | Text | Banner overlay, About card |
| `about_intro_vi` | Vietnamese Intro | Textarea | Banner overlay, About card |
| `vision_text` | Nội dung Tầm Nhìn | Textarea | Home + About |
| `mission_text` | Nội dung Sứ Mệnh | Textarea | Home + About |
| `core_values` | Giá Trị Cốt Lõi | Repeater | Home + About |
| — `cv_title` | Tên giá trị | Text | |
| — `cv_description` | Mô tả | Textarea | |
| `trusted_by` | Đối Tác Tin Tưởng | Repeater | About page |
| — `partner_logo` | Logo | Image | |
| — `partner_name` | Tên đối tác | Text | |
| `footer_copyright` | Copyright text | Text | Footer bottom bar |

---

### 0.2 ACF Fields on Pages

**WP Admin → Pages → [edit page] → [field group bên dưới editor]**

#### About Page (`page-about.php`)

| Field name | Label | Type |
|---|---|---|
| `leaders` | Lãnh Đạo | Repeater |
| — `leader_name` | Họ tên | Text |
| — `leader_title` | Chức danh | Text |
| — `leader_bio` | Tiểu sử | Textarea |
| — `leader_portrait` | Ảnh chân dung | Image |
| — `leader_bg_photo` | Ảnh nền landscape | Image |
| `members` | Thành Viên | Repeater |
| — `member_name` | Họ tên | Text |
| — `member_title` | Chức danh | Text |
| — `member_bio` | Tiểu sử | Textarea |
| — `member_portrait` | Ảnh | Image |

#### Contact Page (`page-contact.php`)

| Field name | Label | Type | Ghi chú |
|---|---|---|---|
| `maps_embed_url` | Google Maps Embed URL | Text | Paste src URL từ Google Maps → Share → Embed |

---

### 0.3 ACF Fields on CPTs

**WP Admin → Services / Projects → [edit post] → [fields bên dưới editor]**

#### Services CPT

| Field name | Label | Type | Ghi chú |
|---|---|---|---|
| `service_icon` | Biểu tượng dịch vụ | Image | Thay thế `_service_icon_url` cũ |
| `service_sub_images` | Ảnh chi tiết | Repeater | Dùng trong `page-services.php` |
| — `sub_image` | Ảnh | Image | |
| — `sub_caption` | Caption | Text | Ví dụ: "MASTER PLAN" |

#### Projects CPT

| Field name | Label | Type |
|---|---|---|
| `project_client` | Chủ đầu tư | Text |
| `project_area_total` | Quy mô tổng thể (m²) | Text |
| `project_area_green` | Diện tích phủ xanh (m²) | Text |
| `project_scope` | Phạm vi thực hiện | Text |
| `project_address` | Địa chỉ dự án | Text |
| `project_category_tag` | Loại dịch vụ | Text |
| `project_gallery` | Thư viện ảnh | Gallery |

---

### 0.4 Standard WordPress (đã dynamic sẵn)

| Nội dung | Quản lý ở |
|---|---|
| Banner Slider ảnh + alt | WP Admin → Banner Slider ✅ |
| Navigation menu | WP Admin → Appearance → Menus ✅ |
| Services: tiêu đề, mô tả, ảnh đại diện | WP Admin → Services → edit ✅ |
| Projects: tiêu đề, nội dung, ảnh đại diện | WP Admin → Projects → edit ✅ |
| News: tiêu đề, nội dung, excerpt, ảnh đại diện | WP Admin → Posts → edit ✅ |
| Single project detail content | WP Admin → Projects → edit (post content) ✅ |
| Single news article content | WP Admin → Posts → edit (post content) ✅ |

---

### 0.5 Quy tắc đọc field trong template

```php
// Options Page (site-wide)
$phone = get_field('contact_phone', 'option');

// Current post/page
$maps_url = get_field('maps_embed_url');

// CPT post in loop
while(have_posts()): the_post();
    $gallery = get_field('project_gallery');
endwhile;

// Fallback pattern (nếu ACF chưa có dữ liệu)
$phone = get_field('contact_phone', 'option') ?: '0937 430 701';
```

---

## 1. Shared Components

### 1.1 Header (`header.php`)

| Thành phần | Trạng thái | Nguồn dữ liệu |
|---|---|---|
| Logo header | ⚠️ Hardcoded path | → `get_field('logo_header', 'option')['url']` |
| Nav desktop | ✅ Dynamic | `wp_nav_menu()` |
| Mobile hamburger | ✅ Done | — |
| Top gradient bar | ✅ Done | — |

---

### 1.2 Footer (`footer.php`)

| Thành phần | Trạng thái | Nguồn dữ liệu |
|---|---|---|
| Gradient direction | ⚠️ Sai hướng | Đổi `to-r from-darkblue to-teal` |
| Logo footer | ⚠️ Hardcoded | → `get_field('logo_footer', 'option')['url']` |
| Tên công ty, MST | ⚠️ Hardcoded | → Options: `company_name_full`, `company_tax_id`, ... |
| Phone, email, address | ⚠️ Hardcoded | → Options: `contact_phone`, `contact_email`, `contact_address` |
| Zalo URL | ⚠️ Hardcoded | → Options: `social_zalo_url` |
| Messenger URL | ⚠️ Hardcoded | → Options: `social_messenger_url` |
| Floating buttons: sai icons/màu | ❌ Sửa | Zalo green + Phone teal + Messenger blue |
| Copyright | ⚠️ Hardcoded | → Options: `footer_copyright` (fallback: year + "Richscape") |

---

### 1.3 `template-parts/section-vision-mission.php`

**Dùng ở:** `front-page.php` + `page-about.php`

| Thành phần | Nguồn dữ liệu |
|---|---|
| Vision heading + text | Options: `vision_text` |
| Mission heading + text | Options: `mission_text` |
| Core values (5 items, 3+2 grid) | Options repeater: `core_values` → `cv_title`, `cv_description` |

---

### 1.4 `template-parts/section-hero-banner.php`

**Dùng ở:** `single-projects.php` + `single-post.php`  
Nguồn: `get_the_post_thumbnail_url(get_the_ID(), 'full')`

### 1.5 `template-parts/section-breadcrumb.php`

**Dùng ở:** `single-projects.php` + `single-post.php`  
Nhận `$breadcrumbs` array qua `set_query_var`.

### 1.6 `template-parts/content-service-card.php`

**Dùng ở:** `front-page.php` + `archive-services.php`  
Nguồn ảnh icon: ACF field `service_icon` (image) thay `_service_icon_url` meta cũ.

### 1.7 `template-parts/project-item.php`

**Dùng ở:** `front-page.php` + `archive-projects.php`  
Nguồn: CPT `projects`, `has_post_thumbnail()`, `get_the_permalink()`.

---

## 2. Trang Chủ

**File:** `front-page.php`

| Section | Nguồn dữ liệu |
|---|---|
| Hero Slider | WP Admin → Banner Slider ✅ |
| Vision/Mission/Core Values | Options: `vision_text`, `mission_text`, `core_values` |
| Services 4 cards | CPT `services` (title, excerpt, featured image, ACF `service_icon`) |
| Projects 4 cards | CPT `projects` (title, featured image) |

---

## 3. Về Chúng Tôi

**File:** `page-about.php`

| Section | Nguồn dữ liệu |
|---|---|
| About card: tagline, intro | Options: `about_tagline_en`, `about_intro_vi` |
| About card: logo | Options: `logo_footer` |
| Vision/Mission/Core Values | `section-vision-mission.php` → Options |
| Leaders (2 người) | ACF repeater `leaders` on About page |
| Members (3 người) | ACF repeater `members` on About page |
| Trusted By (9 logos) | Options repeater: `trusted_by` |

---

## 4. Dịch Vụ

**File:** `page-services.php`

| Section | Nguồn dữ liệu |
|---|---|
| 4 service blocks (tiêu đề, mô tả) | CPT `services` — query theo `menu_order` |
| Sub-images 2×2 grid per service | ACF repeater `service_sub_images` → `sub_image`, `sub_caption` |

---

## 5. Dự Án

### Listing — `page-projects.php`

| Thành phần | Nguồn dữ liệu |
|---|---|
| Grid 3×3 (9 projects) | CPT `projects`, `posts_per_page: 9` |
| Ảnh | Featured image |
| Tên, link | `the_title()`, `get_permalink()` |

### Detail — `single-projects.php`

| Thành phần | Nguồn dữ liệu |
|---|---|
| Hero banner | Featured image |
| Title, content | `the_title()`, `the_content()` |
| Meta fields | ACF: `project_client`, `project_area_total`, `project_area_green`, `project_scope`, `project_address`, `project_category_tag` |
| Gallery | ACF: `project_gallery` |
| Dự án liên quan | WP_Query 4 other projects |
| View count | Post meta `_project_views` (auto-incremented) |

---

## 6. Thông Tin - Bản Tin

### Listing — `page-news.php`

| Thành phần | Nguồn dữ liệu |
|---|---|
| Article list | Standard WP posts, `posts_per_page: 10`, paginated |
| Thumbnail | Featured image |
| Title, excerpt | `the_title()`, `the_excerpt()` |

### Detail — `single-post.php`

| Thành phần | Nguồn dữ liệu |
|---|---|
| Hero banner | Featured image |
| Title, content | `the_title()`, `the_content()` |
| Bài viết liên quan | WP_Query 4 same-category posts |
| View count | Post meta `_post_views` (auto-incremented) |

---

## 7. Liên Hệ

**File:** `page-contact.php`

| Thành phần | Nguồn dữ liệu |
|---|---|
| Phone, email, address | Options: `contact_phone`, `contact_email`, `contact_address` |
| Google Maps embed | ACF on Contact page: `maps_embed_url` |
| Contact form | `wp_mail()` + nonce — fields: họ tên, email, SĐT, nội dung |

---

## 8. CPT Archive Pages

### `archive-services.php`
Query `services` CPT → `get_template_part('template-parts/content-service-card')`

### `archive-projects.php`
Query `projects` CPT → `get_template_part('template-parts/project-item')`

---

## 9. Admin & Data Import

### `inc/import-data.php` — Cần sửa

| Vấn đề | Fix |
|---|---|
| Menu URLs dùng `#anchor` | Đổi sang archive links + page permalinks |
| Thiếu 5 demo news posts | Thêm `post` type entries |
| Thiếu 5 demo projects (chỉ có 4) | Thêm: HAPPY HOME PARK, MVILLAGE - HỘI AN, JAPAN GARDEN, EMPIRE BALCONY, VANLANG UNIVERSITY |

### ACF Options Page — Đăng ký trong `functions.php`

```php
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Richscape Options',
        'menu_title' => 'Richscape Options',
        'menu_slug'  => 'richscape-options',
        'capability' => 'manage_options',
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 2,
    ]);
}
```

---

## 10. Tổng hợp TODO

### Ưu tiên 1 — ACF setup (nền tảng cho mọi thứ)
- [ ] Đăng ký ACF Options Page trong `functions.php`
- [ ] Đăng ký tất cả field groups (Options, About page, Services CPT, Projects CPT, Contact page)

### Ưu tiên 2 — Sửa shared components
- [ ] `header.php`: logo đọc từ ACF Options
- [ ] `footer.php`: tất cả text/ảnh/links đọc từ ACF Options + sửa gradient + sửa 3 floating buttons
- [ ] Extract + viết `template-parts/section-vision-mission.php` đọc từ ACF Options
- [ ] Extract `template-parts/content-service-card.php` dùng ACF `service_icon`
- [ ] Extract `template-parts/project-item.php`
- [ ] Tạo `template-parts/section-hero-banner.php`
- [ ] Tạo `template-parts/section-breadcrumb.php`
- [ ] Sửa `inc/import-data.php` menu URLs + thêm demo news + thêm 5 projects

### Ưu tiên 3 — Sửa trang chủ
- [ ] Services section title: left-aligned + teal underline
- [ ] Thay inline card HTML bằng `get_template_part()`

### Ưu tiên 4 — Tạo 9 PHP file mới
- [ ] `archive-services.php`, `archive-projects.php`
- [ ] `page-about.php`, `page-services.php`, `page-projects.php`, `page-news.php`, `page-contact.php`
- [ ] `single-projects.php`, `single-post.php`

### Ưu tiên 5 — WP Admin data entry (Chrome)
- [ ] Nhập toàn bộ dữ liệu vào Richscape Options (company, contact, social, vision, mission, core values, trusted by, logos)
- [ ] Nhập leaders + members vào About page fields
- [ ] Nhập `maps_embed_url` vào Contact page
- [ ] Nhập `service_sub_images` cho từng service
- [ ] Nhập ACF fields cho từng project
- [ ] Upload ảnh thực tế (team, logos, projects, services)
- [ ] Cập nhật navigation menu (6 items, URL đúng)
- [ ] Upload banner slider ảnh thực tế

---

## 11. Cây thư mục

```
wp-content/themes/richscape/
│
├── front-page.php                          ← sửa (dùng get_template_part, ACF)
├── header.php                              ← sửa (logo từ ACF Options)
├── footer.php                              ← sửa (tất cả text từ ACF Options)
├── functions.php                           ← thêm Options Page + tất cả ACF field groups
├── inc/import-data.php                     ← sửa (menu URLs, thêm news + projects)
│
├── page-about.php                          ← mới
├── page-services.php                       ← mới
├── page-projects.php                       ← mới
├── page-news.php                           ← mới
├── page-contact.php                        ← mới
├── archive-services.php                    ← mới
├── archive-projects.php                    ← mới
├── single-projects.php                     ← mới
├── single-post.php                         ← mới
│
└── template-parts/
    ├── content-service-card.php            ← populate (extract từ front-page)
    ├── project-item.php                    ← populate (extract từ front-page)
    ├── section-vision-mission.php          ← mới (extract + ACF Options)
    ├── section-about-card.php              ← mới (ACF Options)
    ├── section-hero-banner.php             ← mới
    └── section-breadcrumb.php             ← mới
```
