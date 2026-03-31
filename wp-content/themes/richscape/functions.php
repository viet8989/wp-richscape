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

	// Inject Tailwind CSS via CDN
	wp_enqueue_script( 'tailwindcss-cdn', 'https://cdn.tailwindcss.com', array(), null, false );
}
add_action( 'wp_enqueue_scripts', 'richscape_scripts' );

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
 * Include Data Import logic
 */
require_once get_template_directory() . '/inc/import-data.php';
