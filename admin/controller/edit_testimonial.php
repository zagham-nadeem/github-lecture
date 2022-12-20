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


$id = id_testimonial($_GET['id']);

if ( empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$testimonial_id = cleardata($_POST['testimonial_id']);
	$testimonial_name = cleardata($_POST['testimonial_name']);
	$testimonial_description = cleardata($_POST['testimonial_description']);
	$testimonial_job = cleardata($_POST['testimonial_job']);
	$testimonial_status = cleardata($_POST['testimonial_status']);
	$testimonial_lang = cleardata($_POST['testimonial_lang']);

	$imagefile = explode(".", $_FILES["testimonial_image"]["name"]);

	$image_save = $_POST['testimonial_image_save'];
	$testimonial_image = $_FILES['testimonial_image'];

	if (empty($testimonial_image['name'])) {
		$testimonial_image = $image_save;
	} else{
			$imagefile = explode(".", $_FILES["testimonial_image"]["name"]);
			$renamefile = round(microtime(true)) . '.' . end($imagefile);
		$image_upload = '../../images/';
		move_uploaded_file($_FILES['testimonial_image']['tmp_name'], $image_upload . 'testimonial_' . $renamefile);
		$testimonial_image = 'testimonial_' . $renamefile;
	}

$statment = $connect->prepare(
	'UPDATE testimonials SET testimonial_id = :testimonial_id, testimonial_name = :testimonial_name, testimonial_description = :testimonial_description, testimonial_job = :testimonial_job, testimonial_status = :testimonial_status, testimonial_lang = :testimonial_lang, testimonial_image = :testimonial_image WHERE testimonial_id = :testimonial_id'
	);

$statment->execute(array(

		':testimonial_id' => $testimonial_id,
		':testimonial_name' => $testimonial_name,
		':testimonial_description' => $testimonial_description,
		':testimonial_job' => $testimonial_job,
		':testimonial_status' => $testimonial_status,
		':testimonial_lang' => $testimonial_lang,
		':testimonial_image' => $testimonial_image
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_testimonial = id_testimonial($_GET['id']);

$testimonial = get_testimonial_per_id($connect, $id_testimonial);

    if (!$testimonial){
    header('Location: ./home.php');
}

$testimonial = $testimonial['0'];

$activelanguages = get_active_languages($connect);
require '../views/edit.testimonial.view.php';

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