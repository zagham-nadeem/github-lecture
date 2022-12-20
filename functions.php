<?php

/*--------------------*/
// Description: Evora - Real Estate CMS
// Author: Evora
// Author URI: https://wicombit.com
/*--------------------*/

use voku\helper\AntiXSS;

require_once __DIR__ . '/classes/anti-xss/autoload.php';
require_once __DIR__ . '/classes/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/classes/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/classes/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

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

function isLogged(){

    if (isset($_SESSION['signedin']) && $_SESSION['signedin'] == true) {
        return true;
    }else{
        return false;
    }
}

function isAdmin(){

    if (isset($_SESSION['signedin']) && $_SESSION['signedin'] == true) {

    $emailSession = filter_var(strtolower($_SESSION['user_email']), FILTER_SANITIZE_STRING);
    
    $sentence = connect()->prepare("SELECT * FROM users WHERE user_email = '".$emailSession."' AND user_status = 1 AND user_role = 1 LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();

    if ($row) {
        
        return true;

    }else{

        return false;
    }

    }else{
        return false;
    }

}

function isEditing(){
    
    return isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit';
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

function checkLanguage($connect, $defaultlang){

    if(empty($_GET['lang']) || !isset($_GET['lang'])){

        if(empty($_COOKIE['siteLang']) || !isset($_COOKIE['siteLang'])){

            $lang = $defaultlang;
            return $lang;

        }else{

            $lang = $_COOKIE['siteLang'];
            return $lang;
        }

    }else{

        $lang = clearGetData($_GET['lang']);
        $langTable = "translate_".$lang;

    $exists = checkTable($connect, $langTable);

    if ($exists){

        if (empty($_COOKIE['siteLang']) || !isset($_COOKIE['siteLang']) || $_GET['lang'] !== $_COOKIE['siteLang']) {
            setcookie("siteLang", $lang, time() + (60 * 60 * 24 * 60), '/');
        }

        return $lang;

        }else{
            
        return $defaultlang;

        }

    }

}

function getStrings($connect, $defaultlang, $lang){

    $langTable = "translate_".$lang;
    $defaultTable = "translate_".$defaultlang;

    $exists = checkTable($connect, $langTable);

    if (!$exists){

        setcookie( "siteLang", $defaultlang, time() + (60 * 60 * 24 * 60), '/');
    
        $sentence = $connect->query("SELECT * FROM $defaultTable");
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

function getInfoLangByCode($connect, $lang){
    $sentence = $connect->query("SELECT * FROM languages WHERE language_code = '".$lang."' LIMIT 1");
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function echoOutput($data){
    $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
    return $data;
}

function textTruncate($data, $chars) {
    if(strlen($data) > $chars) {
        $data = $data.' ';
        $data = substr($data, 0, $chars);
        $data = $data.'...';
    }
    return $data;
}

function echoNoHtml($data){
    //$data = htmlentities($data, ENT_QUOTES, "UTF-8");
    $data = strip_tags($data);
    $data = substr($data, 0, 110);
    return $data;
}

function clearData($data){
    $antiXss = new AntiXSS();
    $data = $antiXss->xss_clean($data);
    return $data;
}

function clearGetData($data){

    $antiXss = new AntiXSS();
    $data = $antiXss->xss_clean($data);
    return $data;
}

function lengthInput($data, $min, $max = NULL){

    $characters = strlen($data);
    $spaces = preg_match('/\s/',$data);

    if ($max) {
        if ($characters >= $min && $characters <= $max && !$spaces) {
            return true;
        }else{
            return false;
        }
    }else{

        if ($characters >= $min && !$spaces) {
            return true;
        }else{
            return false;
        }
    }
}

function validateInput($data){

    $specialChars = preg_match('@[^\w]@', $data);

    if ($specialChars) {
        return true;
    }else{
        return false;
    }
}

function getNumPage(){
    
    return isset($_GET['p']) && !empty($_GET['p']) && (int)$_GET['p'] ? clearGetData($_GET['p']) : 1;
}

function getItemId(){
    
    return isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : NULL;
}

function getSortBy($value){

   if (isset($_GET['sortby']) && $_GET['sortby'] === $value) {
       return "value = '$value' selected";
   }

   return "value = '$value'";
}

function getSlugItem(){
    
    return isset($_GET['slug']) && !empty($_GET['slug']) && $_GET['slug'] ? clearGetData($_GET['slug']) : NULL;
}

function getPostQuery(){
    
    return isset($_GET['query']) && !empty($_GET['query']) && $_GET['query'] ? clearGetData($_GET['query']) : NULL;
}

function getSlugCategory(){
    
    return isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] ? clearGetData($_GET['category']) : NULL;
}

function getSlugCity(){
    
    return isset($_GET['city']) && !empty($_GET['city']) && $_GET['city'] ? clearGetData($_GET['city']) : NULL;
}

function getSlugZone(){
    
    return isset($_GET['zone']) && !empty($_GET['zone']) && $_GET['zone'] ? clearGetData($_GET['zone']) : NULL;
}

function getSlugStatus(){
    
    return isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] ? clearGetData($_GET['status']) : NULL;
}

function getSlugType(){
    
    return isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] ? clearGetData($_GET['type']) : NULL;
}

function getSlugCondition(){
    
    return isset($_GET['condition']) && !empty($_GET['condition']) && $_GET['condition'] ? clearGetData($_GET['condition']) : NULL;
}

function getParamsOffers(){
    
    return isset($_GET['offers']) && !empty($_GET['offers']) ? clearGetData($_GET['offers']) : NULL;
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
    
    return isset($_GET['extras']) && !empty($_GET['extras']) ? clearGetData($_GET['extras']) : NULL;
}

function getParamsSort(){
    
    return isset($_GET['sortby']) && !empty($_GET['sortby']) ? clearGetData($_GET['sortby']) : NULL;
}

function formatDate($date){

    $sentence = connect()->prepare("SELECT st_dateformat FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $newDate = date($row['st_dateformat'], strtotime($date));
    return $newDate;
}

function generatePassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

function getAddress($city, $zone = NULL){

    if (!$zone) {
        return $city;
    }else{
        return $city . ', ' . $zone;
    }
}

function getPercent($newprice, $oldprice){

    $calc = (($oldprice - $newprice) / $oldprice) * 100;
    $percent = round(abs($calc));
    return $percent."%";
}

function getDiscount($newprice, $oldprice){

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

    return '<span uk-icon="arrow-down"></span>' . $output;

}

function getPrice($price){

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

}

function getUnit($value){

    $sentence = connect()->prepare("SELECT st_unit FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $output = $value.' '.$row['st_unit'];
    return $output;
}

function getPluralText($value, $singular, $plural){

    if ($value <= 1) {
        return $value .' '. $singular;
    }else if ($value >= 2){
        return $value .' '. $plural;
    }else{
        return false;
    }

}

function maskEmail($email)
{
    $mail_parts = explode('@', $email);
    $username = '@'.$mail_parts[0];
    $len = strlen($username);

    return $username;
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

function getGravatar( $email, $s = 150, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function numTotalPages($total_items, $items_page){

    $numPages = ceil($total_items / $items_page);
    return $numPages;
}

function getSocialMedia($connect){
    
    $sentence = $connect->prepare("SELECT st_facebook,st_twitter,st_youtube,st_instagram,st_linkedin,st_whatsapp FROM settings"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

/*------------------------------------------------------------ */
/* SITE */
/*------------------------------------------------------------ */

function getSeoTitle($pageTitle = NULL, $pageSubTitle = NULL){

    if (!$pageSubTitle && empty($pageSubTitle)) {
        
        return $pageTitle;
        
    }elseif(!$pageTitle && empty($pageTitle)){

        return $pageSubTitle;

    }elseif($pageTitle && !empty($pageTitle) && $pageSubTitle && !empty($pageSubTitle)){

        return $pageSubTitle.' - '.$pageTitle;

    }else{

        return null;
    }
}

function getSeoDescription($generalDescription, $itemDescription = NULL, $seoDescription = NULL){

    if (!$itemDescription && empty($itemDescription) && !$seoDescription && empty($seoDescription)) {
        
        return echoNoHtml(substr($generalDescription, 0, 155));
        
    }else{

        if ($seoDescription && !empty($seoDescription)) {

            return echoNoHtml(substr($seoDescription, 0, 155));

        }else{

            return echoNoHtml(substr($itemDescription, 0, 155));
        }

    }
}

/*------------------------------------------------------------ */
/* ADS */
/*------------------------------------------------------------ */

function getHeaderAd($connect, $lang){
    
    $sentence = $connect->prepare("SELECT * FROM ads WHERE ad_position = 'header' AND ad_lang = '".$lang."' AND ad_status = 1"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFooterAd($connect, $lang){
    
    $sentence = $connect->prepare("SELECT * FROM ads WHERE ad_position = 'footer' AND ad_lang = '".$lang."' AND ad_status = 1"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getSidebarAd($connect, $lang){
    
    $sentence = $connect->prepare("SELECT * FROM ads WHERE ad_position = 'sidebar' AND ad_lang = '".$lang."' AND ad_status = 1"); 
    $sentence->execute();
    return $sentence->fetchAll();
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


function getStaff($connect, $lang){
    
    $sentence = $connect->prepare("SELECT staffs.*,tr_staffs.* FROM staffs,tr_staffs WHERE staffs.staff_id = tr_staffs.tr_staff AND tr_staffs.tr_lang = '".$lang."'"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getPosts($items_per_page, $connect, $lang){
    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;
    
    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS posts.*,tr_posts.*,tr_categories.tr_name AS category_name, tr_categories.tr_slug AS category_slug FROM posts,tr_posts,tr_categories WHERE posts.post_visibility = 1 AND posts.post_id = tr_posts.tr_post AND posts.post_category = tr_categories.tr_category AND tr_posts.tr_lang = '".$lang."' AND tr_categories.tr_lang = '".$lang."'";

    if(getSlugCategory()){

        $sqlQuery .= " AND tr_categories.tr_slug = '".getSlugCategory()."'";
    }

    if(getPostQuery()){

        $sqlQuery .= " AND tr_posts.tr_title LIKE '%".getPostQuery()."%'";
    }

    $sqlQuery .= " ORDER BY posts.post_date DESC LIMIT $limit, $items_per_page";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);
}

function getProperties($items_per_page, $connect, $lang){

    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;

    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, CAST(properties.pt_price AS UNSIGNED) AS price, CAST(properties.pt_size AS UNSIGNED) AS size, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND tr_properties.tr_lang = '".$lang."'";

    if(getSlugCity()){

        $sqlQuery .= " AND tr_ptcities.tr_slug = '".getSlugCity()."'";
    }

    if(getSlugZone()){

        $sqlQuery .= " AND tr_ptzones.tr_slug = '".getSlugZone()."'";
    }

    if(getSlugType()){

        $sqlQuery .= " AND tr_pttypes.tr_slug = '".getSlugType()."'";
    }

    if(getSlugStatus()){

        $sqlQuery .= " AND tr_ptstatus.tr_slug = '".getSlugStatus()."'";
    }

    if(getSlugCondition()){

        $sqlQuery .= " AND tr_ptconditions.tr_slug = '".getSlugCondition()."'";
    }

    if(getParamsOffers() && getParamsOffers() == '1'){

        $sqlQuery .= " AND properties.pt_offer = '".getParamsOffers()."'";
    }

    $sqlQuery .= " GROUP BY properties.pt_id";

    if (getParamsSort()) {

        $sortby = getParamsSort();

        if($sortby == 'default') {

            $sqlQuery .= " ORDER BY properties.pt_date DESC";

        }elseif($sortby == 'price-asc') {

            $sqlQuery .= " ORDER BY price ASC";

        }elseif ($sortby == 'price-desc') {

            $sqlQuery .= " ORDER BY price DESC";
            
        }elseif($sortby == 'date-asc') {

            $sqlQuery .= " ORDER BY properties.pt_date ASC";

        }elseif ($sortby == 'date-desc') {

            $sqlQuery .= " ORDER BY properties.pt_date DESC";
            
        }elseif($sortby == 'size-asc') {

            $sqlQuery .= " ORDER BY size ASC";

        }elseif ($sortby == 'size-desc') {

            $sqlQuery .= " ORDER BY size DESC";
        }

    }elseif(!isset($_GET['sortby']) || empty($_GET['sortby'])) {

        $sqlQuery .= " ORDER BY properties.pt_date DESC";
    }

    $sqlQuery .= " LIMIT $limit, $items_per_page";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);

}

function getSearchProperties($items_per_page, $connect, $lang){

    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;

    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, CAST(properties.pt_price AS UNSIGNED) AS price, CAST(properties.pt_size AS UNSIGNED) AS size, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND tr_properties.tr_lang = '".$lang."'";

    if(getParamsReference() && !empty(getParamsReference())){

        $sqlQuery .= " AND properties.pt_reference = '".getParamsReference()."'";
    }

    if(getParamsCity() && getParamsCity() != "any"){

        $sqlQuery .= " AND properties.pt_city = '".getParamsCity()."'";
    }

    if(getParamsZone() && getParamsZone() != "any"){

        $sqlQuery .= " AND properties.pt_zone = '".getParamsZone()."'";
    }

    if(getParamsType() && getParamsType() != "any"){

        $sqlQuery .= " AND properties.pt_type = '".getParamsType()."'";
    }

    if(getParamsStatus() && getParamsStatus() != "any"){

        $sqlQuery .= " AND properties.pt_status = '".getParamsStatus()."'";
    }

    if(getParamsCondition() && getParamsCondition() != "any"){

        $sqlQuery .= " AND properties.pt_conditions = '".getParamsCondition()."'";
    }

    if(getParamsOffers() && getParamsOffers() == "1"){

        $sqlQuery .= " AND properties.pt_offer = '".getParamsOffers()."'";
    }

    if(getParamsMinBeds() && getParamsMinBeds() != "any"){

        $sqlQuery .= "AND properties.pt_beds >= '".getParamsMinBeds()."'";
    }

    if(getParamsMinBaths() && getParamsMinBaths() != "any"){

        $sqlQuery .= "AND properties.pt_baths >= '".getParamsMinBaths()."'";
    }

    if (!getParamsMinArea() || getParamsMinArea() == 'any') {
        $q_minarea = '0';
    }else{
        $q_minarea = getParamsMinArea();
    }

    if (!getParamsMaxArea() || getParamsMaxArea() == 'any') {
        $q_maxarea = '9999999999';
    }else{
        $q_maxarea = getParamsMaxArea();
    }

    $sqlQuery .= " AND properties.pt_size BETWEEN $q_minarea AND $q_maxarea";

    if (!getParamsMinPrice() || getParamsMinPrice() == 'any') {
        $q_minprice = '0';
    }else{
        $q_minprice = getParamsMinPrice();
    }

    if (!getParamsMaxPrice() || getParamsMaxPrice() == 'any') {
        $q_maxprice = '9999999999';
    }else{
        $q_maxprice = getParamsMaxPrice();
    }

    $sqlQuery .= " AND properties.pt_price BETWEEN $q_minprice AND $q_maxprice";

    if(getParamsExtras()){

        $q_extras = array_unique(getParamsExtras());

        if (is_array($q_extras)) {

            if (count($q_extras) > 1) {

                $sqlQuery .= " AND properties.pt_id IN (SELECT pe_property FROM properties_extras WHERE pe_extra IN (";

                $numOptions = count($q_extras);
                $i = 0;
                foreach ($q_extras as $option){
                    if(++$i === $numOptions) {
                        $sqlQuery .= "'$option') GROUP BY pe_property HAVING COUNT(DISTINCT pe_extra)=$numOptions)";
                    }else{
                        $sqlQuery .= " '$option',";
                    }
                }

            }else{

                $single_extra = $q_extras[0];

                $sqlQuery .= " AND properties.pt_id IN (SELECT pe_property FROM properties_extras WHERE pe_extra = $single_extra)";
            }
        }
    }

    $sqlQuery .= " GROUP BY properties.pt_id";

    if (getParamsSort()) {

        $sortby = getParamsSort();

        if($sortby == 'default') {

            $sqlQuery .= " ORDER BY properties.pt_date DESC";

        }elseif($sortby == 'price-asc') {

            $sqlQuery .= " ORDER BY price ASC";

        }elseif ($sortby == 'price-desc') {

            $sqlQuery .= " ORDER BY price DESC";
            
        }elseif($sortby == 'date-asc') {

            $sqlQuery .= " ORDER BY properties.pt_date ASC";

        }elseif ($sortby == 'date-desc') {

            $sqlQuery .= " ORDER BY properties.pt_date DESC";
            
        }elseif($sortby == 'size-asc') {

            $sqlQuery .= " ORDER BY size ASC";

        }elseif ($sortby == 'size-desc') {

            $sqlQuery .= " ORDER BY size DESC";
        }

    }elseif(!isset($_GET['sortby']) || empty($_GET['sortby'])) {

        $sqlQuery .= " ORDER BY properties.pt_date DESC";
    }

    $sqlQuery .= " LIMIT $limit, $items_per_page";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);

}

function getRelatedPosts($connect, $id, $category, $lang)
{
    $sentence = $connect->prepare("SELECT posts.*,tr_posts.*, tr_categories.tr_name AS category_name, tr_categories.tr_slug AS category_slug FROM posts LEFT JOIN tr_posts ON posts.post_id = tr_posts.tr_post LEFT JOIN tr_categories ON posts.post_category = tr_categories.tr_category WHERE posts.post_visibility = 1 AND posts.post_id != '".$id."' AND posts.post_category = '".$category."' AND tr_posts.tr_lang = '".$lang."' AND tr_categories.tr_lang = '".$lang."' LIMIT 6"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getCategories($connect, $lang)
{
    $sentence = $connect->prepare("SELECT categories.*,tr_categories.* FROM categories,tr_categories WHERE categories.category_id = tr_categories.tr_category AND tr_categories.tr_lang = '".$lang."'"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getSlider($connect, $lang)
{
    $sentence = $connect->query("SELECT sliders.*,properties.pt_id, properties.pt_price,properties.pt_direction, properties.pt_size, properties.pt_beds, properties.pt_baths, tr_properties.tr_label, tr_properties.tr_title,tr_properties.tr_slug,tr_ptstatus.tr_name AS status, tr_ptstatus.tr_status, tr_ptstatus.tr_lang, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone FROM sliders, properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' WHERE slider_visibility = 1 AND properties.pt_id = sliders.slider_property AND properties.pt_id = tr_properties.tr_property AND tr_properties.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getCities($connect, $lang)
{
    
    $sentence = $connect->prepare("SELECT pt_cities.*,tr_ptcities.tr_name AS tr_name FROM pt_cities,tr_ptcities WHERE pt_cities.pt_city_id = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."'"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getZoneByCity($connect, $city, $lang)
{
    
    $sentence = $connect->prepare("SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name FROM pt_zones,tr_ptzones WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND pt_zones.pt_zone_city = '".$city."' AND tr_ptzones.tr_lang = '".$lang."'"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getZones($connect, $lang){
    $sentence = $connect->query("SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name FROM pt_zones,tr_ptzones WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getHomeTypes($connect, $lang){
    $sentence = $connect->query("SELECT pt_types.*,tr_pttypes.* FROM pt_types,tr_pttypes WHERE pt_types.pt_type_id = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' AND pt_types.pt_type_id IN (SELECT pt_type FROM properties)");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getRefProperties($connect){
    $sentence = $connect->query("SELECT pt_reference FROM properties");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getOffersProperties($connect, $lang, $value){
    $sentence = $connect->prepare("SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND properties.pt_offer = 1 AND tr_properties.tr_lang = '".$lang."' GROUP BY properties.pt_id ORDER BY properties.pt_date DESC LIMIT $value"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeatredProperties($connect, $lang, $value){
    $sentence = $connect->prepare("SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND properties.pt_featured = 1 AND tr_properties.tr_lang = '".$lang."' GROUP BY properties.pt_id ORDER BY properties.pt_date DESC LIMIT $value"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getLatestProperties($connect, $lang, $value){
    $sentence = $connect->prepare("SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND tr_properties.tr_lang = '".$lang."' GROUP BY properties.pt_id ORDER BY properties.pt_date DESC LIMIT $value"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getPropertyById($connect, $id_property, $lang){
    $sentence = $connect->prepare("SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE properties.pt_visibility = 1 AND tr_properties.tr_lang = '".$lang."' AND properties.pt_id = '".$id_property."' GROUP BY properties.pt_id LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function isPropertyInFav($connect, $userId, $itemId){
    $sentence = $connect->query("SELECT * FROM favorites WHERE user = '".$userId."' AND item = '".$itemId."' LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? true : false;
}

function getUserFavorites($connect, $userId){
    $sentence = $connect->prepare("SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug, favorites.* FROM favorites, properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone WHERE favorites.user = '".$userId."' AND favorites.item = properties.pt_id GROUP BY properties.pt_id");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getCityDetails($connect, $lang, $id_city){
    
    $sentence = $connect->prepare("SELECT pt_cities.*,tr_ptcities.tr_name AS tr_name FROM pt_cities,tr_ptcities WHERE pt_cities.pt_city_id = tr_ptcities.tr_city AND pt_cities.pt_city_id = $id_city AND tr_ptcities.tr_lang = '".$lang."' LIMIT 1"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getRelatedProperties($connect, $lang, $price, $type, $city, $property, $limit){
    $sentence = $connect->prepare("SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, tr_properties.tr_slug AS slug FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND properties.pt_type = $type AND properties.pt_city = $city AND properties.pt_price <= $price * 1.5 AND properties.pt_id = tr_properties.tr_property AND properties.pt_id != $property AND tr_properties.tr_lang = '".$lang."' GROUP BY properties.pt_id LIMIT $limit"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeaturedCities($connect, $lang, $value){
    $sentence = $connect->prepare("SELECT pt_cities.*, tr_ptcities.*, (SELECT COUNT(*) FROM properties WHERE properties.pt_city = pt_cities.pt_city_id AND properties.pt_sold = 0 AND properties.pt_visibility = 1) AS total_properties FROM pt_cities, tr_ptcities WHERE pt_cities.pt_city_featured = 1 AND pt_cities.pt_city_id = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LIMIT $value");
    $sentence->execute();
    return $sentence->fetchAll();
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

function getDefaultBlogPage($connect, $lang){
    $sentence = $connect->prepare("SELECT * FROM pages, tr_pages WHERE pages.page_id = tr_pages.tr_page AND pages.page_visibility = 1 AND pages.page_template = 'blog' AND pages.page_id IN (SELECT st_defaultblogpage FROM settings) AND tr_pages.tr_lang = '".$lang."' LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    
    if ($row) {
        return $row;
    }else{
        return null;
    }

}

function getLangByPageSlug($connect, $slug){
    $sentence = $connect->prepare("SELECT tr_lang FROM tr_pages WHERE tr_pages.tr_slug = '".$slug."' LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getPageBySlug($connect, $slug, $lang){
    $sentence = $connect->prepare("SELECT pages.*, tr_pages.* FROM pages, tr_pages WHERE pages.page_id = tr_pages.tr_page AND pages.page_visibility = 1 AND tr_pages.tr_slug = '".$slug."' LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getPageIDBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT tr_page AS id FROM tr_pages WHERE tr_slug = '".$slug."' GROUP BY tr_page LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getLanguagesByPage($connect, $page){
    
    $sentence = $connect->prepare("SELECT tr_slug AS slug, tr_lang, language_id, language_code, language_status, language_name FROM tr_pages, languages WHERE tr_page = $page AND tr_lang = language_code AND language_status = 1 GROUP BY language_code ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getPageByID($connect, $id_page, $lang){
    $sentence = $connect->prepare("SELECT pages.*, tr_pages.* FROM pages, tr_pages WHERE pages.page_id = tr_pages.tr_page AND pages.page_visibility = 1 AND pages.page_id = $id_page AND tr_pages.tr_page = $id_page AND tr_pages.tr_lang = '".$lang."' LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getPostByID($connect, $id_post, $lang){
    $sentence = $connect->prepare("SELECT posts.*, tr_posts.*,tr_categories.tr_name AS category_name, tr_categories.tr_slug AS category_slug FROM posts, tr_posts,tr_categories WHERE posts.post_id = tr_posts.tr_post AND posts.post_category = tr_categories.tr_category AND posts.post_visibility = 1 AND posts.post_id = $id_post AND tr_posts.tr_post = $id_post AND tr_posts.tr_lang = '".$lang."' AND tr_categories.tr_lang = '".$lang."' LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getGallery($connect, $id_property){

    $sentence = $connect->prepare("SELECT * FROM properties_gallery WHERE pg_property = '".$id_property."'");
    $sentence->execute();
    return $sentence->fetchAll();

}

function getPreferredChoice($connect, $lang){
    $sentence = $connect->prepare("SELECT preferred_choice.*, tr_preferred_choice.* FROM preferred_choice, tr_preferred_choice WHERE preferred_choice.pc_id = tr_preferred_choice.tr_pc AND tr_preferred_choice.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getExtrasByProperty($connect, $id_property, $lang){
    $sentence = $connect->query("SELECT properties_extras.*,tr_ptextras.* FROM properties_extras,tr_ptextras WHERE properties_extras.pe_extra = tr_ptextras.tr_extra AND properties_extras.pe_property = $id_property AND tr_ptextras.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getCurrentCategory($connect, $slug, $lang)
{
    
    $sentence = $connect->prepare("SELECT categories.*,tr_categories.tr_name AS tr_name FROM categories,tr_categories WHERE categories.category_id = tr_categories.tr_category AND tr_categories.tr_slug = '".$slug."' AND tr_categories.tr_lang = '".$lang."' LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getCurrentCity($connect, $id, $lang){
    
    $sentence = $connect->prepare("SELECT pt_cities.*,tr_ptcities.tr_name AS tr_name FROM pt_cities,tr_ptcities WHERE pt_cities.pt_city_id = tr_ptcities.tr_city AND tr_ptcities.tr_city = '".$id."' AND tr_ptcities.tr_lang = '".$lang."' LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getCityBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT tr_city AS id FROM tr_ptcities WHERE tr_slug = '".$slug."' GROUP BY tr_city LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getCurrentZone($connect, $id, $lang){
    
    $sentence = $connect->prepare("SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name FROM pt_zones,tr_ptzones WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND tr_ptzones.tr_zone = '".$id."' AND tr_ptzones.tr_lang = '".$lang."' LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getZoneBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT tr_zone AS id FROM tr_ptzones WHERE tr_slug = '".$slug."' GROUP BY tr_zone LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getCurrentStatus($connect, $id, $lang){
    
    $sentence = $connect->prepare("SELECT pt_status.*,tr_ptstatus.tr_name AS tr_name FROM pt_status,tr_ptstatus WHERE pt_status.pt_status_id = tr_ptstatus.tr_status AND tr_ptstatus.tr_status = '".$id."' AND tr_ptstatus.tr_lang = '".$lang."' LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getStatusBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT tr_status AS id FROM tr_ptstatus WHERE tr_slug = '".$slug."' GROUP BY tr_status LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getCurrentCondition($connect, $id, $lang){
    
    $sentence = $connect->prepare("SELECT pt_conditions.*,tr_ptconditions.tr_name AS tr_name FROM pt_conditions,tr_ptconditions WHERE pt_conditions.pt_conditions_id = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_conditions = '".$id."' AND tr_ptconditions.tr_lang = '".$lang."' LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getConditionBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT tr_conditions AS id FROM tr_ptconditions WHERE tr_slug = '".$slug."' GROUP BY tr_conditions LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getCurrentType($connect, $id, $lang){
    
    $sentence = $connect->prepare("SELECT pt_types.*,tr_pttypes.tr_name AS tr_name FROM pt_types,tr_pttypes WHERE pt_types.pt_type_id = tr_pttypes.tr_type AND tr_pttypes.tr_type = '".$id."' AND tr_pttypes.tr_lang = '".$lang."' LIMIT 1"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getTypeBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT tr_type AS id FROM tr_pttypes WHERE tr_slug = '".$slug."' GROUP BY tr_type LIMIT 1");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getStatus($connect, $lang){
    $sentence = $connect->query("SELECT pt_status.*,tr_ptstatus.* FROM pt_status,tr_ptstatus WHERE pt_status.pt_status_id = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getConditions($connect, $lang){
    $sentence = $connect->query("SELECT pt_conditions.*,tr_ptconditions.* FROM pt_conditions,tr_ptconditions WHERE pt_conditions.pt_conditions_id = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getExtras($connect, $lang){
    $sentence = $connect->query("SELECT pt_extras.*,tr_ptextras.* FROM pt_extras,tr_ptextras WHERE pt_extras.pt_extra_id = tr_ptextras.tr_extra AND tr_ptextras.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getTypes($connect, $lang){
    $sentence = $connect->query("SELECT pt_types.*,tr_pttypes.* FROM pt_types,tr_pttypes WHERE pt_types.pt_type_id = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getTestimonials($connect, $lang){
    $sentence = $connect->query("SELECT * FROM testimonials WHERE testimonial_status = 1 AND testimonial_lang = '".$lang."'");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getPartners($connect){
    $sentence = $connect->query("SELECT * FROM partners WHERE partner_status = 1");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeaturedPosts($connect, $lang, $value){
    $sentence = $connect->query("SELECT posts.*,tr_posts.*,tr_categories.tr_name AS category_name, tr_categories.tr_slug AS category_slug FROM posts,tr_posts,tr_categories WHERE posts.post_visibility = 1 AND posts.post_featured = 1 AND posts.post_id = tr_posts.tr_post AND posts.post_category = tr_categories.tr_category AND tr_posts.tr_lang = '".$lang."' AND tr_categories.tr_lang = '".$lang."' ORDER BY posts.post_date DESC LIMIT $value");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getRecentsPosts($connect, $lang, $value){
    $sentence = $connect->query("SELECT posts.*,tr_posts.*,tr_categories.tr_name AS category_name, tr_categories.tr_slug AS category_slug FROM posts,tr_posts,tr_categories WHERE posts.post_visibility = 1 AND posts.post_id = tr_posts.tr_post AND posts.post_category = tr_categories.tr_category AND tr_posts.tr_lang = '".$lang."' AND tr_categories.tr_lang = '".$lang."' ORDER BY posts.post_date DESC LIMIT $value");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getHeaderMenu($connect, $lang){
    
    $q = $connect->query("SELECT * FROM menus WHERE menu_header = 1 AND menu_status = 1 AND menu_lang = '".$lang."' ORDER BY menu_id DESC LIMIT 1");
    $f = $q->fetch();
    $result = $f;
    return $result;
}

function getFooterMenu($connect, $lang){
    
    $q = $connect->query("SELECT * FROM menus WHERE menu_footer = 1 AND menu_status = 1 AND menu_lang = '".$lang."' ORDER BY menu_id DESC LIMIT 1");
    $f = $q->fetch();
    $result = $f;
    return $result;
}

function getNavigation($connect, $idMenu, $lang){
    
    $sentence = $connect->prepare("SELECT navigations.navigation_id, navigations.navigation_page, navigations.navigation_target, COALESCE(tr_pages.tr_slug, navigations.navigation_url) AS navigation_url, COALESCE(tr_pages.tr_title, navigations.navigation_label) AS navigation_label, navigations.navigation_type FROM navigations LEFT JOIN tr_pages ON tr_page = navigations.navigation_page AND tr_lang = '".$lang."' WHERE navigation_menu = '".$idMenu."' ORDER BY navigation_order ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
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