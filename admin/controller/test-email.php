<?php

require '../../config.php';
require '../functions.php';

$output = "";

$connect = connect($database);

if(!$connect){
    
    exit();
}

if ($_POST){

    $idtemplate = filter_var($_POST["idtemplate"], FILTER_SANITIZE_STRING);
	$langcode = filter_var($_POST["langcode"], FILTER_SANITIZE_STRING);
	$sendto = filter_var($_POST["sendto"], FILTER_SANITIZE_STRING);

    $emailTemplate = getEmailTemplate($connect, $idtemplate);
    $settings = getSettings($connect);
    $checkMail = checkMail($settings);

    $privacypages = get_pages_by_template($connect, $settings['st_language'], 'privacy');
    $privacypages = $privacypages['0'];
    $termspages = get_pages_by_template($connect, $settings['st_language'], 'terms');
    $termspages = $termspages['0'];

    $array_content = array("{LOGO_URL}" => SITE_URL."/images/logo.png",
     "{SITE_DOMAIN}" => SITE_URL, 
     "{SITE_NAME}" => "Example Site Name", 
     "{USER_NAME}" => "Daniel", 
     "{USER_EMAIL}" => "example@email.com", 
     "{USER_PHONE}" => "+123 456 789", 
     "{USER_MESSAGE}" => cleardata("This is an example message."),
     "{PRIVACY_URL}" => SITE_URL."/".$privacypages['tr_slug'],
     "{TERMS_URL}" => SITE_URL."/".$termspages['tr_slug'],
     "{SIGNIN_URL}" => SITE_URL."/signin",
     "{RESET_URL}" => SITE_URL."/reset",
     "{PROPERTY_URL}" => SITE_URL."/property/1/example-property-slug",
     "{PROPERTY_TITLE}" => "Example Property Title",
     "{PROPERTY_REFERENCE}" => "REF123456",
     "{PROPERTY_IMAGE}" => SITE_URL."/admin/assets/images/placeholder.png",
     "{PROPERTY_PRICE}" => getPrice("150000", $settings),
     "{SENDER_NAME}" => "James", 
     "{SENDER_EMAIL}" => "sender@example.com",
     "{FRIEND_EMAIL}" => "friend@example.com"
 );


    if ($emailTemplate) {

        $emailContent = json_decode($emailTemplate['email_content'],true);

        $key = array_search($langcode, array_column($emailContent, 'lang'));

        if(!empty($key) || $key != NULL || $key === 0){

        try{        

            if (empty($checkMail)) {

            $mail = sendMail($array_content, $emailContent[$key]['message'], $sendto, $emailTemplate['email_fromname'], $emailContent[$key]['subject'], $emailTemplate['email_plaintext'], $settings);

            if ($mail == TRUE) {
                $output = "<span class='text-success'><i class='fa fa-check'></i> "._EMAILSENTSUCCESS."</span>";
                echo $output;
            }else{

                $output = $mail;
                echo "<span class='text-danger'>".$output."</span";
            }

            }else{

                $output = $checkMail;
                echo "<span class='text-danger'>".$output."</span";
            }

            
        }catch (PDOException $e){
            
            $output = $e->getMessage();
            echo "<span class='text-danger'>".$output."</span";

        }

        }else{


        try{        

            if (empty($checkMail)) {

            $mail = sendMail($array_content, $emailContent[0]['message'], $sendto, $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext'], $settings);

            if ($mail == TRUE) {
                $output = "<span class='text-success'><i class='fa fa-check'></i> "._EMAILSENTSUCCESS."</span>";
                echo $output;
            }else{

                $output = $mail;
                echo "<span class='text-danger'>".$output."</span";
            }

            }else{

                $output = $checkMail;
                echo "<span class='text-danger'>".$output."</span";
            }

            
        }catch (PDOException $e){
            
            $output = $e->getMessage();
            echo "<span class='text-danger'>".$output."</span";

        }

    }


    }

}

?>