<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$query = new WP_Query(array(
	'post_type' => 'recipe',
	'post_status' => 'publish',
	'posts_per_page' => -1
));

$rec = array();
while ($query->have_posts()) {
	$query->the_post();
	$post_id = get_the_ID();
	$post_content = array(
		'post_id' => $post_id,
		'post_content' => get_post_meta( $post_id, $key = '', $single = false ),
		'post_thumbnail' => get_the_post_thumbnail_url( $post_id, $size = 'post-thumbnail' ) ,
		);
	//array_push($rec,$post_content);
	$rec[] = $post_content;
}

//echo "<pre>";
//print_r($rec);
echo json_encode($rec);

wp_reset_query();
// echo "<pre>";
// print_r($results);
//  exit();