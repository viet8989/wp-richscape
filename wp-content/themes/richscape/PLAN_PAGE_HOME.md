# PLAN_PAGE_HOME.md — Trang Chủ (front-page.php)

## Tổng quan

Trang chủ là landing page chính, kết hợp từ `header.php`, `front-page.php`, và `footer.php`.  
Design gốc: https://testky.my.canva.site/richscape-web/

---

## Cấu trúc hiện tại (Current Code)

### 1. Header (`header.php`)
| Thành phần | Trạng thái | Ghi chú |
|---|---|---|
| Top gradient bar (darkblue → teal) | ✅ Done | `max-width:1280px`, `height:41.11px`, `border-radius:5px` |
| Logo trái | ✅ Done | `/wp-content/uploads/logo.png` |
| Nav desktop (hidden md:flex) | ✅ Done | `wp_nav_menu()` với `theme_location: primary` |
| Mobile hamburger menu | ✅ Done | JS toggle, ẩn khi `md:` |
| Nav items tiếng Việt | ⚠️ Phụ thuộc | Cần đăng ký menu đúng trong WP Admin |

**Nav items cần có (theo Canva):**
- TRANG CHỦ
- VỀ CHÚNG TÔI
- DỊCH VỤ
- DỰ ÁN TIÊU BIỂU
- THÔNG TIN - BẢN TIN
- LIÊN HỆ

---

### 2. Hero / Banner Slider (`[richscape_banner_slider]` shortcode)

| Thành phần | Trạng thái | Ghi chú |
|---|---|---|
| Full-width image slider | ✅ Done | Template: `templates/banner-slider.php`, CSS: `assets/css/richscape-banner-slider.css`, JS: `assets/js/richscape-banner-slider.js` |
| Prev/Next arrows | ✅ Done | `.rbs-arrow.rbs-prev/.rbs-next` |
| Dot indicators (bottom-right) | ✅ Done | `.rbs-dots`, injected bởi JS |
| Overlay card bottom-left | ✅ Done | Gradient darkblue → teal |
| — Teal label "VỀ CHÚNG TÔI" | ✅ Done | `.rbs-label` |
| — English tagline | ✅ Done | `.rbs-tagline` |
| — Vietnamese intro paragraph | ✅ Done | `.rbs-body` |
| — "LANDSCAPE CREATOR" footer text | ✅ Done | `.rbs-footer-text` |
| Slide data: ACF repeater | ✅ Done | `banner_slides` field |
| Slide data: Theme option fallback | ✅ Done | `richscape_banner_slides` option |
| Slide data: Placeholder fallback | ✅ Done | Built-in placeholders |
| Admin manager page (Banner Slider) | ✅ Done | `richscape_banner_slides` option, quản lý qua WP Admin |

---

### 3. Vision, Mission & Core Values Section (`front-page.php` lines 11–59)

| Thành phần | Trạng thái | Ghi chú |
|---|---|---|
| Background darkblue `#1A2251` | ✅ Done | `bg-darkblue` |
| Left column: Vision block | ✅ Done | Italic serif teal heading, gray-300 body |
| Left column: Mission block | ✅ Done | Italic serif teal heading, gray-300 body |
| Right column: heading "Core Values" | ⚠️ Cần sửa | Design dùng "Giá Trị Cốt Lõi" (tiếng Việt) — heading hiện là "Core Values" |
| Right column: 5 giá trị (numbered) | ✅ Done | PHP array, numbered circle border-teal |
| Layout 3+2 grid cho core values | ❌ Thiếu | Hiện dùng `space-y-6` (list thẳng đứng), Canva dùng grid 3+2 |

**5 Core Values (nội dung hiện tại — đúng):**
1. ĐỔI MỚI SÁNG TẠO
2. CHẤT LƯỢNG
3. TÔN TRỌNG THIÊN NHIÊN
4. KHÁCH HÀNG LÀ TRUNG TÂM
5. ĐÓNG GÓP CỘNG ĐỒNG

---

### 4. Services Section (`front-page.php` lines 62–221)

| Thành phần | Trạng thái | Ghi chú |
|---|---|---|
| Section title "DỊCH VỤ" | ⚠️ Khác design | Canva: title left-aligned + teal underline; hiện tại: `text-center` |
| Sub-heading | ⚠️ Thêm | Hiện có nhưng không có trong Canva — xem lại |
| 4 cards ngang (`lg:grid-cols-4`) | ✅ Done | |
| Card: gradient background | ✅ Done | `linear-gradient(135deg, #1A2251 0%, #2A9D8F 100%)` |
| Card: numbered badge | ✅ Done | Teal font-serif 52px, top-right |
| Card: service icon | ✅ Done | SVG inline (mock) hoặc `_service_icon_url` meta (WP) |
| Card: multi-line title | ✅ Done | font-sans bold uppercase |
| Card: description | ✅ Done | white/80, font-body sm |
| Card: photo image | ✅ Done | rounded-2xl, group-hover:scale-110 |
| Card: "DỰ ÁN LIÊN QUAN" CTA | ✅ Done | Teal bg, darkblue text, underline, rounded-full |
| Data từ CPT `services` | ✅ Done | WP_Query posts_per_page=4 |
| Fallback mock data (4 services) | ✅ Done | PHP array với Unsplash images |

**4 Services (nội dung hiện tại — đúng):**
1. THIẾT KẾ THI CÔNG CẢNH QUAN
2. HỆ THỐNG CHIẾU SÁNG & TƯỚI TỰ ĐỘNG
3. ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ ÂM
4. BẢO DƯỠNG CẢNH QUAN

---

### 5. Featured Projects Section (`front-page.php` lines 224–289)

| Thành phần | Trạng thái | Ghi chú |
|---|---|---|
| Section title "DỰ ÁN TIÊU BIỂU" | ✅ Done | teal tracking-widest |
| Sub-heading | ✅ Done | darkblue font-black |
| "XEM TẤT CẢ" button | ✅ Done | `get_post_type_archive_link('projects')` |
| 2×2 grid | ✅ Done | `md:grid-cols-2`, aspect-[16/9] |
| Project card: image | ✅ Done | group-hover:scale-110 |
| Project card: gradient overlay | ✅ Done | `from-black/90 to-transparent` |
| Project card: name overlay | ✅ Done | font-black uppercase white |
| Project card: "Xem Dự Án" hover CTA | ✅ Done | opacity-0 → opacity-100 on hover |
| Data từ CPT `projects` | ✅ Done | WP_Query posts_per_page=4 |
| Fallback mock data (4 projects) | ✅ Done | PHP array (thiếu ảnh riêng — dùng chung 1 Unsplash URL) |

**4 Projects (mock — nên thay):**
- POLARIS – RESORT
- MVILLAGE – TÚ XƯƠNG
- SUMMER SEA – RESORT
- MVILLAGE – THI SÁCH

**Vấn đề:** Mock projects dùng cùng 1 ảnh Unsplash — cần ảnh riêng cho mỗi project.

---

### 6. Footer (`footer.php`)

| Thành phần | Trạng thái | Ghi chú |
|---|---|---|
| Gradient bg (teal → darkblue, top → bottom) | ✅ Done | `from-teal to-darkblue` |
| Col 1: Thông tin công ty | ✅ Done | Tên, tên viết tắt, quốc tế, MST |
| Col 2: Logo trung tâm | ✅ Done | `/wp-content/uploads/logo_footer.png` |
| Col 3: Thông tin liên hệ | ✅ Done | Phone, email, address |
| Floating Zalo button | ⚠️ Sai màu | Canva: green circle; hiện: `bg-blue-500` (Messenger icon) |
| Floating Phone/Messenger buttons | ⚠️ Sai | Canva có: Zalo (green), Phone (teal), Messenger (teal) — hiện chỉ có 2 buttons |
| Back-to-top arrow | ✅ Done | `#top`, right-6 bottom-6 |
| Copyright bar | ✅ Done | |

---

## Danh sách việc cần làm (TODO)

### Ưu tiên cao
- [ ] **Footer floating buttons**: Sửa đúng 3 buttons theo Canva — Zalo (green), Phone (teal), Messenger (teal). Thêm đúng icon Zalo SVG và href.
- [ ] **Core Values layout**: Đổi từ `space-y-6` list sang grid 3+2 theo Canva design.
- [ ] **Core Values heading**: Đổi "Core Values" → "Giá Trị Cốt Lõi" (hoặc giữ song ngữ nếu đúng design).
- [ ] **Services section title**: Đổi từ `text-center` sang left-aligned với teal underline theo Canva.

### Ưu tiên trung bình
- [ ] **Mock projects images**: Dùng ảnh khác nhau cho mỗi project thay vì cùng 1 Unsplash URL.
- [ ] **Nav menu**: Đảm bảo WP Admin có menu "Primary" đăng ký đúng 6 items tiếng Việt với anchor links.
- [ ] **Services section sub-heading**: Xem lại có cần "Nâng Tầm Không Gian Sống Của Bạn" không (không có trong Canva).

### Ưu tiên thấp
- [ ] **Banner slider**: Thêm ảnh thực tế của dự án thay placeholder.
- [ ] **Footer gradient**: Canva là darkblue trái → teal phải (horizontal), hiện là top → bottom — xem lại.
- [ ] **`content-service-card.php` và `project-item.php`**: Hiện là empty placeholders — cân nhắc có cần dùng không (logic đã inline trong front-page.php).

---

## File liên quan

| File | Vai trò |
|---|---|
| `front-page.php` | Template chính trang chủ |
| `header.php` | Fixed header + nav |
| `footer.php` | Footer + floating buttons |
| `templates/banner-slider.php` | Hero slider HTML |
| `assets/css/richscape-banner-slider.css` | Slider styles |
| `assets/js/richscape-banner-slider.js` | Slider JS |
| `functions.php` | CPT registration, shortcode, enqueue |
| `inc/import-data.php` | Demo data import (4 services + 4 projects) |
| `src/input.css` | Tailwind source |
| `tailwind.config.js` | Custom colors/fonts |
