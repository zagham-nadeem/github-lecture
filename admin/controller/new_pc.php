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

$pc_image = $_FILES['pc_image']['tmp_name'];

$imagefile = explode(".", $_FILES["pc_image"]["name"]);
$renamefile = round(microtime(true)) . '.' . end($imagefile);

$image_upload = '../../images/';

move_uploaded_file($pc_image, $image_upload . 'pc_' . $renamefile);

	$statment = $connect->prepare(
		"INSERT INTO preferred_choice (pc_id, pc_image) VALUES (null, :pc_image)");

	$statment->execute(array(
		':pc_image' => 'pc_' . $renamefile
		));

$statment = $connect->prepare('SELECT @@identity AS id');
$statment->execute();
$row = $statment->fetch(PDO::FETCH_ASSOC);
$id = $row["id"];

$tr_lang = cleardata($_POST['tr_lang']);
$tr_title = cleardata($_POST['tr_title']);
$tr_content = $_POST['tr_content'];

$sentence = $connect->prepare("INSERT INTO tr_preferred_choice (tr_id,tr_pc,tr_title,tr_lang,tr_content) VALUES (null, :tr_pc, :tr_title, :tr_lang, :tr_content)");

$sentence->execute(array(
		':tr_pc' => $id,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_content' => $tr_content
		));

	header('Location: ./preferred_choice.php');

}

$categories = get_all_categories($connect);
$languages = get_active_languages($connect);

require '../views/new.pc.view.php';

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