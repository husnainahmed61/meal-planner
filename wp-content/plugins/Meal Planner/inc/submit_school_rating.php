<?php 
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../../wp-config.php');

//------------------------------------------------------------------- CONNECT DO DATABASE ------------------------------------------------------------------- 

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
 global $wpdb;

$ip = get_client_ip();
// echo "<pre>";
// print_r($ip);
// exit();
$school_id = $_POST['school_id'];

$table_name = $wpdb->prefix . "schools_rating";
$count_res = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE school_id = ".$school_id." AND user_ip ='".$ip."'");

    $rowcount = count($count_res);
    //print_r($wpdb->last_query);
// print_r($rowcount);
// exit();
if ($rowcount >= 1) {

    echo "2";
    exit();
}

$rating1 = $_POST['rating1'];
$rating2 = $_POST['rating2'];
$rating3 = $_POST['rating3'];
$rating4 = $_POST['rating4'];
$rating5 = $_POST['rating5'];

$average_rating = ($rating1+$rating2+$rating3+$rating4)/4;
// echo "<pre>";
// print_r($average_rating);
// exit();


 //exit();
if ( isset($_POST['submit']) && !empty($_POST['submit']) )
{
//------------------------------------------------------------------- WRITE IN DATABASE ------------------------------------------------------------------- 

    $table_name      = $wpdb->prefix . "schools_rating";
    //print_r($wpdb->insert($tablename, $data)); exit();
    $res = $wpdb->query("INSERT INTO ".$table_name."(`school_id`, `user_ip`, `q1_rating`, `q1_comment`, `q2_rating`, `q2_comment`, `q3_rating`, `q3_comment`, `q4_rating`, `q4_comment`, `average_rating`, `main_comment`,`user_email`) VALUES (
        '".$school_id."',
        '".$ip."',
        '".$rating1."',
        '".$_POST['comment1']."',
        '".$rating2."',
        '".$_POST['comment2']."',
        '".$rating3."',
        '".$_POST['comment3']."',
        '".$rating4."',
        '".$_POST['comment4']."',
        '".$average_rating."',
        '".$_POST['comment5']."',
        '".$_POST['user_email']."')");

//------------------------------------------------------------------- SUCCESS MESSAGE ------------------------------------------------------------------- 
if ($res == TRUE) {
    $data['message'] = "success";
    echo "1";

//--------- Send Mail ----------

//	require(__DIR__ . '/wp-load.php');

	if (filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
	$to      = $_POST['user_email'];
	$subject = 'Deine Bewertung wurde eingereicht';
	$message = '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>        <title>                  </title>        <!--[if !mso]><!-- -->        <meta http-equiv="X-UA-Compatible" content="IE=edge">        <!--<![endif]-->        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <style type="text/css">          #outlook a { padding:0; }          .ReadMsgBody { width:100%; }          .ExternalClass { width:100%; }          .ExternalClass * { line-height:100%; }          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }          p { display:block;margin:13px 0; }        </style>        <!--[if !mso]><!-->        <style type="text/css">          @media only screen and (max-width:480px) {            @-ms-viewport { width:320px; }            @viewport { width:320px; }          }        </style>        <!--<![endif]-->        <!--[if mso]>        <xml>        <o:OfficeDocumentSettings>          <o:AllowPNG/>          <o:PixelsPerInch>96</o:PixelsPerInch>        </o:OfficeDocumentSettings>        </xml>        <![endif]-->        <!--[if lte mso 11]>        <style type="text/css">          .outlook-group-fix { width:100% !important; }        </style>        <![endif]-->              <!--[if !mso]><!-->        <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet" type="text/css">        <style type="text/css">          @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);@import url(https://fonts.googleapis.com/css?family=Cabin:400,700);        </style>      <!--<![endif]-->                <style type="text/css">      @media only screen and (min-width:480px) {        .mj-column-per-100 { width:100% !important; max-width: 100%; }      }    </style>              <style type="text/css">                    @media only screen and (max-width:480px) {      table.full-width-mobile { width: 100% !important; }      td.full-width-mobile { width: auto !important; }    }          </style>        <style type="text/css">.hide_on_mobile { display: none !important;}         @media only screen and (min-width: 480px) { .hide_on_mobile { display: block !important;} }        [owa] .mj-column-per-100 {            width: 100%!important;          }          [owa] .mj-column-per-50 {            width: 50%!important;          }          [owa] .mj-column-per-33 {            width: 33.333333333333336%!important;          }          p {              margin: 0px;          }</style>              </head>      <body style="background-color:#FFFFFF;">                      <div style="background-color:#FFFFFF;">                    <!--[if mso | IE]>      <table         align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"      >        <tr>          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">      <![endif]-->                <div style="Margin:0px auto;max-width:600px;">                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">          <tbody>            <tr>              <td style="direction:ltr;font-size:0px;padding:9px 0px 9px 0px;text-align:center;vertical-align:top;">                <!--[if mso | IE]>                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">                        <tr>                  <td               class="" style="vertical-align:top;width:600px;"            >          <![endif]-->                  <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">              <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">                    <tbody><tr>              <td align="center" style="font-size:0px;padding:0px 0px 0px 0px;word-break:break-word;">                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">        <tbody>          <tr>            <td style="width:180px;">                    <img height="auto" src="https://gradeyourschool.at/wp-content/uploads/2019/08/gys_logo_.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="180">                </td>          </tr>        </tbody>      </table>                  </td>            </tr>                      <tr>              <td style="font-size:0px;padding:10px 25px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:25px;word-break:break-word;">                      <p style="border-top:solid 1px #000000;font-size:1;margin:0px auto;width:100%;">      </p>            <!--[if mso | IE]>        <table           align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #000000;font-size:1;margin:0px auto;width:565px;" role="presentation" width="565px"        >          <tr>            <td style="height:0;line-height:0;">              &nbsp;            </td>          </tr>        </table>      <![endif]-->                      </td>            </tr>                      <tr>              <td align="center" style="font-size:0px;padding:0px 15px 5px 15px;word-break:break-word;">                      <div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:1.5;text-align:center;color:#000000;">        <p><span style="font-size:16px;"><strong>Danke f&#xFC;r deine Bewertung!</strong></span></p>      </div>                  </td>            </tr>                      <tr>              <td align="left" style="font-size:0px;padding:15px 15px 15px 15px;word-break:break-word;">                      <div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:1.5;text-align:left;color:#000000;">        <p>Hey!</p><br><p></p><p>Vielen Dank f&#xFC;r deine Bewertung auf GradeYourSchool.at&#x1F64C;</p><br><p>Mit deiner Bewertung wirst du vielleicht der/die pers&#xF6;nliche Held/in f&#xFC;r eine/n potenziellen Mitsch&#xFC;ler da du ihm/ihr gerade die Schulwahl ein wenig erleichtert hast.</p><p></p><br><p>Wir w&#xFC;rden uns freuen, wenn du deinen Freunden von unserer Website erz&#xE4;hlst und diese zum Bewerten deiner Schule animierst. Denn je mehr Bewertungen, desto leichter kann man sich ein Bild &#xFC;ber deine Schule machen.</p><p></p><br><p>Falls du uns weiterhin unterst&#xFC;tzen m&#xF6;chtest, kannst du uns auf Instagram oder Facebook f&#xFC;r aktuelle Infos folgen. <em>(Klicke einfach auf die Icons&#xA0;</em>&#x1F60A;<em>)</em></p>      </div>                  </td>            </tr>                      <tr>              <td align="center" style="font-size:0px;padding:5px 5px 5px 5px;word-break:break-word;">                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">        <tbody>          <tr>            <td style="width:30px;">                      <a href="https://www.instagram.com/gradeyourschool/" target="_blank">                <img alt="Instagram | GradeYourSchool" height="auto" src="https://gradeyourschool.at/wp-content/uploads/2020/01/instagram.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="30">            </a>                  </td>          </tr>        </tbody>      </table>                  </td>            </tr>                      <tr>              <td align="center" style="font-size:0px;padding:5px 5px 5px 5px;word-break:break-word;">                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">        <tbody>          <tr>            <td style="width:30px;">                      <a href="https://www.facebook.com/Gradeyourschool" target="_blank">                <img alt="Facebook | GradeYourSchool" height="auto" src="https://gradeyourschool.at/wp-content/uploads/2020/01/facebook.png" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="30">            </a>                  </td>          </tr>        </tbody>      </table>                  </td>            </tr>                      <tr>              <td style="font-size:0px;padding:10px 25px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:25px;word-break:break-word;">                      <p style="border-top:solid 1px #000000;font-size:1;margin:0px auto;width:100%;">      </p>            <!--[if mso | IE]>        <table           align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #000000;font-size:1;margin:0px auto;width:565px;" role="presentation" width="565px"        >          <tr>            <td style="height:0;line-height:0;">              &nbsp;            </td>          </tr>        </table>      <![endif]-->                      </td>            </tr>                      <tr>              <td align="left" style="font-size:0px;padding:15px 15px 15px 15px;word-break:break-word;">                      <div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:11px;line-height:1.5;text-align:left;color:#000000;">        <p>Mit freundlichen Gr&#xFC;&#xDF;en<br>Dein GradeYourSchool Team</p><p></p><p></p><br><p><em>PS: Keine Angst, das hier ist die erste und letzte Mail die du von uns erh&#xE4;ltst.</em></p>      </div>                  </td>            </tr>                </tbody></table>          </div>              <!--[if mso | IE]>            </td>                  </tr>                        </table>                <![endif]-->              </td>            </tr>          </tbody>        </table>              </div>                <!--[if mso | IE]>          </td>        </tr>      </table>      <![endif]-->              </div>                </body></html>';
	

$headers= 'From: Info | GradeYourSchool <info@gradeyourschool.at>' . "\r\n" .
	'Reply-To: GradeYourSchool <info@gradeyourschool.at>' . "\r\n" .
	'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

 wp_mail($to, $subject, $message, $headers); 
}

	
}
//------------------------------------------------------------------- FAILED MESSAGE ------------------------------------------------------------------- 
else
{
    $data['message'] = "failed";
    echo "0";
}

    }
?>