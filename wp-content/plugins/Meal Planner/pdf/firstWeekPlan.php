<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

$adminEdit = $_REQUEST['admin-edit'];
$getUser = $_REQUEST['user'];

if (isset($adminEdit) && $adminEdit == 'yes'){
	$user_id = $getUser;
} else {
	$user = wp_get_current_user();
	$user_id = isset( $user->ID ) ? (int) $user->ID : 0 ;
}

if ($user_id != 0){
	$userInfo = $wpdb->get_results( "SELECT * FROM ".$meal_planer." WHERE user_id=".$user_id);
	$userPlan = $wpdb->get_results( "SELECT * FROM " . $meal_plans . " WHERE user_id=" . $user_id);

	$FirstWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7" );
}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10">
			<h4>First Week Shopping List</h4>
		</div>
		<div class="col-md-4">
			<h5>Break Fast shopping List</h5>
			<?php foreach ($FirstWeekPlan as $plan){
				$bf_meta = get_post_meta( $plan->bf_reciepe_id, $key = '', $single = false );

				$json = $bf_meta['recipe_ingredients'][0];
				$json_un = unserialize($json);

				foreach ($json_un as $key => $ing){
					?>
					<p style="margin: 0"><?=$ing['ingredient'].' '.$ing['amount'].' '.$ing['unit'].' '.($ing['notes'])?></p>

				<?php } ?>
				<hr>
			<?php }
			?>
		</div>
		<div class="col-md-4">
			<h5>Lunch shopping List</h5>
			<?php foreach ($FirstWeekPlan as $plan){
				$lunch_meta = get_post_meta( $plan->lunch_reciepe_id, $key = '', $single = false );

				$json = $lunch_meta['recipe_ingredients'][0];
				$json_un = unserialize($json);

				foreach ($json_un as $key => $ing){
					?>
					<p style="margin: 0"><?=$ing['ingredient'].' '.$ing['amount'].' '.$ing['unit'].' '.($ing['notes'])?></p>

				<?php } ?>
				<hr>
			<?php }
			?>
		</div>
		<div class="col-md-4">
			<h5>Dinner shopping List</h5>
			<?php foreach ($FirstWeekPlan as $plan){
				$lunch_meta = get_post_meta( $plan->lunch_reciepe_id, $key = '', $single = false );
				$dinner_meta = get_post_meta( $plan->dinner_reciepe_id, $key = '', $single = false );

				$json = $dinner_meta['recipe_ingredients'][0];
				$json_un = unserialize($json);

				foreach ($json_un as $key => $ing){
					?>
					<p style="margin: 0"><?=$ing['ingredient'].' '.$ing['amount'].' '.$ing['unit'].' '.($ing['notes'])?></p>

				<?php } ?>
				<hr>
			<?php }
			?>
		</div>
	</div>
</div>
<script>
    jQuery(document).ready(function () {
        window.print();
        return false;
    });
</script>
