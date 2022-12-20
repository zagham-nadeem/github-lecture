<?php

/*--------------------*/
// Description: Evora - Real Estate CMS
// Author: Evora
// Author URI: https://wicombit.com
/*--------------------*/

if(!isset($_SESSION)) { 
    session_start(); 
}

require_once __DIR__ . '/lang/languages.php';
require_once __DIR__ . '/../classes/anti-xss/autoload.php';
require_once __DIR__ . '/../classes/slugify.php';
require_once __DIR__ . '/../classes/anti-xss/autoload.php';
require_once __DIR__ . '/../classes/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../classes/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../classes/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Ausi\SlugGenerator\SlugGenerator;
use voku\helper\AntiXSS;

function connect($database){
    try{
        $connect = new PDO('mysql:host='. $database['host'] .';dbname='. $database['db'], $database['user'], $database['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
        return $connect;
        
    }catch (PDOException $e){
        return false;
    }
}

function check_access($connect){
    $sentence = $connect->query("SELECT * FROM users WHERE user_email = '".$_SESSION['user_email']."' AND user_status = 1 LIMIT 1");
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function isAdmin($connect){

    if (isset($_SESSION['user_email'])) {

    $emailSession = filter_var(strtolower($_SESSION['user_email']), FILTER_SANITIZE_STRING);
    
    $sentence = $connect->prepare("SELECT * FROM users WHERE user_email = '".$emailSession."' AND user_status = 1 AND user_role = 1 LIMIT 1"); 
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

function isAgent($connect){

    if (isset($_SESSION['user_email'])) {

    $emailSession = filter_var(strtolower($_SESSION['user_email']), FILTER_SANITIZE_STRING);
    
    $sentence = $connect->prepare("SELECT * FROM users WHERE user_email = '".$emailSession."' AND user_status = 1 AND user_role = 2 LIMIT 1"); 
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

function echoOutput($data){
    $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');

    if (empty($data)) {
        return "-";
    }else{
        return $data;
    }

}

function cleardata($data){
    $antiXss = new AntiXSS();
    $data = $antiXss->xss_clean($data);
    return $data;
}

function get_user_information($connect){
    $sentence = $connect->query("SELECT * FROM users WHERE user_email = '".$_SESSION['user_email']."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function currentPage(){
    
    return isset($_GET['p']) ? (int)$_GET['p'] : 1;
}

function goToPage($parameter, $value) { 
    $params = array(); 
    $output = "?"; 
    $firstRun = true; 
    foreach($_GET as $key=>$val) { 
        if($key != $parameter) { 
            if(!$firstRun) { 
                $output .= "&"; 
            } else { 
                $firstRun = false; 
            } 
            $output .= $key."=".urlencode($val); 
        } 
    } 

    if(!$firstRun) 
        $output .= "&"; 
    $output .= $parameter."=".urlencode($value); 
    return htmlentities($output); 
} 

// LANGUAGES ---------------------------------------

function check_table($connect, $table) {

    try {
        $result = $connect->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {

        return FALSE;
    }

    return $result !== FALSE;
}

function lang($lang){
    return cleardata($lang);
}

function get_all_languages($connect){
    
    $sentence = $connect->prepare("SELECT * FROM languages ORDER BY language_status DESC, language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_active_languages($connect){
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_translated = 1 ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_language($id_language){
    return (int)cleardata($id_language);
}

function get_language_per_id($connect, $id_language){
    $sentence = $connect->query("SELECT * FROM languages WHERE language_id = $id_language LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function get_translation($connect, $langTable){
    $sentence = $connect->query("SELECT * FROM $langTable");
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function get_languages_code($connect){
    
    $sentence = $connect->prepare("SELECT language_code, language_name FROM languages"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

// PREFERRED CHOICE ---------------------------------------

function get_preferred_choice_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_preferred_choice) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function totalPreferredChoice($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM preferred_choice");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_preferred_choice($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT preferred_choice.*,tr_preferred_choice.* FROM preferred_choice,tr_preferred_choice,settings WHERE preferred_choice.pc_id = tr_preferred_choice.tr_pc AND tr_preferred_choice.tr_lang = settings.st_language GROUP BY tr_preferred_choice.tr_pc ORDER BY preferred_choice.pc_id DESC"; 

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();

}

function id_pc($id_pc){
    return (int)cleardata($id_pc);
}

function get_languages_by_pc($connect, $id_pc)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_preferred_choice WHERE tr_pc = $id_pc) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_pc_per_id_by_language($connect, $id_pc, $lang){
    $sentence = $connect->query("SELECT preferred_choice.*,tr_preferred_choice.* FROM preferred_choice,tr_preferred_choice WHERE preferred_choice.pc_id = $id_pc AND tr_preferred_choice.tr_pc = $id_pc AND tr_preferred_choice.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_pc($connect, $id_pc, $lang){
    $sentence = $connect->query("SELECT * FROM tr_preferred_choice WHERE tr_pc = $id_pc AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_pc($connect, $id_pc)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_preferred_choice WHERE tr_pc = $id_pc) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function preferred_choice_total($connect)
{
    
$total_numbers = $connect->prepare('SELECT * FROM preferred_choice');
$total_numbers->execute(array());
$total_numbers->fetchAll();
$total = $total_numbers->rowCount();
return $total;
}

// STATUS ---------------------------------------

function get_status_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptstatus) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function totalStatus($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM pt_status");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_status($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT pt_status.*,tr_ptstatus.tr_name AS tr_name FROM pt_status,tr_ptstatus,settings WHERE pt_status.pt_status_id = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = settings.st_language GROUP BY tr_ptstatus.tr_status";

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_status($id_status){
    return (int)cleardata($id_status);
}

function get_languages_by_status($connect, $id_status)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptstatus WHERE tr_status = $id_status) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_status_per_id_by_language($connect, $id_status, $lang){
    $sentence = $connect->query("SELECT pt_status.*,tr_ptstatus.* FROM pt_status,tr_ptstatus WHERE pt_status.pt_status_id = $id_status AND tr_ptstatus.tr_status = $id_status AND tr_ptstatus.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_status($connect, $id_status, $lang){
    $sentence = $connect->query("SELECT * FROM tr_ptstatus WHERE tr_status = $id_status AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_status($connect, $id_status)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_ptstatus WHERE tr_status = $id_status) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_status_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_ptstatus WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}

// STAFF ---------------------------------------

function get_staffs_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_staffs) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function totalStaffs($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM staffs");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_active_staffs($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM staffs WHERE staff_status = 1 ORDER BY staff_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_all_staffs($connect, $items_per_page = NULL){
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT staffs.*,tr_staffs.* FROM staffs,tr_staffs,settings WHERE staffs.staff_id = tr_staffs.tr_staff AND tr_staffs.tr_lang = settings.st_language GROUP BY tr_staffs.tr_staff ORDER BY staff_id DESC"; 
    
    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll(PDO::FETCH_ASSOC);
}

function id_staff($id_staff){
    return (int)cleardata($id_staff);
}

function get_languages_by_staff($connect, $id_staff)
{
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_staffs WHERE tr_staff = $id_staff) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_staff_per_id_by_language($connect, $id_staff, $lang){
    $sentence = $connect->query("SELECT staffs.*,tr_staffs.* FROM staffs,tr_staffs WHERE staffs.staff_id = $id_staff AND tr_staffs.tr_staff = $id_staff AND tr_staffs.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_staff($connect, $id_staff, $lang){
    $sentence = $connect->query("SELECT * FROM tr_staffs WHERE tr_staff = $id_staff AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_staffs($connect, $id_staff)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_staffs WHERE tr_staff = $id_staff) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_staff_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_staffs WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}

// CONDITIONS ---------------------------------------

function get_conditions_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptconditions) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function totalConditions($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM pt_conditions");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_conditions($connect, $items_per_page = NULL )
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT pt_conditions.*,tr_ptconditions.tr_name AS tr_name FROM pt_conditions,tr_ptconditions,settings WHERE pt_conditions.pt_conditions_id = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = settings.st_language GROUP BY tr_ptconditions.tr_conditions";

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_conditions($id_conditions){
    return (int)cleardata($id_conditions);
}

function get_languages_by_conditions($connect, $id_conditions)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptconditions WHERE tr_conditions = $id_conditions) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_conditions_per_id_by_language($connect, $id_conditions, $lang){
    $sentence = $connect->query("SELECT pt_conditions.*,tr_ptconditions.* FROM pt_conditions,tr_ptconditions WHERE pt_conditions.pt_conditions_id = $id_conditions AND tr_ptconditions.tr_conditions = $id_conditions AND tr_ptconditions.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_conditions($connect, $id_conditions, $lang){
    $sentence = $connect->query("SELECT * FROM tr_ptconditions WHERE tr_conditions = $id_conditions AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_conditions($connect, $id_conditions)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_ptconditions WHERE tr_conditions = $id_conditions) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_conditions_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_ptconditions WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}

// TYPES ---------------------------------------

function get_types_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_pttypes) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function totalTypes($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM pt_types");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_types($connect, $items_per_page = NULL )
{
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT pt_types.*,tr_pttypes.tr_name AS tr_name FROM pt_types,tr_pttypes,settings WHERE pt_types.pt_type_id = tr_pttypes.tr_type AND tr_pttypes.tr_lang = settings.st_language GROUP BY tr_pttypes.tr_type";

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll(PDO::FETCH_ASSOC);
}

function id_type($id_type){
    return (int)cleardata($id_type);
}

function get_languages_by_type($connect, $id_type)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_pttypes WHERE tr_type = $id_type) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_type_per_id_by_language($connect, $id_type, $lang){
    $sentence = $connect->query("SELECT pt_types.*,tr_pttypes.* FROM pt_types,tr_pttypes WHERE pt_types.pt_type_id = $id_type AND tr_pttypes.tr_type = $id_type AND tr_pttypes.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_type($connect, $id_type, $lang){
    $sentence = $connect->query("SELECT * FROM tr_pttypes WHERE tr_type = $id_type AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_type($connect, $id_type)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_pttypes WHERE tr_type = $id_type) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_type_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_pttypes WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}

// EXTRAS ---------------------------------------

function get_extras_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptextras) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function totalExtras($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM pt_extras");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_extras($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = ("SELECT pt_extras.*,tr_ptextras.tr_name AS tr_name FROM pt_extras,tr_ptextras,settings WHERE pt_extras.pt_extra_id = tr_ptextras.tr_extra AND tr_ptextras.tr_lang = settings.st_language GROUP BY tr_ptextras.tr_extra"); 

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_extra($id_extra){
    return (int)cleardata($id_extra);
}

function get_languages_by_extra($connect, $id_extra)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptextras WHERE tr_extra = $id_extra) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_extra_per_id_by_language($connect, $id_extra, $lang){
    $sentence = $connect->query("SELECT pt_extras.*,tr_ptextras.* FROM pt_extras,tr_ptextras WHERE pt_extras.pt_extra_id = $id_extra AND tr_ptextras.tr_extra = $id_extra AND tr_ptextras.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_extra($connect, $id_extra, $lang){
    $sentence = $connect->query("SELECT * FROM tr_ptextras WHERE tr_extra = $id_extra AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_extra($connect, $id_extra)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_ptextras WHERE tr_extra = $id_extra) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


// MENUS ---------------------------------------

function get_all_menus($connect){
    
    $sentence = $connect->prepare("SELECT menus.*, languages.language_name FROM menus, languages WHERE menus.menu_lang = languages.language_code"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_menu($id_menu){
    return (int)cleardata($id_menu);
}

function get_languages_by_menu($connect, $id_menu)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT menu_lang FROM menus WHERE menu_id = $id_menu) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_menu_per_id($connect, $id_menu){
    $sentence = $connect->query("SELECT * FROM menus WHERE menu_id = $id_menu LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function get_navigations($connect){
    
    $sentence = $connect->prepare("SELECT * FROM navigations ORDER BY navigation_order ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_navigations_by_menu($connect, $id_menu, $lang){
    
    $sentence = $connect->prepare("SELECT navigations.navigation_id, COALESCE(tr_pages.tr_slug, navigations.navigation_url) AS navigation_url, COALESCE(tr_pages.tr_title, navigations.navigation_label) AS navigation_label, navigations.navigation_type FROM navigations LEFT JOIN tr_pages ON tr_page = navigations.navigation_page AND tr_lang = '".$lang."' WHERE navigation_menu = '".$id_menu."' ORDER BY navigation_order ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

// PROPERTIES ---------------------------------------

function get_gallery($connect, $id_property){

$sentence = $connect->prepare("SELECT * FROM properties_gallery WHERE pg_property = '".$id_property."'");
$sentence->execute();
return $sentence->fetchAll();

}

function get_extras_by_property($connect, $id_property)
{
    
    $sentence = $connect->prepare("SELECT pt_extras.*,tr_ptextras.tr_name AS tr_name FROM pt_extras,tr_ptextras WHERE pt_extras.pt_extra_id = tr_ptextras.tr_extra AND pt_extra_id IN (SELECT pe_extra FROM properties_extras WHERE pe_property = $id_property) GROUP BY tr_ptextras.tr_extra"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_extras_by_not_property($connect, $id_property)
{
    
    $sentence = $connect->prepare("SELECT pt_extras.*,tr_ptextras.tr_name AS tr_name FROM pt_extras,tr_ptextras WHERE pt_extras.pt_extra_id = tr_ptextras.tr_extra AND pt_extras.pt_extra_id = tr_ptextras.tr_extra AND pt_extras.pt_extra_id NOT IN (SELECT pe_extra FROM properties_extras WHERE pe_property = $id_property) GROUP BY tr_ptextras.tr_extra"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_properties_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_properties) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function totalProperties($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM properties");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_references($connect)
{
    
    $sql = "SELECT pt_reference FROM properties";

    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll(PDO::FETCH_ASSOC);
}

function get_all_properties($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;

    $sql = "SELECT properties.*,tr_properties.* FROM properties,tr_properties,settings WHERE properties.pt_id = tr_properties.tr_property AND tr_properties.tr_lang = settings.st_language GROUP BY tr_properties.tr_property ORDER BY pt_id DESC";

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll(PDO::FETCH_ASSOC);
}

function id_property($id_property){
    return (int)cleardata($id_property);
}

function get_languages_by_property($connect, $id_property)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_properties WHERE tr_property = $id_property) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_property_per_id_by_language($connect, $id_property, $lang){
    $sentence = $connect->query("SELECT properties.*,tr_properties.* FROM properties,tr_properties WHERE properties.pt_id = $id_property AND tr_properties.tr_property = $id_property AND tr_properties.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_property($connect, $id_property, $lang){
    $sentence = $connect->query("SELECT * FROM tr_properties WHERE tr_property = $id_property AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_property($connect, $id_property)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_properties WHERE tr_property = $id_property) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_property_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_properties WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}

function properties_total($connect)
{
    
$total_numbers = $connect->prepare('SELECT * FROM properties');
$total_numbers->execute(array());
$total_numbers->fetchAll();
$total = $total_numbers->rowCount();
return $total;
}

// PAGES ---------------------------------------

function is_default_page($connect, $page_id)
{
    
    $sentence = $connect->prepare("SELECT * FROM settings WHERE '".$page_id."' IN (SELECT st_defaultpropertiespage FROM settings) OR '".$page_id."' IN (SELECT st_defaultsearchpage FROM settings) OR '".$page_id."' IN (SELECT st_defaultcontactpage FROM settings) OR '".$page_id."' IN (SELECT st_defaultblogpage FROM settings) OR '".$page_id."' IN (SELECT st_defaultprivacypage FROM settings) OR '".$page_id."' IN (SELECT st_defaulttermspage FROM settings)"); 
    $sentence->execute();
    $sentence->fetchAll();
    $exist = $sentence->rowCount();

    if ($exist > 0) {
        return true;
    }else{
        return false;
    }

}

function get_pages_by_template($connect, $lang, $type)
{
    $sentence = $connect->prepare("SELECT pages.*,tr_pages.* FROM pages,tr_pages WHERE pages.page_id = tr_pages.tr_page AND pages.page_template = '".$type."' AND tr_pages.tr_lang = '".$lang."'"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_pages_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_pages) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_pages_by_language($connect, $lang)
{
    
    $sentence = $connect->prepare("SELECT pages.*,tr_pages.* FROM pages,tr_pages WHERE pages.page_id = tr_pages.tr_page AND tr_pages.tr_lang = '".$lang."'"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function totalPages($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM pages");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_pages($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT pages.*,tr_pages.* FROM pages,tr_pages,settings WHERE pages.page_id = tr_pages.tr_page AND tr_pages.tr_lang = settings.st_language GROUP BY tr_pages.tr_page"; 
    
    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll(PDO::FETCH_ASSOC);
}

function id_page($id_page){
    return (int)cleardata($id_page);
}

function get_languages_by_page($connect, $id_page)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_pages WHERE tr_page = $id_page) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_page_per_id_by_language($connect, $id_page, $lang){
    $sentence = $connect->query("SELECT pages.*,tr_pages.* FROM pages,tr_pages WHERE pages.page_id = $id_page AND tr_pages.tr_page = $id_page AND tr_pages.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_page($connect, $id_page, $lang){
    $sentence = $connect->query("SELECT * FROM tr_pages WHERE tr_page = $id_page AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function get_page_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_pages WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}


function get_languages_not_page($connect, $id_page)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_pages WHERE tr_page = $id_page) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function pages_total($connect)
{
    
$total_numbers = $connect->prepare('SELECT * FROM pages');
$total_numbers->execute(array());
$total_numbers->fetchAll();
$total = $total_numbers->rowCount();
return $total;
}

// BLOG  ---------------------------------------

function get_categories_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_categories) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function totalCategories($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM categories");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_categories($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT categories.*,tr_categories.tr_name AS tr_name FROM categories,tr_categories,settings WHERE categories.category_id = tr_categories.tr_category AND tr_categories.tr_lang = settings.st_language GROUP BY tr_categories.tr_category";

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
   
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_category($id_category){
    return (int)cleardata($id_category);
}

function get_languages_by_category($connect, $id_category)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_categories WHERE tr_category = $id_category) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_category_per_id_by_language($connect, $id_category, $lang){
    $sentence = $connect->query("SELECT categories.*,tr_categories.* FROM categories,tr_categories WHERE categories.category_id = $id_category AND tr_categories.tr_category = $id_category AND tr_categories.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_category($connect, $id_category, $lang){
    $sentence = $connect->query("SELECT * FROM tr_categories WHERE tr_category = $id_category AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_category($connect, $id_category)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_categories WHERE tr_category = $id_category) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_category_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_categories WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}


function get_posts_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_posts) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function totalPosts($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM posts");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_posts($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;

    $sql = "SELECT posts.*,tr_posts.* FROM posts,tr_posts,settings WHERE posts.post_id = tr_posts.tr_post AND tr_posts.tr_lang = settings.st_language GROUP BY tr_posts.tr_post";

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
   
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_post($id_post){
    return (int)cleardata($id_post);
}

function get_languages_by_post($connect, $id_post)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_posts WHERE tr_post = $id_post) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_post_per_id_by_language($connect, $id_post, $lang){
    $sentence = $connect->query("SELECT posts.*,tr_posts.* FROM posts,tr_posts WHERE posts.post_id = $id_post AND tr_posts.tr_post = $id_post AND tr_posts.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_post($connect, $id_post, $lang){
    $sentence = $connect->query("SELECT * FROM tr_posts WHERE tr_post = $id_post AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function get_post_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_posts WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}


function get_languages_not_post($connect, $id_post)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_posts WHERE tr_post = $id_post) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function posts_total($connect)
{
    
$total_numbers = $connect->prepare('SELECT * FROM posts');
$total_numbers->execute(array());
$total_numbers->fetchAll();
$total = $total_numbers->rowCount();
return $total;
}

// ADS ---------------------------------------

function get_all_ads($connect){
    
    $sentence = $connect->prepare("SELECT ads.*, languages.language_name FROM ads, languages WHERE ads.ad_lang = languages.language_code"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_ad($id_ad){
    return (int)cleardata($id_ad);
}

function get_languages_by_ad($connect, $id_ad)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT ad_lang FROM ads WHERE ad_id = $id_ad) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_ad_per_id($connect, $id_ad){
    $sentence = $connect->query("SELECT * FROM ads WHERE ad_id = $id_ad LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

// USERS ---------------------------------------

function get_active_users($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM users WHERE user_status = 1 ORDER BY user_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function totalUsers($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM users");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function total_properties_by_user($connect, $id_user){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM properties WHERE pt_agent = $id_user");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];
    return $total_items;    

}

function get_all_properties_by_user($connect, $id_user, $max, $items_per_page = NULL){

    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;

    $sql = "SELECT properties.*,tr_properties.* FROM properties,tr_properties WHERE properties.pt_id = tr_properties.tr_property AND properties.pt_agent = $id_user GROUP BY tr_properties.tr_property ORDER BY pt_date DESC";

    if ($max) {
        $sql .=" LIMIT $max";
    };

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll(PDO::FETCH_ASSOC);

}

function get_all_users($connect)
{
    
    $sentence = $connect->prepare("SELECT users.*,roles.role_name AS role_name FROM users,roles WHERE users.user_role = roles.role_id ORDER BY users.user_id DESC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_user($id_user){
    return (int)cleardata($id_user);
}

function get_user_per_id($connect, $id_user){
    $sentence = $connect->query("SELECT * FROM users WHERE user_id = $id_user LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function users_total($connect)
{
    
$total_numbers = $connect->prepare('SELECT * FROM users');
$total_numbers->execute(array());
$total_numbers->fetchAll();
$total = $total_numbers->rowCount();
return $total;
}

// SUBSCRIBERS ---------------------------------------

function totalSubscribers($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM subscribers");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_subscribers($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM subscribers ORDER BY subscriber_id DESC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

// TESTIMONIALS ---------------------------------------

function totalTestimonials($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM testimonials");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_testimonials($connect){
    
    $sentence = $connect->prepare("SELECT testimonials.*, languages.language_name FROM testimonials, languages WHERE testimonials.testimonial_lang = languages.language_code"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_testimonial($id_testimonial){
    return (int)cleardata($id_testimonial);
}

function get_testimonial_per_id($connect, $id_testimonial){
    $sentence = $connect->query("SELECT * FROM testimonials WHERE testimonial_id = $id_testimonial LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

// PARTNERS ---------------------------------------

function totalPartners($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM partners");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_partners($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT * FROM partners ORDER BY partner_id DESC"; 
    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_partner($id_partner){
    return (int)cleardata($id_partner);
}

function get_partner_per_id($connect, $id_partner){
    $sentence = $connect->query("SELECT * FROM partners WHERE partner_id = $id_partner LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

// CITIES ---------------------------------------

function get_cities_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptcities) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function totalCities($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM pt_cities");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_cities($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT pt_cities.*,tr_ptcities.tr_name AS tr_name FROM pt_cities,tr_ptcities,settings WHERE pt_cities.pt_city_id = tr_ptcities.tr_city AND tr_ptcities.tr_lang = settings.st_language GROUP BY pt_cities.pt_city_id";
    
    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_city($id_city){
    return (int)cleardata($id_city);
}

function get_languages_by_city($connect, $id_city)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptcities WHERE tr_city = $id_city) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_city_per_id_by_language($connect, $id_city, $lang){
    $sentence = $connect->query("SELECT pt_cities.*,tr_ptcities.* FROM pt_cities,tr_ptcities WHERE pt_cities.pt_city_id = $id_city AND tr_ptcities.tr_city = $id_city AND tr_ptcities.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_city($connect, $id_city, $lang){
    $sentence = $connect->query("SELECT * FROM tr_ptcities WHERE tr_city = $id_city AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_city($connect, $id_city)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_ptcities WHERE tr_city = $id_city) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_city_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_ptcities WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}

// ZONES ---------------------------------------

function get_zones_languages($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptzones) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function totalZones($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM pt_zones");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_zones($connect, $items_per_page = NULL)
{
    
    $limit = (currentPage() > 1) ? currentPage() * $items_per_page - $items_per_page : 0;
    
    $sql = "SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name,tr_ptcities.tr_name AS city_name FROM pt_zones,tr_ptzones,tr_ptcities,settings WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND pt_zones.pt_zone_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = settings.st_language AND tr_ptzones.tr_lang = settings.st_language GROUP BY pt_zones.pt_zone_id";

    if ($items_per_page) {
        $sql .=" LIMIT $limit, $items_per_page";
    };
    
    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_all_zones_by_city($connect, $id_city)
{
    
    
    $sql = "SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name FROM pt_zones,tr_ptzones WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND pt_zones.pt_zone_city = $id_city GROUP BY pt_zones.pt_zone_id";

    $sentence = $connect->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_zone($id_zone){
    return (int)cleardata($id_zone);
}

function get_languages_by_zone($connect, $id_zone)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code IN (SELECT tr_lang FROM tr_ptzones WHERE tr_zone = $id_zone) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_zone_per_id_by_language($connect, $id_zone, $lang){
    $sentence = $connect->query("SELECT pt_zones.*,tr_ptzones.*,tr_ptcities.tr_name AS city_name FROM pt_zones,tr_ptzones,tr_ptcities WHERE pt_zones.pt_zone_id = $id_zone AND pt_zones.pt_zone_city = tr_ptcities.tr_city AND tr_ptzones.tr_zone = $id_zone AND tr_ptzones.tr_lang = '".$lang."' AND tr_ptcities.tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function check_zone($connect, $id_zone, $lang){
    $sentence = $connect->query("SELECT * FROM tr_ptzones WHERE tr_zone = $id_zone AND tr_lang = '".$lang."' LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}


function get_languages_not_zone($connect, $id_zone)
{
    
    $sentence = $connect->prepare("SELECT * FROM languages WHERE language_status = 1 AND language_code NOT IN (SELECT tr_lang FROM tr_ptzones WHERE tr_zone = $id_zone) ORDER BY language_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_zone_slug($connect, $slug){

$sentence = $connect->prepare("SELECT COUNT(*) AS total FROM tr_ptzones WHERE tr_slug LIKE '$slug%'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row['total'];
}

// EMAILS

function id_email($id){
    return (int)cleardata($id);
}

function get_etemplate_by_id($connect, $id){

$sentence = $connect->prepare("SELECT * FROM emailtemplates WHERE email_id = '".$id."'");
$sentence->execute();
$row = $sentence->fetch(PDO::FETCH_ASSOC);
return $row;
}

function get_all_email_templates($connect){
    
    $sentence = $connect->prepare("SELECT * FROM emailtemplates"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getEmailTemplate($connect, $id){

    if (!empty($id) && (int)($id)) {

        $q = $connect->query("SELECT * FROM emailtemplates WHERE email_id = ".$id." LIMIT 1");
        $f = $q->fetch();
        $result = $f;

        return $result;

    }else{

        return null;
    }  
}

function checkMail($settings){

$smtp = new SMTP;

//Enable connection-level debug output
//$smtp->do_debug = SMTP::DEBUG_CONNECTION;

$result = "";

try {
    //Connect to an SMTP server
    if (!$smtp->connect($settings['st_smtphost'], $settings['st_smtpport'])) {
       $result = "Connect failed";
    }
    //Say hello
    if (!$smtp->hello(gethostname())) {
        $result = "EHLO failed";
    }
    //Get the list of ESMTP services the server offers
    $e = $smtp->getServerExtList();
    //If server can do TLS encryption, use it
    if (is_array($e) && array_key_exists($settings['st_smtpencrypt'], $e)) {
        $tlsok = $smtp->startTLS();
        if (!$tlsok) {
        $result = 'Failed to start encryption: ' . $smtp->getError()['error'];
        }
        //Repeat EHLO after STARTTLS
        if (!$smtp->hello(gethostname())) {
        $result = 'EHLO (2) failed: ' . $smtp->getError()['error'];
        }
        //Get new capabilities list, which will usually now include AUTH if it didn't before
        $e = $smtp->getServerExtList();
    }
    //If server supports authentication, do it (even if no encryption)
    if (is_array($e) && array_key_exists('AUTH', $e)) {
        if ($smtp->authenticate($settings['st_smtpemail'], $settings['st_smtppassword'])) {
        } else{
            $result = 'Authentication failed: ' . $smtp->getError()['error'];
        }
    }

} catch (Exception $e) {
    $result = 'SMTP error: ' . $e->getMessage();
}

    return $result;

}

function sendMail($array_content, $email_content, $destinationmail, $fromName, $subject, $isHtml, $settings) {
    
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();                                          
        $mail->Host       = $settings['st_smtphost'];                
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $settings['st_smtpemail'];              
        $mail->Password   = $settings['st_smtppassword'];                             
        $mail->SMTPSecure = $settings['st_smtpencrypt'];
        $mail->Port       = $settings['st_smtpport'];

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
        if (!$mail->send())
        {
            $result = $mail->ErrorInfo;
        }
        else 
        {
            $result = TRUE;
        }

        return $result;

    } catch (Exception $e) {
     return null;
 }

} 

function getPrice($price, $array){

    $row = $array;

    $output = "";

    if ($row['st_currencyposition'] == 'left') {
        $output = $row['st_currency'] . number_format($price, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'left-space') {
        $output = $row['st_currency'] .' '. number_format($price, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'right') {
        $output = number_format($price, 0, '', $row['st_decimalseparator']) . $row['st_currency'];
    }elseif ($row['st_currencyposition'] == 'right-space') {
        $output = number_format($price, 0, '', $row['st_decimalseparator']) .' '. $row['st_currency'];
    }else{

    }

    return $output;
}

// SLIDERS ---------------------------------------

function totalSliders($connect, $items_per_page){

    $total_items = $connect->prepare("SELECT COUNT(*) AS total FROM sliders");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_sliders($connect)
{
    
    $sentence = $connect->prepare("SELECT sliders.*, properties.pt_reference AS property_reference FROM sliders, properties WHERE sliders.slider_property = properties.pt_id ORDER BY sliders.slider_id DESC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function id_slider($id_slider){
    return (int)cleardata($id_slider);
}

function get_slider_per_id($connect, $id_slider){
    $sentence = $connect->query("SELECT * FROM sliders WHERE slider_id = $id_slider LIMIT 1");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

// OTHERS ---------------------------------------

function getSettings($connect)
{
    $q = $connect->query("SELECT * FROM settings");
    $f = $q->fetch();
    $result = $f;
    return $result;
}

function get_settings($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM settings"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function get_theme($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM theme"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_all_roles($connect)
{
    
    $sentence = $connect->prepare("SELECT * FROM roles ORDER BY role_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function FormatDate($connect, $date){

    $sentence = $connect->prepare("SELECT st_dateformat FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $newDate = date($row['st_dateformat'], strtotime($date));
    return $newDate;
}

function hexToRgb($hex, $alpha = false) {
   $hex = str_replace('#', '', $hex);
   $length = strlen($hex);
   $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
   $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
   $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
   if ( $alpha ) {
      $rgb['a'] = $alpha;
   }

   // return $rgb;
   return implode(array_keys($rgb)) . '(' . implode(', ', $rgb) . ')';
}

?>