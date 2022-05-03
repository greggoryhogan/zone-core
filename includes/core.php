<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Custom Post Types and Taxonomies
 */
function register_zone_cpts_and_taxonomies() {

	/**
	 * Post Type: Work
	 */

	$labels = array(
		'name' => __( 'Works', 'zone' ),
		'singular_name' => __( 'Work', 'zone' ),
	);

	$args = array(
		'label' => __( 'Works', 'zone' ),
		'labels' => $labels,
		'description' => '',
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_rest' => false,
		'rest_base' => '',
		'has_archive' => true,
		'show_in_menu' => true,
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'rewrite' => array( 'slug' => 'work', 'with_front' => false ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'thumbnail', 'author' ),
		'taxonomies' => array( 'industries','services' ),
	);

	register_post_type( 'work', $args );

	/**
	 * Taxonomy: Work Category
	 */

	$labels = array(
		'name' => __( 'Categories', 'zone' ),
		'singular_name' => __( 'Category', 'zone' ),
        'add_new_item' => __( 'Add New Category', 'zone' ),
        'parent_item' => __( 'Parent Category', 'zone' ),
        'not_found' => __( 'No Categories found', 'zone' ),
	);

	$args = array(
		'label' => __( 'Categories', 'zone' ),
		'labels' => $labels,
		'public' => true,
		'label' => 'Categories',
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'work-category', 'with_front' => false, ),
		'show_admin_column' => 0,
		'show_in_rest' => false,
		'rest_base' => '',
		'show_in_quick_edit' => true,
        'hierarchical'    => true,
	);
	register_taxonomy( 'work-category', array( 'work' ), $args );

	/**
	 * Taxonomy: Industries
	 */

	$labels = array(
		'name' => __( 'Industries', 'zone' ),
		'singular_name' => __( 'Industry', 'zone' ),
        'add_new_item' => __( 'Add New Industry', 'zone' ),
        'parent_item' => __( 'Parent Industry', 'zone' ),
        'not_found' => __( 'No Industries found', 'zone' ),
	);

	$args = array(
		'label' => __( 'Industries', 'zone' ),
		'labels' => $labels,
		'public' => true,
		'label' => 'Industries',
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'industry', 'with_front' => false, ),
		'show_admin_column' => 0,
		'show_in_rest' => false,
		'rest_base' => '',
		'show_in_quick_edit' => true,
        'hierarchical'    => true,
	);
	register_taxonomy( 'industries', array( 'work' ), $args );

    /**
	 * Taxonomy: Services
	 */

	$labels = array(
		'name' => __( 'Services', 'zone' ),
		'singular_name' => __( 'Service', 'zone' ),
        'add_new_item' => __( 'Add New Service', 'zone' ),
        'parent_item' => __( 'Parent Service', 'zone' ),
        'not_found' => __( 'No Services found', 'zone' ),
	);

	$args = array(
		'label' => __( 'Services', 'zone' ),
		'labels' => $labels,
		'public' => true,
		'label' => 'Services',
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'service', 'with_front' => false, ),
		'show_admin_column' => 0,
		'show_in_rest' => false,
		'rest_base' => '',
		'show_in_quick_edit' => true,
        'hierarchical'    => true,
	);
	register_taxonomy( 'services', array( 'work' ), $args );


	/**
	 * Taxonomy: Page Category
	 */

	$labels = array(
		'name' => __( 'Categories', 'zone' ),
		'singular_name' => __( 'Category', 'zone' ),
        'add_new_item' => __( 'Add New Category', 'zone' ),
        'parent_item' => __( 'Parent Category', 'zone' ),
        'not_found' => __( 'No Categories found', 'zone' ),
	);

	$args = array(
		'label' => __( 'Categories', 'zone' ),
		'labels' => $labels,
		'public' => true,
		'label' => 'Categories',
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'page-category', 'with_front' => false, ),
		'show_admin_column' => 0,
		'show_in_rest' => false,
		'rest_base' => '',
		'show_in_quick_edit' => true,
        'hierarchical'    => true,
	);
	register_taxonomy( 'page-category', array( 'page' ), $args );

	/**
	 * Insert Featured Category for Posts, Pages and Work
	 */
	$featured_post = term_exists( 'Featured', 'category' );
    if($featured_post == null) {
		wp_insert_term(
			'Featured',   // the term 
			'category', // the taxonomy
			array(
				'slug'        => 'featured',
				'parent'      => 0
			)
		);
	}
	$featured_page = term_exists( 'Featured', 'page-category' );
    if($featured_page == null) {
		wp_insert_term(
			'Featured',   // the term 
			'page-category', // the taxonomy
			array(
				'slug'        => 'featured',
				'parent'      => 0
			)
		);
	}
	$featured_work = term_exists( 'Featured', 'work-category' );
    if($featured_work == null) {
		wp_insert_term(
			'Featured',   // the term 
			'work-category', // the taxonomy
			array(
				'slug'        => 'featured',
				'parent'      => 0
			)
		);
	}

}
add_action( 'init', 'register_zone_cpts_and_taxonomies' );
?>