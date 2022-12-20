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

$id_conditions = cleardata($_GET['id']);

if(!$id_conditions){
	header('Location: ./home.php');
}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_conditions = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM pt_conditions WHERE pt_conditions_id = :pt_conditions_id');
$statement->execute(array('pt_conditions_id' => $id_conditions));

$statement = $connect->prepare('DELETE FROM tr_ptconditions WHERE tr_conditions = :tr_conditions');
$statement->execute(array('tr_conditions' => $id_conditions));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>