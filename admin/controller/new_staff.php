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
	
	$staff_facebook = cleardata($_POST['staff_facebook']);
	$staff_twitter = cleardata($_POST['staff_twitter']);
	$staff_linkedin = cleardata($_POST['staff_linkedin']);
	$staff_google = cleardata($_POST['staff_google']);

	$staff_image = $_FILES['staff_image']['tmp_name'];

	$imagefile = explode(".", $_FILES["staff_image"]["name"]);
	$renamefile = round(microtime(true)) . '.' . end($imagefile);

	$image_upload = '../../images/';

	move_uploaded_file($staff_image, $image_upload . 'staff_' . $renamefile);

	$statment = $connect->prepare(
		"INSERT INTO staffs (staff_id,staff_facebook, staff_twitter, staff_linkedin, staff_google, staff_image,staff_status) VALUES (null, :staff_facebook, :staff_twitter, :staff_linkedin, :staff_google, :staff_image, 1)"
		);

	$statment->execute(array(
		':staff_facebook' => $staff_facebook,
		':staff_twitter' => $staff_twitter,
		':staff_linkedin' => $staff_linkedin,
		':staff_google' => $staff_google,
		':staff_image' => 'staff_' . $renamefile

		));

$statment = $connect->prepare('SELECT @@identity AS id');
$statment->execute();
$row = $statment->fetch(PDO::FETCH_ASSOC);
$id = $row["id"];

$tr_lang = cleardata($_POST['tr_lang']);
$tr_name = cleardata($_POST['tr_name']);
$tr_job = cleardata($_POST['tr_job']);

$sentence = $connect->prepare("INSERT INTO tr_staffs (tr_id,tr_staff,tr_lang,tr_name,tr_job) VALUES (null, :tr_staff, :tr_lang, :tr_name, :tr_job)");

$sentence->execute(array(
		':tr_staff' => $id,
		':tr_lang' => $tr_lang,
		':tr_name' => $tr_name,
		':tr_job' => $tr_job

		));

	header('Location: ./staffs.php');

}

$languages = get_active_languages($connect);

require '../views/new.staff.view.php';

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