<?php

use voku\helper\AntiXSS;

require_once __DIR__ . '../../classes/anti-xss/autoload.php';
require_once __DIR__ . '../../classes/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '../../classes/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '../../classes/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function connect(){

    global $database;

    try{
        $connect = new PDO('mysql:host='.$database['host'].';dbname='.$database['db'],$database['user'],$database['pass'], array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
        return $connect;
        
    }catch (PDOException $e){
        return false;
    }
}

function getSettings($connect){
    
    $sentence = $connect->prepare("SELECT * FROM settings"); 
    $sentence->execute();
    return $sentence->fetch();
}

function getTheme($connect){
    
    $sentence = $connect->prepare("SELECT * FROM theme"); 
    $sentence->execute();
    return $sentence->fetch();
}

function checkTable($connect, $table) {

    try {
        $result = $connect->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {

        return FALSE;
    }

    return $result !== FALSE;
}

function getLanguages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_translated = 1 ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function setLanguage($lang){
    setcookie("siteLang", $lang, time() + (60 * 60 * 24 * 60), '/');
}

function getTranslation($connect, $langTable){
    $sentence = $connect->query("SELECT * FROM $langTable");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getGeneralTranslation($connect){
    $sentence = $connect->query("SELECT * FROM translations");
    $sentence->execute();
    return $sentence->fetchAll();
}

function checkLanguage($defaultlang){

    if(empty($_GET['lang']) || !isset($_GET['lang'])){

            $lang = $defaultlang;
            return $lang;
    }else{

        $lang = clearGetData($_GET['lang']);
        return $lang;

    }

}

function getStrings($connect, $defaultlang, $lang){

    $langTable = "translate_".$lang;

    $exists = checkTable($connect, $langTable);

    if (!$exists){

        setcookie( "siteLang", $defaultlang, time() + (60 * 60 * 24 * 60), '/');
    
        $sentence = $connect->query("SELECT * FROM translations");
        $row = $sentence->fetch(PDO::FETCH_ASSOC);
        return $row;

        if (isset($lang)) {

            return null;
        }

    }else{

        $sentence = $connect->query("SELECT * FROM $langTable");
        $row = $sentence->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}

function getDefaultPage($connect, $page, $lang){
    $sentence = $connect->prepare("SELECT pages.page_id, tr_pages.tr_slug, tr_pages.tr_title FROM pages, tr_pages WHERE pages.page_id = tr_pages.tr_page AND pages.page_visibility = 1 AND pages.page_id = '".$page."' AND tr_pages.tr_page = '".$page."' AND tr_pages.tr_lang = '".$lang."' LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    
    if ($row) {
        return $row;
    }else{
        return null;
    }

}

function getUserInfo($connect, $userEmail = NULL){

    if (!$userEmail) {

        $email = filter_var(strtolower($_SESSION['user_email']), FILTER_VALIDATE_EMAIL);

    }else{

        $email = filter_var(strtolower($userEmail), FILTER_VALIDATE_EMAIL);
    }
    
    if ($email) {

        $sentence = $connect->prepare("SELECT * FROM users WHERE user_email = '".$email."' LIMIT 1");
        $sentence->execute();
        $row = $sentence->fetch();
        return $row;

    }else{

        return null;
    }

}

function getImage($src){

    return SITE_URL.'/images/'. $src;
}

function getAddress($city, $zone = NULL){

    if (!$zone) {
        return $city;
    }else{
        return $city . ', ' . $zone;
    }
}

function formatHTML($content){

    $content = str_replace(array("\n","\r","\t"),'', $content);
    $content = str_replace("</h1>", "</h3><br />", $content);
    $content = str_replace("</h2>", "</h3><br />", $content);
    $content = str_replace("</h3>", "</h3><br />", $content);
    $content = str_replace("</h4>", "</h3><br />", $content);
    $content = str_replace("</h5>", "</h3><br />", $content);
    $content = str_replace("</h6>", "</h3><br />", $content);
    return $content;
    
}

function getPercent($newprice, $oldprice){

    $calc = (($oldprice - $newprice) / $oldprice) * 100;
    $percent = round(abs($calc));
    return $percent."%";
}

function getDiscount($newprice, $oldprice){

    if (!empty($oldprice)) {

    $output = "";
    $sentence = connect()->prepare("SELECT st_currency, st_currencyposition, st_decimalseparator FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $calc = $oldprice - $newprice;

    if ($row['st_currencyposition'] == 'left') {
        $output = $row['st_currency'] . number_format($calc, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'left-space') {
        $output = $row['st_currency'] .' '. number_format($calc, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'right') {
        $output = number_format($calc, 0, '', $row['st_decimalseparator']) . $row['st_currency'];
    }elseif ($row['st_currencyposition'] == 'right-space') {
        $output = number_format($calc, 0, '', $row['st_decimalseparator']) .' '. $row['st_currency'];
    }

    return $output;

    }else{

        return false;
    }

}

function formatDate($date){

    $sentence = connect()->prepare("SELECT st_dateformat FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $newDate = date($row['st_dateformat'], strtotime($date));
    return $newDate;
}

function getPrice($price){

    if (!empty($price)) {

    $output = "";
    $sentence = connect()->prepare("SELECT st_currency, st_currencyposition, st_decimalseparator FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    if ($row['st_currencyposition'] == 'left') {
        $output = $row['st_currency'] . number_format($price, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'left-space') {
        $output = $row['st_currency'] .' '. number_format($price, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'right') {
        $output = number_format($price, 0, '', $row['st_decimalseparator']) . $row['st_currency'];
    }elseif ($row['st_currencyposition'] == 'right-space') {
        $output = number_format($price, 0, '', $row['st_decimalseparator']) .' '. $row['st_currency'];
    }

    return $output;

    }else{

        return false;
    }

}

function getUnit($value){

    $sentence = connect()->prepare("SELECT st_unit FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $output = $value.' '.$row['st_unit'];
    return $output;
}

function clearGetData($data){

    $antiXss = new AntiXSS();
    $data = $antiXss->xss_clean($data);
    return $data;
}

function getPostQuery(){
    
    return isset($_GET['query']) && !empty($_GET['query']) && $_GET['query'] ? clearGetData($_GET['query']) : NULL;
}

function getIDCategory(){
    
    return isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] ? clearGetData($_GET['category']) : NULL;
}

function getParamsID(){
    
    return isset($_GET['id']) && !empty($_GET['id']) ? clearGetData($_GET['id']) : NULL;
}

function getParamsLang(){
    
    return isset($_GET['lang']) && !empty($_GET['lang']) ? clearGetData($_GET['lang']) : NULL;
}

function getParamsOffers(){
    
    return isset($_GET['offers']) && !empty($_GET['offers']) && $_GET['offers'] !== 'undefined' ? clearGetData($_GET['offers']) : NULL;
}

function getParamsReference(){
    
    return isset($_GET['reference']) && !empty($_GET['reference']) ? clearGetData($_GET['reference']) : NULL;
}

function getParamsCity(){
    
    return isset($_GET['city']) && !empty($_GET['city']) && (int)$_GET['city'] ? clearGetData($_GET['city']) : NULL;
}

function getParamsZone(){
    
    return isset($_GET['zone']) && !empty($_GET['zone']) && (int)$_GET['zone'] ? clearGetData($_GET['zone']) : NULL;
}

function getParamsStatus(){
    
    return isset($_GET['status']) && !empty($_GET['status']) && (int)$_GET['status'] ? clearGetData($_GET['status']) : NULL;
}

function getParamsType(){
    
    return isset($_GET['type']) && !empty($_GET['type']) && (int)$_GET['type'] ? clearGetData($_GET['type']) : NULL;
}

function getParamsCondition(){
    
    return isset($_GET['condition']) && !empty($_GET['condition']) && (int)$_GET['condition'] ? clearGetData($_GET['condition']) : NULL;
}

function getParamsMinBeds(){
    
    return isset($_GET['minbeds']) && !empty($_GET['minbeds']) && (int)$_GET['minbeds'] ? clearGetData($_GET['minbeds']) : NULL;
}

function getParamsMinBaths(){
    
    return isset($_GET['minbaths']) && !empty($_GET['minbaths']) && (int)$_GET['minbaths'] ? clearGetData($_GET['minbaths']) : NULL;
}

function getParamsMinArea(){
    
    return isset($_GET['minarea']) && !empty($_GET['minarea']) && (int)$_GET['minarea'] ? clearGetData($_GET['minarea']) : NULL;
}

function getParamsMaxArea(){
    
    return isset($_GET['maxarea']) && !empty($_GET['maxarea']) && (int)$_GET['maxarea'] ? clearGetData($_GET['maxarea']) : NULL;
}

function getParamsMinPrice(){
    
    return isset($_GET['minprice']) && !empty($_GET['minprice']) && (int)$_GET['minprice'] ? clearGetData($_GET['minprice']) : NULL;
}

function getParamsMaxPrice(){
    
    return isset($_GET['maxprice']) && !empty($_GET['maxprice']) && (int)$_GET['maxprice'] ? clearGetData($_GET['maxprice']) : NULL;
}

function getParamsExtras(){
    
    return isset($_GET['extras']) && !empty($_GET['extras']) && $_GET['extras'] !== 'undefined' ? clearGetData($_GET['extras']) : NULL;
}

function getParamsSort(){
    
    return isset($_GET['sortby']) && !empty($_GET['sortby']) && $_GET['sortby'] !== 'undefined' ? clearGetData($_GET['sortby']) : NULL;
}

function getEmailTemplate($connect, $id){

    // ID

    // #1 New User Registered (Welcome Email)
    // #2 Forgot Password - Reset Link
    // #3 Password Reset - Confirmation
    // #4 Confirmation Message Contact Form (Send to Admin)
    // #5 Confirmation Message Contact Form (Send to User)
    // #6 Confirmation Message Property Form (Send to Admin)
    // #7 Confirmation Message Property Form (Send to User)

    if (!empty($id) && (int)($id)) {

        $q = $connect->query("SELECT * FROM emailtemplates WHERE email_id = ".$id." LIMIT 1");
        $f = $q->fetch();
        $result = $f;

        if ($result['email_disabled'] == 1) {
            return null;
        }else{
            return $result;
        }
    }else{

        return null;
    }  

}

function sendMail($array_content, $email_content, $destinationmail, $fromName, $subject, $isHtml, $replyToName = NULL, $replyToAddress = NULL) {
    
    $sentence = connect()->prepare("SELECT * FROM settings"); 
    $sentence->execute();
    $settings = $sentence->fetch();
    
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();                                          
        $mail->Host       = $settings['st_smtphost'];                
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $settings['st_smtpemail'];              
        $mail->Password   = $settings['st_smtppassword'];                             
        $mail->SMTPSecure = $settings['st_smtpencrypt'];
        $mail->Port       = $settings['st_smtpport'];

        if (isset($replyToAddress, $replyToName) && !empty($replyToAddress) && !empty($replyToName)) {
            $mail->addReplyTo($replyToAddress, $replyToName);
        }

        $mail->setFrom($settings['st_smtpemail'], $fromName);
        $mail->CharSet = "UTF-8";
        $mail->AddAddress($destinationmail); 
        $mail->isHTML($isHtml);

        $find = array_keys($array_content);
        $replace = array_values($array_content);

        $mailcontent = str_replace($find, $replace, $email_content);
        $mailsubject = str_replace($find, $replace, $subject);

        $mail->Subject = $mailsubject;
        $mail->Body = $mailcontent;
        if (!$mail->send()){

            $result = $mail->ErrorInfo;
            
        }else{

            $result = TRUE;
        }

        return $result;

    } catch (Exception $e) {
     return null;
    }

} 

?>