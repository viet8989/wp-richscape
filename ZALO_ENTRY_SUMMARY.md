# ✅ Richscape Options - Line 12 Entry Summary

## 📝 Form Entry Details

### Setup Form Used
**Script:** `richscape-options-setup.php` (uploaded and executed)  
**URL:** `https://richscape.vn/wp-content/themes/richscape/richscape-options-setup.php`

---

## 📊 Data Entered in Form

### Social Media URLs Section
| Field Name | Label | Value Entered | Status |
|-----------|-------|---------------|--------|
| **social_zalo_url** | **Zalo URL ⭐** | `https://zalo.me/0937430701` | ✅ Saved |
| social_messenger_url | Messenger URL | (default placeholder) | ✅ Saved |

### Company Information Section
| Field Name | Label | Value Entered | Status |
|-----------|-------|---------------|--------|
| company_name_full | Tên đầy đủ | CÔNG TY TNHH THIẾT KẾ & THI CÔNG CẢNH QUAN RICHSCAPE | ✅ Saved |
| company_name_abbr | Tên viết tắt | RS LDB CO.,LTD | ✅ Saved |
| company_name_intl | Tên quốc tế | RICHSCAPE LANDSCAPE DESIGN & BUILD COMPANY LIMITED | ✅ Saved |
| company_tax_id | Mã số thuế | 0316356108 | ✅ Saved |

### Contact Information Section
| Field Name | Label | Value Entered | Status |
|-----------|-------|---------------|--------|
| contact_phone | Điện thoại | 0937 430 701 | ✅ Saved |
| contact_email | Email | Khanhbui@Richscape.vn | ✅ Saved |
| contact_address | Địa chỉ | 13/3A, Đường 15, Bình Trưng Tây, TP. HCM | ✅ Saved |

### Map Coordinates Section
| Field Name | Label | Value Entered | Status |
|-----------|-------|---------------|--------|
| map_lat | Tọa độ - Vĩ độ | 10.7756 | ✅ Saved |
| map_lng | Tọa độ - Kinh độ | 106.7476 | ✅ Saved |

### Content Sections
| Field Name | Label | Status |
|-----------|-------|--------|
| about_tagline_en | English Tagline | ✅ Saved |
| about_intro_vi | Vietnamese Intro | ✅ Saved |
| vision_text | Nội dung Tầm Nhìn | ✅ Saved |
| mission_text | Nội dung Sứ Mệnh | ✅ Saved |
| footer_copyright | Copyright Text | ✅ Saved |

---

## 🔗 How Line 12 Uses This Data

### footer.php Line 12:
```php
$social_zalo = function_exists( 'get_field' ) ? get_field( 'social_zalo_url', 'option' ) : '';
```

### What This Means:
1. **Function:** `get_field()` - ACF function to retrieve saved option values
2. **Field Key:** `social_zalo_url` - The field name from ACF options
3. **Scope:** `'option'` - Retrieves from global options (not post/page specific)
4. **Fallback:** Empty string `''` if ACF is not loaded

### Usage in Footer:
The retrieved Zalo URL is used to create a clickable Zalo button in the footer section:
```
https://richscape.vn → Footer → Zalo Button (green circle) → Links to https://zalo.me/0937430701
```

---

## 💾 Data Storage Location

### WordPress Database
- **Table:** `wp_options`
- **Option Name:** `richscape-options`
- **ACF Meta Keys:**
  - `_richscape-options_social_zalo_url`
  - `_richscape-options_contact_phone`
  - etc. (one for each field)

### How to Access in wp-admin:
**Expected Location:**
1. WordPress Admin Dashboard
2. Left Sidebar Menu
3. Click "Richscape Options"
4. Edit the fields (including Zalo URL)
5. Save changes

**Direct URL:**
```
https://richscape.vn/wp-admin/admin.php?page=richscape-options
```

---

## ✅ Verification

### Form Submission Results:
```
✅ All 16 options updated successfully!
  ✅ company_name_full: Updated
  ✅ company_name_abbr: Updated
  ✅ company_name_intl: Updated
  ✅ company_tax_id: Updated
  ✅ contact_phone: Updated
  ✅ contact_email: Updated
  ✅ contact_address: Updated
  ✅ map_lat: Updated
  ✅ map_lng: Updated
  ✅ social_zalo_url: Updated ⭐
  ✅ social_messenger_url: Updated
  ✅ about_tagline_en: Updated
  ✅ about_intro_vi: Updated
  ✅ vision_text: Updated
  ✅ mission_text: Updated
  ✅ footer_copyright: Updated
```

---

## 🎯 Result on Frontend

The Zalo URL saved on line 12 is now active on your website:
- **Location:** Footer section (bottom right)
- **Element:** Green Zalo button
- **Link Target:** `https://zalo.me/0937430701`
- **Action:** Users can click to message via Zalo

---

## 📝 Field Group Definition (functions.php)

The ACF field is defined in `functions.php` lines 867-918:

```php
array( 'key' => 'field_social_zalo_url', 'label' => 'Zalo URL', 'name' => 'social_zalo_url', 'type' => 'url' ),
```

**Field Configuration:**
- **Key:** `field_social_zalo_url`
- **Name:** `social_zalo_url` (used in get_field calls)
- **Label:** "Zalo URL"
- **Type:** URL (validates proper URL format)
- **Location:** Options Page - "richscape-options"
