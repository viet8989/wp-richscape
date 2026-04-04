# Plan: DỊCH VỤ Page

**Template file:** `page-services.php`
**WordPress slug:** `dich-vu`

---

## Page Structure

The page is a single scrollable page with a **Page Header** followed by **4 service sections**, each sharing the same layout pattern.

---

## Layout Pattern (repeated per service)

Each service block:
1. **Section title** — teal, bold, left-aligned with teal underline (e.g. `THIẾT KẾ THI CÔNG CẢNH QUAN`)
2. **Description paragraph** — short intro text below the title
3. **2-column image grid** — responsive 2-col grid of photos, each with a teal caption label below

---

## Service Sections

### 1. THIẾT KẾ THI CÔNG CẢNH QUAN
Description: Kiến tạo không gian xanh thẩm mỹ, mang đậm dấu ấn riêng với quy trình chuyên nghiệp từ khâu ý tưởng đến khi hoàn thiện thực tế.

Image grid (4 images, 2×2):
- MASTER PLAN
- 3D CONCEPT
- KHÁI TOÁN
- HARDSCAPE & CÂY XANH

---

### 2. CHIẾU SÁNG - TƯỚI TỰ ĐỘNG

Image grid (4 images, 2×2):
- KICH BẢN CHIẾU SÁNG - HỆ TƯỚI
- LẮP ĐẶT CHIẾU SÁNG
- HỆ TƯỚI TỰ ĐỘNG
- THIẾT BỊ CHÍNH HÃNG, AN TOÀN

---

### 3. ĐÀI PHUN NƯỚC - HỒ BƠI - HỒ CẢNH

Image grid (4 images, 2×2):
- THÁC NƯỚC / ĐÀI PHUN NGHỆ THUẬT
- HỒ BƠI
- HỒ SINH THÁI
- HỒ JACUZZI

---

### 4. CHĂM SÓC - BẢO TRÌ CẢNH QUAN

Image grid (4 images, 2×2):
- CẮT TỈA & TẠO DÁNG ĐỊNH KỲ
- VỆ SINH CẢNH QUAN
- BẢO TRÌ HỆ THỐNG BƠM - LỌC
- DINH DƯỠNG, PHÒNG BỆNH

---

## Implementation Notes

| Item | Approach |
|------|----------|
| Template file | `page-services.php` |
| Service data | Hard-coded in template (matches 4 CPT services on homepage) |
| Images | Static in `assets/images/services/` — one subfolder per service |
| CSS | Tailwind utility classes; section title style reuses homepage `.section-title` pattern |
| Section titles | Teal color (`#2A9D8F`), bold, with 2px teal bottom border underline |
| Image captions | Teal uppercase text, centered below each image |
| Build | `npm run build` then FTP upload |

---

## New Files to Create

```
wp-content/themes/richscape/
├── page-services.php                  ← page template
└── assets/images/services/
    ├── thiet-ke/                       ← 4 images for service 1
    ├── chieu-sang/                     ← 4 images for service 2
    ├── dai-phun-nuoc/                  ← 4 images for service 3
    └── cham-soc/                       ← 4 images for service 4
```
