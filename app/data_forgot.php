<?php

require './app_core.php';

$json = file_get_contents('php://input');

$obj = json_decode($json, true);

$errors = array();

$user_email = filter_var(strtolower($obj['user_email']), FILTER_VALIDATE_EMAIL);

if ($user_email) {

    $Sql_Query = "SELECT * FROM users WHERE user_email = '".$user_email."' LIMIT 1";

    $sentence = $connect->prepare($Sql_Query);

    $sentence->execute();

    $qResults = $sentence->fetch();

    if (!$qResults) {

        
        echo $InvalidMSGJSon = json_encode('email-not-exist');

    }else{

        $currentDate = date("Y-m-d H:i:s");

        $Sql_Query = "SELECT * FROM tokens WHERE token_email = '".$user_email."'";

        $sentence = $connect->prepare($Sql_Query);

        $sentence->execute();

        $qResults = $sentence->fetch();

        if ($qResults['token_date'] >= $currentDate) {

            
            echo $InvalidMSGJSon = json_encode('already-requested');

        }else{


        $dateFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"));
        $token_date = date("Y-m-d H:i:s", $dateFormat);
        $token_key = hash('sha512', 2418*2 . $user_email);
        $generateKey = substr(hash('sha512', uniqid(rand(),1)),3,10);
        $token_key = $token_key . $generateKey;

        $statement = $connect->prepare("INSERT INTO tokens (token_email, token_key, token_date) VALUES (:token_email, :token_key, :token_date)");
        $statement->execute(array(
            ':token_email' => $user_email,
            ':token_key' => $token_key,
            ':token_date' => $token_date
        ));

        try {

            $userInfo = getUserInfo($connect, $user_email);

            $array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
                "{SITE_DOMAIN}" => $urlPath->home(), 
                "{SITE_NAME}" => $translation['tr_1'], 
                "{USER_NAME}" => $userInfo['user_name'], 
                "{USER_EMAIL}" => $userInfo['user_email'], 
                "{USER_PHONE}" => $userInfo['user_phone'], 
                "{RESET_URL}" => $urlPath->reset(['email' => $user_email, 'key' => $token_key])
            );

            $emailTemplate = getEmailTemplate($connect, 2);

            if ($emailTemplate) {

                $emailContent = json_decode($emailTemplate['email_content'],true);

                $key = array_search($lang, array_column($emailContent, 'lang'));

                if(!empty($key) || $key != NULL || $key === 0){

                    $mail = sendMail($array_content, $emailContent[$key]['message'], $user_email, $emailTemplate['email_fromname'], $emailContent[$key]['subject'], $emailTemplate['email_plaintext']);

                    if ($mail == TRUE) {

                        echo $InvalidMSGJSon = json_encode('success');

                    }else{

                        echo $InvalidMSGJSon = json_encode('incomplete');
                    }

                }

            }else{

                echo $InvalidMSGJSon = json_encode('incomplete');
            }


        } catch (Exception $e) {

            
            echo $InvalidMSGJSon = json_encode('incomplete');

        }

        }

    }
    
}else{

    $InvalidMSGJSon = json_encode('incomplete');

    echo $InvalidMSGJSon;
}

?>