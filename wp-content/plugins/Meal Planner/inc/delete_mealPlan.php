<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

$user_id = $_REQUEST['user'];
if ($user_id != 0) {
	$wpdb->delete( $meal_planer, array('user_id'=>$user_id));
	$res = $wpdb->delete( $meal_plans, array('user_id'=>$user_id));

}
echo json_encode($res);