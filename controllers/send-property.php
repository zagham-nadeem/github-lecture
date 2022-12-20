<?php

require '../core.php';

if ($_POST){

    $array = array('senderName' => '', 'senderEmail' => '', 'friendEmail' => '', 'error' => '');

    $propertyId = filter_var($_POST["pid"], FILTER_SANITIZE_STRING);
    $propertyUrl = filter_var($_POST["purl"], FILTER_SANITIZE_URL);
    $propertyTitle = filter_var($_POST["ptitle"], FILTER_SANITIZE_STRING);
    $propertyRef = filter_var($_POST["pref"], FILTER_SANITIZE_STRING);
    $propertyImage = filter_var($_POST["pimage"], FILTER_SANITIZE_STRING);
    $propertyPrice = filter_var($_POST["pprice"], FILTER_SANITIZE_STRING);
    $senderName = filter_var(strtolower($_POST['sendername']), FILTER_SANITIZE_STRING);
    $senderEmail = filter_var(strtolower($_POST['senderemail']), FILTER_SANITIZE_STRING);
	$friendEmail = filter_var(strtolower($_POST['friendemail']), FILTER_SANITIZE_STRING);

        if (empty($senderName)) {
            $array['senderName'] = $translation['tr_159'];
        }

        if (empty($senderEmail)) {
            $array['senderEmail'] = $translation['tr_158'];
        } elseif (!filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
            $array['senderEmail'] = $translation['tr_163'];
        }

        if (empty($friendEmail)) {
            $array['friendEmail'] = $translation['tr_158'];
        } elseif (!filter_var($friendEmail, FILTER_VALIDATE_EMAIL)) {
            $array['friendEmail'] = $translation['tr_163'];
        }

        $filterArray = array_filter($array);

        if (count($filterArray) != 0) {

                $array['error'] = $translation['tr_168'];
                echo json_encode($array);

        }else{


        $array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
            "{SITE_DOMAIN}" => $urlPath->home(), 
            "{SITE_NAME}" => $translation['tr_1'], 
            "{SENDER_NAME}" => $senderName, 
            "{SENDER_EMAIL}" => $senderEmail, 
            "{FRIEND_EMAIL}" => $friendEmail, 
            "{PROPERTY_URL}" => $propertyUrl,
            "{PROPERTY_TITLE}" => $propertyTitle, 
            "{PROPERTY_REFERENCE}" => $propertyRef, 
            "{PROPERTY_IMAGE}" => $propertyImage,
            "{PROPERTY_PRICE}" => $propertyPrice
        );

        $emailTemplate = getEmailTemplate($connect, 6);

        if ($emailTemplate) {

            $emailContent = json_decode($emailTemplate['email_content'],true);

            $key = array_search($lang, array_column($emailContent, 'lang'));

            if(!empty($key) || $key != NULL || $key === 0){

                $mail = sendMail($array_content, $emailContent[$key]['message'], $friendEmail, $emailTemplate['email_fromname'], $emailContent[$key]['subject'], $emailTemplate['email_plaintext'], $senderName, $senderEmail);
            }

            if ($mail == TRUE) {

                echo json_encode($array);

            }else{

                $array['error'] = $translation['tr_168'];
                echo json_encode($array);
            }

        }else{
                
                $array['error'] = $translation['tr_168'];
                echo json_encode($array);
        }

        }
}

?>