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


$id = id_category($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$category_id = cleardata($_POST['category_id']);


$statment = $connect->prepare(
	'UPDATE categories SET category_id = :category_id WHERE category_id = :category_id'
	);

$statment->execute(array(

		':category_id' => $category_id

		));

	$tr_name = cleardata($_POST['tr_name']);
	$tr_slug = $_POST['tr_slug'];
	$tr_category = cleardata($_POST['tr_category']);
	$tr_id = cleardata($_POST['tr_id']);
	$tr_lang = cleardata($_POST['tr_lang']);

	$slug = convertSlug($tr_slug);

	$exists = get_category_slug($connect, $slug); 

if ($exists > 0)
{

    $new_number = $exists + 1;
    $newslug = $slug."-".$new_number;

$sentence = $connect->prepare( 'UPDATE tr_categories SET tr_slug = :tr_slug, tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_category = :tr_category');

$sentence->execute(array(

		':tr_slug' => $newslug,
		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_category' => $tr_category
		));

}else{

$sentence = $connect->prepare( 'UPDATE tr_categories SET tr_slug = :tr_slug, tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_category = :tr_category');

$sentence->execute(array(

		':tr_slug' => $slug,
		':tr_name' => $tr_name,
		':tr_id' => $tr_id,
		':tr_lang' => $tr_lang,
		':tr_category' => $tr_category

		));

}

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_category = id_category($_GET['id']);

$lang = lang($_GET['lang']);

$category = get_category_per_id_by_language($connect, $id_category, $lang);

    if (!$category){
    header('Location: ./home.php');
}

$category = $category['0'];

$languages = get_languages_by_category($connect, $id_category);
$activelanguages = get_languages_not_category($connect, $id_category);

require '../views/edit.category.view.php';

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