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

$connect = connect($database);
if(!$connect){
header('Location: ./error.php');
} 

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$ad_title = cleardata($_POST['ad_title']);
$ad_position = cleardata($_POST['ad_position']);
$ad_lang = cleardata($_POST['ad_lang']);

$statment = $connect->prepare( "INSERT INTO ads (ad_id,ad_title,ad_position,ad_lang) VALUES (null, :ad_title, :ad_position, :ad_lang)");

$statment->execute(array(
':ad_title' => $ad_title,
':ad_position' => $ad_position,
':ad_lang' => $ad_lang
));
}

}elseif($check_access['user_role'] == 2){

	require '../views/denied.view.php';
	
}else{
	
	header('Location:'.SITE_URL);
}


}else {
header('Location: ./login.php');		
}


?>