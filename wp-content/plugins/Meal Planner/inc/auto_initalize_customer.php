<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";
$user = wp_get_current_user();
$user_id = isset( $user->ID ) ? (int) $user->ID : 0 ;

if ($user_id != 0){

	$userInfo = $wpdb->get_results( "SELECT * FROM ".$meal_planer." WHERE user_id=".$user_id);
	$userPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id);

	//getting all rescipes
	$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	require_once( $parse_uri[0] . 'wp-load.php' );

	$query = new WP_Query(array(
		'post_type' => 'recipe',
		'post_status' => 'publish',
		'posts_per_page' => -1
	));

	$post_id = array();
	while ($query->have_posts()) {
		$query->the_post();
		$post_id[] = get_the_ID();
	}


	if (isset($userInfo) && !empty($userInfo)){
		if (isset($userPlan) && !empty($userPlan)){
			foreach ($userPlan as $key => $plan){
				$k = array_rand($post_id);
				$bf = $post_id[$k];

				$k = array_rand($post_id);
				$lunch = $post_id[$k];

				$k = array_rand($post_id);
				$dinner = $post_id[$k];

				$data = array(
					'bf_reciepe_id' => $bf,
					'lunch_reciepe_id' => $lunch,
					'dinner_reciepe_id' => $dinner
				);

				$wpdb->update( $meal_plans, $data, array('id'=> $plan->id));
			}
		}
		else{
			$selectedDate = date('Y-m-d');
			for ($i = 0 ; $i < 28 ; $i++){
				$date = date('Y-m-d', strtotime($selectedDate . ' +'.$i.' day'));
				$k = array_rand($post_id);
				$bf = $post_id[$k];

				$k = array_rand($post_id);
				$lunch = $post_id[$k];

				$k = array_rand($post_id);
				$dinner = $post_id[$k];

				$data = array(
					'user_id' =>$user_id,
					'action_date' => $date,
					'bf_reciepe_id' => $bf,
					'lunch_reciepe_id' => $lunch,
					'dinner_reciepe_id' => $dinner
				);
				$wpdb->insert( $meal_plans, $data );
			}
		}
	} else {
		$data = array(
			'user_id' =>$user_id,
			'round' => 1,
			'starting_date' => date('Y-m-d'),
		);
		$wpdb->insert( $meal_planer, $data );

		if (isset($wpdb->insert_id) && !empty($wpdb->insert_id)){
			$selectedDate = date('Y-m-d');
			for ($i = 0 ; $i < 28 ; $i++){
				$date = date('Y-m-d', strtotime($selectedDate . ' +'.$i.' day'));
				$k = array_rand($post_id);
				$bf = $post_id[$k];

				$k = array_rand($post_id);
				$lunch = $post_id[$k];

				$k = array_rand($post_id);
				$dinner = $post_id[$k];

				$data = array(
					'user_id' =>$user_id,
					'action_date' => $date,
					'bf_reciepe_id' => $bf,
					'lunch_reciepe_id' => $lunch,
					'dinner_reciepe_id' => $dinner
				);
				$wpdb->insert( $meal_plans, $data );
			}
		}
	}
}

