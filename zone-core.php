<?php
/*
Plugin Name:  Zone Core
Plugin URI:	  https://zonecreative.com
Description:  Essentials for Zone to run separated from the theme, such as custom post types and taxonomies
Version:	  1.0.0
Author:		  Gregg Hogan
Author URI:   https://mynameisgregg.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  zone
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//Basic definitions for file paths
define( 'ZONE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ZONE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//Load Custom Post Types and Taxonomies
require_once( ZONE_PLUGIN_PATH . '/includes/core.php' );