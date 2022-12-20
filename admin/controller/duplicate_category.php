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

$id_category = id_category($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_category($connect, $id_category, $lang);

if (!$exists)
{

$type = get_category_per_id_by_language($connect, $id_category, $oldlang);

$type = $type['0'];

$slug = convertSlug($type['tr_name']);

$newslug = $slug."-".$lang;

$sentence = $connect->prepare('INSERT INTO tr_categories (tr_id,tr_category,tr_lang,tr_slug,tr_name) VALUES (null, :tr_category, :tr_lang, :tr_slug, :tr_name)');

$sentence->execute(array(
		':tr_category' => $id_category,
		':tr_lang' => $lang,
		':tr_slug' => $newslug,
		':tr_name' => $type['tr_name']."-".$lang

		));

header('Location: ./edit_category.php?lang='.$lang.'&id='.$id_category);

}else{

header('Location: ./edit_category.php?lang='.$oldlang.'&id='.$id_category);

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