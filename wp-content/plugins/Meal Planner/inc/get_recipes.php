<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$planType = $_REQUEST['planType'];
$planDay = $_REQUEST['planDay'];

if ($planType == "bf"){
	$planType = "breakfast";
}
$query = new WP_Query(array(
	'post_type' => 'recipe',
	'post_status' => 'publish',
	'posts_per_page' => -1
));

$rec = array();
while ($query->have_posts()) {
	$query->the_post();
	$post_id = get_the_ID();

	if (isset($planType) && !empty($planType)){
		$category = get_the_category( $post_id );
		//$rec[] = $category;
		if ((isset($category[0]->name) && (ucfirst($category[0]->name) == ucfirst($planDay) || ucfirst($category[0]->name) == ucfirst($planType)))
		    && ((isset($category[1]->name) && (ucfirst($category[1]->name) == ucfirst($planType) || ucfirst($category[1]->name) == ucfirst($planDay))))){
			$post_content = array(
				'post_id' => $post_id,
				'post_content' => get_post_meta( $post_id, $key = '', $single = false ),
				'post_thumbnail' => get_the_post_thumbnail_url( $post_id, $size = 'post-thumbnail' ) ,
			);
			$rec[] = $post_content;
		} else {
//			$post_content = array(
//				'post_id' => $post_id,
//				'post_content' => get_post_meta( $post_id, $key = '', $single = false ),
//				'post_thumbnail' => get_the_post_thumbnail_url( $post_id, $size = 'post-thumbnail' ) ,
//			);
//			$rec[] = $post_content;
		}
	}

	//array_push($rec,$post_content);

}

//echo "<pre>";
//print_r($rec);
echo json_encode($rec);

wp_reset_query();
// echo "<pre>";
// print_r($results);
//  exit();