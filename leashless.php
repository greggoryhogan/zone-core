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
function load_leashless_scritps() {
	if( ! function_exists('get_plugin_data') ){
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    $plugin_data = get_plugin_data( __FILE__ );
    wp_enqueue_style( 'leashless', LSHLSS_PLUGIN_URL . 'assets/css/leashless.css',null,$plugin_data->Version );
}
add_action( 'wp_enqueue_scripts', 'load_leashless_scritps' );

//Juicy Stuff
require_once( LSHLSS_PLUGIN_PATH . '/includes/core.php' );