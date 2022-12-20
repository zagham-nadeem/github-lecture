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

$id_type = cleardata($_GET['id']);

if(!$id_type){
	header('Location: ./home.php');
}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_type = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM pt_types WHERE pt_type_id = :pt_type_id');
$statement->execute(array('pt_type_id' => $id_type));

$statement = $connect->prepare('DELETE FROM tr_pttypes WHERE tr_type = :tr_type');
$statement->execute(array('tr_type' => $id_type));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>