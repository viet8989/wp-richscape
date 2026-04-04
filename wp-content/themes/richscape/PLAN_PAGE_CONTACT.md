# Plan: LIÊN HỆ Page

**Template file:** `page-contact.php`
**WordPress slug:** `lien-he`

---

## Page Layout

### 1. Page Header
No explicit page title shown in Canva design — the content card starts immediately below the header.

### 2. Main Content Area — Two-Column Layout

**Left column (~40%)**
- **Contact info card** — dark blue (`#1A2251`) background, rounded corners, padding
  - `ADDRESS` — teal small caps label + address text (white):
    > 13/3A, Street 15, Binh Trung Tay Ward, Thu Duc City
  - `PHONE` — teal small caps label + phone (white):
    > 0937 430 701
  - `EMAIL` — teal small caps label + email (white):
    > Khanhbui@Richscape.vn

**Right column (~60%)**
- **Google Maps embed** — full height iframe showing company location
  - Address: 13/3A, Đường 15, Bình Trung Tây, Thành Phố Hồ Chí Minh
  - Note: large blank white area in Canva design is placeholder for this embed

### 3. Contact Form (below two-column block)
Not shown in Canva design — inferred as standard contact page requirement.
- Section label: `GỬI TIN NHẮN CHO CHÚNG TÔI` (teal, bold)
- Fields:
  - Họ và tên (text)
  - Email (email)
  - Số điện thoại (tel)
  - Nội dung (textarea)
  - Submit button: `GỬI` — teal background, white text

### 4. Footer
Standard `get_footer()`

---

## Implementation Notes

| Item | Approach |
|------|----------|
| Template | `page-contact.php` |
| Contact info | Hard-coded in template (static company info) |
| Google Maps | `<iframe>` embed via Google Maps Embed API — address: 13/3A Đường 15, Bình Trung Tây, TP.HCM |
| Contact form | WordPress native (`wp_mail`) or Contact Form 7 plugin shortcode |
| Form handling | POST to same page, show success/error message inline |
| CSRF protection | WordPress nonce on form |
| CSS | Tailwind + `src/input.css`; card style matches project detail sidebar |
| Build | `npm run build` then FTP upload |

---

## Contact Info (hardcoded)

```
ADDRESS : 13/3A, Đường 15, Bình Trung Tây, Thành Phố Hồ Chí Minh
PHONE   : 0937 430 701
EMAIL   : Khanhbui@Richscape.vn
```

---

## New Files to Create

```
wp-content/themes/richscape/
└── page-contact.php    ← contact page template
```
