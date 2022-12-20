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

$id_category = cleardata($_GET['id']);

if(!$id_category){
	header('Location: ./home.php');
}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_category = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM categories WHERE category_id = :category_id');
$statement->execute(array('category_id' => $id_category));

$statement = $connect->prepare('DELETE FROM tr_categories WHERE tr_category = :tr_category');
$statement->execute(array('tr_category' => $id_category));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>