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


$id = id_status($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$pt_status_id = cleardata($_POST['pt_status_id']);


$statment = $connect->prepare(
	'UPDATE pt_status SET pt_status_id = :pt_status_id WHERE pt_status_id = :pt_status_id'
	);

$statment->execute(array(

		':pt_status_id' => $pt_status_id

		));

	$tr_name = cleardata($_POST['tr_name']);
	$tr_status = cleardata($_POST['tr_status']);
	$tr_id = cleardata($_POST['tr_id']);
	$tr_lang = cleardata($_POST['tr_lang']);
	$slug = convertSlug($_POST['tr_slug']);

$sentence = $connect->prepare("UPDATE tr_ptstatus SET tr_slug = :tr_slug, tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_status = :tr_status");

$sentence->execute(array(

		':tr_slug' => $slug,
		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_status' => $tr_status
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_status = id_status($_GET['id']);

$lang = lang($_GET['lang']);

$status = get_status_per_id_by_language($connect, $id_status, $lang);

    if (!$status){
    header('Location: ./home.php');
}

$status = $status['0'];

$languages = get_languages_by_status($connect, $id_status);
$activelanguages = get_languages_not_status($connect, $id_status);

require '../views/edit.status.view.php';

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>