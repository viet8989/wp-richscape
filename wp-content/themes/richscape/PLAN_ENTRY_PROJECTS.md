# Plan: Projects Menu Item via WP-Admin

## Context

The user wants to navigate to the Projects listing page from the site menu, managed through **WP-Admin → Appearance → Menus**. No plugin is needed — WordPress natively supports adding CPT archive links to menus. The `projects` CPT already has `has_archive: true` and `show_in_nav_menus: true`, so it will appear in the menu builder automatically.

Four things are missing:
1. The demo menu import uses `#projects` (hash anchor) instead of the real archive URL — needs fixing so the initial import points to `/projects/`.
2. There is no `archive-projects.php` template — visiting `/projects/` currently falls back to `index.php` with a generic loop.
3. Imported posts have no featured images — must be set manually via WP Admin.
4. `template-parts/project-item.php` is an empty placeholder — the project card markup lives inline in `front-page.php` and needs to be extracted here so both `front-page.php` and `archive-projects.php` can reuse it.

## What to do

### 1. Fix demo menu import (`inc/import-data.php`, line ~103)

Change the "DỰ ÁN TIÊU BIỂU" menu item URL from `#projects` to the real archive link:

```php
// Before
array( 'title' => 'DỰ ÁN TIÊU BIỂU', 'url' => '#projects' ),

// After
array( 'title' => 'DỰ ÁN TIÊU BIỂU', 'url' => get_post_type_archive_link( 'projects' ) ),
```

### 2. Populate `template-parts/project-item.php`

Extract the project card markup from `front-page.php` (lines ~248–260) into `template-parts/project-item.php`. The card receives `$post` from the loop and renders: featured image, gradient overlay, project name, and "Xem Dự Án" hover link.

Update `front-page.php` to call `get_template_part( 'template-parts/project-item' )` instead of inline HTML.

### 3. Create `archive-projects.php`

New file: `wp-content/themes/richscape/archive-projects.php`

Display all projects in a 2×2 grid (matching the front-page design). Uses `get_template_part( 'template-parts/project-item' )` for each card — no duplicated markup.

Structure:
- `get_header()`
- Page title "DỰ ÁN TIÊU BIỂU" with teal underline
- `WP_Query` for all published `projects` posts
- 2-column responsive grid via `get_template_part()`
- `get_footer()`

### 4. Set featured images via WP Admin

For each imported project post, go to **WP Admin → Projects → edit post → Featured Image** (bottom-right metabox) → upload or select an image → **Set featured image** → **Update**.

The theme already checks `has_post_thumbnail()` and falls back to an Unsplash placeholder only when no featured image is set.

### 5. No plugin needed

WordPress's built-in **Appearance → Menus** shows CPT archives under "Custom Post Types" once `show_in_nav_menus: true` is set (already done). The user can add/reorder menu items there at any time.

## Critical files

| File | Action |
|------|--------|
| `wp-content/themes/richscape/inc/import-data.php` | Update `#projects` URL → archive link (line ~103) |
| `wp-content/themes/richscape/template-parts/project-item.php` | Populate with project card markup extracted from `front-page.php` |
| `wp-content/themes/richscape/front-page.php` | Replace inline project card HTML with `get_template_part()` call |
| `wp-content/themes/richscape/archive-projects.php` | Create new archive template using `get_template_part()` |

## Verification

1. Delete the `richscape_demo_imported` option (WP-CLI: `wp option delete richscape_demo_imported`) and visit any admin page to re-run the import — confirm "DỰ ÁN TIÊU BIỂU" in the menu now links to `/projects/`.
2. Visit `/projects/` — should render the new archive template with project cards.
3. In WP-Admin → Appearance → Menus, confirm "Projects Archive" appears under the CPT panel and can be added/managed freely.
4. For each project post: **WP Admin → Projects → edit → Featured Image → upload → Set featured image → Update**. Confirm the real image replaces the Unsplash placeholder on the front page and archive.
