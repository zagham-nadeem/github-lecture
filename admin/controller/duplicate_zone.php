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


$id = id_zone($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){

$id_zone = id_zone($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_zone($connect, $id_zone, $lang);


if (!$exists)
{

$zone = get_zone_per_id_by_language($connect, $id_zone, $oldlang);

$zone = $zone['0'];

$slug = convertSlug($zone['tr_name']);

$newslug = $slug."-".$lang;

$sentence = $connect->prepare( 'INSERT INTO tr_ptzones (tr_id,tr_zone,tr_lang,tr_slug,tr_name) VALUES (null, :tr_zone, :tr_lang, :tr_slug, :tr_name)' );

$sentence->execute(array(
		':tr_zone' => $id_zone,
		':tr_lang' => $lang,
		':tr_slug' => $newslug,
		':tr_name' => $zone['tr_name']."-".$lang

		));

header('Location: ./edit_zone.php?lang='.$lang.'&id='.$id_zone);

}else{

header('Location: ./edit_zone.php?lang='.$oldlang.'&id='.$id_zone);

}


}else{

	header('Location:'.SITE_URL);

}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>