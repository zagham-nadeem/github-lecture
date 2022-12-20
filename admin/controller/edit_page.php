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


$id_page = id_page($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$page_id = cleardata($_POST['page_id']);
	$page_visibility = cleardata($_POST['page_visibility']);
	$page_private = cleardata($_POST['page_private']);
	$page_footer = cleardata($_POST['page_footer']);
	$page_template = cleardata($_POST['page_template']);
	$page_ad_header = cleardata($_POST['page_ad_header']);
	$page_ad_footer = cleardata($_POST['page_ad_footer']);
	$page_ad_sidebar = cleardata($_POST['page_ad_sidebar']);

$statment = $connect->prepare(
	"UPDATE pages SET page_id = :page_id, page_visibility = :page_visibility, page_private = :page_private, page_footer = :page_footer, page_template = :page_template, page_ad_header = :page_ad_header, page_ad_footer = :page_ad_footer, page_ad_sidebar = :page_ad_sidebar WHERE page_id = :page_id"
	);

$statment->execute(array(

		':page_id' => $page_id,
		':page_visibility' => $page_visibility,
		':page_private' => $page_private,
		':page_footer' => $page_footer,
		':page_template' => $page_template,
		':page_ad_header' => $page_ad_header,
		':page_ad_footer' => $page_ad_footer,
		':page_ad_sidebar' => $page_ad_sidebar
		));

$tr_id = cleardata($_POST['tr_id']);
$tr_page = cleardata($_POST['tr_page']);
$tr_lang = cleardata($_POST['tr_lang']);
$tr_title = cleardata($_POST['tr_title']);
$tr_slug = cleardata($_POST['tr_slug']);
$tr_content = $_POST['tr_content'];
$tr_seotitle = cleardata($_POST['tr_seotitle']);
$tr_seodescription = cleardata($_POST['tr_seodescription']);

$tr_slug = cleardata($_POST['tr_slug']);

if (empty($tr_slug)) {
	$slug = $_POST['tr_slug_save'];
}else{

	$converted_slug = convertSlug($_POST['tr_slug']);
	$exists = get_page_slug($connect, $converted_slug);

	if ($exists > 0)
	{
		$new_number = $exists + 1;
		$slug = $converted_slug."-".$new_number;

	}else{

		$slug = $converted_slug;
	}

}

$sentence = $connect->prepare("UPDATE tr_pages SET tr_title = :tr_title, tr_content = :tr_content, tr_seotitle = :tr_seotitle, tr_seodescription = :tr_seodescription, tr_slug = :tr_slug WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_page = :tr_page");

$sentence->execute(array(
		':tr_id' => $tr_id,
		':tr_page' => $tr_page,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_slug' => $slug,
		':tr_content' => $tr_content,
		':tr_seotitle' => $tr_seotitle,
		':tr_seodescription' => $tr_seodescription
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);


}else{

$id_page = id_page($_GET['id']);

$lang = lang($_GET['lang']);

$page = get_page_per_id_by_language($connect, $id_page, $lang);

    if (!$page){
    header('Location: ./home.php');
}

$page = $page['0'];

$languages = get_languages_by_page($connect, $id_page);
$activelanguages = get_languages_not_page($connect, $id_page);

require '../views/edit.page.view.php';

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