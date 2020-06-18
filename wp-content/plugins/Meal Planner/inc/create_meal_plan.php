<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

//check if user exists - if exist get data
$user = wp_get_current_user();
$user_id = isset( $user->ID ) ? (int) $user->ID : 0 ;

if ($user_id != 0){
    $userInfo = $wpdb->get_results( "SELECT * FROM ".$meal_planer." WHERE user_id=".$user_id);
	$FirstWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7" );

	//LEFT JOIN wp_postmeta v1 ON (wp_posts.ID = v1.post_id)
	$secondWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7 OFFSET 7" );
	$thirdWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7 OFFSET 14" );
	$fourthWeekPlan = $wpdb->get_results( "SELECT * FROM ".$meal_plans." WHERE user_id=".$user_id." LIMIT 7 OFFSET 21" );
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
		<ul class="nav nav-tabs" role="tablist">
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
				<h2>Profile Content Goes Here</h2>
				<img src="http://lorempixel.com/400/400/cats/2" alt="Cats"/>
			</div>
			<div class="tab-pane fade" id="settings">
				<h2>Settings Content Goes Here</h2>
				<img src="http://lorempixel.com/400/400/cats/4" alt="Cats"/>
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
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
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
					</ul>
					<br>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane fade active in" id="reciepes">
						</div>
						<div class="tab-pane fade" id="favourite">
							<div class="row">
								<div class="card mb-3" style="max-width: 540px;">
									<div class="row no-gutters">
										<div class="col-md-5">
											<svg class="bd-placeholder-img" width="100%" height="200" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image</text></svg>
										</div>
										<div class="col-md-7">
											<div class="card-body">
												<h5 class="card-title">Card title</h5>
												<p class="card-text">It's a broader card with text below as a natural lead-in to extra content. This content is a little longer.</p>
												<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
											</div>
										</div>
									</div>
								</div>
							</div>
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
    $(document).ready(function () {
        $("#auto").on("click", function(){
            $("#auto").attr('disabled','disabled');
            $.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/auto_initalize_customer.php",
                data:'',
                cache: false,
                success: function(res)
                {
                    //var jsonData = JSON.parse(res);
                    location.reload();
                    //console.log(jsonData);
                }
            });
        });

        $("#secondWeek, #thirdWeek, #fourthWeek").hide();

        $("#week1").on("click", function(){
            //alert();
            $("#week1").css({"background-color" :"#418AD0", "color": "white"});

            $("#secondWeek, #thirdWeek, #fourthWeek").hide(500);
            $("#week2, #week3, #week4").css({"background-color" :"", "color": ""});
            $("#firstWeek").show(500);
        });

        $("#week2").on("click", function(){
            //alert();
            $("#week2").css({"background-color" :"#418AD0", "color": "white"});
            $("#firstWeek, #thirdWeek, #fourthWeek").hide(500);
            $("#week1, #week3, #week4").css({"background-color" :"", "color": ""});
            $("#secondWeek").show(500);
        });

        $("#week3").on("click", function(){
            $("#week3").css({"background-color" :"#418AD0", "color": "white"});
            $("#firstWeek, #secondWeek, #fourthWeek").hide(500);
            $("#week1, #week2, #week4").css({"background-color" :"", "color": ""});
            $("#thirdWeek").show(500);
        });

        $("#week4").on("click", function(){
            $("#week4").css({"background-color" :"#418AD0", "color": "white"});
            $("#firstWeek, #secondWeek, #thirdWeek").hide(500);
            $("#week1, #week2, #week3").css({"background-color" :"", "color": ""});
            $("#fourthWeek").show(500);
        });


        $("#startingDate").change(function () {
            var startingDate = this.value;
            $("#startingDate").attr('disabled','disabled');
            $.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/initalize_customer.php",
                data:'startingDate='+ startingDate,
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
            $.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/get_recipes.php",
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
                    $('#reciepes').html(rows);
                }
            });

        }
        $(".select_recipe").click(function () {
            var planId = $(this).attr('data-id');
            var planType = $(this).attr('data-type');
            //alert(planType);
            getReciepes(planId,planType);
            $('#myModal').modal('show');
        });

        $("#myModal").on("click",".confrimRecipe",  function () {
            var planId = $(this).attr('data-id');
            var planType = $(this).attr('data-type');
            var reciepeId = $(this).attr('data-reciepe');
            $.ajax
            ({
                type: "post",
                url: "<?=WPAC_PLUGIN_DIR?>" + "inc/add_reciepe.php?planId="+planId+"&planType="+planType+"&reciepeId="+reciepeId,
                cache: false,
                success: function(res)
                {
                    var jsonData = JSON.parse(res);
                    console.log(jsonData);
                    $('#myModal').modal('hide');
                    $('#'+jsonData.id).attr('src', jsonData.image);
                }
            });

        });

        $('.perform_check').change(function() {
            var planId = $(this).attr('data-id');
            var planType = $(this).attr('data-type');
            if(this.checked) {
                $.ajax
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
                $.ajax
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
        $(".favourite").click(function () {
            var $this = $(this);
            var is_favourite = $(this).attr('data-favourite');
            var planId = $(this).attr('data-id');
            var planType = $(this).attr('data-type');
            //alert(planType);
            $.ajax
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