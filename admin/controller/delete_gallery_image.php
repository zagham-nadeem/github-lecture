<?php 


session_start();
if (isset($_SESSION['user_email'])){
    
    
require '../../config.php';
require '../functions.php';


$connect = connect($database);
if(!$connect){
	header('Location: ./error.php');
	} 

$id_image = cleardata($_GET['id']);

if(!$id_image){
	header('Location: ./home.php');
}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){

$statement = $connect->prepare('DELETE FROM properties_gallery WHERE pg_id = :pg_id;');
$statement->execute(array('pg_id' => $id_image));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location:'.SITE_URL);
}

}else{
	
	header('Location: ./login.php');		
}


?>