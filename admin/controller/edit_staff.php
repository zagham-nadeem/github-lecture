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


$id = id_staff($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$staff_id = cleardata($_POST['staff_id']);
	$staff_facebook = cleardata($_POST['staff_facebook']);
	$staff_twitter = cleardata($_POST['staff_twitter']);
	$staff_linkedin = cleardata($_POST['staff_linkedin']);
	$staff_google = cleardata($_POST['staff_google']);
	$staff_status = cleardata($_POST['staff_status']);

	$imagefile = explode(".", $_FILES["staff_image"]["name"]);

	$image_save = $_POST['staff_image_save'];
	$staff_image = $_FILES['staff_image'];

	if (empty($staff_image['name'])) {
		$staff_image = $image_save;
	} else{
			$imagefile = explode(".", $_FILES["staff_image"]["name"]);
			$renamefile = round(microtime(true)) . '.' . end($imagefile);
		$image_upload = '../../images/';
		move_uploaded_file($_FILES['staff_image']['tmp_name'], $image_upload . 'staff_' . $renamefile);
		$staff_image = 'staff_' . $renamefile;
	}

$statment = $connect->prepare("UPDATE staffs SET staff_facebook = :staff_facebook, staff_twitter = :staff_twitter, staff_linkedin = :staff_linkedin, staff_google = :staff_google, staff_status = :staff_status, staff_image = :staff_image WHERE staff_id = :staff_id");

$statment->execute(array(

		':staff_facebook' => $staff_facebook,
		':staff_twitter' => $staff_twitter,
		':staff_linkedin' => $staff_linkedin,
		':staff_google' => $staff_google,
		':staff_status' => $staff_status,
		':staff_image' => $staff_image,
		':staff_id' => $staff_id

		));

	$tr_staff = cleardata($_POST['tr_staff']);
	$tr_id = cleardata($_POST['tr_id']);
	$tr_lang = cleardata($_POST['tr_lang']);
	$tr_name = $_POST['tr_name'];
	$tr_job = $_POST['tr_job'];

$sentence = $connect->prepare("UPDATE tr_staffs SET tr_name = :tr_name, tr_job = :tr_job WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_staff = :tr_staff");

$sentence->execute(array(

		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_staff' => $tr_staff,
		':tr_job' => $tr_job
		));


header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_staff = id_staff($_GET['id']);

$lang = lang($_GET['lang']);

$staff = get_staff_per_id_by_language($connect, $id_staff, $lang);

    if (!$staff){
    header('Location: ./home.php');
}

$staff = $staff['0'];

$languages = get_languages_by_staff($connect, $id_staff);
$activelanguages = get_languages_not_staffs($connect, $id_staff);

require '../views/edit.staff.view.php';

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