<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

$planId = $_REQUEST['planId'];
$planType = $_REQUEST['planType'];
$is_checked = $_REQUEST['is_checked'];

if ($planType == "bf"){
	$data = array(
		'bf_is_checked' => $is_checked,
	);
}

if ($planType == "lunch"){
	$data = array(
		'lunch_is_checked' => $is_checked,
	);
}

if ($planType == "dinner"){
	$data = array(
		'dinner_is_checked' => $is_checked,
	);
}

$wpdb->update( $meal_plans, $data, array('id'=> $planId));

echo json_encode($is_checked);