<style>
	.checked {
		color: orange;
	}
</style>
<div class="container-fluid">
	<div class="row" >
		<div class="col-md-12">
			<h2>Create Meal Plan</h2>
		</div>
		<button class="btn btn-primary btn-sm">Auto</button>
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
				<div class="row">
					<div class="col-md-12">
						<h3>Day 1</h3><h5>Wed</h5>
					</div>
					<div class="col-md-4">
						<label class="checkbox-inline"><input type="checkbox" value="">BreakFast</label>
						<img class="select_recipe" src="http://lorempixel.com/400/400/cats/1" alt="Cats"/>
					</div>
					<div class="col-md-4">
						<label class="checkbox-inline"><input type="checkbox" value="">Lunch</label>
						<img src="http://lorempixel.com/400/400/cats/2" alt="Cats"/>
					</div>
					<div class="col-md-4">
						<label class="checkbox-inline"><input type="checkbox" value="">Dinner</label>
						<img src="http://lorempixel.com/400/400/cats/4" alt="Cats"/>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<h3>Day 2</h3><h5>Thu</h5>
					</div>

					<div class="col-md-4">
						<label class="checkbox-inline"><input type="checkbox" value="">BreakFast</label>
						<img class="select_recipe" src="http://lorempixel.com/400/400/cats/1" alt="Cats"/>
					</div>
					<div class="col-md-4">
						<label class="checkbox-inline"><input type="checkbox" value="">Lunch</label>
						<img src="http://lorempixel.com/400/400/cats/2" alt="Cats"/>
					</div>
					<div class="col-md-4">
						<label class="checkbox-inline"><input type="checkbox" value="">Dinner</label>
						<img src="http://lorempixel.com/400/400/cats/4" alt="Cats"/>
					</div>
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
			<div class="modal-body">
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
											<svg class="bd-placeholder-img" width="100%" height="250" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image</text></svg>

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
				<button type="button" class="btn btn-primary btn-sm">Save changes</button>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function () {
        function table_row(item){
            var value = '<div class="row">\
                <div class="card mb-3" style="max-width: 540px;">\
                    <div class="row no-gutters">\
                        <div class="col-md-5">\
                        <img src ="'+item.post_thumbnail+'" class="bd-placeholder-img" width="100%" height="200">\
            </div>\
            <div class="col-md-7">\
                <div class="card-body">\
                <h5 class="card-title">'+item.post_content.recipe_title+'</h5>\
                <span class="fa fa-star checked"></span>\
                <span class="fa fa-star checked"></span>\
                <span class="fa fa-star checked"></span>\
                <span class="fa fa-star"></span>\
                <span class="fa fa-star"></span>\
            <p class="card-text">'+item.post_content.recipe_description+' </p>\
            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>\
            </div>\
            </div>\
            </div>\
            </div>\
            </div>\
            <hr>';
            return value;
        }

        function getReciepes()
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
                        rows+=table_row(jsonParse[i]);
                        //console.log(obj.post_thumbnail);
                    }
                    $('#reciepes').html(rows);
                    // res.response.forEach(el => {
                    //     console.log(el);
                    // });
                    // for(var i=0;i<arr.length;i++){
                    //     if(parseFloat(arr[i].value))
                    //         tot += parseFloat(arr[i].value);
                    // }
                    // document.getElementById('total').value = (tot).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                }
            });

        }
        $(".select_recipe").click(function () {
            getReciepes();
            $('#myModal').modal('show');
        });
    });
</script>