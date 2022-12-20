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


$menu_name = cleardata($_POST['menu_name']);
$menu_header = cleardata($_POST['menu_header']);
$menu_footer = cleardata($_POST['menu_footer']);
$menu_sidebar = cleardata($_POST['menu_sidebar']);
$menu_lang = cleardata($_POST['menu_lang']);


	$statment = $connect->prepare( "INSERT INTO menus (menu_id,menu_name,menu_header,menu_footer,menu_sidebar,menu_lang) VALUES (null, :menu_name, :menu_header, :menu_footer, :menu_sidebar, :menu_lang)");

	$statment->execute(array(
		':menu_name' => $menu_name,
		':menu_header' => $menu_header,
		':menu_footer' => $menu_footer,
		':menu_sidebar' => $menu_sidebar,
		':menu_lang' => $menu_lang

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