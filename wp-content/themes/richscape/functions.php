<?php
/**
 * Richscape Theme functions and definitions
 */

if ( ! function_exists( 'richscape_setup' ) ) :
	function richscape_setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register menus.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'richscape' ),
		) );
	}
endif;
add_action( 'after_setup_theme', 'richscape_setup' );

/**
 * Enqueue scripts and styles.
 */
function richscape_scripts() {
	// Enqueue main stylesheet.
	wp_enqueue_style( 'richscape-style', get_stylesheet_uri() );

	// Enqueue compiled Tailwind CSS.
	wp_enqueue_style( 'richscape-tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), '1.0.0' );

	// Enqueue banner slider assets (CSS + JS).
	wp_enqueue_style(
		'richscape-banner-slider',
		get_template_directory_uri() . '/assets/css/richscape-banner-slider.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/richscape-banner-slider.css' )
	);
	wp_enqueue_script(
		'richscape-banner-slider',
		get_template_directory_uri() . '/assets/js/richscape-banner-slider.js',
		array(), // no jQuery dependency
		filemtime( get_template_directory() . '/assets/js/richscape-banner-slider.js' ),
		true     // load in footer
	);
}
add_action( 'wp_enqueue_scripts', 'richscape_scripts' );

/**
 * Disable Gutenberg for projects and services CPTs so ACF fields
 * are fully accessible in Classic Editor.
 */
add_filter( 'use_block_editor_for_post_type', function( $use, $post_type ) {
	if ( in_array( $post_type, array( 'projects', 'services' ), true ) ) {
		return false;
	}
	return $use;
}, 10, 2 );

/* ============================================================
   Project Gallery – Custom Meta Box (replaces ACF Pro gallery)
   Stores attachment IDs in post meta key: _project_gallery_ids
   ============================================================ */

/**
 * Register the meta box.
 */
add_action( 'add_meta_boxes', function() {
	add_meta_box(
		'richscape_project_gallery',
		'Thư Viện Ảnh Dự Án',
		'richscape_project_gallery_meta_box',
		'projects',
		'normal',
		'default'
	);
} );

/**
 * Render the meta box HTML.
 */
function richscape_project_gallery_meta_box( $post ) {
	wp_nonce_field( 'richscape_save_gallery', 'richscape_gallery_nonce' );
	$ids = get_post_meta( $post->ID, '_project_gallery_ids', true );
	if ( ! is_array( $ids ) ) {
		$ids = $ids ? explode( ',', $ids ) : array();
	}
	?>
	<style>
	#richscape-gallery-wrap { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:12px; min-height:60px; }
	.richscape-gallery-thumb { position:relative; width:100px; height:80px; border:2px solid #ddd; border-radius:4px; overflow:hidden; cursor:move; }
	.richscape-gallery-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
	.richscape-gallery-thumb .remove-img { position:absolute; top:2px; right:2px; background:rgba(0,0,0,.65); color:#fff; border:none; border-radius:50%; width:20px; height:20px; font-size:14px; line-height:18px; text-align:center; cursor:pointer; padding:0; }
	#richscape-add-gallery-images { margin-top:4px; }
	</style>
	<div id="richscape-gallery-wrap">
	<?php foreach ( $ids as $id ) :
		$id = (int) $id;
		if ( ! $id ) continue;
		$thumb = wp_get_attachment_image_url( $id, 'thumbnail' );
	?>
		<div class="richscape-gallery-thumb" data-id="<?php echo $id; ?>">
			<img src="<?php echo esc_url( $thumb ); ?>" alt="">
			<button type="button" class="remove-img" title="Xóa">×</button>
		</div>
	<?php endforeach; ?>
	</div>
	<input type="hidden" id="richscape-gallery-ids" name="richscape_gallery_ids" value="<?php echo esc_attr( implode( ',', array_filter( $ids ) ) ); ?>">
	<button type="button" id="richscape-add-gallery-images" class="button">+ Thêm Ảnh</button>

	<script>
	(function($){
		var frame;
		$('#richscape-add-gallery-images').on('click', function(){
			if ( frame ) { frame.open(); return; }
			frame = wp.media({
				title: 'Chọn ảnh cho thư viện dự án',
				button: { text: 'Thêm vào thư viện' },
				multiple: true
			});
			frame.on('select', function(){
				var selection = frame.state().get('selection');
				var wrap = $('#richscape-gallery-wrap');
				var existingIds = $('#richscape-gallery-ids').val().split(',').filter(Boolean);
				selection.each(function(attachment){
					var id = attachment.id;
					if ( existingIds.indexOf(String(id)) !== -1 ) return;
					existingIds.push(String(id));
					var thumbUrl = attachment.attributes.sizes && attachment.attributes.sizes.thumbnail
						? attachment.attributes.sizes.thumbnail.url
						: attachment.attributes.url;
					wrap.append(
						'<div class="richscape-gallery-thumb" data-id="'+id+'">' +
						'<img src="'+thumbUrl+'" alt="">' +
						'<button type="button" class="remove-img" title="Xóa">×</button>' +
						'</div>'
					);
				});
				$('#richscape-gallery-ids').val(existingIds.join(','));
			});
			frame.open();
		});

		$(document).on('click', '.remove-img', function(){
			var thumb = $(this).closest('.richscape-gallery-thumb');
			var id = String(thumb.data('id'));
			thumb.remove();
			var ids = $('#richscape-gallery-ids').val().split(',').filter(function(v){ return v && v !== id; });
			$('#richscape-gallery-ids').val(ids.join(','));
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Save the gallery IDs when the post is saved.
 */
add_action( 'save_post_projects', function( $post_id ) {
	if ( ! isset( $_POST['richscape_gallery_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['richscape_gallery_nonce'], 'richscape_save_gallery' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$raw = isset( $_POST['richscape_gallery_ids'] ) ? sanitize_text_field( $_POST['richscape_gallery_ids'] ) : '';
	$ids = array_map( 'absint', array_filter( explode( ',', $raw ) ) );
	update_post_meta( $post_id, '_project_gallery_ids', $ids );
} );

/**
 * Helper: get gallery images for a project post.
 * Returns array of attachment data arrays (url, sizes, alt).
 */
function richscape_get_project_gallery( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();

	// First try native meta box IDs.
	$ids = get_post_meta( $post_id, '_project_gallery_ids', true );
	if ( ! empty( $ids ) && is_array( $ids ) ) {
		$images = array();
		foreach ( $ids as $id ) {
			$id = (int) $id;
			if ( ! $id ) continue;
			$url  = wp_get_attachment_url( $id );
			$alt  = get_post_meta( $id, '_wp_attachment_image_alt', true );
			$med  = wp_get_attachment_image_url( $id, 'medium_large' ) ?: wp_get_attachment_image_url( $id, 'medium' ) ?: $url;
			$images[] = array( 'url' => $url, 'alt' => $alt, 'sizes' => array( 'medium_large' => $med ) );
		}
		return $images;
	}

	// Fallback: try ACF gallery field (if ACF Pro ever gets installed).
	if ( function_exists( 'get_field' ) ) {
		$acf = get_field( 'project_gallery', $post_id );
		if ( ! empty( $acf ) ) return $acf;
	}

	return array();
}

/* ============================================================
   Banner Slider – Shortcode [richscape_banner_slider]
   ============================================================ */

/**
 * Build the slides array from ACF → theme option → placeholders.
 *
 * @param  int|null $post_id  Post/page ID to read ACF fields from.
 * @return array              Array of ['url' => string, 'alt' => string].
 */
function richscape_get_banner_slides( $post_id = null ) {

	// ── 1. Try ACF repeater on the current post/page ─────────
	if ( function_exists( 'get_field' ) ) {
		$rows = get_field( 'banner_slides', $post_id ?: get_the_ID() );
		if ( ! empty( $rows ) && is_array( $rows ) ) {
			$slides = array();
			foreach ( $rows as $row ) {
				$img = $row['slide_image'] ?? null;
				if ( ! $img ) continue;
				// ACF returns an array for image fields; support both array and URL.
				$url = is_array( $img ) ? ( $img['url'] ?? '' ) : $img;
				$alt = $row['slide_alt'] ?? ( is_array( $img ) ? ( $img['alt'] ?? '' ) : '' );
				if ( $url ) {
					$slides[] = array( 'url' => $url, 'alt' => $alt );
				}
			}
			if ( ! empty( $slides ) ) return $slides;
		}
	}

	// ── 2. Try theme option 'richscape_banner_slides' ─────────
	$option_slides = get_option( 'richscape_banner_slides', array() );
	if ( ! empty( $option_slides ) && is_array( $option_slides ) ) {
		return $option_slides;
	}

	// ── 3. Placeholder fallback (8 landscape images) ──────────
	$placeholder_base = 'https://picsum.photos/seed/richscape';
	$placeholders = array(
		array( 'url' => $placeholder_base . '1/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 1' ),
		array( 'url' => $placeholder_base . '2/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 2' ),
		array( 'url' => $placeholder_base . '3/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 3' ),
		array( 'url' => $placeholder_base . '4/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 4' ),
		array( 'url' => $placeholder_base . '5/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 5' ),
		array( 'url' => $placeholder_base . '6/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 6' ),
		array( 'url' => $placeholder_base . '7/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 7' ),
		array( 'url' => $placeholder_base . '8/1920/800', 'alt' => 'Richscape – Thiết kế cảnh quan 8' ),
	);
	return $placeholders;
}

/**
 * Shortcode callback – renders the slider HTML.
 *
 * Usage: [richscape_banner_slider] or [richscape_banner_slider post_id="42"]
 *
 * @param  array $atts  Shortcode attributes.
 * @return string       Slider HTML.
 */
function richscape_banner_slider_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'post_id' => null ), $atts, 'richscape_banner_slider' );

	$slides = richscape_get_banner_slides( $atts['post_id'] ? (int) $atts['post_id'] : null );

	ob_start();
	include get_template_directory() . '/templates/banner-slider.php';
	return ob_get_clean();
}
add_shortcode( 'richscape_banner_slider', 'richscape_banner_slider_shortcode' );

/* ============================================================
   ACF Field Group – banner_slides repeater
   Registers the field group programmatically so no JSON import
   is needed. Only runs when ACF Pro is active.
   ============================================================ */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	acf_add_local_field_group( array(
		'key'    => 'group_richscape_banner_slides',
		'title'  => 'Banner Slider Slides',
		'fields' => array(
			array(
				'key'          => 'field_banner_slides',
				'label'        => 'Banner Slides',
				'name'         => 'banner_slides',
				'type'         => 'repeater',
				'min'          => 1,
				'max'          => 12,
				'layout'       => 'block',
				'button_label' => 'Add Slide',
				'sub_fields'   => array(
					array(
						'key'           => 'field_slide_image',
						'label'         => 'Slide Image',
						'name'          => 'slide_image',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'required'      => 1,
					),
					array(
						'key'           => 'field_slide_alt',
						'label'         => 'Alt Text',
						'name'          => 'slide_alt',
						'type'          => 'text',
						'placeholder'   => 'Describe the image for accessibility',
					),
				),
			),
		),
		// Show this field group on all pages and posts
		'location' => array(
			array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ) ),
			array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ) ),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => true,
	) );
} );

/**
 * Register Custom Post Types: Services and Projects
 */
function richscape_register_cpts() {

	// Services CPT
	$services_labels = array(
		'name'                  => _x( 'Services', 'Post Type General Name', 'richscape' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'richscape' ),
		'menu_name'             => __( 'Services', 'richscape' ),
		'name_admin_bar'        => __( 'Service', 'richscape' ),
		'archives'              => __( 'Service Archives', 'richscape' ),
		'attributes'            => __( 'Service Attributes', 'richscape' ),
		'parent_item_colon'     => __( 'Parent Service:', 'richscape' ),
		'all_items'             => __( 'All Services', 'richscape' ),
		'add_new_item'          => __( 'Add New Service', 'richscape' ),
		'add_new'               => __( 'Add New', 'richscape' ),
		'new_item'              => __( 'New Service', 'richscape' ),
		'edit_item'             => __( 'Edit Service', 'richscape' ),
		'update_item'           => __( 'Update Service', 'richscape' ),
		'view_item'             => __( 'View Service', 'richscape' ),
		'view_items'            => __( 'View Services', 'richscape' ),
		'search_items'          => __( 'Search Service', 'richscape' ),
		'not_found'             => __( 'Not found', 'richscape' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'richscape' ),
	);
	$services_args = array(
		'label'                 => __( 'Service', 'richscape' ),
		'labels'                => $services_labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-hammer',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'services', $services_args );

	// Projects CPT
	$projects_labels = array(
		'name'                  => _x( 'Projects', 'Post Type General Name', 'richscape' ),
		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'richscape' ),
		'menu_name'             => __( 'Projects', 'richscape' ),
		'name_admin_bar'        => __( 'Project', 'richscape' ),
		'archives'              => __( 'Project Archives', 'richscape' ),
		'attributes'            => __( 'Project Attributes', 'richscape' ),
		'parent_item_colon'     => __( 'Parent Project:', 'richscape' ),
		'all_items'             => __( 'All Projects', 'richscape' ),
		'add_new_item'          => __( 'Add New Project', 'richscape' ),
		'add_new'               => __( 'Add New', 'richscape' ),
		'new_item'              => __( 'New Project', 'richscape' ),
		'edit_item'             => __( 'Edit Project', 'richscape' ),
		'update_item'           => __( 'Update Project', 'richscape' ),
		'view_item'             => __( 'View Project', 'richscape' ),
		'view_items'            => __( 'View Projects', 'richscape' ),
		'search_items'          => __( 'Search Project', 'richscape' ),
		'not_found'             => __( 'Not found', 'richscape' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'richscape' ),
	);
	$projects_args = array(
		'label'                 => __( 'Project', 'richscape' ),
		'labels'                => $projects_labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'show_in_rest'          => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'projects', $projects_args );

}
add_action( 'init', 'richscape_register_cpts', 0 );

/**
 * Mark home menu item as active on front page
 */
add_filter( 'nav_menu_css_class', function( $classes, $item ) {
	if ( is_front_page() && home_url( '/' ) === trailingslashit( $item->url ) ) {
		$classes[] = 'current-menu-item';
	}
	return $classes;
}, 10, 2 );

/**
 * Include Data Import logic
 */
require_once get_template_directory() . '/inc/import-data.php';

/* ============================================================
   Admin Menu – Banner Slider Manager
   ============================================================ */

add_action( 'admin_menu', function () {
	add_menu_page(
		'Banner Slider',
		'Banner Slider',
		'manage_options',
		'richscape-banner-slider',
		'richscape_banner_slider_admin_page',
		'dashicons-images-alt2',
		25
	);
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( $hook !== 'toplevel_page_richscape-banner-slider' ) return;
	wp_enqueue_media();
} );

function richscape_banner_slider_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) return;

	// Handle form submission.
	if ( isset( $_POST['richscape_banner_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['richscape_banner_nonce'] ) ), 'richscape_save_banner' ) ) {
		$urls = isset( $_POST['slide_url'] ) ? array_map( 'esc_url_raw', wp_unslash( $_POST['slide_url'] ) ) : array();
		$alts = isset( $_POST['slide_alt'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['slide_alt'] ) ) : array();

		$slides = array();
		foreach ( $urls as $i => $url ) {
			if ( empty( $url ) ) continue;
			$slides[] = array(
				'url' => $url,
				'alt' => $alts[ $i ] ?? '',
			);
		}
		update_option( 'richscape_banner_slides', $slides );
		echo '<div class="notice notice-success is-dismissible"><p>Đã lưu banner slider thành công!</p></div>';
	}

	$slides = get_option( 'richscape_banner_slides', array() );
	if ( empty( $slides ) ) {
		$slides = array( array( 'url' => '', 'alt' => '' ) );
	}
	?>
	<div class="wrap">
		<h1>Quản lý Banner Slider</h1>
		<p class="description">Thêm, xóa hoặc sắp xếp lại ảnh cho banner slider trang chủ. Kéo thả để đổi thứ tự.</p>
		<form method="post" id="richscape-banner-form">
			<?php wp_nonce_field( 'richscape_save_banner', 'richscape_banner_nonce' ); ?>
			<div id="richscape-slides-list" style="margin-top:20px;">
				<?php foreach ( $slides as $index => $slide ) : ?>
				<div class="richscape-slide-row" style="display:flex;align-items:center;gap:16px;margin-bottom:16px;background:#fff;padding:16px;border:1px solid #ddd;border-radius:6px;">
					<span class="dashicons dashicons-move" style="cursor:grab;color:#aaa;font-size:22px;flex-shrink:0;" title="Kéo để sắp xếp"></span>
					<div style="flex-shrink:0;width:120px;height:68px;background:#f0f0f0;border:1px solid #ccc;border-radius:4px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
						<?php if ( ! empty( $slide['url'] ) ) : ?>
							<img src="<?php echo esc_url( $slide['url'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
						<?php else : ?>
							<span class="dashicons dashicons-format-image" style="font-size:32px;color:#ccc;"></span>
						<?php endif; ?>
					</div>
					<div style="flex:1;display:flex;flex-direction:column;gap:8px;">
						<div style="display:flex;gap:8px;align-items:center;">
							<input type="url" name="slide_url[]" value="<?php echo esc_attr( $slide['url'] ); ?>"
							       placeholder="URL ảnh" class="richscape-slide-url large-text"
							       style="flex:1;" readonly>
							<button type="button" class="button richscape-select-image">Chọn ảnh</button>
							<button type="button" class="button richscape-clear-image" title="Xóa slide này" style="color:#b32d2e;">&#10005;</button>
						</div>
						<input type="text" name="slide_alt[]" value="<?php echo esc_attr( $slide['alt'] ); ?>"
						       placeholder="Alt text (mô tả ảnh)" class="large-text">
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<div style="margin-top:8px;">
				<button type="button" id="richscape-add-slide" class="button">+ Thêm slide</button>
			</div>

			<p style="margin-top:24px;">
				<?php submit_button( 'Lưu Banner Slider', 'primary', 'submit', false ); ?>
			</p>
		</form>
	</div>

	<script>
	(function($){
		// Template for a new slide row
		function newSlideRow() {
			return $('<div class="richscape-slide-row" style="display:flex;align-items:center;gap:16px;margin-bottom:16px;background:#fff;padding:16px;border:1px solid #ddd;border-radius:6px;">' +
				'<span class="dashicons dashicons-move" style="cursor:grab;color:#aaa;font-size:22px;flex-shrink:0;" title="Kéo để sắp xếp"></span>' +
				'<div style="flex-shrink:0;width:120px;height:68px;background:#f0f0f0;border:1px solid #ccc;border-radius:4px;overflow:hidden;display:flex;align-items:center;justify-content:center;">' +
					'<span class="dashicons dashicons-format-image" style="font-size:32px;color:#ccc;"></span>' +
				'</div>' +
				'<div style="flex:1;display:flex;flex-direction:column;gap:8px;">' +
					'<div style="display:flex;gap:8px;align-items:center;">' +
						'<input type="url" name="slide_url[]" value="" placeholder="URL ảnh" class="richscape-slide-url large-text" style="flex:1;" readonly>' +
						'<button type="button" class="button richscape-select-image">Chọn ảnh</button>' +
						'<button type="button" class="button richscape-clear-image" title="Xóa slide này" style="color:#b32d2e;">&#10005;</button>' +
					'</div>' +
					'<input type="text" name="slide_alt[]" value="" placeholder="Alt text (mô tả ảnh)" class="large-text">' +
				'</div>' +
			'</div>');
		}

		// Add slide
		$('#richscape-add-slide').on('click', function(){
			$('#richscape-slides-list').append(newSlideRow());
		});

		// Remove slide
		$(document).on('click', '.richscape-clear-image', function(){
			if ($('.richscape-slide-row').length > 1) {
				$(this).closest('.richscape-slide-row').remove();
			} else {
				var row = $(this).closest('.richscape-slide-row');
				row.find('.richscape-slide-url').val('');
				row.find('input[name="slide_alt[]"]').val('');
				row.find('div').first().html('<span class="dashicons dashicons-format-image" style="font-size:32px;color:#ccc;"></span>');
			}
		});

		// Open media uploader
		$(document).on('click', '.richscape-select-image', function(){
			var row = $(this).closest('.richscape-slide-row');
			var frame = wp.media({
				title: 'Chọn ảnh banner',
				button: { text: 'Sử dụng ảnh này' },
				multiple: false,
				library: { type: 'image' }
			});
			frame.on('select', function(){
				var attachment = frame.state().get('selection').first().toJSON();
				row.find('.richscape-slide-url').val(attachment.url);
				if (!row.find('input[name="slide_alt[]"]').val()) {
					row.find('input[name="slide_alt[]"]').val(attachment.alt || attachment.title || '');
				}
				var thumb = row.find('div').first();
				thumb.html('<img src="' + attachment.url + '" style="width:100%;height:100%;object-fit:cover;">');
			});
			frame.open();
		});

		// Sortable drag-to-reorder
		if ($.fn.sortable) {
			$('#richscape-slides-list').sortable({ handle: '.dashicons-move', axis: 'y' });
		}
	})(jQuery);
	</script>
	<?php
}

/* ============================================================
   ACF Options Page
   ============================================================ */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_options_page' ) ) return;
	acf_add_options_page( array(
		'page_title' => 'Richscape Options',
		'menu_title' => 'Richscape Options',
		'menu_slug'  => 'richscape-options',
		'capability' => 'manage_options',
		'icon_url'   => 'dashicons-admin-generic',
		'position'   => 2,
	) );
} );

/* ============================================================
   ACF Field Groups (all registered programmatically)
   ============================================================ */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	// ── Options Page Fields ──────────────────────────────────
	acf_add_local_field_group( array(
		'key'    => 'group_richscape_site_options',
		'title'  => 'Richscape Site Options',
		'fields' => array(
			array( 'key' => 'field_logo_header',         'label' => 'Logo Header',         'name' => 'logo_header',         'type' => 'image',    'return_format' => 'array', 'preview_size' => 'medium' ),
			array( 'key' => 'field_logo_footer',         'label' => 'Logo Footer',         'name' => 'logo_footer',         'type' => 'image',    'return_format' => 'array', 'preview_size' => 'medium' ),
			array( 'key' => 'field_company_name_full',   'label' => 'Tên đầy đủ',          'name' => 'company_name_full',   'type' => 'text' ),
			array( 'key' => 'field_company_name_abbr',   'label' => 'Tên viết tắt',        'name' => 'company_name_abbr',   'type' => 'text' ),
			array( 'key' => 'field_company_name_intl',   'label' => 'Tên quốc tế',         'name' => 'company_name_intl',   'type' => 'text' ),
			array( 'key' => 'field_company_tax_id',      'label' => 'Mã số thuế',          'name' => 'company_tax_id',      'type' => 'text' ),
			array( 'key' => 'field_contact_phone',       'label' => 'Điện thoại',          'name' => 'contact_phone',       'type' => 'text' ),
			array( 'key' => 'field_contact_email',       'label' => 'Email',               'name' => 'contact_email',       'type' => 'email' ),
			array( 'key' => 'field_contact_address',     'label' => 'Địa chỉ',             'name' => 'contact_address',     'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_social_zalo_url',     'label' => 'Zalo URL',            'name' => 'social_zalo_url',     'type' => 'url' ),
			array( 'key' => 'field_social_messenger_url','label' => 'Messenger URL',       'name' => 'social_messenger_url','type' => 'url' ),
			array( 'key' => 'field_about_tagline_en',    'label' => 'English Tagline',     'name' => 'about_tagline_en',    'type' => 'text' ),
			array( 'key' => 'field_about_intro_vi',      'label' => 'Vietnamese Intro',    'name' => 'about_intro_vi',      'type' => 'textarea', 'rows' => 4 ),
			array( 'key' => 'field_vision_text',         'label' => 'Nội dung Tầm Nhìn',   'name' => 'vision_text',         'type' => 'textarea', 'rows' => 4 ),
			array( 'key' => 'field_mission_text',        'label' => 'Nội dung Sứ Mệnh',    'name' => 'mission_text',        'type' => 'textarea', 'rows' => 4 ),
			array(
				'key'          => 'field_core_values',
				'label'        => 'Giá Trị Cốt Lõi',
				'name'         => 'core_values',
				'type'         => 'repeater',
				'button_label' => 'Thêm giá trị',
				'layout'       => 'block',
				'sub_fields'   => array(
					array( 'key' => 'field_cv_title',       'label' => 'Tên giá trị', 'name' => 'cv_title',       'type' => 'text' ),
					array( 'key' => 'field_cv_description', 'label' => 'Mô tả',       'name' => 'cv_description', 'type' => 'textarea', 'rows' => 2 ),
				),
			),
			array(
				'key'          => 'field_trusted_by',
				'label'        => 'Đối Tác Tin Tưởng',
				'name'         => 'trusted_by',
				'type'         => 'repeater',
				'button_label' => 'Thêm đối tác',
				'layout'       => 'block',
				'sub_fields'   => array(
					array( 'key' => 'field_partner_logo', 'label' => 'Logo',        'name' => 'partner_logo', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail' ),
					array( 'key' => 'field_partner_name', 'label' => 'Tên đối tác', 'name' => 'partner_name', 'type' => 'text' ),
				),
			),
			array( 'key' => 'field_footer_copyright', 'label' => 'Copyright text', 'name' => 'footer_copyright', 'type' => 'text' ),
		),
		'location' => array(
			array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'richscape-options' ) ),
		),
		'active' => true,
	) );

	// ── About Page Fields ────────────────────────────────────
	acf_add_local_field_group( array(
		'key'    => 'group_richscape_about_page',
		'title'  => 'Lãnh Đạo & Thành Viên',
		'fields' => array(
			array(
				'key'          => 'field_leaders',
				'label'        => 'Lãnh Đạo',
				'name'         => 'leaders',
				'type'         => 'repeater',
				'button_label' => 'Thêm lãnh đạo',
				'layout'       => 'block',
				'sub_fields'   => array(
					array( 'key' => 'field_leader_name',     'label' => 'Họ tên',           'name' => 'leader_name',     'type' => 'text' ),
					array( 'key' => 'field_leader_title',    'label' => 'Chức danh',        'name' => 'leader_title',    'type' => 'text' ),
					array( 'key' => 'field_leader_bio',      'label' => 'Tiểu sử',          'name' => 'leader_bio',      'type' => 'textarea', 'rows' => 4 ),
					array( 'key' => 'field_leader_portrait', 'label' => 'Ảnh chân dung',    'name' => 'leader_portrait', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),
					array( 'key' => 'field_leader_bg_photo', 'label' => 'Ảnh nền landscape','name' => 'leader_bg_photo', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),
				),
			),
			array(
				'key'          => 'field_members',
				'label'        => 'Thành Viên',
				'name'         => 'members',
				'type'         => 'repeater',
				'button_label' => 'Thêm thành viên',
				'layout'       => 'block',
				'sub_fields'   => array(
					array( 'key' => 'field_member_name',     'label' => 'Họ tên',    'name' => 'member_name',     'type' => 'text' ),
					array( 'key' => 'field_member_title',    'label' => 'Chức danh', 'name' => 'member_title',    'type' => 'text' ),
					array( 'key' => 'field_member_bio',      'label' => 'Tiểu sử',   'name' => 'member_bio',      'type' => 'textarea', 'rows' => 3 ),
					array( 'key' => 'field_member_portrait', 'label' => 'Ảnh',       'name' => 'member_portrait', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),
				),
			),
		),
		'location' => array(
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ) ),
		),
		'active' => true,
	) );

	// ── Contact Page Fields ──────────────────────────────────
	acf_add_local_field_group( array(
		'key'    => 'group_richscape_contact_page',
		'title'  => 'Bản Đồ Google',
		'fields' => array(
			array(
				'key'          => 'field_maps_embed_url',
				'label'        => 'Google Maps Embed URL',
				'name'         => 'maps_embed_url',
				'type'         => 'text',
				'instructions' => 'Paste src URL từ Google Maps → Share → Embed (chỉ phần src="...")',
			),
		),
		'location' => array(
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ) ),
		),
		'active' => true,
	) );

	// ── Services CPT Fields ──────────────────────────────────
	acf_add_local_field_group( array(
		'key'    => 'group_richscape_services_cpt',
		'title'  => 'Chi Tiết Dịch Vụ',
		'fields' => array(
			array(
				'key'           => 'field_service_icon',
				'label'         => 'Biểu tượng dịch vụ',
				'name'          => 'service_icon',
				'type'          => 'image',
				'return_format' => 'array',
				'preview_size'  => 'thumbnail',
			),
			array(
				'key'          => 'field_service_sub_images',
				'label'        => 'Ảnh chi tiết',
				'name'         => 'service_sub_images',
				'type'         => 'repeater',
				'button_label' => 'Thêm ảnh',
				'layout'       => 'block',
				'sub_fields'   => array(
					array( 'key' => 'field_sub_image',   'label' => 'Ảnh',     'name' => 'sub_image',   'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),
					array( 'key' => 'field_sub_caption', 'label' => 'Caption', 'name' => 'sub_caption', 'type' => 'text',  'placeholder' => 'VD: MASTER PLAN' ),
				),
			),
		),
		'location' => array(
			array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'services' ) ),
		),
		'active' => true,
	) );

	// ── Projects CPT Fields ──────────────────────────────────
	acf_add_local_field_group( array(
		'key'    => 'group_richscape_projects_cpt',
		'title'  => 'Chi Tiết Dự Án',
		'fields' => array(
			array( 'key' => 'field_project_client',       'label' => 'Chủ đầu tư',              'name' => 'project_client',       'type' => 'text' ),
			array( 'key' => 'field_project_area_total',   'label' => 'Quy mô tổng thể (m²)',    'name' => 'project_area_total',   'type' => 'text' ),
			array( 'key' => 'field_project_area_green',   'label' => 'Diện tích phủ xanh (m²)', 'name' => 'project_area_green',   'type' => 'text' ),
			array( 'key' => 'field_project_scope',        'label' => 'Phạm vi thực hiện',       'name' => 'project_scope',        'type' => 'text' ),
			array( 'key' => 'field_project_address',      'label' => 'Địa chỉ dự án',           'name' => 'project_address',      'type' => 'text' ),
			array( 'key' => 'field_project_category_tag', 'label' => 'Loại dịch vụ',            'name' => 'project_category_tag', 'type' => 'text' ),
			array(
				'key'           => 'field_project_gallery',
				'label'         => 'Thư viện ảnh',
				'name'          => 'project_gallery',
				'type'          => 'gallery',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			),
			array(
				'key'         => 'field_project_service',
				'label'       => 'Dịch vụ liên quan',
				'name'        => 'project_service',
				'type'        => 'post_object',
				'post_type'   => array( 'services' ),
				'return_format' => 'object',
				'allow_null'  => 1,
				'multiple'    => 0,
				'ui'          => 1,
			),
			array(
				'key'         => 'field_project_special',
				'label'       => 'Dự án nổi bật',
				'name'        => 'project_special',
				'type'        => 'true_false',
				'message'     => 'Đánh dấu là dự án nổi bật',
				'default_value' => 0,
				'ui'          => 1,
			),
		),
		'location' => array(
			array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'projects' ) ),
		),
		'active' => true,
	) );
} );

/* ============================================================
   Projects Archive – only show special projects
   ============================================================ */
add_action( 'pre_get_posts', function( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) return;
	if ( $query->is_post_type_archive( 'projects' ) || $query->is_tax( 'project_cat' ) ) {
		$query->set( 'meta_query', array(
			array(
				'key'     => 'project_special',
				'value'   => '1',
				'compare' => '=',
			),
		) );
	}
} );

/* ============================================================
   View Counters (Projects + Posts)
   ============================================================ */
function richscape_increment_view_count( $post_id, $meta_key = '_post_views' ) {
	if ( is_admin() ) return;
	$count = (int) get_post_meta( $post_id, $meta_key, true );
	update_post_meta( $post_id, $meta_key, $count + 1 );
}
