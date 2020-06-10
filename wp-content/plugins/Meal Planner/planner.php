<?php
/*
Plugin Name:  Meal Planner
Description:  Meal planner For A Healthy Diet.
Version:      1.0.0
Author:       Hasnain ahmed
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('WPINC')) {
    die();
}

if (!defined('WPAC_PLUGIN_DIR')) {
    define('WPAC_PLUGIN_DIR', plugin_dir_url(__FILE__));
}

require plugin_dir_path(__FILE__) . 'inc/settings.php';


function wpac_plugin_scripts()
{
    wp_enqueue_style('bootstrap3-style', WPAC_PLUGIN_DIR . 'assets/js/bootstrap3.min.css');
    wp_enqueue_style('datatable-style', WPAC_PLUGIN_DIR . 'assets/datatable/jquery.dataTables.min.css');

    //wp_enqueue_style('wpac-style', WPAC_PLUGIN_DIR . 'assets/EasyAutocomplete/easy-autocomplete.css');
    wp_register_script( 'bootstrap3-script', WPAC_PLUGIN_DIR .'assets/js/bootstrap3.min.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'bootstrap3-script' );
    wp_register_script( 'bootstrap-script', WPAC_PLUGIN_DIR .'assets/js/bootstrap.min.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'bootstrap-script' );
    wp_register_script( 'jquery-script', WPAC_PLUGIN_DIR .'assets/js/jquery.min.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'jquery-script' );
    // Register the script like this for a plugin:
     wp_register_script( 'datatable-script', WPAC_PLUGIN_DIR .'assets/datatable/jquery.dataTables.min.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'datatable-script' );

    wp_register_script( 'custom-script', WPAC_PLUGIN_DIR .'assets/js/main.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script' );


}

add_action('wp_enqueue_scripts', 'wpac_plugin_scripts');

function enqueue_admin_script() {
    // Stylsheets
    wp_enqueue_style('bootstrap3-style', WPAC_PLUGIN_DIR . 'assets/js/bootstrap.min.css');
    wp_enqueue_style('datatable-style', WPAC_PLUGIN_DIR . 'assets/datatable/jquery.dataTables.min.css');

    // Bootstrap JS
    wp_register_script( 'bootstrap-script', WPAC_PLUGIN_DIR .'assets/js/bootstrap.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'bootstrap-script' );

    // Jquery Js
    wp_register_script( 'jquery-script', WPAC_PLUGIN_DIR .'assets/js/jquery.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'jquery-script' );

    // Datatable Js
    wp_register_script( 'datatable-script', WPAC_PLUGIN_DIR .'assets/datatable/jquery.dataTables.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'datatable-script' );

    //custom script
    wp_register_script( 'custom-script', WPAC_PLUGIN_DIR .'assets/js/main.js', array( 'jquery' ) );
    wp_enqueue_script( 'custom-script' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_script' );


function wpac_pluginprefix_deactivation()
{
    //Offers_Title
    
    // clear the permalinks to remove post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'wpac_pluginprefix_deactivation');