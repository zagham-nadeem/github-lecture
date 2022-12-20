<?php 

/*--------------------*/
// Description: Evora - Real Estate CMS
// Author: Evora
// Author URI: https://wicombit.com
/*--------------------*/

session_start();
if (isset($_SESSION['user_email'])){
    
    
require '../../config.php';
require '../functions.php';
require '../views/header.view.php';

$connect = connect($database);
if(!$connect){
	header ('Location: ./error.php');
	}


$id = id_zone($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$pt_zone_id = cleardata($_POST['pt_zone_id']);
	$pt_zone_city = cleardata($_POST['pt_zone_city']);


$statment = $connect->prepare(
	'UPDATE pt_zones SET pt_zone_id = :pt_zone_id, pt_zone_city = :pt_zone_city WHERE pt_zone_id = :pt_zone_id'
	);

$statment->execute(array(

		':pt_zone_id' => $pt_zone_id,
		':pt_zone_city' => $pt_zone_city
		));

	$tr_name = cleardata($_POST['tr_name']);
	$tr_zone = cleardata($_POST['tr_zone']);
	$tr_id = cleardata($_POST['tr_id']);
	$tr_lang = cleardata($_POST['tr_lang']);
	$slug = convertSlug($_POST['tr_slug']);

$sentence = $connect->prepare("UPDATE tr_ptzones SET tr_slug = :tr_slug, tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_zone = :tr_zone");

$sentence->execute(array(

		':tr_slug' => $slug,
		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_zone' => $tr_zone
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_zone = id_zone($_GET['id']);

$lang = lang($_GET['lang']);

$zone = get_zone_per_id_by_language($connect, $id_zone, $lang);

    if (!$zone){
    header('Location: ./home.php');
}

$zone = $zone['0'];

$languages = get_languages_by_zone($connect, $id_zone);
$activelanguages = get_languages_not_zone($connect, $id_zone);
$cities = get_all_cities($connect);

require '../views/edit.zone.view.php';

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>