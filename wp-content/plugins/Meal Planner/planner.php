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
	wp_enqueue_style('custom-style', WPAC_PLUGIN_DIR . 'assets/css/style.css');
    wp_enqueue_style('bootstrap3-style', WPAC_PLUGIN_DIR . 'assets/js/bootstrap3.min.css');
    wp_enqueue_style('datatable-style', WPAC_PLUGIN_DIR . 'assets/datatable/jquery.dataTables.min.css');

    //wp_enqueue_style('wpac-style', WPAC_PLUGIN_DIR . 'assets/EasyAutocomplete/easy-autocomplete.css');
    wp_register_script( 'bootstrap3-script', WPAC_PLUGIN_DIR .'assets/js/bootstrap3.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'bootstrap3-script' );

	// For either a plugin or a theme, you can then enqueue the script:
    wp_register_script( 'bootstrap-script', WPAC_PLUGIN_DIR .'assets/js/bootstrap.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'bootstrap-script' );

	// For either a plugin or a theme, you can then enqueue the script:
    wp_register_script( 'jquery-script', WPAC_PLUGIN_DIR .'assets/js/jquery.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'jquery-script' );

	// For either a plugin or a theme, you can then enqueue the script:
     wp_register_script( 'datatable-script', WPAC_PLUGIN_DIR .'assets/datatable/jquery.dataTables.min.js', array( 'jquery' ) );
     wp_enqueue_script( 'datatable-script' );

    wp_register_script( 'custom-script', WPAC_PLUGIN_DIR .'assets/js/main.js', array( 'jquery' ) );
    wp_enqueue_script( 'custom-script' );


}

add_action('wp_enqueue_scripts', 'wpac_plugin_scripts');

function enqueue_admin_script() {
    // Stylsheets
    //wp_enqueue_style('bootstrap3-style', WPAC_PLUGIN_DIR . 'assets/js/bootstrap.min.css');
    wp_enqueue_style('datatable-style', WPAC_PLUGIN_DIR . 'assets/datatable/jquery.dataTables.min.css');

//    // Bootstrap JS
//    wp_register_script( 'bootstrap-script', WPAC_PLUGIN_DIR .'assets/js/bootstrap.min.js', array( 'jquery' ) );
//    wp_enqueue_script( 'bootstrap-script' );

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

//creating tables of plugin
//require plugin_dir_path( __FILE__ ).'inc/db.php';
function wpac_planner_table()
{
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	$meal_planer      = $wpdb->prefix . "meal_planer";
	$meal_plans    = $wpdb->prefix . "meal_plans";
	//$fk =  $wpdb->prefix . "posts";

	$sql = "CREATE TABLE IF NOT EXISTS $meal_planer (
      id int(11) NOT NULL AUTO_INCREMENT,
      user_id varchar(255) NOT NULL,
      round int(11) DEFAULT 1,
      starting_date DATETIME DEFAULT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY  (id)
    ) $charset_collate";

	$sql2 = "CREATE TABLE IF NOT EXISTS $meal_plans (
      id int(11) NOT NULL AUTO_INCREMENT,
      user_id int(11),
      action_date  DATETIME DEFAULT NULL,
      action_type varchar(255),
      reciepe_id int(11),
      is_checked int(1) DEFAULT 0,
      is_favourite int(1) DEFAULT 0,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      deleted_at DATETIME DEFAULT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	dbDelta($sql2);

	file_put_contents( __DIR__ . '/my_loggg.txt', ob_get_contents() );

}

register_activation_hook(__FILE__, 'wpac_planner_table');

function wpac_pluginprefix_deactivation()
{
    //Offers_Title
    
    // clear the permalinks to remove post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'wpac_pluginprefix_deactivation');