<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register parks and locations
 */
function register_leashless_cpt_and_tax() {

	/**
	 * Post Type: Letters.
	 */

	$labels = array(
		'name' => __( 'Parks', 'lshlss' ),
		'singular_name' => __( 'Park', 'lshlss' ),
	);

	$args = array(
		'label' => __( 'Parks', 'lshlss' ),
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
		'rewrite' => array( 'slug' => 'parks', 'with_front' => false ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'thumbnail', 'author' ),
		'taxonomies' => array( 'locations' ),
	);

	register_post_type( 'parks', $args );

	/**
	 * Taxonomy: Locations
	 */

	$labels = array(
		'name' => __( 'Locations', 'lshlss' ),
		'singular_name' => __( 'Location', 'lshlss' ),
        'add_new_item' => __( 'Add New Location', 'lshlss' ),
        'parent_item' => __( 'Parent Location', 'lshlss' ),
        'not_found' => __( 'No locations found', 'lshlss' ),
	);

	$args = array(
		'label' => __( 'Locations', 'lshlss' ),
		'labels' => $labels,
		'public' => true,
		'label' => 'Locations',
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'location', 'with_front' => false, ),
		'show_admin_column' => 0,
		'show_in_rest' => false,
		'rest_base' => '',
		'show_in_quick_edit' => true,
        'hierarchical'    => true,
	);
	register_taxonomy( 'locations', array( 'parks' ), $args );
}
add_action( 'init', 'register_leashless_cpt_and_tax' );
?>