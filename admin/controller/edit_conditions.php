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


$id = id_conditions($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$pt_conditions_id = cleardata($_POST['pt_conditions_id']);


$statment = $connect->prepare("UPDATE pt_conditions SET pt_conditions_id = :pt_conditions_id WHERE pt_conditions_id = :pt_conditions_id");

$statment->execute(array(':pt_conditions_id' => $pt_conditions_id));

	$tr_name = cleardata($_POST['tr_name']);
	$tr_conditions = cleardata($_POST['tr_conditions']);
	$tr_id = cleardata($_POST['tr_id']);
	$tr_lang = cleardata($_POST['tr_lang']);
	$slug = convertSlug($_POST['tr_slug']);

$sentence = $connect->prepare("UPDATE tr_ptconditions SET tr_slug = :tr_slug, tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_conditions = :tr_conditions");

$sentence->execute(array(

		':tr_slug' => $slug,
		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_conditions' => $tr_conditions
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_conditions = id_conditions($_GET['id']);

$lang = lang($_GET['lang']);

$conditions = get_conditions_per_id_by_language($connect, $id_conditions, $lang);

    if (!$conditions){
    header('Location: ./home.php');
}

$conditions = $conditions['0'];

$languages = get_languages_by_conditions($connect, $id_conditions);
$activelanguages = get_languages_not_conditions($connect, $id_conditions);

require '../views/edit.conditions.view.php';

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>