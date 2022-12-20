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
	header('Location: ./error.php');
	} 

$id = id_property($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_property = cleardata($_GET['id']);
$lang = cleardata($_GET['lang']);

$statement = $connect->prepare('DELETE FROM tr_properties WHERE tr_property = :tr_property AND tr_lang = :tr_lang');
$statement->execute(array('tr_property' => $id_property, 'tr_lang' => $lang));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else {
		header('Location: ./login.php');		
		}


?>