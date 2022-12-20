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

$id_zone = cleardata($_GET['id']);

if(!$id_zone){
	header('Location: ./home.php');
}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_zone = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM pt_zones WHERE pt_zone_id = :pt_zone_id');
$statement->execute(array('pt_zone_id' => $id_zone));

$statement = $connect->prepare('DELETE FROM tr_ptzones WHERE tr_zone = :tr_zone');
$statement->execute(array('tr_zone' => $id_zone));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>