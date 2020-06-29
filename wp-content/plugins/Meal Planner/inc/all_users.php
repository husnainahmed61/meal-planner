<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;
$meal_planer      = $wpdb->prefix . "meal_planer";
$meal_plans    = $wpdb->prefix . "meal_plans";

$usersInfo = $wpdb->get_results( "SELECT * FROM ".$meal_planer);
?>
    <hr>
    <div class="row">
        <div class="col-sm-6 align-self-center" >
            <h3>All Users</h3>
        </div>
    </div>
    <hr>
    <div class="" style="width: 99%;">
        <table id="usersTable" class="" style="width:100%">
            <thead style="text-align: left;">
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Starting Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($usersInfo) && !empty($usersInfo)) {
                foreach ($usersInfo as $key => $user){
	                $userInfo = get_user_by( 'id', $user->user_id );
                    //print_r($userInfo);
                ?>
            <tr>
                <td><?=$key+1?></td>
                <td><?=$userInfo->user_nicename?></td>
                <td><?=$userInfo->user_email?></td>
                <td><?=$user->starting_date?></td>
                <td>
                    <a href="<?=home_url()?>/meal-planner/?admin-edit=yes&user=<?=$user->user_id?>">
                        <button>Edit Meal Plan</button>
                    </a>

                    <button onclick="deleteMealPlan(<?=$user->user_id?>)">Delete Meal Plan</button>
                    <button onclick="resetMealPlan(<?=$user->user_id?>)">Reset Meal Plan</button>
                </td>
            </tr>
            <?php } } ?>
            </tbody>
            <tfoot style="text-align: left;">
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Starting Date</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
<script>
    function deleteMealPlan(userId) {
        jQuery.ajax
        ({
            type: "post",
            url: "<?=WPAC_PLUGIN_DIR?>" + "inc/delete_mealPlan.php",
            data:'user='+userId,
            cache: false,
            success: function(res)
            {
                var jsonData = JSON.parse(res);
                location.reload();

                //console.log(jsonData);
            }
        });
    }
    function resetMealPlan(userId) {
        jQuery.ajax
        ({
            type: "post",
            url: "<?=WPAC_PLUGIN_DIR?>" + "inc/reset_mealPlan.php",
            data:'user='+userId,
            cache: false,
            success: function(res)
            {
                var jsonData = JSON.parse(res);
                location.reload();

                //console.log(jsonData);
            }
        });
    }
</script>