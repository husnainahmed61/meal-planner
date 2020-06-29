<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

//$user = wp_get_current_user();
$user_id = $_REQUEST['user'];
$planId = $_REQUEST['planId'];
$planType = $_REQUEST['planType'];

if ($planType == 'bf'){
	$recipe = $wpdb->get_results( "SELECT bf_reciepe_id FROM ".$meal_plans." WHERE user_id=".$user_id." AND id=".$planId );
	$recipeId = $recipe[0]->bf_reciepe_id;
}
if ($planType == 'lunch'){
	$recipe = $wpdb->get_results( "SELECT lunch_reciepe_id FROM ".$meal_plans." WHERE user_id=".$user_id." AND id=".$planId );
	$recipeId = $recipe[0]->lunch_reciepe_id;
}
if ($planType == 'dinner'){
	$recipe = $wpdb->get_results( "SELECT dinner_reciepe_id FROM ".$meal_plans." WHERE user_id=".$user_id." AND id=".$planId );
	$recipeId = $recipe[0]->dinner_reciepe_id;
}

if (isset($recipeId) && !empty($recipeId)){
	$post_content = array(
		'post_id' => $recipeId,
		'post_content' => get_post_meta( $recipeId, $key = '', $single = false ),
		'post_thumbnail' => get_the_post_thumbnail_url( $recipeId, $size = 'post-thumbnail' ) ,
	);
	$reciepes[] = $post_content;
	echo json_encode($reciepes);
}
else{
	echo json_encode('failed');
}
