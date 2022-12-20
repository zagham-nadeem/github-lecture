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


$id = id_status($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_status = id_status($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_status($connect, $id_status, $lang);


if (!$exists)
{

$status = get_status_per_id_by_language($connect, $id_status, $oldlang);

$status = $status['0'];

$slug = convertSlug($status['tr_name']);

$newslug = $slug."-".$lang;

$sentence = $connect->prepare( 'INSERT INTO tr_ptstatus (tr_id,tr_status,tr_lang,tr_slug,tr_name) VALUES (null, :tr_status, :tr_lang, :tr_slug, :tr_name)' );

$sentence->execute(array(
		':tr_status' => $id_status,
		':tr_lang' => $lang,
		':tr_slug' => $newslug,
		':tr_name' => $status['tr_name']."-".$lang

		));

header('Location: ./edit_status.php?lang='.$lang.'&id='.$id_status);

}else{

header('Location: ./edit_status.php?lang='.$oldlang.'&id='.$id_status);

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>