<?php

require './app_core.php';

$json = file_get_contents('php://input');

$obj = json_decode($json, true);

$contactName = filter_var($obj["user_name"], FILTER_SANITIZE_STRING);

$contactPhone = filter_var($obj["user_phone"], FILTER_SANITIZE_STRING);

$contactEmail = filter_var(strtolower($obj['user_email']), FILTER_VALIDATE_EMAIL);

$contactMessage = filter_var($obj["user_message"], FILTER_SANITIZE_STRING);

if ($contactName && $contactPhone && $contactEmail && $contactMessage){

	$InvalidMSG = json_encode('not-sended');
	$validMSG = json_encode('success');

  $array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
   "{SITE_DOMAIN}" => $urlPath->home(), 
   "{SITE_NAME}" => $translation['tr_1'], 
   "{USER_NAME}" => $contactName, 
   "{USER_EMAIL}" => $contactEmail, 
   "{USER_PHONE}" => $contactPhone, 
   "{USER_MESSAGE}" => $contactMessage
 );

  $emailTemplate = getEmailTemplate($connect, 4);

  if ($emailTemplate) {

    $emailContent = json_decode($emailTemplate['email_content'],true);

    $mail = sendMail($array_content, $emailContent[0]['message'], $settings['st_recipientemail'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);

    if ($mail == TRUE) {

      echo $validMSG;

    }else{

      echo $InvalidMSG;
    }
    
  }else{

   echo $InvalidMSG;
 }

}else{

	$InvalidMSG = json_encode('incomplete');
  
	echo $InvalidMSG;
}

?>