<?php 
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

// echo "<pre>";
// print_r($_POST);
// echo "file";
 //print_r($_FILES);


 //exit();
if ( isset($_POST) && !empty($_POST) )
{
    $res_word = $_POST['res_word'];

    global $wpdb;
    $table_name      = $wpdb->prefix . "school_res_words";
    //print_r($wpdb->insert($tablename, $data)); exit();
    $res = $wpdb->query("INSERT INTO ".$table_name."(`res_words`) VALUES (
        '".$res_word."')");

    // print_r($wpdb); 
    // exit();
if ($res == TRUE) {
   return true;
}
else
{
    return false;
}


    }
?>