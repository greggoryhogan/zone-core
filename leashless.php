<?php
/*
Plugin Name:  Leashless
Plugin URI:	  https://theleashlessdog.com
Description:  All the fancy stuff required to run theleashlessdog.com
Version:	  1.0.0
Author:		  Gregg Hogan
Author URI:   https://mynameisgregg.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  lshlss
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LSHLSS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSHLSS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* 
 * Style/Scripts
 */
function load_leashless_plugin_scripts() {
	if( ! function_exists('get_plugin_data') ){
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    $plugin_data = get_plugin_data( __FILE__ );

    wp_enqueue_style( 'leashless', LSHLSS_PLUGIN_URL . 'assets/css/leashless.css',null,$plugin_data['Version'] );
    wp_enqueue_style( 'jquery-autocomplete-css', 'https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css',null,$plugin_data['Version'] );
    wp_enqueue_script( 'jquery-autocomplete-js', 'https://code.jquery.com/ui/1.13.1/jquery-ui.js', array('jquery'),$plugin_data['Version'], true );
    wp_enqueue_script( 'plugin-js', LSHLSS_PLUGIN_URL. '/assets/js/plugin.js', array('jquery'),$plugin_data['Version'], true );
    //wp_enqueue_script( 'plugin-js', LSHLSS_PLUGIN_URL. '/assets/js/plugin.min.js', array('jquery'),$version, false );
    $autocomplete = array();
    $locations = get_terms( 'locations', array(
        'hide_empty' => false,
        'parent' => 0
    ));
    foreach($locations as $location) {
        $parent = $location->parent;
        if($parent == 0) {
            $category = 'State';
            $name = $location->name;
        } else {
            $term = get_term_by('id',$parent,'locations');
            $category = $term->name;
            $name = $location->name.', '.$category;
        }
        $autocomplete[] = array(
            'label' => $name,
            'value' => $location->slug,
            'category' => 'States'
        );
    }

    $locations = get_terms( 'locations', array(
        'hide_empty' => false,
    ));
    foreach($locations as $location) {
        $parent = $location->parent;
        if($parent != 0) {
            $term = get_term_by('id',$parent,'locations');
            $category = $term->name;
            $name = $location->name.', '.$category;
        }
        $autocomplete[] = array(
            'label' => $name,
            'value' => $location->slug,
            'category' => 'Counties'
        );
    }
    wp_localize_script( 'plugin-js', 'site_js',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'available_locations' => json_encode($autocomplete),
            'siteurl' => get_bloginfo('url'),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'load_leashless_plugin_scripts' );

//Juicy Stuff
require_once( LSHLSS_PLUGIN_PATH . '/includes/core.php' );
require_once( LSHLSS_PLUGIN_PATH . '/includes/gravity-forms.php' );