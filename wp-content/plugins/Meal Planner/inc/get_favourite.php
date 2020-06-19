<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

$user = wp_get_current_user();
$user_id = isset( $user->ID ) ? (int) $user->ID : 0 ;

if ($user_id != 0){
	$bf = array();
	$lunch = array();
	$dinner = array();

	$bffav = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." AND bf_is_favourite=1" );
	$lunchfav = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." AND lunch_is_favourite=1" );
	$dinnerfav = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." AND dinner_is_favourite=1" );

	foreach ($bffav as $key => $plan) {
		$bf[] = $plan->bf_reciepe_id;
	}
	foreach ($lunchfav as $key => $plan) {
		$lunch[] = $plan->lunch_reciepe_id;
	}
	foreach ($dinnerfav as $key => $plan) {
		$dinner[] = $plan->dinner_reciepe_id;
	}
	$fav_reciepes = array_unique(array_merge($bf, $lunch, $dinner));

	if (isset($fav_reciepes) && !empty($fav_reciepes)){
		$reciepes = array();
		foreach ($fav_reciepes as $key => $post_id){
			$post_content = array(
				'post_id' => $post_id,
				'post_content' => get_post_meta( $post_id, $key = '', $single = false ),
				'post_thumbnail' => get_the_post_thumbnail_url( $post_id, $size = 'post-thumbnail' ) ,
			);
			//array_push($rec,$post_content);
			$reciepes[] = $post_content;
		}
		echo json_encode($reciepes);
	}
}
