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


$id = id_type($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$pt_type_id = cleardata($_POST['pt_type_id']);


$statment = $connect->prepare("UPDATE pt_types SET pt_type_id = :pt_type_id WHERE pt_type_id = :pt_type_id");

$statment->execute(array(

		':pt_type_id' => $pt_type_id

		));

	$tr_name = cleardata($_POST['tr_name']);
	$tr_type = cleardata($_POST['tr_type']);
	$tr_id = cleardata($_POST['tr_id']);
	$tr_lang = cleardata($_POST['tr_lang']);
	$slug = convertSlug($_POST['tr_slug']);

$sentence = $connect->prepare("UPDATE tr_pttypes SET tr_slug = :tr_slug, tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_type = :tr_type");

$sentence->execute(array(

		':tr_slug' => $slug,
		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_type' => $tr_type
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_type = id_type($_GET['id']);

$lang = lang($_GET['lang']);

$type = get_type_per_id_by_language($connect, $id_type, $lang);

    if (!$type){
    header('Location: ./home.php');
}

$type = $type['0'];

$languages = get_languages_by_type($connect, $id_type);
$activelanguages = get_languages_not_type($connect, $id_type);

require '../views/edit.type.view.php';

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>