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

$id_email = id_email($_GET['id']);
    
if(empty($id_email)){
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

$languages = get_languages_code($connect);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$email_id = cleardata($_POST['email_id']);
$email_fromname = cleardata($_POST['email_fromname']);
$email_plaintext = cleardata($_POST['email_plaintext']);
$email_disabled = cleardata($_POST['email_disabled']);

$sentence = $connect->prepare("UPDATE emailtemplates SET email_fromname = :email_fromname, email_plaintext = :email_plaintext, email_disabled = :email_disabled, email_content = :email_content WHERE email_id = :email_id");

$array = array();

if($email_id['email_id'] == 4 || $email_id['email_id'] == 5){

	    $array[] = array(
	    "message" => $_POST["message"],
	    "subject" => $_POST["subject"],
	    );

}else{

	foreach ($languages as $language) {

	    $lang = $language['language_code'];

	    $array[] = array(
	    "lang" => $lang,
	    "message" => $_POST["message_".$lang],
	    "subject" => $_POST["subject_".$lang],
	    );
	}

}

$data = json_encode($array);

$sentence->execute(array(
		':email_id' => $email_id,
		':email_fromname' => $email_fromname,
		':email_plaintext' => $email_plaintext,
		':email_disabled' => $email_disabled,
		':email_content' => $data
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

} else{

$etemplate = get_etemplate_by_id($connect, $id_email);
    
    if (!$etemplate){
    header('Location: ./home.php');
}

$etemplate_content = $etemplate['email_content'];

$contents = json_decode($etemplate_content,true);

if (empty($contents)) {
	$contents = array();
}

}

$languages = get_languages_code($connect);

require '../views/edit.etemplate.view.php';

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