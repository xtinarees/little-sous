<?php
/*
Plugin Name: Little Sous
Plugin URI:
Description: Provides acf fields needed for Little Sous
Version: 2015.06.10
Author: Christina Rees
Author URI: http://www.github.com/xtinarees
*/

/** If this file is called directly, abort. */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/** Constants */

/**
 * Full path to the GravityView file
 * @define "LITTLESOUS_FILE" "./dmagazine.php"
 */
define( 'LITTLESOUS_FILE', __FILE__ );

/**
 * The URL to this file
 * @define "LITTLESOUS_URL"
 */
define( 'LITTLESOUS_URL', plugin_dir_url( __FILE__ ) );

/**
 * The absolute path to the plugin directory
 * @define "LITTLESOUS_DIR" "./"
 */
define( 'LITTLESOUS_DIR', plugin_dir_path( __FILE__ ) );

include_once(LITTLESOUS_DIR . 'lib/acf-fields-post.php');
include_once(LITTLESOUS_DIR . 'lib/acf-fields-options.php');
include_once(LITTLESOUS_DIR . 'lib/acf-fields-recipe.php');
include_once(LITTLESOUS_DIR . 'lib/acf-fields-category.php');
include_once(LITTLESOUS_DIR . 'lib/acf-fields-user.php');
include_once(LITTLESOUS_DIR . 'lib/acf-fields-media.php');


include_once(LITTLESOUS_DIR . 'lib/class-LittleSous.php');
include_once(LITTLESOUS_DIR . 'lib/class-popular-posts.php');
include_once(LITTLESOUS_DIR . 'lib/class-taxonomies.php');
include_once(LITTLESOUS_DIR . 'lib/class-custom-post-type.php');
include_once(LITTLESOUS_DIR . 'lib/class-recipe.php');
include_once(LITTLESOUS_DIR . 'lib/class-shortcodes.php');





function my_enqueue() {
    wp_enqueue_style( 'custom_wp_admin_css', plugins_url('/css/acf.css', __FILE__) );
    wp_enqueue_script( 'custom_wp_admin_js', plugins_url('/js/acf.js', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'my_enqueue' );
