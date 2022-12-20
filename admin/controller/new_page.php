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

	$page_visibility = cleardata($_POST['page_visibility']);
	$page_private = cleardata($_POST['page_private']);
	$page_footer = cleardata($_POST['page_footer']);
	$page_template = cleardata($_POST['page_template']);
	$page_ad_header = cleardata($_POST['page_ad_header']);
	$page_ad_footer = cleardata($_POST['page_ad_footer']);
	$page_ad_sidebar = cleardata($_POST['page_ad_sidebar']);

	$statment = $connect->prepare("INSERT INTO pages (page_id,page_visibility,page_private,page_footer,page_template,page_ad_header,page_ad_footer,page_ad_sidebar) VALUES (null, :page_visibility, :page_private, :page_footer, :page_template, :page_ad_header, :page_ad_footer, :page_ad_sidebar)");

	$statment->execute(array(
		':page_visibility' => $page_visibility,
		':page_private' => $page_private,
		':page_footer' => $page_footer,
		':page_template' => $page_template,
		':page_ad_header' => $page_ad_header,
		':page_ad_footer' => $page_ad_footer,
		':page_ad_sidebar' => $page_ad_sidebar
		));

$statment = $connect->prepare('SELECT @@identity AS id');
$statment->execute();
$row = $statment->fetch(PDO::FETCH_ASSOC);
$id = $row["id"];

$tr_lang = cleardata($_POST['tr_lang']);
$tr_title = cleardata($_POST['tr_title']);
$tr_content = $_POST['tr_content'];
$tr_seotitle = cleardata($_POST['tr_seotitle']);
$tr_seodescription = cleardata($_POST['tr_seodescription']);

$converted_slug = convertSlug($_POST['tr_title']);
$exists = get_page_slug($connect, $converted_slug);

if ($exists > 0)
{
	$new_number = $exists + 1;
	$slug = $converted_slug."-".$new_number;

}else{

	$slug = $converted_slug;
}

$sentence = $connect->prepare("INSERT INTO tr_pages (tr_id,tr_page,tr_title,tr_lang,tr_slug,tr_content,tr_seotitle,tr_seodescription) VALUES (null, :tr_page, :tr_title, :tr_lang, :tr_slug, :tr_content, :tr_seotitle, :tr_seodescription)");

$sentence->execute(array(
		':tr_page' => $id,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_slug' => $slug,
		':tr_content' => $tr_content,
		':tr_seotitle' => $tr_seotitle,
		':tr_seodescription' => $tr_seodescription
		));

	header('Location: ./pages.php');

}

$languages = get_active_languages($connect);

require '../views/new.page.view.php';

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