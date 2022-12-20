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
	header ('Location: ./error.php');
	}

$id_language = id_language($_GET['id']);
    
if(empty($id_language)){
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$language_id = cleardata($_POST['language_id']);
	$language_name = cleardata($_POST['language_name']);
	$language_code = cleardata($_POST['language_code']);
	$language_type = cleardata($_POST['language_type']);
	$language_status = cleardata($_POST['language_status']);

$statment = $connect->prepare(
	"UPDATE languages SET language_name = :language_name, language_code = :language_code, language_type = :language_type, language_status = :language_status WHERE language_id = :language_id"
	);

$statment->execute(array(

		':language_name' => $language_name,
		':language_code' => $language_code,
		':language_type' => $language_type,
		':language_status' => $language_status,
		':language_id' => $language_id

		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

} else{

$id_language = id_language($_GET['id']);

$language = get_language_per_id($connect, $id_language);
    
    if (!$language){
    header('Location: ./home.php');
}

$language = $language['0'];

$settings = get_settings($connect);

}

require '../views/edit.language.view.php';

}elseif($check_access['user_role'] == 2){

	require '../views/denied.view.php';
	
}else{
	
	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>