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

	$allUserPlan = $wpdb->get_results( "SELECT * FROM " . $meal_plans . " WHERE user_id=" . $user_id);

	try {
		$datetime1 = new DateTime( $userInfo[0]->starting_date );
	} catch ( Exception $e ) {
	}
	$today = new DateTime();
	if ($today < $datetime1){
	    $difference = '';
    } else {
		$difference = $datetime1->diff($today);
    }

	$bf_meta = get_post_meta( $userPlan[0]->bf_reciepe_id, $key = '', $single = false );
	$bf_image = get_the_post_thumbnail_url( $userPlan[0]->bf_reciepe_id, $size = 'post-thumbnail' );

	$lunch_meta = get_post_meta( $userPlan[0]->lunch_reciepe_id, $key = '', $single = false );
	$lunch_image = get_the_post_thumbnail_url( $userPlan[0]->lunch_reciepe_id, $size = 'post-thumbnail' );

	$dinner_meta = get_post_meta( $userPlan[0]->dinner_reciepe_id, $key = '', $single = false );
	$dinner_image = get_the_post_thumbnail_url( $userPlan[0]->dinner_reciepe_id, $size = 'post-thumbnail' );

	$is_weight_day = $userPlan[0]->is_weight_day;
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
            <h4>Round <?=$userInfo[0]->round?> Day <?=(isset($difference) && !empty($difference)) ? $difference->d + 1 : ''?></h4>
        </div>
    </div>
    <div class="row" style="border: 1px solid #888888; border-radius: 2px; padding: 50px;">
        <div class="row">
            <div class="col-md-12">
                <h5>Menu</h5>
            </div>
        </div>
        <div class="row">
            <button class="next btn btn-warning" style="margin: 5px;">Next Day</button>
            <div class="col-md-12">

            </div>

            <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888" >
                <div class="card">
                    <img class="card-img-top" src="<?=(isset($bf_image) && !empty($bf_image)) ? $bf_image : 'http://via.placeholder.com/300x300?text=Breakfast Not Selected'?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                    <div class="card-body">
                        <br>
                        <h5 class="card-title">BreakFast</h5>
                        <h4><?=$bf_meta['recipe_title'][0]?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888">
                <div class="card">
                    <img class="card-img-top" src="<?=(isset($lunch_image) && !empty($lunch_image)) ? $lunch_image : 'http://via.placeholder.com/300x300?text=Lunch Not Selected'?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                    <div class="card-body">
                        <br>
                        <h5 class="card-title">Lunch</h5>
                        <h4><?=$lunch_meta['recipe_title'][0]?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888">
                <div class="card">
                    <img class="card-img-top" src="<?=(isset($dinner_image) && !empty($dinner_image)) ? $dinner_image : 'http://via.placeholder.com/300x300?text=Dinner Not Selected'?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                    <div class="card-body">
                        <br>
                        <h5 class="card-title">Dinner</h5>
                        <h4><?=$dinner_meta['recipe_title'][0]?></h4>
                    </div>
                </div>
            </div>
        </div>
        <?php
        foreach ($allUserPlan as $key => $plan){
	        $bf_meta = get_post_meta($plan->bf_reciepe_id);
	        $bf_image = get_the_post_thumbnail_url( $plan->bf_reciepe_id, $size = 'post-thumbnail' );

	        $lunch_meta = get_post_meta($plan->lunch_reciepe_id);
	        $lunch_image = get_the_post_thumbnail_url( $plan->lunch_reciepe_id, $size = 'post-thumbnail' );

	        $dinner_meta = get_post_meta($plan->dinner_reciepe_id);
	        $dinner_image = get_the_post_thumbnail_url( $plan->dinner_reciepe_id, $size = 'post-thumbnail' );?>
            <div class="row" style="display: none">
                <button class="back btn btn-warning" style="margin: 5px;">Previous Day</button>
                <button class="next btn btn-warning" style="margin: 5px;">Next Day</button>
                <br>
                <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888" >
                    <div class="card">
                        <img class="card-img-top" src="<?=(isset($bf_image) && !empty($bf_image)) ? $bf_image : 'http://via.placeholder.com/300x300?text=Breakfast Not Selected'?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                        <div class="card-body">
                            <br>
                            <h5 class="card-title">BreakFast</h5>
                            <h4><?=$bf_meta['recipe_title'][0]?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888">
                    <div class="card">
                        <img class="card-img-top" src="<?=(isset($lunch_image) && !empty($lunch_image)) ? $lunch_image : 'http://via.placeholder.com/300x300?text=Lunch Not Selected'?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                        <div class="card-body">
                            <br>
                            <h5 class="card-title">Lunch</h5>
                            <h4><?=$lunch_meta['recipe_title'][0]?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="box-shadow: 0px 4px 5px #888888">
                    <div class="card">
                        <img class="card-img-top" src="<?=(isset($dinner_image) && !empty($dinner_image)) ? $dinner_image : 'http://via.placeholder.com/300x300?text=Dinner Not Selected'?>" alt="Card image cap" style="height: 250px;width: 100%;object-fit: cover;">
                        <div class="card-body">
                            <br>
                            <h5 class="card-title">Dinner</h5>
                            <h4><?=$dinner_meta['recipe_title'][0]?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>
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
	            <?php $height = do_shortcode("[wlt-height]");
	            $height = explode('-', $height);
	            $height = $height[0];
	            $height = substr($height, 0, -3);
	            $height = $height/100;
	            $height = $height*$height;

	            if(is_numeric($height)){
		            $currentWeight = do_shortcode("[wlt-weight-start]");
		            $currentWeight = explode('.',$currentWeight);
		            $currentWeight = $currentWeight[0];

		            $targetWeight = do_shortcode("[wlt-target]");
		            $targetWeight = substr($targetWeight, 0, -2);
		            //$targetWeight = $targetWeight[0];


		            $currentBMI = $currentWeight/$height;
		            $currentBMI = number_format($currentBMI,1);
		            if ($currentBMI < 18.5){
			            $currentBMI = 'Underweight'.' ('.$currentBMI.')';
		            }
		            if ($currentBMI >= 18.5 && $currentBMI <= 24.9){
			            $currentBMI = 'Healthy'.' ('.$currentBMI.')';
		            }
		            if ($currentBMI >= 25 && $currentBMI <= 29.9){
			            $currentBMI = 'Overweight'.' ('.$currentBMI.')';
		            }
		            if ($currentBMI >= 30){
			            $currentBMI = 'Obesity'.' ('.$currentBMI.')';
		            }

		            $targetBMI = $targetWeight/$height;
		            $targetBMI = number_format($targetBMI,1);
		            if ($targetBMI < 18.5){
			            $targetBMI = 'Underweight'.' ('.$targetBMI.')';
		            }
		            if ($targetBMI >= 18.5 && $targetBMI <= 24.9){
			            $targetBMI = 'Healthy'.' ('.$targetBMI.')';
		            }
		            if ($targetBMI >= 25 && $targetBMI <= 29.9){
			            $targetBMI = 'Overweight'.' ('.$targetBMI.')';
		            }
		            if ($targetBMI >= 30){
			            $targetBMI = 'Obesity'.' ('.$targetBMI.')';
		            }
                }
	            ?>
                <div class="panel panel-success">
                    <div class="panel-heading">Start Weight : <?=do_shortcode("[wlt-weight-start]")?></div>
                    <div class="panel-body">Start BMI : <?=$currentBMI?> </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">Current Weight : <?=do_shortcode("[wlt-weight-most-recent]")?></div>
                    <div class="panel-body">Current BMI : <?php echo do_shortcode("[wlt-bmi display='both']"); ?> </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">Target Weight : <?=do_shortcode("[wlt-target]")?></div>
                    <div class="panel-body">Target BMI : <?=$targetBMI?> </div>
                </div>
            </div>
            <button class="btn btn-info btn-sm" id="enter_weight">Enter Weight</button>
            <hr>
            <h5>Total Weight Lost : <span class="label label-primary"><?=do_shortcode("[wlt-weight-diff]")?></span></h5>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-5" style="border: 1px solid #888888; border-radius: 2px; padding: 10px;">
            <h4>Shopping List</h4>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" style="min-width: 150px !important;">Today's Shopping List</button>
                    <div id="demo" class="collapse">
		                <?php $json = $bf_meta['recipe_ingredients'][0];
		                $json_un = unserialize($json);

		                if (isset($json_un) && !empty($json_un)){
			                foreach ($json_un as $key => $ing){
				                ?>
                                <p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
			                <?php } } ?>
                        <hr>
		                <?php $json = $lunch_meta['recipe_ingredients'][0];
		                $json_un = unserialize($json);
		                if (isset($json_un) && !empty($json_un)){
			                foreach ($json_un as $key => $ing){
				                ?>
                                <p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
			                <?php } } ?>
                        <hr>
		                <?php $json = $dinner_meta['recipe_ingredients'][0];
		                $json_un = unserialize($json);

		                if (isset($json_un) && !empty($json_un)){
			                foreach ($json_un as $key => $ing){
				                ?>
                                <p style="margin: 0"><?=$ing['amount'].' '.$ing['unit'].' ,'.$ing['ingredient'].' '.($ing['notes'])?></p>
			                <?php } } ?>
                    </div>
                </div>
<!--                <div class="col-md-6">-->
<!--                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo" style="min-width: 150px !important;">Today</button>-->
<!--                </div>-->
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
            <div class="modal-body" style="overflow-y: auto; height: 280px">
                <div class="row">
                    <div class="col-sm-12">
	                    <?php echo do_shortcode("[wlt-form]"); ?>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($is_weight_day) && $is_weight_day ==1){ ?>
    <script>
        jQuery(document).ready(function () {
            jQuery('#myModal').modal('show');
        });
    </script>
<?php }
?>
<script>
    jQuery(document).ready(function () {
        jQuery("#enter_weight").on("click", function () {
            jQuery("#enter_weight").attr('disabled', 'disabled');
            jQuery('#myModal').modal('show');
        });
    });
    jQuery('.next').click(function(){
        jQuery(this).parent().hide().next().fadeIn(500);//hide parent and show next
    });

    jQuery('.back').click(function(){
        jQuery(this).parent().hide().prev().fadeIn(500);//hide parent and show previous
    });
</script>
