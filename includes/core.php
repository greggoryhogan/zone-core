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
		'rewrite' => array( 'slug' => 'park', 'with_front' => false ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'thumbnail', 'author' ),
		'taxonomies' => array( 'location' ),
	);

	register_post_type( 'park', $args );

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
	register_taxonomy( 'locations', array( 'park' ), $args );
}
add_action( 'init', 'register_leashless_cpt_and_tax' );

/**
 * Helper function to import locations from csv
 */
function create_default_park_locations() {
    if(is_admin() && isset($_GET['insertlocations'])) {

        //Bulk Delete for testing
        /*$taxonomy_name = 'locations';
        $terms = get_terms( array(
            'taxonomy' => $taxonomy_name,
            'hide_empty' => false
        ) );
        foreach ( $terms as $term ) {
            wp_delete_term($term->term_id, $taxonomy_name); 
        } */       
        
        //Iterate csv and insert locations
        $row = 0;
        if (($handle = fopen(LSHLSS_PLUGIN_PATH.'assets/csv/statesandcounties.csv', 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $num = count($data);
                $row++;
                if($row > 1) {
                    $county = $data[0];
                    $state = $data[5];
                    $state_abbreviation = $data[4];
                    //echo $county .', '.$state.'<br>';
                    $term = term_exists($state,'locations');
                    if($term == null) {
                        $term = wp_insert_term($state,'locations');
                        $term_id = $term['term_id'];
                        add_term_meta($term_id,'abbreviation',$state_abbreviation);
                        //echo $state .' does not exist but was inserted with ID '.$term_id.'<br>';
                    } else {
                        $term_id = $term['term_id'];
                    }
                    $sub_term_id = term_exists($county,'locations',$term_id);
                    if($sub_term_id == null) {
                        $sub_term = wp_insert_term($county,'locations',array('parent' => $term_id));
                        $sub_term_id = $sub_term['term_id'];
                        //echo $county .' does not exist but was inserted with ID '.$sub_term_id.'<br>';
                    }
                }
                
            }
            fclose($handle);
        }
    }
}
add_action('init','create_default_park_locations');

/**
 * Helper to show breadcrumb for state and county for current park
 */
function get_park_location() {
    global $post;
    $taxonomy = 'locations';
    $terms = wp_get_post_terms($post->ID, $taxonomy);
    if( is_wp_error( $terms ) ) {
        return;
    } else {
        $string = '';
        foreach($terms as $term) {
            $string .= '<a href="'.get_term_link($term,$taxonomy).'">'.$term->name.'</a> > ';
        }
        $string = substr($string, 0, -2);
        return $string;
    } 
}

/**
 * Search form for locations
 */
add_shortcode( 'park_search', 'park_search_func' );
function park_search_func() {
    $form = '<form action="" id="findapark" class="ui-widget">
        <input type="text" id="parklocation" name="parklocation" autocomplete="false" placeholder="Enter your state or county" />
    </form>';
    return $form;
}
?>