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

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$testimonial_name = cleardata($_POST['testimonial_name']);
$testimonial_description = cleardata($_POST['testimonial_description']);
$testimonial_job = cleardata($_POST['testimonial_job']);
$testimonial_status = cleardata($_POST['testimonial_status']);
$testimonial_lang = cleardata($_POST['testimonial_lang']);

	$testimonial_image = $_FILES['testimonial_image']['tmp_name'];

	$imagefile = explode(".", $_FILES["testimonial_image"]["name"]);
	$renamefile = round(microtime(true)) . '.' . end($imagefile);

	$image_upload = '../../images/';

	move_uploaded_file($testimonial_image, $image_upload . 'testimonial_' . $renamefile);

$statment = $connect->prepare("INSERT INTO testimonials (testimonial_id, testimonial_name, testimonial_description, testimonial_job, testimonial_image, testimonial_status, testimonial_lang) VALUES (null, :testimonial_name, :testimonial_description, :testimonial_job, :testimonial_image, :testimonial_status, :testimonial_lang)");

$statment->execute(array(
		':testimonial_name' => $testimonial_name,
		':testimonial_description' => $testimonial_description,
		':testimonial_job' => $testimonial_job,
		':testimonial_status' => $testimonial_status,
		':testimonial_lang' => $testimonial_lang,
		':testimonial_image' => 'testimonial_' . $renamefile
));

	header('Location: ./testimonials.php');

}

$activelanguages = get_active_languages($connect);
require '../views/new.testimonial.view.php';

}elseif($check_access['user_role'] == 2){

	require '../views/denied.view.php';
	
}else{
	
	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
}else {
		header('Location: ./login.php');		
		}


?>