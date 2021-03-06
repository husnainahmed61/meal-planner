<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";
//$user = $_REQUEST['user'];
$user_id = $_REQUEST['user'];

if ($user_id != 0){
	if (isset($_POST['startingDate']) && !empty($_POST['startingDate'])){

		$userInfo = $wpdb->get_results( "SELECT * FROM ".$meal_planer." WHERE user_id=".$user_id);
		if (isset($userInfo) && !empty($userInfo)) {
			$wpdb->update( $meal_planer, array('starting_date' => $_POST['startingDate']), array('user_id'=> $user_id));
			$userPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id);
			$selectedDate = $_POST['startingDate'];
			if (isset($userPlan) && !empty($userPlan)){
				foreach ($userPlan as $key => $plan){
					$weightDay = 0;
					if ($key == 0 || $key == 3 || $key == 10 || $key == 17 || $key == 24 || $key == 28){
						$weightDay = 1;
					}
					$date = date('Y-m-d', strtotime($selectedDate . ' +'.$key.' day'));
					$data = array(
						'day' => $key+1,
						'is_weight_day' => $weightDay,
						'bf_reciepe_id' => NULL,
						'lunch_reciepe_id' => NULL,
						'dinner_reciepe_id' => NULL,
						'action_date' => $date,
					);
					$wpdb->update( $meal_plans, $data, array('id'=> $plan->id));
				}
			} else {
				for ($i = 0 ; $i < 28 ; $i++){
					$weightDay = 0;
					if ($i == 0 || $i == 3 || $i == 10 || $i == 17 || $i == 24 || $i == 28){
						$weightDay = 1;
					}
					$date = date('Y-m-d', strtotime($selectedDate . ' +'.$i.' day'));
					$data = array(
						'day' => $i+1,
						'is_weight_day' => $weightDay,
						'user_id' =>$user_id,
						'action_date' => $date,
					);
					$wpdb->insert( $meal_plans, $data );
				}
			}
		} else{
			$data = array(
				'user_id' =>$user_id,
				'round' => 1,
				'starting_date' => $_POST['startingDate'],
			);
			$wpdb->insert( $meal_planer, $data );

			if (isset($wpdb->insert_id) && !empty($wpdb->insert_id)){
				$selectedDate = $_POST['startingDate'];
				for ($i = 0 ; $i < 28 ; $i++){
					$weightDay = 0;
					if ($i == 0 || $i == 3 || $i == 10 || $i == 17 || $i == 24 || $i == 28){
						$weightDay = 1;
					}
					$date = date('Y-m-d', strtotime($selectedDate . ' +'.$i.' day'));
					$data = array(
						'day' => $i+1,
						'is_weight_day' => $weightDay,
						'user_id' =>$user_id,
						'action_date' => $date,
					);
					$wpdb->insert( $meal_plans, $data );
				}
			}
		}
		echo json_encode($wpdb->insert_id);
	}
}

