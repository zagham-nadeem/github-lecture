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


$id = id_extra($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$pt_extra_id = cleardata($_POST['pt_extra_id']);


$statment = $connect->prepare("UPDATE pt_extras SET pt_extra_id = :pt_extra_id WHERE pt_extra_id = :pt_extra_id");

$statment->execute(array(':pt_extra_id' => $pt_extra_id));

	$tr_name = cleardata($_POST['tr_name']);
	$tr_extra = cleardata($_POST['tr_extra']);
	$tr_id = cleardata($_POST['tr_id']);
	$tr_lang = cleardata($_POST['tr_lang']);


$sentence = $connect->prepare("UPDATE tr_ptextras SET tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_extra = :tr_extra");

$sentence->execute(array(

		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_extra' => $tr_extra

		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_extra = id_extra($_GET['id']);

$lang = lang($_GET['lang']);

$extra = get_extra_per_id_by_language($connect, $id_extra, $lang);

    if (!$extra){
    header('Location: ./home.php');
}

$extra = $extra['0'];

$languages = get_languages_by_extra($connect, $id_extra);
$activelanguages = get_languages_not_extra($connect, $id_extra);

require '../views/edit.extra.view.php';

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>