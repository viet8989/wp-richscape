# Plan: Services Menu Item via WP-Admin

## Context

The user wants to navigate to the Services listing page from the site menu, managed through **WP-Admin → Appearance → Menus**. No plugin is needed — WordPress natively supports adding CPT archive links to menus. The `services` CPT already has `has_archive: true` and `show_in_nav_menus: true`, so it will appear in the menu builder automatically.

Four things are missing:
1. The demo menu import uses `#services` (hash anchor) instead of the real archive URL — needs fixing so the initial import points to `/services/`.
2. There is no `archive-services.php` template — visiting `/services/` currently falls back to `index.php` with a generic loop.
3. Imported posts have no featured images — must be set manually via WP Admin.
4. `template-parts/content-service-card.php` is an empty placeholder — the service card markup lives inline in `front-page.php` and needs to be extracted here so both `front-page.php` and `archive-services.php` can reuse it.

## What to do

### 1. Fix demo menu import (`inc/import-data.php`, line ~102)

Change the "DỊCH VỤ" menu item URL from `#services` to the real archive link:

```php
// Before
'DỊCH VỤ' => '#services',

// After
'DỊCH VỤ' => get_post_type_archive_link( 'services' ),
```

### 2. Populate `template-parts/content-service-card.php`

Extract the service card markup from `front-page.php` (lines ~122–164) into `template-parts/content-service-card.php`. The card receives `$post` and `$count` (card number) from the loop and renders: gradient background, numbered badge, icon, title, description, photo image, and "DỰ ÁN LIÊN QUAN" CTA button.

Update `front-page.php` to call `get_template_part( 'template-parts/content-service-card' )` instead of inline HTML.

### 3. Create `archive-services.php`

New file: `wp-content/themes/richscape/archive-services.php`

Display all services in a 4-column horizontal grid (matching the front-page design). Uses `get_template_part( 'template-parts/content-service-card' )` for each card — no duplicated markup.

Structure:
- `get_header()`
- Page title "DỊCH VỤ" with teal underline
- `WP_Query` for all published `services` posts ordered by `menu_order`
- Responsive grid (1 col mobile → 2 col tablet → 4 col desktop) via `get_template_part()`
- `get_footer()`

### 4. Set featured images via WP Admin

For each imported service post, go to **WP Admin → Services → edit post → Featured Image** (bottom-right metabox) → upload or select an image → **Set featured image** → **Update**.

The theme already checks `has_post_thumbnail()` and falls back to an Unsplash placeholder only when no featured image is set.

### 5. No plugin needed

WordPress's built-in **Appearance → Menus** shows CPT archives under "Custom Post Types" once `show_in_nav_menus: true` is set (already done). The user can add/reorder menu items there at any time.

## Critical files

| File | Action |
|------|--------|
| `wp-content/themes/richscape/inc/import-data.php` | Update `#services` URL → archive link (line ~102) |
| `wp-content/themes/richscape/template-parts/content-service-card.php` | Populate with service card markup extracted from `front-page.php` |
| `wp-content/themes/richscape/front-page.php` | Replace inline service card HTML with `get_template_part()` call |
| `wp-content/themes/richscape/archive-services.php` | Create new archive template using `get_template_part()` |

## Verification

1. Delete the `richscape_demo_imported` option (WP-CLI: `wp option delete richscape_demo_imported`) and visit any admin page to re-run the import — confirm "DỊCH VỤ" in the menu now links to `/services/`.
2. Visit `/services/` — should render the new archive template with service cards.
3. In WP-Admin → Appearance → Menus, confirm "Services Archive" appears under the CPT panel and can be added/managed freely.
4. For each service post: **WP Admin → Services → edit → Featured Image → upload → Set featured image → Update**. Confirm the real image replaces the Unsplash placeholder on the front page and archive.
