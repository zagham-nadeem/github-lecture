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


$id = id_type($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){

$id_type = id_type($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_type($connect, $id_type, $lang);


if (!$exists)
{

$type = get_type_per_id_by_language($connect, $id_type, $oldlang);

$type = $type['0'];

$slug = convertSlug($type['tr_name']);

$newslug = $slug."-".$lang;

$sentence = $connect->prepare( 'INSERT INTO tr_pttypes (tr_id,tr_type,tr_lang,tr_slug,tr_name) VALUES (null, :tr_type, :tr_lang, :tr_slug, :tr_name)' );

$sentence->execute(array(
		':tr_type' => $id_type,
		':tr_lang' => $lang,
		':tr_slug' => $newslug,
		':tr_name' => $type['tr_name']."-".$lang

		));

header('Location: ./edit_type.php?lang='.$lang.'&id='.$id_type);

}else{

header('Location: ./edit_type.php?lang='.$oldlang.'&id='.$id_type);

}


}else{

	header('Location:'.SITE_URL);

}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>