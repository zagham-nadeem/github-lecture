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

$id_staff = cleardata($_GET['id']);

if(!$id_staff){
	header('Location: ./home.php');
}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1){

$id_staff = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM staffs WHERE staff_id = :staff_id');
$statement->execute(array('staff_id' => $id_staff));

$statement = $connect->prepare('DELETE FROM tr_staffs WHERE tr_staff = :tr_staff');
$statement->execute(array('tr_staff' => $id_staff));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}elseif($check_access['user_role'] == 2){

	require '../views/denied.view.php';
	
}else{
	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>