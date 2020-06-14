<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

if (!get_current_user_id()){
	echo("<script>location.href = '".home_url()."'</script>");
}
//check user is available in database else insert in database table meal plan

?>

<div class="container-fluid">
    <div class="row" >
        <div class="col-md-12">
            <h4>Round 3 Day 22</h4>
        </div>
    </div>
    <div class="row" style="border: 1px solid #888888; border-radius: 2px; padding: 50px;">
        <div class="row">
            <div class="col-md-12">
                <h5>Menu</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" style="box-shadow: 0px 10px 8px #888888" >
                <div class="card">
                    <img class="card-img-top" src="https://images2.minutemediacdn.com/image/upload/c_fill,g_auto,h_1248,w_2220/v1555352925/shape/mentalfloss/istock_000059566150_small.jpg?itok=qh2qo4eB" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">BreakFast</h5>
                        <p class="card-text">1 egg and tea.</p>
                        <h4>Lamb Fry</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="box-shadow: 0px 10px 8px #888888">
                <div class="card">
                    <img class="card-img-top" src="https://images2.minutemediacdn.com/image/upload/c_fill,g_auto,h_1248,w_2220/v1555352925/shape/mentalfloss/istock_000059566150_small.jpg?itok=qh2qo4eB" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Lunch</h5>
                        <p class="card-text">Egg Sandwich.</p>
                        <h4>Lamb Fry</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="box-shadow: 0px 10px 8px #888888">
                <div class="card">
                    <img class="card-img-top" src="https://images2.minutemediacdn.com/image/upload/c_fill,g_auto,h_1248,w_2220/v1555352925/shape/mentalfloss/istock_000059566150_small.jpg?itok=qh2qo4eB" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Dinner</h5>
                        <p class="card-text">Fruit Salad.</p>
                        <h4>Lamb Fry</h4>
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
        <div class="col-md-5" style="border: 1px solid #888888; border-radius: 2px;padding: 15px;">
            <h4>Progress</h4>
            <div class="row">
                <button class="btn btn-primary btn-sm" style="min-width: 0px;">Progress</button>
                <button class="btn btn-primary btn-sm" style="min-width: 0px;">Enter Weight</button>
            </div>
        </div>
        <div class="col-md-2">

        </div>
        <div class="col-md-5" style="border: 1px solid #888888; border-radius: 2px; padding: 10px;">
            <h4>Shopping Lists</h4>
        </div>
    </div>
</div>
