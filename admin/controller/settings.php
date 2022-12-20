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

$languages = get_active_languages($connect);

$settings = get_settings($connect);

$propertiespages = get_pages_by_template($connect, $settings['st_language'], 'properties');
$searchpages = get_pages_by_template($connect, $settings['st_language'], 'search');
$contactpages = get_pages_by_template($connect, $settings['st_language'], 'contact');
$blogpages = get_pages_by_template($connect, $settings['st_language'], 'blog');
$privacypages = get_pages_by_template($connect, $settings['st_language'], 'privacy');
$termspages = get_pages_by_template($connect, $settings['st_language'], 'terms');

require '../views/settings.view.php'; 

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