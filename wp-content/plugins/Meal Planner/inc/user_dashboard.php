<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

if (!get_current_user_id()){
	echo("<script>location.href = '".home_url()."'</script>");
}
//check user is available in database else insert in database table meal plan
global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

//check if user exists - if exist get data
$user = wp_get_current_user();
$user_id = isset( $user->ID ) ? (int) $user->ID : 0 ;
$dateToday = date('Y-m-d');

if ($user_id != 0) {
	$userInfo      = $wpdb->get_results( "SELECT * FROM " . $meal_planer . " WHERE user_id=" . $user_id );
	$userPlan = $wpdb->get_results( "SELECT * FROM " . $meal_plans . " WHERE user_id=" . $user_id." AND action_date='".$dateToday."'");

	try {
		$datetime1 = new DateTime( $userInfo[0]->starting_date );
	} catch ( Exception $e ) {
	}
	$today = new DateTime();
	$difference = $datetime1->diff($today);

	$bf_meta = get_post_meta( $userPlan[0]->bf_reciepe_id, $key = '', $single = false );
	$bf_image = get_the_post_thumbnail_url( $userPlan[0]->bf_reciepe_id, $size = 'post-thumbnail' );

	$lunch_meta = get_post_meta( $userPlan[0]->lunch_reciepe_id, $key = '', $single = false );
	$lunch_image = get_the_post_thumbnail_url( $userPlan[0]->lunch_reciepe_id, $size = 'post-thumbnail' );

	$dinner_meta = get_post_meta( $userPlan[0]->dinner_reciepe_id, $key = '', $single = false );
	$dinner_image = get_the_post_thumbnail_url( $userPlan[0]->dinner_reciepe_id, $size = 'post-thumbnail' );
//	echo '<pre>';
//	print_r($bf_meta);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Hello ,<?=$user->data->user_nicename?></h3>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-12">
            <h4>Round <?=$userInfo[0]->round?> Day <?=$difference->d?></h4>
        </div>
    </div>
    <div class="row" style="border: 1px solid #888888; border-radius: 2px; padding: 50px;">
        <div class="row">
            <div class="col-md-12">
                <h5>Menu</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888" >
                <div class="card">
                    <img class="card-img-top" src="<?=$bf_image?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                    <div class="card-body">
                        <br>
                        <h5 class="card-title">BreakFast</h5>
                        <h4><?=$bf_meta['recipe_title'][0]?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888">
                <div class="card">
                    <img class="card-img-top" src="<?=$lunch_image?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                    <div class="card-body">
                        <br>
                        <h5 class="card-title">Lunch</h5>
                        <h4><?=$lunch_meta['recipe_title'][0]?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888">
                <div class="card">
                    <img class="card-img-top" src="<?=$dinner_image?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                    <div class="card-body">
                        <br>
                        <h5 class="card-title">Dinner</h5>
                        <h4><?=$dinner_meta['recipe_title'][0]?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <button class="btn btn-primary btn-sm">View Menu</button>
        <button class="btn btn-primary btn-sm">Edit Menu</button>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6" style="border: 1px solid #888888; border-radius: 2px;padding: 15px;">
            <h4>Progress</h4>
            <div class="row">
	            <?php echo do_shortcode("[wlt-form]"); ?>

            </div>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-5" style="border: 1px solid #888888; border-radius: 2px; padding: 10px;">
            <h4>Shopping Lists</h4>
        </div>
    </div>
</div>
