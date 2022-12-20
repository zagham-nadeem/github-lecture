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
	$slider_property = cleardata($_POST['slider_property']);
	$slider_visibility = cleardata($_POST['slider_visibility']);

	$slider_image = $_FILES['slider_image']['tmp_name'];

	$imagefile = explode(".", $_FILES["slider_image"]["name"]);
	$renamefile = round(microtime(true)) . '.' . end($imagefile);

	$image_upload = '../../images/';

	move_uploaded_file($slider_image, $image_upload . 'slider_' . $renamefile);

	$statment = $connect->prepare(
		'INSERT INTO sliders (slider_id,slider_property,slider_visibility,slider_image) VALUES (null, :slider_property, :slider_visibility, :slider_image)'
		);

	$statment->execute(array(
		':slider_property' => $slider_property,
		':slider_visibility' => $slider_visibility,
		':slider_image' => 'slider_' . $renamefile
		

		));

	header('Location: ./sliders.php');


}

$properties = get_all_properties($connect);

require '../views/new.slider.view.php';

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