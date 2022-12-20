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


$id_pc = id_pc($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$pc_id = cleardata($_POST['pc_id']);
	
	$imagefile = explode(".", $_FILES["pc_image"]["name"]);

	$image_save = $_POST['pc_image_save'];
	$pc_image = $_FILES['pc_image'];

	if (empty($pc_image['name'])) {
		$pc_image = $image_save;
	} else{
			$imagefile = explode(".", $_FILES["pc_image"]["name"]);
			$renamefile = round(microtime(true)) . '.' . end($imagefile);
		$image_upload = '../../images/';
		move_uploaded_file($_FILES['pc_image']['tmp_name'], $image_upload . 'pc_' . $renamefile);
		$pc_image = 'pc_' . $renamefile;
	}

$statment = $connect->prepare(
	"UPDATE preferred_choice SET pc_id = :pc_id, pc_image = :pc_image WHERE pc_id = :pc_id"
	);

$statment->execute(array(

		':pc_id' => $pc_id,
		':pc_image' => $pc_image
		));

$tr_id = cleardata($_POST['tr_id']);
$tr_pc = cleardata($_POST['tr_pc']);
$tr_lang = cleardata($_POST['tr_lang']);
$tr_title = cleardata($_POST['tr_title']);
$tr_content = $_POST['tr_content'];


$sentence = $connect->prepare( 'UPDATE tr_preferred_choice SET tr_title = :tr_title, tr_content = :tr_content WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_pc = :tr_pc');

$sentence->execute(array(
		':tr_id' => $tr_id,
		':tr_pc' => $tr_pc,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_content' => $tr_content

		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_pc = id_pc($_GET['id']);

$lang = lang($_GET['lang']);

$pc = get_pc_per_id_by_language($connect, $id_pc, $lang);

    if (!$pc){
    header('Location: ./home.php');
}

$pc = $pc['0'];

$languages = get_languages_by_pc($connect, $id_pc);
$activelanguages = get_languages_not_pc($connect, $id_pc);
$categories = get_all_categories($connect);

require '../views/edit.pc.view.php';

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