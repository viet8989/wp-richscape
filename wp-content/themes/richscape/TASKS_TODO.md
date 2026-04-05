# TASKS_TODO.md — Richscape Implementation Checklist

Thực hiện tuần tự. Mỗi task đánh dấu `[x]` khi hoàn thành.  
**Legend:** 🖥️ Code · 🌐 Chrome/WP-Admin · 🏗️ Build/Deploy

> **Nguyên tắc:** Mọi text và ảnh đều đọc từ WP Admin (ACF Options, ACF fields, CPT, WP posts). Không hardcode nội dung trong PHP template.

---

## PHASE 0 — ACF Setup: Nền tảng dữ liệu động

*Phải làm trước tất cả, vì mọi template đều phụ thuộc vào các field này.*

---

### TASK 01 🖥️ — Đăng ký ACF Options Page trong `functions.php`

Thêm vào `functions.php` sau phần `richscape_setup`:

```php
/* ============================================================
   ACF Options Page
   ============================================================ */
add_action('acf/init', function() {
    if (!function_exists('acf_add_options_page')) return;
    acf_add_options_page([
        'page_title' => 'Richscape Options',
        'menu_title' => 'Richscape Options',
        'menu_slug'  => 'richscape-options',
        'capability' => 'manage_options',
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 2,
        'redirect'   => false,
    ]);
});
```

- [x] Thêm xong, save `functions.php`
- [x] Kiểm tra WP Admin → thấy "Richscape Options" trong sidebar

---

### TASK 02 🖥️ — Đăng ký ACF field group: Options Page (site-wide)

Thêm vào `functions.php` trong `acf/init` action (hoặc tạo file riêng `inc/acf-fields.php` và `require_once` trong functions.php):

```php
/* ============================================================
   ACF Field Group – Richscape Options Page
   ============================================================ */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'   => 'group_richscape_options',
        'title' => 'Richscape Site Options',
        'fields' => [
            // --- Logos ---
            ['key'=>'field_logo_header',         'label'=>'Logo Header',             'name'=>'logo_header',         'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail'],
            ['key'=>'field_logo_footer',         'label'=>'Logo Footer',             'name'=>'logo_footer',         'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail'],
            // --- Company Info ---
            ['key'=>'field_company_name_full',   'label'=>'Tên đầy đủ',              'name'=>'company_name_full',   'type'=>'text'],
            ['key'=>'field_company_name_abbr',   'label'=>'Tên viết tắt',            'name'=>'company_name_abbr',   'type'=>'text'],
            ['key'=>'field_company_name_intl',   'label'=>'Tên quốc tế',             'name'=>'company_name_intl',   'type'=>'text'],
            ['key'=>'field_company_tax_id',      'label'=>'Mã số thuế',              'name'=>'company_tax_id',      'type'=>'text'],
            // --- Contact ---
            ['key'=>'field_contact_phone',       'label'=>'Điện thoại',              'name'=>'contact_phone',       'type'=>'text'],
            ['key'=>'field_contact_email',       'label'=>'Email',                   'name'=>'contact_email',       'type'=>'email'],
            ['key'=>'field_contact_address',     'label'=>'Địa chỉ',                 'name'=>'contact_address',     'type'=>'textarea', 'rows'=>2],
            // --- Social ---
            ['key'=>'field_social_zalo_url',     'label'=>'Zalo URL',                'name'=>'social_zalo_url',     'type'=>'url'],
            ['key'=>'field_social_messenger_url','label'=>'Messenger URL',           'name'=>'social_messenger_url','type'=>'url'],
            // --- About Card ---
            ['key'=>'field_about_tagline_en',    'label'=>'English Tagline',         'name'=>'about_tagline_en',    'type'=>'text'],
            ['key'=>'field_about_intro_vi',      'label'=>'Vietnamese Intro',        'name'=>'about_intro_vi',      'type'=>'textarea', 'rows'=>3],
            // --- Vision & Mission ---
            ['key'=>'field_vision_text',         'label'=>'Tầm Nhìn',               'name'=>'vision_text',         'type'=>'textarea', 'rows'=>4],
            ['key'=>'field_mission_text',        'label'=>'Sứ Mệnh',                'name'=>'mission_text',        'type'=>'textarea', 'rows'=>4],
            // --- Core Values (repeater) ---
            ['key'=>'field_core_values', 'label'=>'Giá Trị Cốt Lõi', 'name'=>'core_values', 'type'=>'repeater',
             'min'=>1, 'max'=>10, 'layout'=>'block', 'button_label'=>'Thêm giá trị',
             'sub_fields'=>[
                ['key'=>'field_cv_title',       'label'=>'Tên giá trị', 'name'=>'cv_title',       'type'=>'text',     'required'=>1],
                ['key'=>'field_cv_description', 'label'=>'Mô tả',       'name'=>'cv_description', 'type'=>'textarea', 'rows'=>2],
            ]],
            // --- Trusted By (repeater) ---
            ['key'=>'field_trusted_by', 'label'=>'Đối Tác Tin Tưởng', 'name'=>'trusted_by', 'type'=>'repeater',
             'min'=>1, 'layout'=>'block', 'button_label'=>'Thêm đối tác',
             'sub_fields'=>[
                ['key'=>'field_partner_logo', 'label'=>'Logo',         'name'=>'partner_logo', 'type'=>'image',  'return_format'=>'array', 'preview_size'=>'thumbnail'],
                ['key'=>'field_partner_name', 'label'=>'Tên đối tác', 'name'=>'partner_name', 'type'=>'text'],
            ]],
            // --- Footer ---
            ['key'=>'field_footer_copyright', 'label'=>'Copyright Text', 'name'=>'footer_copyright', 'type'=>'text',
             'placeholder'=>'© 2025 Richscape. All rights reserved.'],
        ],
        'location' => [[['param'=>'options_page','operator'=>'==','value'=>'richscape-options']]],
    ]);
});
```

- [x] Thêm xong, save
- [x] WP Admin → Richscape Options → thấy đủ các fields

---

### TASK 03 🖥️ — Đăng ký ACF field group: About Page

```php
/* ============================================================
   ACF Field Group – About Page (ve-chung-toi)
   ============================================================ */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'   => 'group_about_page',
        'title' => 'Thông Tin Đội Ngũ',
        'fields' => [
            // Leaders repeater
            ['key'=>'field_leaders', 'label'=>'Lãnh Đạo', 'name'=>'leaders', 'type'=>'repeater',
             'layout'=>'block', 'button_label'=>'Thêm lãnh đạo',
             'sub_fields'=>[
                ['key'=>'field_leader_name',       'label'=>'Họ tên',            'name'=>'leader_name',       'type'=>'text',     'required'=>1],
                ['key'=>'field_leader_title',      'label'=>'Chức danh',         'name'=>'leader_title',      'type'=>'text',     'required'=>1],
                ['key'=>'field_leader_bio',        'label'=>'Tiểu sử',           'name'=>'leader_bio',        'type'=>'textarea', 'rows'=>3],
                ['key'=>'field_leader_portrait',   'label'=>'Ảnh chân dung',     'name'=>'leader_portrait',   'type'=>'image',    'return_format'=>'array', 'preview_size'=>'thumbnail'],
                ['key'=>'field_leader_bg_photo',   'label'=>'Ảnh nền (landscape)','name'=>'leader_bg_photo', 'type'=>'image',    'return_format'=>'array', 'preview_size'=>'medium'],
            ]],
            // Members repeater
            ['key'=>'field_members', 'label'=>'Thành Viên', 'name'=>'members', 'type'=>'repeater',
             'layout'=>'block', 'button_label'=>'Thêm thành viên',
             'sub_fields'=>[
                ['key'=>'field_member_name',     'label'=>'Họ tên',    'name'=>'member_name',     'type'=>'text',     'required'=>1],
                ['key'=>'field_member_title',    'label'=>'Chức danh', 'name'=>'member_title',    'type'=>'text',     'required'=>1],
                ['key'=>'field_member_bio',      'label'=>'Tiểu sử',   'name'=>'member_bio',      'type'=>'textarea', 'rows'=>3],
                ['key'=>'field_member_portrait', 'label'=>'Ảnh',       'name'=>'member_portrait', 'type'=>'image',    'return_format'=>'array', 'preview_size'=>'thumbnail'],
            ]],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-about.php']]],
    ]);
});
```

- [x] Thêm xong, save

---

### TASK 04 🖥️ — Đăng ký ACF field group: Services CPT

```php
/* ============================================================
   ACF Field Group – Services CPT
   ============================================================ */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'   => 'group_services_meta',
        'title' => 'Chi Tiết Dịch Vụ',
        'fields' => [
            ['key'=>'field_service_icon', 'label'=>'Biểu tượng (icon)', 'name'=>'service_icon',
             'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail',
             'instructions'=>'Upload icon SVG hoặc PNG nền trong suốt, 60×60px'],
            ['key'=>'field_service_sub_images', 'label'=>'Ảnh chi tiết (2×2 grid)', 'name'=>'service_sub_images',
             'type'=>'repeater', 'min'=>0, 'max'=>8, 'layout'=>'block', 'button_label'=>'Thêm ảnh',
             'sub_fields'=>[
                ['key'=>'field_sub_image',   'label'=>'Ảnh',     'name'=>'sub_image',   'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail', 'required'=>1],
                ['key'=>'field_sub_caption', 'label'=>'Caption', 'name'=>'sub_caption', 'type'=>'text'],
            ]],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'services']]],
    ]);
});
```

- [x] Thêm xong, save
- [x] WP Admin → Services → edit → thấy fields

---

### TASK 05 🖥️ — Đăng ký ACF field group: Projects CPT

```php
/* ============================================================
   ACF Field Group – Projects CPT
   ============================================================ */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'   => 'group_projects_meta',
        'title' => 'Thông Tin Dự Án',
        'fields' => [
            ['key'=>'field_project_client',       'label'=>'Chủ đầu tư',            'name'=>'project_client',       'type'=>'text'],
            ['key'=>'field_project_area_total',   'label'=>'Quy mô tổng thể (m²)',  'name'=>'project_area_total',   'type'=>'text'],
            ['key'=>'field_project_area_green',   'label'=>'Diện tích phủ xanh (m²)','name'=>'project_area_green', 'type'=>'text'],
            ['key'=>'field_project_scope',        'label'=>'Phạm vi thực hiện',      'name'=>'project_scope',        'type'=>'text'],
            ['key'=>'field_project_address',      'label'=>'Địa chỉ dự án',          'name'=>'project_address',      'type'=>'text'],
            ['key'=>'field_project_category_tag', 'label'=>'Loại dịch vụ',           'name'=>'project_category_tag', 'type'=>'text'],
            ['key'=>'field_project_gallery',      'label'=>'Thư viện ảnh dự án',     'name'=>'project_gallery',      'type'=>'gallery', 'return_format'=>'array', 'preview_size'=>'medium'],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'projects']]],
    ]);
});
```

- [x] Thêm xong, save
- [x] WP Admin → Projects → edit → thấy fields

---

### TASK 06 🖥️ — Đăng ký ACF field group: Contact Page

```php
/* ============================================================
   ACF Field Group – Contact Page
   ============================================================ */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'   => 'group_contact_page',
        'title' => 'Bản Đồ Google',
        'fields' => [
            ['key'=>'field_maps_embed_url', 'label'=>'Google Maps Embed URL', 'name'=>'maps_embed_url',
             'type'=>'text', 'instructions'=>'Paste src URL từ Google Maps → Share → Embed a map → copy URL trong src="..."'],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-contact.php']]],
    ]);
});
```

- [x] Thêm xong, save

---

## PHASE 1 — Sửa shared components

### TASK 07 🖥️ — Sửa `header.php`: logo động từ ACF Options

Thay đoạn hardcode logo:
```php
// Before
<img ... src="/wp-content/uploads/logo.png" alt="Richscape">

// After
<?php
$logo = get_field('logo_header', 'option');
$logo_url = $logo ? $logo['url'] : get_template_directory_uri() . '/assets/images/logo-fallback.png';
$logo_alt = $logo ? ($logo['alt'] ?: 'Richscape') : 'Richscape';
?>
<img class="_7_i_XA h-14 w-auto drop-shadow-sm" src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>">
```

- [x] Sửa xong, logo đọc từ ACF Options (fallback: file tĩnh nếu chưa set)

---

### TASK 08 🖥️ — Sửa `footer.php`: toàn bộ text/ảnh/links động

**8a. Sửa gradient** (line 4):
```php
// Before: bg-gradient-to-b from-teal to-darkblue
// After:  bg-gradient-to-r from-darkblue to-teal
```

**8b. Logo footer:**
```php
<?php $logo_f = get_field('logo_footer', 'option'); ?>
<img class="_7_i_XA h-28 w-auto rounded-xl p-4"
     src="<?php echo esc_url($logo_f ? $logo_f['url'] : '/wp-content/uploads/logo_footer.png'); ?>"
     alt="Richscape">
```

**8c. Company info col 1:**
```php
<?php
$name_full = get_field('company_name_full', 'option') ?: 'CÔNG TY TNHH THIẾT KẾ & THI CÔNG CẢNH QUAN RICHSCAPE';
$name_abbr = get_field('company_name_abbr', 'option') ?: 'RS LDB CO.,LTD';
$name_intl = get_field('company_name_intl', 'option') ?: 'RICHSCAPE LANDSCAPE DESIGN & BUILD COMPANY LIMITED';
$tax_id    = get_field('company_tax_id',    'option') ?: '0316356108';
?>
<p><strong><?php echo esc_html($name_full); ?></strong></p>
<p><strong>Tên viết tắt:</strong> <?php echo esc_html($name_abbr); ?></p>
<p><strong>Tên quốc tế:</strong> <?php echo esc_html($name_intl); ?></p>
<p><strong>Mã số thuế:</strong> <?php echo esc_html($tax_id); ?></p>
```

**8d. Contact info col 3:**
```php
<?php
$phone   = get_field('contact_phone',   'option') ?: '0937 430 701';
$email   = get_field('contact_email',   'option') ?: 'Khanhbui@Richscape.vn';
$address = get_field('contact_address', 'option') ?: '13/3A, Đường 15, Bình Trưng Tây, TP. HCM';
?>
<li>... <span><?php echo esc_html($phone); ?></span></li>
<li>... <span><?php echo esc_html($email); ?></span></li>
<li>... <span><?php echo esc_html($address); ?></span></li>
```

**8e. Floating buttons 3 cái đúng:**
```php
<?php
$zalo_url      = get_field('social_zalo_url',      'option') ?: '#';
$messenger_url = get_field('social_messenger_url', 'option') ?: '#';
?>
<div class="fixed right-6 bottom-24 flex flex-col space-y-4 z-50">
    <!-- Zalo -->
    <a href="<?php echo esc_url($zalo_url); ?>" target="_blank"
       class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-colors"
       title="Zalo">
        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="white">
            <path d="M12.49 10.272v-.45h2.706v.9H13.39v.57h1.806v.9H13.39v.598h1.806v.9H12.49V10.272zm-1.977 3.42l-1.36-2.47v2.47H8.246v-3.42h1.035l1.343 2.437v-2.437h.907v3.42h-.991zm-3.33 0H6.276v-3.42h.907v3.42zm9.56-7.2H7.267A5.267 5.267 0 002 11.76v.009A5.267 5.267 0 007.267 17.036h.26v2.44l2.43-2.44h2.786A5.267 5.267 0 0018 11.769v-.009a5.267 5.267 0 00-5.267-5.267z"/>
        </svg>
    </a>
    <!-- Phone -->
    <a href="tel:<?php echo esc_attr(get_field('contact_phone', 'option') ?: '0937430701'); ?>"
       class="w-12 h-12 rounded-full flex items-center justify-center text-white shadow-lg hover:opacity-80 transition-opacity"
       style="background-color:#2A9D8F;" title="Gọi điện">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
    </a>
    <!-- Messenger -->
    <a href="<?php echo esc_url($messenger_url); ?>" target="_blank"
       class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-lg hover:bg-blue-600 transition-colors"
       title="Messenger">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.145 2 11.25c0 2.895 1.48 5.485 3.795 7.155.235.17.375.445.365.74l-.175 2.145c-.06.745.71 1.255 1.345.89l2.42-1.395c.23-.13.505-.175.76-.135 1.05.175 2.16.27 3.32.27 5.523 0 10-4.145 10-9.25S17.523 2 12 2z"/></svg>
    </a>
</div>
```

**8f. Copyright:**
```php
<?php $copyright = get_field('footer_copyright', 'option') ?: '&copy; ' . date('Y') . ' Richscape. All rights reserved.'; ?>
<p><?php echo wp_kses_post($copyright); ?></p>
```

- [x] Gradient horizontal đúng
- [x] Logo, company info, contact info đọc từ ACF Options
- [x] 3 floating buttons đúng icon, màu, URL từ Options
- [x] Copyright từ Options

---

### TASK 09 🖥️ — Tạo `template-parts/section-vision-mission.php` (dynamic)

Đọc tất cả từ ACF Options:

```php
<?php
$vision      = get_field('vision_text',  'option');
$mission     = get_field('mission_text', 'option');
$core_values = get_field('core_values',  'option'); // repeater array
?>
<section class="py-20 bg-darkblue text-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Left: Vision & Mission -->
            <div class="space-y-12">
                <div>
                    <h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4">Tầm nhìn</h2>
                    <p class="text-gray-300 font-body leading-relaxed">
                        <?php echo nl2br(esc_html($vision ?: 'Trở thành công ty thiết kế và thi công cảnh quan hàng đầu tại Việt Nam...')); ?>
                    </p>
                </div>
                <div>
                    <h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4">Sứ mệnh</h2>
                    <p class="text-gray-300 font-body leading-relaxed">
                        <?php echo nl2br(esc_html($mission ?: 'Cam kết cung cấp dịch vụ chuyên nghiệp, sáng tạo và chất lượng vượt trội...')); ?>
                    </p>
                </div>
            </div>

            <!-- Right: Core Values -->
            <div>
                <h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-8">Giá Trị Cốt Lõi</h2>
                <?php if ($core_values): ?>
                    <!-- Row 1: first 3 items -->
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <?php foreach(array_slice($core_values, 0, 3) as $i => $cv): ?>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full border-2 border-teal text-teal flex items-center justify-center font-bold text-sm mr-3 mt-1"><?php echo $i+1; ?></div>
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wide mb-1"><?php echo esc_html($cv['cv_title']); ?></h3>
                                <p class="text-gray-400 font-body text-xs"><?php echo esc_html($cv['cv_description']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Row 2: remaining items centered -->
                    <?php $remaining = array_slice($core_values, 3); if($remaining): ?>
                    <div class="grid gap-4 max-w-[66%] mx-auto" style="grid-template-columns: repeat(<?php echo min(count($remaining),3); ?>, 1fr);">
                        <?php foreach($remaining as $j => $cv): ?>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full border-2 border-teal text-teal flex items-center justify-center font-bold text-sm mr-3 mt-1"><?php echo $j+4; ?></div>
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wide mb-1"><?php echo esc_html($cv['cv_title']); ?></h3>
                                <p class="text-gray-400 font-body text-xs"><?php echo esc_html($cv['cv_description']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
```

Cập nhật `front-page.php`: thay toàn bộ block section cũ (lines 10–59) bằng:
```php
<?php get_template_part('template-parts/section-vision-mission'); ?>
```

- [x] File tạo xong, đọc từ ACF Options
- [x] `front-page.php` dùng `get_template_part()`
- [x] Layout 3+2 grid hiển thị đúng

---

### TASK 10 🖥️ — Tạo `template-parts/content-service-card.php` (dynamic)

Extract từ `front-page.php` lines ~122–164, dùng ACF field `service_icon` thay meta cũ:

```php
<?php
// Expects: in WP_Query loop. $count passed via set_query_var('card_count', $n)
$count    = get_query_var('card_count', 1);
$img_url  = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : '';
$icon     = get_field('service_icon'); // ACF image field
$icon_url = $icon ? $icon['url'] : '';
$icon_alt = $icon ? ($icon['alt'] ?: get_the_title()) : '';
$desc     = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 25);
?>
<div class="group relative overflow-hidden flex flex-col border border-white/20 transition-transform duration-300 hover:-translate-y-1"
     style="background:linear-gradient(135deg,#1A2251 0%,#2A9D8F 100%);min-height:500px;border-radius:28px;">
    <!-- Title + Icon + Number -->
    <div class="relative pt-6 px-5 pb-3">
        <div class="flex items-start">
            <h3 class="flex-1 text-white font-sans font-bold uppercase text-2xl leading-tight" style="min-height:90px;padding-right:56px;">
                <?php the_title(); ?>
            </h3>
            <?php if($icon_url): ?>
            <div class="absolute" style="top:24px;right:52px;width:44px;">
                <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" style="width:44px;height:auto;object-fit:contain;opacity:0.9;">
            </div>
            <?php endif; ?>
            <div class="absolute" style="top:12px;right:16px;">
                <span class="font-serif leading-none font-normal" style="font-size:52px;color:#2A9D8F;line-height:1;"><?php echo $count; ?></span>
            </div>
        </div>
    </div>
    <!-- Description -->
    <div class="px-5 pb-4">
        <p class="text-white/80 font-body text-sm leading-relaxed"><?php echo esc_html($desc); ?></p>
    </div>
    <!-- Photo -->
    <div class="mx-2 mb-1 rounded-2xl overflow-hidden flex-grow" style="min-height:240px;">
        <?php if($img_url): ?>
        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>"
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        <?php endif; ?>
    </div>
    <!-- CTA -->
    <div class="flex justify-center py-4">
        <a href="<?php the_permalink(); ?>"
           class="font-sans font-bold text-xs uppercase tracking-widest px-6 py-2 rounded-full hover:opacity-80 transition-opacity"
           style="background-color:#2A9D8F;color:#1A2251;text-decoration:underline;">
            DỰ ÁN LIÊN QUAN
        </a>
    </div>
</div>
```

Cập nhật `front-page.php`: xóa cả 2 inline card blocks (WP loop + mock), thay bằng:
```php
if ($services_query->have_posts()):
    $count = 1;
    while ($services_query->have_posts()): $services_query->the_post();
        set_query_var('card_count', $count);
        get_template_part('template-parts/content-service-card');
        $count++;
    endwhile;
    wp_reset_postdata();
endif;
```

- [ ] File tạo xong
- [x] `front-page.php` dùng `get_template_part()`
- [x] Icon đọc từ ACF field `service_icon`

---

### TASK 11 🖥️ — Tạo `template-parts/project-item.php` (dynamic)

Extract từ `front-page.php` lines ~248–260:

```php
<?php
$img_url = has_post_thumbnail()
    ? get_the_post_thumbnail_url(get_the_ID(), 'large')
    : 'https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=800&auto=format&fit=crop';
?>
<div class="group relative rounded-2xl overflow-hidden shadow-xl aspect-[4/3] md:aspect-[16/9] bg-darkblue cursor-pointer">
    <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>"
         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-90 group-hover:opacity-100">
    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/90 to-transparent"></div>
    <div class="absolute bottom-6 left-6 right-6">
        <h3 class="text-2xl md:text-3xl font-black uppercase text-white tracking-wide"><?php the_title(); ?></h3>
        <a href="<?php the_permalink(); ?>"
           class="inline-flex mt-3 text-teal items-center font-bold text-sm uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
            Xem Dự Án <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</div>
```

Cập nhật `front-page.php`: xóa inline project card HTML, thay bằng:
```php
while ($projects_query->have_posts()): $projects_query->the_post();
    get_template_part('template-parts/project-item');
endwhile;
```

- [ ] File tạo xong
- [x] `front-page.php` dùng `get_template_part()`

---

### TASK 12 🖥️ — Tạo `template-parts/section-hero-banner.php`

```php
<?php $hero = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
<div class="w-full relative overflow-hidden" style="height:130px;">
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image:url('<?php echo esc_url($hero); ?>');">
        <div class="absolute inset-0 bg-darkblue/60"></div>
    </div>
</div>
```

- [ ] File tạo xong

---

### TASK 13 🖥️ — Tạo `template-parts/section-breadcrumb.php`

```php
<?php $crumbs = get_query_var('breadcrumbs', []); if(empty($crumbs)) return; ?>
<div class="bg-gray-100 py-2 px-4">
    <div class="max-w-7xl mx-auto text-xs uppercase tracking-widest text-gray-500 flex flex-wrap gap-1 items-center">
        <?php foreach($crumbs as $i => $crumb):
            $is_last = ($i === count($crumbs)-1); ?>
            <?php if(!$is_last): ?>
                <a href="<?php echo esc_url($crumb['url']); ?>" class="hover:text-teal"><?php echo esc_html($crumb['label']); ?></a>
                <span class="text-gray-300">/</span>
            <?php else: ?>
                <span class="text-teal"><?php echo esc_html($crumb['label']); ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
```

- [ ] File tạo xong

---

### TASK 14 🖥️ — Sửa `front-page.php`: Services section title + bỏ mock fallback

**Services title** (lines ~63–69) — đổi `text-center` → left-aligned + teal underline:
```php
<div class="mb-16">
    <h2 class="text-teal font-bold uppercase text-3xl md:text-4xl inline-block border-b-2 border-teal pb-1">
        DỊCH VỤ
    </h2>
</div>
```

**Bỏ mock services fallback** — khi CPT rỗng thì không show, thay bằng empty state:
```php
else:
    echo '<p class="text-gray-400 col-span-4 text-center py-12">Chưa có dịch vụ nào. Vui lòng thêm tại WP Admin → Services.</p>';
```

**Bỏ mock projects fallback** — tương tự:
```php
else:
    echo '<p class="text-gray-400 col-span-2 text-center py-12">Chưa có dự án nào.</p>';
```

- [x] Services title: left-aligned + teal underline
- [x] Không còn mock hardcoded data

---

### TASK 15 🖥️ — Sửa `inc/import-data.php`: menu URLs + thêm demo data

**15a. Menu URLs:**
```php
$menu_items = [
    'TRANG CHỦ'           => home_url('/'),
    'VỀ CHÚNG TÔI'        => home_url('/ve-chung-toi/'),
    'DỊCH VỤ'             => get_post_type_archive_link('services') ?: home_url('/services/'),
    'DỰ ÁN TIÊU BIỂU'    => get_post_type_archive_link('projects') ?: home_url('/projects/'),
    'THÔNG TIN - BẢN TIN' => home_url('/thong-tin-ban-tin/'),
    'LIÊN HỆ'             => home_url('/lien-he/'),
];
```

**15b. Thêm 5 demo projects còn thiếu** (sau `$projects_data` array):
```php
$projects_data = array_merge($projects_data, [
    ['title'=>'HAPPY HOME PARK',     'content'=>'...', 'excerpt'=>'...'],
    ['title'=>'MVILLAGE - HỘI AN',   'content'=>'...', 'excerpt'=>'...'],
    ['title'=>'JAPAN GARDEN',        'content'=>'...', 'excerpt'=>'...'],
    ['title'=>'EMPIRE BALCONY',      'content'=>'...', 'excerpt'=>'...'],
    ['title'=>'VANLANG UNIVERSITY',  'content'=>'...', 'excerpt'=>'...'],
]);
```

**15c. Thêm 5 demo news posts:**
```php
$news_data = [
    ['title'=>'CÁC PHONG CÁCH CẢNH QUAN HIỆN ĐẠI',                'excerpt'=>'Khám phá các xu hướng thiết kế cảnh quan đang được ưa chuộng.'],
    ['title'=>'XU HƯỚNG KIẾN TRÚC CẢNH QUAN SAU COVID 19',         'excerpt'=>'Đại dịch thay đổi cách chúng ta nhìn nhận không gian xanh.'],
    ['title'=>'ĐIỀU GÌ CẦN QUAN TÂM KHI THI CÔNG TƯỜNG XANH',     'excerpt'=>'Tường xanh đòi hỏi kỹ thuật và vật liệu đặc thù để bền vững.'],
    ['title'=>'NHỮNG SAI LẦM KHI CHỌN CÂY CHO CẢNH QUAN VÙNG BIỂN','excerpt'=>'Muối và gió biển ảnh hưởng lớn đến sự phát triển của cây trồng.'],
    ['title'=>'CÁC LOẠI CÂY KHÔNG HOA NHƯNG RỰC RỠ CHO KHU VƯỜN', 'excerpt'=>'Cây lá màu sắc mang lại vẻ đẹp quanh năm mà không cần mùa hoa.'],
];
foreach($news_data as $i => $n) {
    wp_insert_post(['post_title'=>$n['title'],'post_excerpt'=>$n['excerpt'],
        'post_content'=>'<p>'.$n['excerpt'].'</p>','post_status'=>'publish',
        'post_type'=>'post','post_author'=>1,'menu_order'=>$i]);
}
```

- [x] Menu URLs đúng (không còn `#anchor`)
- [x] 9 projects trong import
- [x] 5 news posts trong import

---

## PHASE 2 — Tạo các trang mới

### TASK 16 🖥️ — Tạo `archive-services.php`

```php
<?php get_header(); ?>
<div class="pt-32 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-16">
        <h1 class="text-teal font-bold uppercase text-3xl md:text-4xl inline-block border-b-2 border-teal pb-1">
            DỊCH VỤ
        </h1>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php $count=1; if(have_posts()): while(have_posts()): the_post();
            set_query_var('card_count', $count);
            get_template_part('template-parts/content-service-card');
            $count++;
        endwhile; endif; ?>
    </div>
</div>
<?php get_footer(); ?>
```

- [x] File tạo xong, `/services/` render đúng

---

### TASK 17 🖥️ — Tạo `archive-projects.php`

```php
<?php get_header(); ?>
<div class="pt-32 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-16">
        <h1 class="text-teal font-bold uppercase text-3xl md:text-4xl inline-block border-b-2 border-teal pb-1">
            DỰ ÁN TIÊU BIỂU
        </h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php if(have_posts()): while(have_posts()): the_post();
            get_template_part('template-parts/project-item');
        endwhile; endif; ?>
    </div>
</div>
<?php get_footer(); ?>
```

- [x] File tạo xong, `/projects/` render đúng

---

### TASK 18 🖥️ — Tạo `page-about.php`

Mỗi section đọc từ ACF:
1. Page header: `VỀ CHÚNG TÔI` + teal underline (pt-32 dưới fixed header)
2. About Card: logo từ `logo_footer` option, tagline từ `about_tagline_en` option, intro từ `about_intro_vi` option
3. `<?php get_template_part('template-parts/section-vision-mission'); ?>`
4. LEADERS: `<?php $leaders = get_field('leaders'); if($leaders): foreach($leaders as $l): ?>` — render card
5. MEMBERS: `<?php $members = get_field('members'); if($members): foreach($members as $m): ?>` — render card
6. Trusted By: `<?php $trusted = get_field('trusted_by', 'option'); if($trusted): foreach($trusted as $p): ?>` — render logo grid

Template header của file:
```php
<?php
/*
 * Template Name: Page About
 */
get_header();
```

- [x] File tạo xong
- [x] Tất cả data đọc từ ACF (không có text nào hardcode)
- [ ] Hiển thị đúng khi có dữ liệu trong WP Admin

---

### TASK 19 🖥️ — Tạo `page-services.php`

Cấu trúc:
```php
<?php
/*
 * Template Name: Page Services
 */
get_header();
?>
<div class="pt-32 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <h1 class="text-teal font-bold uppercase text-3xl md:text-4xl inline-block border-b-2 border-teal pb-1">DỊCH VỤ</h1>
    </div>

    <?php
    $sq = new WP_Query(['post_type'=>'services','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
    if($sq->have_posts()):
        while($sq->have_posts()): $sq->the_post();
            $sub_images = get_field('service_sub_images'); // ACF repeater
    ?>
    <section class="py-16 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-teal font-bold uppercase text-2xl md:text-3xl inline-block border-b-2 border-teal pb-1 mb-6">
                <?php the_title(); ?>
            </h2>
            <p class="text-gray-600 mb-10 max-w-2xl"><?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(),30); ?></p>

            <?php if($sub_images): ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php foreach($sub_images as $si):
                    $img = $si['sub_image'];
                    $cap = $si['sub_caption']; ?>
                <div>
                    <div class="rounded-xl overflow-hidden aspect-square">
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($cap ?: $img['alt']); ?>"
                             class="w-full h-full object-cover">
                    </div>
                    <?php if($cap): ?>
                    <p class="text-teal text-xs font-bold uppercase text-center mt-2 tracking-widest"><?php echo esc_html($cap); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endwhile; wp_reset_postdata(); endif; ?>
</div>
<?php get_footer(); ?>
```

- [ ] File tạo xong, sub-images từ ACF

---

### TASK 20 🖥️ — Tạo `page-projects.php`

```php
<?php
/*
 * Template Name: Page Projects
 */
get_header();
$pq = new WP_Query(['post_type'=>'projects','posts_per_page'=>9,'orderby'=>'menu_order','order'=>'ASC']);
?>
<div class="pt-32 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-16">
        <h1 class="text-teal font-bold uppercase text-3xl md:text-4xl inline-block border-b-2 border-teal pb-1">DỰ ÁN TIÊU BIỂU</h1>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if($pq->have_posts()): while($pq->have_posts()): $pq->the_post();
            $img = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(),'large') : ''; ?>
        <div class="group relative rounded-2xl overflow-hidden shadow-lg aspect-square cursor-pointer">
            <?php if($img): ?>
            <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <?php endif; ?>
            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent"></div>
            <div class="absolute bottom-4 left-4 right-4">
                <a href="<?php the_permalink(); ?>"
                   class="text-teal font-bold uppercase text-sm tracking-widest hover:underline">
                    <?php the_title(); ?>
                </a>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
</div>
<?php get_footer(); ?>
```

- [ ] File tạo xong

---

### TASK 21 🖥️ — Tạo `single-projects.php`

Cấu trúc đầy đủ:
1. `get_header()`
2. Hero banner: `get_template_part('template-parts/section-hero-banner')`
3. Breadcrumb:
```php
set_query_var('breadcrumbs', [
    ['label'=>'TRANG CHỦ',       'url'=>home_url('/')],
    ['label'=>'DỰ ÁN',           'url'=>get_post_type_archive_link('projects')],
    ['label'=>strtoupper(get_the_title()), 'url'=>''],
]);
get_template_part('template-parts/section-breadcrumb');
```
4. View counter: `update_post_meta(get_the_ID(), '_project_views', (int)get_post_meta(get_the_ID(),'_project_views',true)+1);`
5. Two-column layout `grid-cols-5`:
   - **Left col-span-3:** title, meta (date + views), ACF fields block, `the_content()`, "LANDSCAPE CREATOR" watermark
   - **Right col-span-2:** darkblue box "Dự án liên quan" — query 4 other projects
6. Photo gallery: ACF `project_gallery` → 3-col masonry grid
7. `get_footer()`

- [x] File tạo xong
- [x] ACF fields hiển thị đúng
- [ ] Gallery render (cần ACF Pro)

---

### TASK 22 🖥️ — Tạo `page-news.php`

```php
<?php
/*
 * Template Name: Page News
 */
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$nq = new WP_Query(['post_type'=>'post','posts_per_page'=>10,'paged'=>$paged]);
?>
<div class="pt-32 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
        <h1 class="text-teal font-bold uppercase text-3xl md:text-4xl inline-block border-b-2 border-teal pb-1">THÔNG TIN - BẢN TIN</h1>
    </div>
    <?php if($nq->have_posts()): while($nq->have_posts()): $nq->the_post();
        $thumb = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(),'medium_large') : '';
        $views = (int)get_post_meta(get_the_ID(),'_post_views',true);
    ?>
    <div class="flex flex-col sm:flex-row gap-8 py-8 border-b border-gray-200">
        <?php if($thumb): ?>
        <div class="sm:w-2/5 rounded-xl overflow-hidden aspect-video flex-shrink-0">
            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
        </div>
        <?php endif; ?>
        <div class="sm:w-3/5">
            <a href="<?php the_permalink(); ?>" class="text-teal font-bold uppercase text-xl hover:underline leading-tight block mb-2">
                <?php the_title(); ?>
            </a>
            <p class="text-gray-400 text-xs mb-3 uppercase tracking-widest">
                <?php echo get_the_date('d/m/Y'); ?> · <?php echo $views; ?> lượt xem
            </p>
            <p class="text-gray-600 text-sm leading-relaxed"><?php the_excerpt(); ?></p>
        </div>
    </div>
    <?php endwhile;
    echo '<div class="mt-12">' . paginate_links(['total'=>$nq->max_num_pages]) . '</div>';
    wp_reset_postdata(); endif; ?>
</div>
<?php get_footer(); ?>
```

- [x] File tạo xong, pagination hoạt động

---

### TASK 23 🖥️ — Tạo `single-post.php`

Cấu trúc (tương tự `single-projects.php`):
1. `get_header()`
2. Hero banner
3. Breadcrumb: Trang Chủ / Thông Tin - Bản Tin / [Tên bài]
4. View counter increment cho `_post_views`
5. Two-column `grid-cols-5`:
   - **Left col-span-3:** title, meta, featured image full-width, `the_content()`, "LANDSCAPE CREATOR" watermark
   - **Right col-span-2:** "Bài viết liên quan" — darkblue box, 4 bài same category, XEM THÊM link
6. `get_footer()`

- [ ] File tạo xong

---

### TASK 24 🖥️ — Tạo `page-contact.php`

Đọc contact info từ ACF Options, map URL từ ACF on page:

```php
<?php
/*
 * Template Name: Page Contact
 */
get_header();
$phone   = get_field('contact_phone',   'option') ?: '0937 430 701';
$email   = get_field('contact_email',   'option') ?: 'Khanhbui@Richscape.vn';
$address = get_field('contact_address', 'option') ?: '13/3A, Đường 15, Bình Trưng Tây, TP. HCM';
$map_url = get_field('maps_embed_url'); // ACF on this page
?>
<div class="pt-32 pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-16">
        <!-- Contact info card (col-span-2) -->
        <div class="lg:col-span-2 rounded-2xl p-8 text-white space-y-6" style="background-color:#1A2251;">
            <h2 class="text-teal font-bold uppercase text-xl tracking-widest mb-6">Thông Tin Liên Hệ</h2>
            <div><p class="text-teal text-xs uppercase tracking-widest mb-1">ADDRESS</p><p class="text-gray-200 text-sm"><?php echo nl2br(esc_html($address)); ?></p></div>
            <div><p class="text-teal text-xs uppercase tracking-widest mb-1">PHONE</p><a href="tel:<?php echo esc_attr($phone); ?>" class="text-white text-sm hover:text-teal"><?php echo esc_html($phone); ?></a></div>
            <div><p class="text-teal text-xs uppercase tracking-widest mb-1">EMAIL</p><a href="mailto:<?php echo esc_attr($email); ?>" class="text-white text-sm hover:text-teal"><?php echo esc_html($email); ?></a></div>
        </div>
        <!-- Google Maps (col-span-3) -->
        <div class="lg:col-span-3 rounded-2xl overflow-hidden" style="min-height:400px;">
            <?php if($map_url): ?>
            <iframe src="<?php echo esc_url($map_url); ?>" width="100%" height="100%" style="border:0;min-height:400px;" allowfullscreen loading="lazy"></iframe>
            <?php else: ?>
            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm" style="min-height:400px;">
                Chưa có Google Maps. Vui lòng nhập URL tại WP Admin → Edit Contact page.
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="max-w-2xl mx-auto">
        <h2 class="text-teal font-bold uppercase text-xl tracking-widest mb-8 inline-block border-b-2 border-teal pb-1">GỬI TIN NHẮN CHO CHÚNG TÔI</h2>
        <?php
        // Handle form submission
        if(isset($_POST['richscape_contact_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['richscape_contact_nonce'])), 'richscape_contact_form')):
            $name    = sanitize_text_field(wp_unslash($_POST['cf_name']    ?? ''));
            $cf_email = sanitize_email(wp_unslash($_POST['cf_email']   ?? ''));
            $phone_f = sanitize_text_field(wp_unslash($_POST['cf_phone']   ?? ''));
            $message = sanitize_textarea_field(wp_unslash($_POST['cf_message'] ?? ''));
            $to      = get_field('contact_email', 'option') ?: get_option('admin_email');
            $subject = 'Liên hệ từ website Richscape - ' . $name;
            $body    = "Họ tên: $name\nEmail: $cf_email\nSĐT: $phone_f\n\nNội dung:\n$message";
            $sent    = wp_mail($to, $subject, $body);
            echo $sent
                ? '<div class="bg-teal/10 border border-teal text-teal rounded-xl px-6 py-4 mb-8">Cảm ơn bạn! Chúng tôi sẽ liên hệ sớm.</div>'
                : '<div class="bg-red-50 border border-red-300 text-red-600 rounded-xl px-6 py-4 mb-8">Có lỗi xảy ra. Vui lòng thử lại hoặc gửi email trực tiếp.</div>';
        endif; ?>
        <form method="post" class="space-y-6">
            <?php wp_nonce_field('richscape_contact_form', 'richscape_contact_nonce'); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <input type="text" name="cf_name" placeholder="Họ và tên *" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-teal">
                <input type="email" name="cf_email" placeholder="Email *" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-teal">
            </div>
            <input type="tel" name="cf_phone" placeholder="Số điện thoại" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-teal">
            <textarea name="cf_message" rows="5" placeholder="Nội dung *" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-teal resize-none"></textarea>
            <button type="submit" class="px-10 py-3 font-bold uppercase tracking-widest text-sm text-white rounded-full hover:opacity-80 transition-opacity" style="background-color:#2A9D8F;">
                GỬI
            </button>
        </form>
    </div>
</div>
<?php get_footer(); ?>
```

- [x] File tạo xong
- [x] Contact info đọc từ ACF Options
- [x] Map URL đọc từ ACF field trên page
- [x] Form gửi email qua `wp_mail()`

---

## PHASE 3 — Build CSS

### TASK 25 🏗️ — Build Tailwind + FTP deploy lần 1

```bash
cd wp-content/themes/richscape
npm run build
```

Upload lên Hostinger qua FTP: tất cả files đã sửa/tạo từ TASK 01–24 + `assets/css/tailwind.css`.

- [ ] Build thành công, không lỗi
- [ ] FTP upload hoàn tất

---

## PHASE 4 — WP Admin Data Entry (Chrome)

### TASK 26 🌐 — Reset demo import

**Chrome → WP Admin → phpMyAdmin / Hostinger DB panel:**
```sql
DELETE FROM wp_options WHERE option_name = 'richscape_demo_imported';
```
Sau đó vào bất kỳ trang WP Admin để trigger `admin_init`.

- [x] Option xóa
- [x] Visit WP Admin → kiểm tra: 4 Services, 9 Projects, 5 Posts đã tạo
- [x] WP Admin → Appearance → Menus → "Main menus" có 6 items URL đúng

---

### TASK 27 🌐 — WP Admin: Nhập dữ liệu vào Richscape Options

**Chrome → WP Admin → Richscape Options**

Điền lần lượt:

| Field | Giá trị |
|---|---|
| Logo Header | Upload logo.png từ Media Library |
| Logo Footer | Upload logo_footer.png từ Media Library |
| Tên đầy đủ | CÔNG TY TNHH THIẾT KẾ & THI CÔNG CẢNH QUAN RICHSCAPE |
| Tên viết tắt | RS LDB CO.,LTD |
| Tên quốc tế | RICHSCAPE LANDSCAPE DESIGN & BUILD COMPANY LIMITED |
| Mã số thuế | 0316356108 |
| Điện thoại | 0937 430 701 |
| Email | Khanhbui@Richscape.vn |
| Địa chỉ | 13/3A, Đường 15, Bình Trưng Tây, TP. HCM |
| Zalo URL | https://zalo.me/0937430701 |
| Messenger URL | https://m.me/richscape |
| English Tagline | As Landscape Creators, We Bring Your Green Visions To Life. |
| Vietnamese Intro | RICHSCAPE mang đến giải pháp thiết kế và thi công cảnh quan chuyên nghiệp – từ ý tưởng đến hiện thực. |
| Tầm Nhìn | Trở thành công ty thiết kế và thi công cảnh quan hàng đầu tại Việt Nam... |
| Sứ Mệnh | Cam kết cung cấp dịch vụ chuyên nghiệp, sáng tạo và chất lượng vượt trội... |
| Giá Trị Cốt Lõi | Thêm 5 rows: ĐỔI MỚI SÁNG TẠO, CHẤT LƯỢNG, TÔN TRỌNG THIÊN NHIÊN, KHÁCH HÀNG LÀ TRUNG TÂM, ĐÓNG GÓP CỘNG ĐỒNG |
| Đối Tác Tin Tưởng | Thêm 9 rows: upload logo + tên đối tác từng row |
| Copyright Text | © 2025 Richscape. All rights reserved. |

Click **Save Changes** sau khi điền xong.

- [ ] Tất cả fields đã điền + saved
- [ ] Kiểm tra footer trên live site: hiển thị đúng thông tin

---

### TASK 28 🌐 — WP Admin: Tạo 5 Pages với đúng template

**Chrome → WP Admin → Pages → Add New** (làm 5 lần):

| Tiêu đề | Slug | Template |
|---|---|---|
| Về Chúng Tôi | `ve-chung-toi` | Page About |
| Dịch Vụ | `dich-vu` | Page Services |
| Dự Án Tiêu Biểu | `du-an-tieu-bieu` | Page Projects |
| Thông Tin - Bản Tin | `thong-tin-ban-tin` | Page News |
| Liên Hệ | `lien-he` | Page Contact |

Mỗi page: Title → Page Attributes → Template → Permalink (slug) → **Publish**

- [x] 5 pages published với đúng slug và template

---

### TASK 29 🌐 — WP Admin: Nhập dữ liệu About page (leaders + members)

**Chrome → WP Admin → Pages → Về Chúng Tôi → Edit**

Kéo xuống section "Thông Tin Đội Ngũ":

**Leaders (2 rows):**
1. Bui Duy Khanh | MANAGING DIRECTOR | [bio] | [ảnh chân dung] | [ảnh nền]
2. Trang Thanh Hoang | VICE MANAGING DIRECTOR | [bio] | [ảnh chân dung] | [ảnh nền]

**Members (3 rows):**
1. Mr. Anthony | SENIOR ADVISOR | [bio] | [ảnh]
2. Truong Thanh Tuan | CONSTRUCTION MANAGER | [bio] | [ảnh]
3. Pham Dinh Hiep | HEAD OF GREEN MAINTENANCE | [bio] | [ảnh]

Click **Update**

- [ ] 2 Leaders với ảnh và bio
- [ ] 3 Members với ảnh và bio

---

### TASK 30 🌐 — WP Admin: Nhập Google Maps URL vào Contact page

**Chrome → WP Admin → Pages → Liên Hệ → Edit**

Bước lấy embed URL:
1. Vào Google Maps → tìm "13/3A Đường 15, Bình Trưng Tây, Thành phố Hồ Chí Minh"
2. Click **Share** → **Embed a map** → copy URL trong `src="..."` của iframe
3. Paste vào field "Google Maps Embed URL" trong trang Liên Hệ
4. Click **Update**

- [x] Map URL đã nhập
- [x] `/lien-he/` hiển thị bản đồ đúng địa chỉ

---

### TASK 31 🌐 — WP Admin: Nhập sub-images cho từng Service

**Chrome → WP Admin → Services**

Cho từng service (4 posts), click Edit:
1. Featured Image → Set featured image → Upload ảnh đại diện
2. Section "Chi Tiết Dịch Vụ" → "Ảnh chi tiết (2×2 grid)":
   - Thêm 4 rows, mỗi row: upload ảnh + điền caption

| Service | 4 Captions |
|---|---|
| THIẾT KẾ THI CÔNG CẢNH QUAN | MASTER PLAN · 3D CONCEPT · KHÁI TOÁN · HARDSCAPE & CÂY XANH |
| CHIẾU SÁNG & TƯỚI TỰ ĐỘNG | KỊCH BẢN CHIẾU SÁNG · LẮP ĐẶT CHIẾU SÁNG · HỆ TƯỚI TỰ ĐỘNG · THIẾT BỊ CHÍNH HÃNG |
| ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ ÂM | THÁC NƯỚC / ĐÀI PHUN · HỒ BƠI · HỒ SINH THÁI · HỒ JACUZZI |
| BẢO DƯỠNG CẢNH QUAN | CẮT TỈA & TẠO DÁNG · VỆ SINH CẢNH QUAN · BẢO TRÌ HỆ THỐNG BƠM · DINH DƯỠNG PHÒNG BỆNH |

3. Section "Chi Tiết Dịch Vụ" → "Biểu tượng (icon)": Upload icon PNG/SVG
4. Click **Update**

- [ ] 4 services đều có featured image + icon + 4 sub-images với captions

---

### TASK 32 🌐 — WP Admin: Nhập ACF fields + ảnh cho 9 Projects

**Chrome → WP Admin → Projects**

Cho từng project (9 posts):
1. Edit → Featured Image → Upload ảnh đại diện
2. Điền fields: Chủ đầu tư, Quy mô m², Diện tích phủ xanh m², Phạm vi, Địa chỉ, Loại dịch vụ
3. Gallery → Upload nhiều ảnh dự án (ít nhất 3 ảnh/project)
4. Post content → Viết mô tả dự án chi tiết
5. Click **Update**

- [ ] 9 projects đều có featured image
- [x] 9 projects có ACF fields đầy đủ (tất cả)
- [ ] Ít nhất 2 projects có gallery ảnh

---

### TASK 33 🌐 — WP Admin: Set featured images + viết nội dung cho 5 News posts

**Chrome → WP Admin → Posts**

Cho từng bài (5 posts):
1. Edit → Featured Image → Upload ảnh chủ đề
2. Bổ sung nội dung bài viết (thay placeholder)
3. Đảm bảo Excerpt đã điền
4. Click **Update**

- [ ] 5 posts đều có featured image và nội dung thực

---

### TASK 34 🌐 — WP Admin: Banner Slider — upload ảnh thực tế

**Chrome → WP Admin → Banner Slider**

1. Xóa placeholder slides
2. Thêm 3–5 slides mới: upload ảnh dự án thực tế + điền alt text
3. Click **Lưu Banner Slider**

- [ ] Slider dùng ảnh thực, không còn picsum.photos

---

### TASK 35 🌐 — WP Admin: Cập nhật Navigation Menu

**Chrome → WP Admin → Appearance → Menus**

1. Chọn "Main Navigation Demo"
2. Xác nhận 6 items có URL đúng (không có `#anchor`)
3. Nếu cần sửa: Custom Links → nhập URL mới → Save
4. Location: check "Primary Menu" → **Save Menu**

- [x] 6 menu items với URL thực
- [x] Menu assign vào "Primary" location

---

## PHASE 5 — Final Deploy & QA

### TASK 36 🏗️ — Final build + FTP upload

```bash
cd wp-content/themes/richscape
npm run build
```

FTP upload tất cả files đã thay đổi lên Hostinger.

- [ ] Build thành công
- [ ] Upload hoàn tất

---

### TASK 37 🌐 — Final QA Checklist

**Chrome → https://deepskyblue-alpaca-301704.hostingersite.com/**

**Shared:**
- [x] Header: logo từ WP Admin, nav 6 items, links đúng, mobile hamburger OK
- [x] Footer: gradient horizontal, company info dynamic, contact dynamic, 3 floating buttons đúng màu+URL

**Từng trang:**
- [x] `/` — Slider, Vision/Mission (dynamic), Services (từ CPT), Projects (từ CPT)
- [ ] `/ve-chung-toi/` — About card, Vision/Mission, Leaders, Members, Trusted By logos
- [ ] `/services/` — Archive grid 4 cards với icon từ ACF
- [ ] `/dich-vu/` — 4 service blocks với sub-images từ ACF
- [ ] `/projects/` — Archive grid, `/du-an-tieu-bieu/` → 3×3 grid
- [ ] `/[project-slug]/` — Hero, breadcrumb, 2-col, ACF fields, gallery
- [x] `/news/` — News listing với thumbnail + excerpt
- [x] `/[post-slug]/` — Article detail, breadcrumb, related articles
- [x] `/contact/` — Contact info từ Options, Map từ ACF, form gửi được

**Test dynamic update (chứng minh không hardcode):**
- [ ] Thay đổi phone number trong Richscape Options → refresh site → footer hiển thị số mới
- [ ] Thêm service mới tại WP Admin → Services → front page hiển thị (nếu ≤4)
- [ ] Thêm project mới tại WP Admin → Projects → archive page hiển thị

---

## Tóm tắt theo loại công việc

| Tasks | Loại | Mô tả |
|---|---|---|
| 01–06 | 🖥️ Code | ACF field groups (Options Page, About, Services, Projects, Contact) |
| 07–15 | 🖥️ Code | Sửa shared components (header, footer, template-parts, front-page, import-data) |
| 16–24 | 🖥️ Code | Tạo 9 PHP template files mới |
| 25 | 🏗️ Build | `npm run build` + FTP deploy lần 1 |
| 26–35 | 🌐 Chrome | WP Admin: reset, Options data, pages, About, Contact, Services, Projects, News, Banner, Menu |
| 36–37 | 🏗️+🌐 | Final build, FTP upload, QA + test dynamic update |

**Tổng: 37 tasks**
