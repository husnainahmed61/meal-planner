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
	//LEFT JOIN wp_postmeta v1 ON (wp_posts.ID = v1.post_id)
	$secondWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7 OFFSET 7" );
	$thirdWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7 OFFSET 14" );
	$fourthWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7 OFFSET 21" );
}

if (!get_current_user_id()){
	echo("<script>location.href = '".home_url()."'</script>");
}
//else insert user
?>

<style xmlns="http://www.w3.org/1999/html">
	.checked {
		color: orange;
	}
    .btn:hover, .btn:focus{
        color: white;
    }
	/********************************************************************/
	/*** PANEL INFO ***/
	.with-nav-tabs.panel-info .nav-tabs > li > a,
	.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
	.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
		color: #31708f;
	}
	.with-nav-tabs.panel-info .nav-tabs > .open > a,
	.with-nav-tabs.panel-info .nav-tabs > .open > a:hover,
	.with-nav-tabs.panel-info .nav-tabs > .open > a:focus,
	.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
	.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
		color: #31708f;
		background-color: #bce8f1;
		border-color: transparent;
	}
	.with-nav-tabs.panel-info .nav-tabs > li.active > a,
	.with-nav-tabs.panel-info .nav-tabs > li.active > a:hover,
	.with-nav-tabs.panel-info .nav-tabs > li.active > a:focus {
		color: #31708f;
		background-color: #fff;
		border-color: #bce8f1;
		border-bottom-color: transparent;
	}
	.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu {
		background-color: #d9edf7;
		border-color: #bce8f1;
	}
	.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a {
		color: #31708f;
	}
	.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
	.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
		background-color: #bce8f1;
	}
	.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a,
	.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
	.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
		color: #fff;
		background-color: #31708f;
	}
</style>
<div class="container-fluid">
	<div class="row" >
		<div class="col-md-12">
			<h2>Create Meal Plan</h2>
		</div>
		<div class="col-md-4">
			<button class="btn btn-primary btn-sm" id="auto">Auto</button>
		</div>
		<div class="col-md-4">
			<label>Starting Date</label>
			<input type="date" value="<?=(isset($userInfo[0]->starting_date)) ? date('Y-m-d',strtotime($userInfo[0]->starting_date)) : ''?>" id="startingDate">
		</div>
        <?php if (isset($userInfo[0]->starting_date)) {?>
		<div class="col-md-4">
            <button type="button" id="week1" style="background-color: #418AD0; color:white">Week 1</button>
            <button type="button" id="week2">Week 2</button>
            <button type="button" id="week3">Week 3</button>
            <button type="button" id="week4">Week 4</button>
		</div>
        <?php } ?>
	</div>
	<br>

	<div class="row">

		<!-- Nav tabs -->
		<ul class="nav nav-tabs main-nav-tab" role="tablist">
			<li class="active">
				<a href="#home" role="tab" data-toggle="tab">
					<icon class="fa fa-home"></icon> Overview
				</a>
			</li>
			<li><a href="#profile" role="tab" data-toggle="tab">
					<i class="fa fa-user"></i> Recipes
				</a>
			</li>
			<li>
				<a href="#settings" role="tab" data-toggle="tab">
					<i class="fa fa-cog"></i> Shopping List
				</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane fade active in" id="home">
                <div id="firstWeek">
	                <?php if (isset($FirstWeekPlan) && !empty($FirstWeekPlan)) {
		                foreach ($FirstWeekPlan as $key => $plan) {
			                $bf_meta = get_post_meta($plan->bf_reciepe_id);
			                $bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

			                $lunch_meta = get_post_meta($plan->lunch_reciepe_id);
			                $lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

			                $dinner_meta = get_post_meta($plan->dinner_reciepe_id);
			                $dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
			                //print_r($bf_meta);
		                    ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Day <?=$key+1?></h3><h5><?=date('D',strtotime($plan->action_date)) ?></h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->bf_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="bf" data-id="<?=$plan->id?>" value="<?=$plan->bf_is_checked?>">BreakFast</label>
                                    <button type="button" data-type="bf" data-id="<?=$plan->id?>" data-favourite="<?=$plan->bf_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->bf_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$bf_meta['recipe_title'][0]?></p>

                                    <img id="bf_<?=$plan->id?>" class="select_recipe" data-type="bf" data-id="<?=$plan->id?>" src="<?=(isset($bf_image) && !empty($bf_image)) ? $bf_image : 'http://via.placeholder.com/300x300?text=Select Your Breakfast'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->lunch_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="lunch" data-id="<?=$plan->id?>" value="<?=$plan->lunch_is_checked?>">Lunch</label>
                                    <button type="button" data-type="lunch" data-id="<?=$plan->id?>" data-favourite="<?=$plan->lunch_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->lunch_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$lunch_meta['recipe_title'][0]?></p>
                                    <img id="lunch_<?=$plan->id?>" class="select_recipe" data-type="lunch" data-id="<?=$plan->id?>" src="<?=(isset($lunch_image) && !empty($lunch_image)) ? $lunch_image : 'http://via.placeholder.com/300x300?text=Select Your Lunch'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->dinner_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="dinner" data-id="<?=$plan->id?>" value="<?=$plan->dinner_is_checked?>">Dinner</label>
                                    <button type="button" data-type="dinner" data-id="<?=$plan->id?>" data-favourite="<?=$plan->dinner_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->dinner_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$dinner_meta['recipe_title'][0]?></p>
                                    <img id="dinner_<?=$plan->id?>" class="select_recipe" data-type="dinner" data-id="<?=$plan->id?>" src="<?=(isset($dinner_image) && !empty($dinner_image)) ? $dinner_image : 'http://via.placeholder.com/300x300?text=Select Your Dinner'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                            </div>
                            <hr>
		                <?php } } ?>
                </div>
                <div id="secondWeek">
					<?php if (isset($secondWeekPlan) && !empty($secondWeekPlan)) {
					    $day = 7;
						foreach ($secondWeekPlan as $key => $plan) {
							$bf_meta = get_post_meta($plan->bf_reciepe_id);
							$bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

							$lunch_meta = get_post_meta($plan->lunch_reciepe_id);
							$lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

							$dinner_meta = get_post_meta($plan->dinner_reciepe_id);
							$dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
							?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Day <?=$day+1?></h3><h5><?=date('D',strtotime($plan->action_date)) ?></h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->bf_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="bf" data-id="<?=$plan->id?>" value="<?=$plan->bf_is_checked?>">BreakFast</label>
                                    <button type="button" data-type="bf" data-id="<?=$plan->id?>" data-favourite="<?=$plan->bf_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->bf_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$bf_meta['recipe_title'][0]?></p>

                                    <img id="bf_<?=$plan->id?>" class="select_recipe" data-type="bf" data-id="<?=$plan->id?>" src="<?=(isset($bf_image) && !empty($bf_image)) ? $bf_image : 'http://via.placeholder.com/300x300?text=Select Your Breakfast'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->lunch_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="lunch" data-id="<?=$plan->id?>" value="<?=$plan->lunch_is_checked?>">Lunch</label>
                                    <button type="button" data-type="lunch" data-id="<?=$plan->id?>" data-favourite="<?=$plan->lunch_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->lunch_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$lunch_meta['recipe_title'][0]?></p>
                                    <img id="lunch_<?=$plan->id?>" class="select_recipe" data-type="lunch" data-id="<?=$plan->id?>" src="<?=(isset($lunch_image) && !empty($lunch_image)) ? $lunch_image : 'http://via.placeholder.com/300x300?text=Select Your Lunch'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->dinner_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="dinner" data-id="<?=$plan->id?>" value="<?=$plan->dinner_is_checked?>">Dinner</label>
                                    <button type="button" data-type="dinner" data-id="<?=$plan->id?>" data-favourite="<?=$plan->dinner_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->dinner_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$dinner_meta['recipe_title'][0]?></p>
                                    <img id="dinner_<?=$plan->id?>" class="select_recipe" data-type="dinner" data-id="<?=$plan->id?>" src="<?=(isset($dinner_image) && !empty($dinner_image)) ? $dinner_image : 'http://via.placeholder.com/300x300?text=Select Your Dinner'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                            </div>
                            <hr>
						<?php $day++; } } ?>
                </div>
                <div id="thirdWeek">
					<?php if (isset($thirdWeekPlan) && !empty($thirdWeekPlan)) {
						$day = 14;
						foreach ($thirdWeekPlan as $key => $plan) {
							$bf_meta = get_post_meta($plan->bf_reciepe_id);
							$bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

							$lunch_meta = get_post_meta($plan->lunch_reciepe_id);
							$lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

							$dinner_meta = get_post_meta($plan->dinner_reciepe_id);
							$dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
							?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Day <?=$day+1?></h3><h5><?=date('D',strtotime($plan->action_date)) ?></h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->bf_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="bf" data-id="<?=$plan->id?>" value="<?=$plan->bf_is_checked?>">BreakFast</label>
                                    <button type="button" data-type="bf" data-id="<?=$plan->id?>" data-favourite="<?=$plan->bf_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->bf_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$bf_meta['recipe_title'][0]?></p>

                                    <img id="bf_<?=$plan->id?>" class="select_recipe" data-type="bf" data-id="<?=$plan->id?>" src="<?=(isset($bf_image) && !empty($bf_image)) ? $bf_image : 'http://via.placeholder.com/300x300?text=Select Your Breakfast'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->lunch_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="lunch" data-id="<?=$plan->id?>" value="<?=$plan->lunch_is_checked?>">Lunch</label>
                                    <button type="button" data-type="lunch" data-id="<?=$plan->id?>" data-favourite="<?=$plan->lunch_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->lunch_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$lunch_meta['recipe_title'][0]?></p>
                                    <img id="lunch_<?=$plan->id?>" class="select_recipe" data-type="lunch" data-id="<?=$plan->id?>" src="<?=(isset($lunch_image) && !empty($lunch_image)) ? $lunch_image : 'http://via.placeholder.com/300x300?text=Select Your Lunch'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->dinner_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="dinner" data-id="<?=$plan->id?>" value="<?=$plan->dinner_is_checked?>">Dinner</label>
                                    <button type="button" data-type="dinner" data-id="<?=$plan->id?>" data-favourite="<?=$plan->dinner_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->dinner_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$dinner_meta['recipe_title'][0]?></p>
                                    <img id="dinner_<?=$plan->id?>" class="select_recipe" data-type="dinner" data-id="<?=$plan->id?>" src="<?=(isset($dinner_image) && !empty($dinner_image)) ? $dinner_image : 'http://via.placeholder.com/300x300?text=Select Your Dinner'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                            </div>
                            <hr>
							<?php $day++; } } ?>
                </div>
                <div id="fourthWeek">
					<?php if (isset($fourthWeekPlan) && !empty($fourthWeekPlan)) {
						$day = 21;
						foreach ($fourthWeekPlan as $key => $plan) {
							$bf_meta = get_post_meta($plan->bf_reciepe_id);
							$bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

							$lunch_meta = get_post_meta($plan->lunch_reciepe_id);
							$lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

							$dinner_meta = get_post_meta($plan->dinner_reciepe_id);
							$dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
							?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Day <?=$day+1?></h3><h5><?=date('D',strtotime($plan->action_date)) ?></h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->bf_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="bf" data-id="<?=$plan->id?>" value="<?=$plan->bf_is_checked?>">BreakFast</label>
                                    <button type="button" data-type="bf" data-id="<?=$plan->id?>" data-favourite="<?=$plan->bf_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->bf_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$bf_meta['recipe_title'][0]?></p>

                                    <img id="bf_<?=$plan->id?>" class="select_recipe" data-type="bf" data-id="<?=$plan->id?>" src="<?=(isset($bf_image) && !empty($bf_image)) ? $bf_image : 'http://via.placeholder.com/300x300?text=Select Your Breakfast'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->lunch_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="lunch" data-id="<?=$plan->id?>" value="<?=$plan->lunch_is_checked?>">Lunch</label>
                                    <button type="button" data-type="lunch" data-id="<?=$plan->id?>" data-favourite="<?=$plan->lunch_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->lunch_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$lunch_meta['recipe_title'][0]?></p>
                                    <img id="lunch_<?=$plan->id?>" class="select_recipe" data-type="lunch" data-id="<?=$plan->id?>" src="<?=(isset($lunch_image) && !empty($lunch_image)) ? $lunch_image : 'http://via.placeholder.com/300x300?text=Select Your Lunch'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" <?=($plan->dinner_is_checked == 1) ? 'checked' : ''?> class="perform_check" data-type="dinner" data-id="<?=$plan->id?>" value="<?=$plan->dinner_is_checked?>">Dinner</label>
                                    <button type="button" data-type="dinner" data-id="<?=$plan->id?>" data-favourite="<?=$plan->dinner_is_favourite?>" class="btn btn-sm favourite" style="min-width: 50px;float: right;font-size: xx-large;">
                                        <span class="glyphicon glyphicon-heart<?=($plan->dinner_is_favourite == 0) ? '-empty' : ''?>"></span>
                                    </button>
                                    <p><?=$dinner_meta['recipe_title'][0]?></p>
                                    <img id="dinner_<?=$plan->id?>" class="select_recipe" data-type="dinner" data-id="<?=$plan->id?>" src="<?=(isset($dinner_image) && !empty($dinner_image)) ? $dinner_image : 'http://via.placeholder.com/300x300?text=Select Your Dinner'?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
                                </div>
                            </div>
                            <hr>
							<?php $day++; } } ?>
                </div>
			</div>
			<div class="tab-pane fade" id="profile">
				<h2>Recipes Content</h2>
				<div class="panel with-nav-tabs panel-info">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab1info" data-toggle="tab">Week 1</a></li>
							<li><a href="#tab2info" data-toggle="tab">Week 2</a></li>
							<li><a href="#tab3info" data-toggle="tab">Week 3</a></li>
							<li><a href="#tab4info" data-toggle="tab">Week 4</a></li>
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1info">
								<?php if (isset($FirstWeekPlan) && !empty($FirstWeekPlan)) {
								foreach ($FirstWeekPlan as $key => $plan) {
								$bf_meta = get_post_meta($plan->bf_reciepe_id);
								$bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

								$lunch_meta = get_post_meta($plan->lunch_reciepe_id);
								$lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

								$dinner_meta = get_post_meta($plan->dinner_reciepe_id);
								$dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
								$day = $key+1;
								?>
									<!--Break Fast goes here-->
									<div class="row">
										<div class="col-md-4">
											<h3><?=$bf_meta['recipe_title'][0]?></h3>
										</div>
										<div class="col-md-4">
											<h5>Day <?=$day?></h5>
										</div>
										<div class="col-md-4">
											<p><?=date('D',strtotime($plan->action_date)) ?> - Breakfast</p>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<img src="<?=$bf_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
										</div>
										<div class="col-md-8">
											<h5>Description</h5>
											<p><?=($bf_meta['recipe_description'][0])?></p>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-4" style="background-color: beige;padding: 15px">
											<p><?=$bf_meta['recipe_servings'][0]?> Servings</p>
											<h5>Ingredients</h5>
											<?php $json = $bf_meta['recipe_ingredients'][0];
											$json_un = unserialize($json);

											foreach ($json_un as $key => $ing){
												?>
												<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
											<?php } ?>

										</div>
										<div class="col-md-8 ">
											<h5>Instructions</h5>
											<?php $json = $bf_meta['recipe_instructions'][0];
											$json_un = unserialize($json);
											//print_r($json_un)
											foreach ($json_un as $key => $desc){
												?>
												<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
											<?php } ?>
										</div>
									</div>
									<hr>
									<!--Lunch goes here-->
									<div class="row">
										<div class="col-md-4">
											<h3><?=$lunch_meta['recipe_title'][0]?></h3>
										</div>
										<div class="col-md-4">
											<h5>Day <?=$day?></h5>
										</div>
										<div class="col-md-4">
											<p><?=date('D',strtotime($plan->action_date)) ?> - Lunch</p>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<img src="<?=$lunch_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
										</div>
										<div class="col-md-8">
											<h5>Description</h5>
											<p><?=($lunch_meta['recipe_description'][0])?></p>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-4" style="background-color: beige;padding: 15px">
											<p><?=$lunch_meta['recipe_servings'][0]?> Servings</p>
											<h5>Ingredients</h5>
											<?php $json = $lunch_meta['recipe_ingredients'][0];
											$json_un = unserialize($json);

											foreach ($json_un as $key => $ing){
												?>
												<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
											<?php } ?>

										</div>
										<div class="col-md-8 ">
											<h5>Instructions</h5>
											<?php $json = $lunch_meta['recipe_instructions'][0];
											$json_un = unserialize($json);
											//print_r($json_un)
											foreach ($json_un as $key => $desc){
												?>
												<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
											<?php } ?>
										</div>
									</div>
									<hr>
									<!--Dinner Goes here-->
									<div class="row">
										<div class="col-md-4">
											<h3><?=$dinner_meta['recipe_title'][0]?></h3>
										</div>
										<div class="col-md-4">
											<h5>Day <?=$day?></h5>
										</div>
										<div class="col-md-4">
											<p><?=date('D',strtotime($plan->action_date)) ?> - Dinner</p>
										</div>

									</div>
									<div class="row">
										<div class="col-md-4">
											<img src="<?=$dinner_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
										</div>
										<div class="col-md-8">
											<h5>Description</h5>
											<p><?=($dinner_meta['recipe_description'][0])?></p>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-4" style="background-color: beige;padding: 15px">
											<p><?=$dinner_meta['recipe_servings'][0]?> Servings</p>
											<h5>Ingredients</h5>
											<?php $json = $dinner_meta['recipe_ingredients'][0];
											$json_un = unserialize($json);

											foreach ($json_un as $key => $ing){
											?>
											<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
											<?php } ?>

										</div>
										<div class="col-md-8 ">
											<h5>Instructions</h5>
											<?php $json = $dinner_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
											foreach ($json_un as $key => $desc){
											?>
											<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
											<?php } ?>
										</div>
									</div>
									<hr>
								<?php } } ?>
							</div>
							<div class="tab-pane fade" id="tab2info">
								<?php if (isset($secondWeekPlan) && !empty($secondWeekPlan)) {
									foreach ($secondWeekPlan as $key => $plan) {
										$bf_meta = get_post_meta($plan->bf_reciepe_id);
										$bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

										$lunch_meta = get_post_meta($plan->lunch_reciepe_id);
										$lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

										$dinner_meta = get_post_meta($plan->dinner_reciepe_id);
										$dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
										$day = 8+$key;
										?>
										<!--Break Fast goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$bf_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Breakfast</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$bf_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($bf_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$bf_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $bf_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $bf_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
										<!--Lunch goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$lunch_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Lunch</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$lunch_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($lunch_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$lunch_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $lunch_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $lunch_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
										<!--Dinner Goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$dinner_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Dinner</p>
											</div>

										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$dinner_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($dinner_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$dinner_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $dinner_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $dinner_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
									<?php } } ?>
							</div>
							<div class="tab-pane fade" id="tab3info">
								<?php if (isset($thirdWeekPlan) && !empty($thirdWeekPlan)) {
									foreach ($thirdWeekPlan as $key => $plan) {
										$bf_meta = get_post_meta($plan->bf_reciepe_id);
										$bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

										$lunch_meta = get_post_meta($plan->lunch_reciepe_id);
										$lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

										$dinner_meta = get_post_meta($plan->dinner_reciepe_id);
										$dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
										$day = 15+$key;
										?>
										<!--Break Fast goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$bf_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Breakfast</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$bf_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($bf_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$bf_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $bf_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $bf_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
										<!--Lunch goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$lunch_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Lunch</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$lunch_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($lunch_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$lunch_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $lunch_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $lunch_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
										<!--Dinner Goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$dinner_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Dinner</p>
											</div>

										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$dinner_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($dinner_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$dinner_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $dinner_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $dinner_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
									<?php } } ?>
							</div>
							<div class="tab-pane fade" id="tab4info">
								<?php if (isset($fourthWeekPlan) && !empty($fourthWeekPlan)) {
									foreach ($fourthWeekPlan as $key => $plan) {
										$bf_meta = get_post_meta($plan->bf_reciepe_id);
										$bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

										$lunch_meta = get_post_meta($plan->lunch_reciepe_id);
										$lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

										$dinner_meta = get_post_meta($plan->dinner_reciepe_id);
										$dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );
										$day = 22+$key;
										?>
										<!--Break Fast goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$bf_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Breakfast</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$bf_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($bf_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$bf_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $bf_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $bf_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
										<!--Lunch goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$lunch_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Lunch</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$lunch_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($lunch_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$lunch_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $lunch_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $lunch_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
										<!--Dinner Goes here-->
										<div class="row">
											<div class="col-md-4">
												<h3><?=$dinner_meta['recipe_title'][0]?></h3>
											</div>
											<div class="col-md-4">
												<h5>Day <?=$day?></h5>
											</div>
											<div class="col-md-4">
												<p><?=date('D',strtotime($plan->action_date)) ?> - Dinner</p>
											</div>

										</div>
										<div class="row">
											<div class="col-md-4">
												<img src="<?=$dinner_image?>" alt="Cats" style="height: 300px;width: 100%;object-fit: cover;"/>
											</div>
											<div class="col-md-8">
												<h5>Description</h5>
												<p><?=($dinner_meta['recipe_description'][0])?></p>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-md-4" style="background-color: beige;padding: 15px">
												<p><?=$dinner_meta['recipe_servings'][0]?> Servings</p>
												<h5>Ingredients</h5>
												<?php $json = $dinner_meta['recipe_ingredients'][0];
												$json_un = unserialize($json);

												foreach ($json_un as $key => $ing){
													?>
													<p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
												<?php } ?>

											</div>
											<div class="col-md-8 ">
												<h5>Instructions</h5>
												<?php $json = $dinner_meta['recipe_instructions'][0];
												$json_un = unserialize($json);
												//print_r($json_un)
												foreach ($json_un as $key => $desc){
													?>
													<p style="margin: 0"><?=$key+1?> : <?=$desc['description']?></p>
												<?php } ?>
											</div>
										</div>
										<hr>
									<?php } } ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="settings">
				<br>
				<div class="row" id="firstWeekPlan">
                    <div class="col-md-10">
                        <h4>First Week Shopping List</h4>
                    </div>
                    <div class="col-md-2">
	                    <button class="" onclick="printJS('firstWeekPlan', 'html')">Download PDF</button>
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
                <br>
                <div class="row" id="secondWeekPlan">
                    <div class="col-md-10">
                        <h4>Second Week Shopping List</h4>
                    </div>
                    <div class="col-md-2">
                        <button class="" onclick="printJS('secondWeekPlan', 'html')">Download PDF</button>
                    </div>
                    <div class="col-md-4">
                        <h5>Break Fast shopping List</h5>
						<?php foreach ($secondWeekPlan as $plan){
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
						<?php foreach ($secondWeekPlan as $plan){
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
						<?php foreach ($secondWeekPlan as $plan){
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
                <br>
                <div class="row" id="thirdWeekPlan">
                    <div class="col-md-10">
                        <h4>Third Week Shopping List</h4>
                    </div>
                    <div class="col-md-2">
                        <button class="" onclick="printJS('thirdWeekPlan', 'html')">Download PDF</button>
                    </div>
                    <div class="col-md-4">
                        <h5>Break Fast shopping List</h5>
						<?php foreach ($thirdWeekPlan as $plan){
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
						<?php foreach ($thirdWeekPlan as $plan){
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
						<?php foreach ($thirdWeekPlan as $plan){
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
                <br>
                <div class="row" id="fourthWeekPlan">
                    <div class="col-md-10">
                        <h4>Fourth Week Shopping List</h4>
                    </div>
                    <div class="col-md-2">
                        <button class="" onclick="printJS('fourthWeekPlan', 'html')">Download PDF</button>
                    </div>
                    <div class="col-md-4">
                        <h5>Break Fast shopping List</h5>
						<?php foreach ($fourthWeekPlan as $plan){
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
						<?php foreach ($fourthWeekPlan as $plan){
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
						<?php foreach ($fourthWeekPlan as $plan){
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
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" style="overflow-y: auto; height: 500px">
				<div class="row">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="active">
							<a href="#reciepes" role="tab" data-toggle="tab">
								<icon class="fa fa-home"></icon> Search / Browse
							</a>
						</li>
						<li><a href="#favourite" role="tab" data-toggle="tab">
								<i class="fa fa-user"></i> Favourites
							</a>
						</li>
                        <li><a href="#current" role="tab" data-toggle="tab">
                                <i class="fa fa-check"></i> View Current
                            </a>
                        </li>
					</ul>
					<br>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane fade active in" id="reciepes">
						</div>
						<div class="tab-pane fade" id="favourite">
						</div>
                        <div class="tab-pane fade" id="current">
                        </div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
    jQuery(document).ready(function () {

        jQuery("#auto").on("click", function(){
            jQuery("#auto").attr('disabled','disabled');
            jQuery.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/auto_initalize_customer.php",
                data:'user=<?=$user_id?>',
                cache: false,
                success: function(res)
                {
                    //var jsonData = JSON.parse(res);
                    location.reload();
                    //console.log(jsonData);
                }
            });
        });

        jQuery("#secondWeek, #thirdWeek, #fourthWeek").hide();

        jQuery("#week1").on("click", function(){
            //alert();
            jQuery("#week1").css({"background-color" :"#418AD0", "color": "white"});

            jQuery("#secondWeek, #thirdWeek, #fourthWeek").hide(500);
            jQuery("#week2, #week3, #week4").css({"background-color" :"", "color": ""});
            jQuery("#firstWeek").show(500);
        });

        jQuery("#week2").on("click", function(){
            //alert();
            jQuery("#week2").css({"background-color" :"#418AD0", "color": "white"});
            jQuery("#firstWeek, #thirdWeek, #fourthWeek").hide(500);
            jQuery("#week1, #week3, #week4").css({"background-color" :"", "color": ""});
            jQuery("#secondWeek").show(500);
        });

        jQuery("#week3").on("click", function(){
            jQuery("#week3").css({"background-color" :"#418AD0", "color": "white"});
            jQuery("#firstWeek, #secondWeek, #fourthWeek").hide(500);
            jQuery("#week1, #week2, #week4").css({"background-color" :"", "color": ""});
            jQuery("#thirdWeek").show(500);
        });

        jQuery("#week4").on("click", function(){
            jQuery("#week4").css({"background-color" :"#418AD0", "color": "white"});
            jQuery("#firstWeek, #secondWeek, #thirdWeek").hide(500);
            jQuery("#week1, #week2, #week3").css({"background-color" :"", "color": ""});
            jQuery("#fourthWeek").show(500);
        });


        jQuery("#startingDate").change(function () {
            var startingDate = this.value;
            jQuery("#startingDate").attr('disabled','disabled');
            jQuery.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/initalize_customer.php",
                data:'startingDate='+ startingDate+'&user=<?=$user_id?>',
                cache: false,
                success: function(res)
                {
                    var jsonData = JSON.parse(res);
                    location.reload();
                }
            });
        });
        function table_row(item,planId,planType){
            var stars = item.post_content.recipe_rating;
            var starRows = '';
            for(var i = 0; i < stars; i++) {
                starRows+='<span class="fa fa-star checked"></span>';
            }
            var value = '<div class="row confrimRecipe" style="cursor: pointer;" data-type="'+planType+'" data-id="'+planId+'" data-reciepe="'+item.post_id+'">\
                <div class="card mb-3" style="max-width: 540px;">\
                    <div class="row no-gutters">\
                        <div class="col-md-5">\
                        <img src ="'+item.post_thumbnail+'" class="bd-placeholder-img" style="height: 150px;width: 100%;object-fit: cover;">\
            </div>\
            <div class="col-md-7">\
                <div class="card-body">\
                <h5 class="card-title">'+item.post_content.recipe_title+'</h5>'+starRows+'\
            <p class="card-text">'+item.post_content.recipe_description+' </p>\
            <p class="card-text"><small class="text-muted">Recipe cook time : '+item.post_content.recipe_cook_time+' '+item.post_content.recipe_cook_time_text+'</small></p>\
            </div>\
            </div>\
            </div>\
            </div>\
            </div>\
            <hr>';
            return value;
        }

        function getReciepes(planId,planType)
        {
            jQuery.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/get_recipes.php",
                data: 'planType='+planType,
                cache: false,
                success: function(res)
                {
                    var jsonParse = JSON.parse(res);
                    console.log(jsonParse);
                    var rows = '';
                    for(var i = 0; i < jsonParse.length; i++) {
                        var obj = jsonParse[i];
                        rows+=table_row(jsonParse[i],planId,planType);
                        //console.log(obj.post_thumbnail);
                    }
                    jQuery('#reciepes').html(rows);
                }
            });
        }
        function getFavourites(planId,planType)
        {
            jQuery.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/get_favourite.php",
                data:'user=<?=$user_id?>',
                cache: false,
                success: function(res)
                {
                    var jsonParse = JSON.parse(res);
                    console.log(jsonParse);
                    var rows = '';
                    for(var i = 0; i < jsonParse.length; i++) {
                        var obj = jsonParse[i];
                        rows+=table_row(jsonParse[i],planId,planType);
                        //console.log(obj.post_thumbnail);
                    }
                    jQuery('#favourite').html(rows);
                }
            });
        }
        function getCurrent(planId,planType)
        {
            jQuery.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/get_current.php",
                data:'user=<?=$user_id?>&planId='+planId+'&planType='+planType,
                cache: false,
                success: function(res)
                {
                    var jsonParse = JSON.parse(res);
                    console.log(jsonParse);
                    if (jsonParse === 'failed'){
                        jQuery('#current').html('<div class="row" style="text-align: center;"><h5>Nothing is selected for current tab</h5></div>');
                    }
                    else{
                        var rows = '';
                        for(var i = 0; i < jsonParse.length; i++) {
                            var obj = jsonParse[i];
                            rows+=table_row(jsonParse[i],planId,planType);
                            //console.log(obj.post_thumbnail);
                        }
                        jQuery('#current').html(rows);
                    }
                }
            });
        }
        jQuery(".select_recipe").click(function () {
            var planId = jQuery(this).attr('data-id');
            var planType = jQuery(this).attr('data-type');
            //alert(planType);
            getReciepes(planId,planType);
            getFavourites(planId,planType);
            getCurrent(planId,planType);
            jQuery('#myModal').modal('show');
        });

        jQuery("#myModal").on("click",".confrimRecipe",  function () {
            var planId = jQuery(this).attr('data-id');
            var planType = jQuery(this).attr('data-type');
            var reciepeId = jQuery(this).attr('data-reciepe');
            jQuery.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/add_reciepe.php?planId="+planId+"&planType="+planType+"&reciepeId="+reciepeId,
                cache: false,
                success: function(res)
                {
                    var jsonData = JSON.parse(res);
                    console.log(jsonData);
                    jQuery('#myModal').modal('hide');
                    jQuery('#'+jsonData.id).attr('src', jsonData.image);
                }
            });

        });

        jQuery('.perform_check').change(function() {
            var planId = jQuery(this).attr('data-id');
            var planType = jQuery(this).attr('data-type');
            if(this.checked) {
                jQuery.ajax
                ({
                    type: "post",
                    url: "<?=WPAC_PLUGIN_DIR?>" + "inc/perform_meal_check.php?planId="+planId+"&planType="+planType+"&is_checked=1",
                    cache: false,
                    success: function(res)
                    {
                        //var jsonData = JSON.parse(res);
                        console.log(res);
                    }
                });

                //alert(planId);
            } else {
                jQuery.ajax
                ({
                    type: "post",
                    url: "<?=WPAC_PLUGIN_DIR?>" + "inc/perform_meal_check.php?planId="+planId+"&planType="+planType+"&is_checked=0",
                    cache: false,
                    success: function(res)
                    {
                        //var jsonData = JSON.parse(res);
                        console.log(res);
                    }
                });
            }
        });
        //favourite
        jQuery(".favourite").click(function () {
            var $this = jQuery(this);
            var is_favourite = jQuery(this).attr('data-favourite');
            var planId = jQuery(this).attr('data-id');
            var planType = jQuery(this).attr('data-type');
            //alert(planType);
            jQuery.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/add_favourite.php?planId="+planId+"&planType="+planType+"&is_favourite="+is_favourite,
                cache: false,
                success: function(res)
                {
                    var jsonData = JSON.parse(res);
                    $this.attr('data-favourite', jsonData.is_checked);

                    if(jsonData.is_checked === 0){
                        $this.html('');
                        $this.html('<span class="glyphicon glyphicon-heart-empty"></span>');
                    }
                    if(jsonData.is_checked === 1){
                        $this.html('');
                        $this.html('<span class="glyphicon glyphicon-heart"></span>');
                    }
                    console.log(res);
                }
            });
        });
    });
</script>