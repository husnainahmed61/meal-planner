<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

$planId = $_REQUEST['planId'];
$planType = $_REQUEST['planType'];
$reciepeId = $_REQUEST['reciepeId'];

if ($planType == "bf"){
	$data = array(
		'bf_reciepe_id' => $reciepeId,
	);
}

if ($planType == "lunch"){
	$data = array(
		'lunch_reciepe_id' => $reciepeId,
	);
}

if ($planType == "dinner"){
	$data = array(
		'dinner_reciepe_id' => $reciepeId,
	);
}

$wpdb->update( $meal_plans, $data, array('id'=> $planId));

$image = get_the_post_thumbnail_url( $reciepeId, $size = 'post-thumbnail' );
$res = array(
	'id' => $planType.'_'.$planId,
	'image' => $image
);
echo json_encode($res);