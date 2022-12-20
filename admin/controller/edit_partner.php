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


$id = id_partner($_GET['id']);

if ( empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$partner_id = cleardata($_POST['partner_id']);
	$partner_name = cleardata($_POST['partner_name']);
	$partner_status = cleardata($_POST['partner_status']);

	$imagefile = explode(".", $_FILES["partner_image"]["name"]);

	$image_save = $_POST['partner_image_save'];
	$partner_image = $_FILES['partner_image'];

	if (empty($partner_image['name'])) {
		$partner_image = $image_save;
	} else{
			$imagefile = explode(".", $_FILES["partner_image"]["name"]);
			$renamefile = round(microtime(true)) . '.' . end($imagefile);
		$image_upload = '../../images/';
		move_uploaded_file($_FILES['partner_image']['tmp_name'], $image_upload . 'partner_' . $renamefile);
		$partner_image = 'partner_' . $renamefile;
	}

$statment = $connect->prepare("UPDATE partners SET partner_id = :partner_id, partner_name = :partner_name, partner_status = :partner_status, partner_image = :partner_image WHERE partner_id = :partner_id");

$statment->execute(array(

		':partner_id' => $partner_id,
		':partner_name' => $partner_name,
		':partner_status' => $partner_status,
		':partner_image' => $partner_image
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_partner = id_partner($_GET['id']);

$partner = get_partner_per_id($connect, $id_partner);

    if (!$partner){
    header('Location: ./home.php');
}

$partner = $partner['0'];

require '../views/edit.partner.view.php';

}

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