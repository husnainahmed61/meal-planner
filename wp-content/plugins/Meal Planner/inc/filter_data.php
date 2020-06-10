<?php 
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

// echo "<pre>";
// print_r($_POST);
// // echo "file";
//  //print_r($_FILES);

// exit();
if ( isset($_POST['submit']) && !empty($_POST['submit']) )
{

	if (isset($_POST['singleValues_language']) && !empty($_POST['singleValues_language'])) {
		
	
	$language = $_POST['singleValues_language'];

	global $wpdb;
    $table_name = $wpdb->prefix . "caregivers";
    $results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE language='".$language."'", OBJECT );
    // echo "<pre>";
    // print_r($results);
    //  exit();
    }

	if (isset($_POST['singleValues_Age']) && !empty($_POST['singleValues_Age'])) {
		
	$from ="";
	$to = "";
	$age = $_POST['singleValues_Age'];

	//print_r($age);exit();
	if ($age == "1") {
		$from = 18;
		$to = 25;
	}
	if ($age == "2") {
		$from = 26;
		$to = 35;
	}
	if ($age == "3") {
		$from = 36;
		$to = 50;
	}
	if ($age == "4") {
		$from = 51;
		$to = 70;
	}

	global $wpdb;
    $table_name = $wpdb->prefix . "caregivers";
    $results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE age BETWEEN ".$from." AND ".$to." ", OBJECT );
    // echo "<pre>";
    // print_r($wpdb);
    //  exit();
    }

	if (isset($_POST['singleValues']) && !empty($_POST['singleValues'])) {
		
	
	$class = $_POST['singleValues'];

	global $wpdb;
    $table_name = $wpdb->prefix . "caregivers";
    $results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE class='".$class."'", OBJECT );
    // echo "<pre>";
    // print_r($results);
    //  exit();
    }

    if (isset($_POST['singleValues_job_Cat']) && !empty($_POST['singleValues_job_Cat'])) {
		
	
	$job_Cat = $_POST['singleValues_job_Cat'];

	global $wpdb;
    $table_name = $wpdb->prefix . "caregivers";
    $results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE job_type=".$job_Cat."", OBJECT );
    // echo "<pre>";
    // print_r($results);
    //  exit();
    }



    if (isset($results) && !empty($results)) {
    	
    foreach ($results as $key => $value) {
    	echo '<div style="float: left; text-align: center; line-height: 0.5;padding: 10px; ">';
    	echo '<div class="card" style="width: 20rem; ">
  <img class="img-responsive" src="'.$value->image .'" alt="Card image cap" style="height: 20rem;">
  <div class="card-body">
    <h5 class="card-title">'.$value->name .'</h5>
    <h6 class="card-subtitle mb-2 text-muted">'. $value->class .'</h6>
    <p class="card-text">age : '.  $value->age .'</p>';
    if ($value->language == "1") {
        echo '<p class="card-text">Languages : Nigerian</p>';	
    } if($value->language == "2") {
    	echo '<p class="card-text">Languages : English</p>';
		} if($value->language == "3") { 
		echo '<p class="card-text">Languages : English and Nigerian</p>';
		  } if($value->language == "4") { 
    	echo '<p class="card-text">Languages : English and Two Nigerian</p>';
    	 } if($value->language == "5") { 
    	echo '<p class="card-text">Languages : English and More Than Two Nigerian</p>';
     	} if($value->language == '6') { 
    	echo '<p class="card-text">Languages : English, Nigerian and Foreign</p>';
   } 	
    
    echo '<p class="card-text">Salary(₦) :'.  $value->salary .'</p>
  </div>
</div></div>';

}}}
?>