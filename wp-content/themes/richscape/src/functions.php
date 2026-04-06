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
		'1.0.0'
	);
	wp_enqueue_script(
		'richscape-banner-slider',
		get_template_directory_uri() . '/assets/js/richscape-banner-slider.js',
		array(), // no jQuery dependency
		'1.0.0',
		true     // load in footer
	);
}
add_action( 'wp_enqueue_scripts', 'richscape_scripts' );

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
