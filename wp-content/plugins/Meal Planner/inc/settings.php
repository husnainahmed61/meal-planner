<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

function wpac_register_menu_page()
{
    add_menu_page('Meal Planner', 'Meal Planner', 'manage_options', 'meal-planner-admin', 'wpac_settings_page_html', 'dashicons-megaphone', 2);
}

add_action('admin_menu', 'wpac_register_menu_page');

function wpac_settings_page_html(){
    include dirname( __FILE__ ) . '/all_users.php';
}

//function wpac_register_submenu_page()
//{
//    add_submenu_page('offers-settings', 'Alle Schulen', 'Alle Schulen', 'manage_options', 'All-Schools', 'wpac_allSchools_page_html');
//    add_submenu_page('offers-settings', 'Schule hinzufügen', 'Schule hinzufügen', 'manage_options', 'Add-new', 'wpac_addNew_page_html');
//    add_submenu_page('offers-settings', 'Blacklist', 'Blacklist', 'manage_options', 'Restricted-words', 'wpac_restrictedWords_page_html');
//
//
//}
//
//add_action('admin_menu', 'wpac_register_submenu_page');

function user_dashboard() {
    //print_r(dirname( __FILE__ ));
    include dirname( __FILE__ ) . '/user_dashboard.php';
} // function my_form_shortcode
add_shortcode( 'user_dashboard_main', 'user_dashboard' );
