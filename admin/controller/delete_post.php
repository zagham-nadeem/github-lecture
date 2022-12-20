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

$id_post = cleardata($_GET['id']);

if(!$id_post){
	header('Location: ./home.php');
}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

$id_post = cleardata($_GET['id']);

$statement = $connect->prepare('DELETE FROM posts WHERE post_id = :post_id');
$statement->execute(array('post_id' => $id_post));

$statement = $connect->prepare('DELETE FROM tr_posts WHERE tr_post = :tr_post');
$statement->execute(array('tr_post' => $id_post));

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