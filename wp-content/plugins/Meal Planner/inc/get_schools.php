<?php 
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

// echo "<pre>";
// print_r($_REQUEST);
// echo "file";
//  print_r($_FILES);
// exit();

    $query = $_REQUEST['query'];
    

    global $wpdb;
    $table_name      = $wpdb->prefix . "schools";
    //print_r($wpdb->insert($tablename, $data)); exit();
    //$res = $wpdb->get_results( "SELECT * FROM ".$table_name."", OBJECT );
    $db_item =  $wpdb->get_results($wpdb->prepare(
                    "SELECT
                        *
                    FROM
                        ".$table_name."
                    WHERE
                        school_name LIKE %s;",
                    '%' . $wpdb->esc_like($query) . '%'
                ));
    //$data['query'] = $query;
    //$data['suggestions'] = $db_item;
    echo json_encode($db_item);
    

?>