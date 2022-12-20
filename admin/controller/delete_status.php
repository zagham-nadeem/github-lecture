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

$id_status = cleardata($_GET['id']);

if(!$id_status){
	header('Location: ./home.php');
}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_status = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM pt_status WHERE pt_status_id = :pt_status_id');
$statement->execute(array('pt_status_id' => $id_status));

$statement = $connect->prepare('DELETE FROM tr_ptstatus WHERE tr_status = :tr_status');
$statement->execute(array('tr_status' => $id_status));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}

?>