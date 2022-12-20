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


$id = id_slider($_GET['id']);

if ( empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$slider_id = cleardata($_POST['slider_id']);
	$slider_property = cleardata($_POST['slider_property']);
	$slider_visibility = cleardata($_POST['slider_visibility']);

	$imagefile = explode(".", $_FILES["slider_image"]["name"]);

	$image_save = $_POST['slider_image_save'];
	$slider_image = $_FILES['slider_image'];

	if (empty($slider_image['name'])) {
		$slider_image = $image_save;
	} else{
			$imagefile = explode(".", $_FILES["slider_image"]["name"]);
			$renamefile = round(microtime(true)) . '.' . end($imagefile);
		$image_upload = '../../images/';
		move_uploaded_file($_FILES['slider_image']['tmp_name'], $image_upload . 'slider_' . $renamefile);
		$slider_image = 'slider_' . $renamefile;
	}


$statment = $connect->prepare(
	'UPDATE sliders SET slider_id = :slider_id, slider_property = :slider_property, slider_visibility = :slider_visibility, slider_image = :slider_image WHERE slider_id = :slider_id'
	);

$statment->execute(array(

		':slider_id' => $slider_id,
		':slider_property' => $slider_property,
		':slider_visibility' => $slider_visibility,
		':slider_image' => $slider_image

		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_slider = id_slider($_GET['id']);

$slider = get_slider_per_id($connect, $id_slider);

    if (!$slider){
    header('Location: ./home.php');
}

$slider = $slider['0'];

$properties = get_all_properties($connect);

require '../views/edit.slider.view.php';

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