<?php
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

global $wpdb;

$row = $_POST['row'];
$rowperpage = 14;
$table_name = $wpdb->prefix . "schools";

    $results =  $wpdb->get_results("SELECT * FROM $table_name ORDER BY country_code limit ".$row.",".$rowperpage);  
    $html = '';

        foreach ($results as $key => $value) {
     $html .= '<div class="col-sm-6 post" style="cursor: pointer;">';

$html .= '<div class="card mb-3" >';
$html .= '<div class="row " style="margin-left: 0px">';
    $html .= '<div class="col-md-4"> <img src="'.$value->school_image.'" class="img-responsive" alt="Responsive image"> </div>';
    $html .= '<div class="col-md-8">';
      $html .= '<div class="card-body target" data_id="' .$value->id.'">';
        $html .= '<h2  class="card-title">'.$value->school_name.'</h2>'; 
        $table_name = $wpdb->prefix . "schools_rating";
         $res =  $wpdb->get_results("SELECT AVG(average_rating) AS average FROM ".$table_name." WHERE school_id =".$value->id);
       $average = round($res[0]->average);
       $rem_rat = 5-$average;
        for ($i=0; $i <$average ; $i++) {
           $html .= '<i class="fa fa-star" aria-hidden="true"></i>';
         } for ($i=0; $i <$rem_rat ; $i++) {
         $html .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
       }
       $html .= '<p class="card-text">Schulform : '.$value->type_of_school.'</p>';

        $html .= '<p class="card-text"><small class="text-muted">Adresse : '.$value->school_Address. ",".$value->country_code.'</small></p>';
        
      $html .= '</div>';
      $html .= '<form method="get" action="" class="bewertung_button">';
        $html .= '<input type="hidden" name="school_id" value="'.$value->id.'">';
        $html .= '<button type="submit" style="padding: 5px 15px 5px 15px";>Bewertungen</button>
        </form>
    </div>

  </div>
</div>
</div>';

}
echo $html;       



//echo "string111";

?>