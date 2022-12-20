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

$id_city = cleardata($_GET['id']);

if(!$id_city){
	header('Location: ./home.php');
}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_city = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM pt_cities WHERE pt_city_id = :pt_city_id');
$statement->execute(array('pt_city_id' => $id_city));

$statement = $connect->prepare('DELETE FROM tr_ptcities WHERE tr_city = :tr_city');
$statement->execute(array('tr_city' => $id_city));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>