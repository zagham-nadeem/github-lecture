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

$id_extra = cleardata($_GET['id']);

if(!$id_extra){
	header('Location: ./home.php');
}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_extra = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM pt_extras WHERE pt_extra_id = :pt_extra_id');
$statement->execute(array('pt_extra_id' => $id_extra));

$statement = $connect->prepare('DELETE FROM tr_ptextras WHERE tr_extra = :tr_extra');
$statement->execute(array('tr_extra' => $id_extra));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>