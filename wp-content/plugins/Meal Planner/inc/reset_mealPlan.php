<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

$user_id = $_REQUEST['user'];
if ($user_id != 0) {
	$data = array(
		'bf_reciepe_id' => NULL,
		'bf_is_checked' => 0,
		'bf_is_favourite' => 0,
		'lunch_reciepe_id' => NULL,
		'lunch_is_checked' => 0,
		'lunch_is_favourite' => 0,
		'dinner_reciepe_id' => NULL,
		'dinner_is_checked' => 0,
		'dinner_is_favourite' => 0,
	);

	$res = $wpdb->update( $meal_plans, $data, array('user_id'=> $user_id));
}
echo json_encode($res);