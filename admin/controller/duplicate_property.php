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


$id = id_property($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){

$id_property = id_property($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_property($connect, $id_property, $lang);


if (!$exists)
{

$property = get_property_per_id_by_language($connect, $id_property, $oldlang);

$property = $property['0'];

$sentence = $connect->prepare("INSERT INTO tr_properties (tr_id,tr_property,tr_title,tr_lang,tr_slug,tr_description, tr_label) VALUES (null, :tr_property, :tr_title, :tr_lang, :tr_slug, :tr_description, :tr_label)");

$sentence->execute(array(
		':tr_property' => $id_property,
		':tr_title' => $property['tr_title']."-".$lang,
		':tr_lang' => $lang,
		':tr_slug' => $property['tr_slug']."-".$lang,
		':tr_description' => $property['tr_description'],
		':tr_label' => $property['tr_label']

		));


header('Location: ./edit_property.php?lang='.$lang.'&id='.$id_property);

}else{

header('Location: ./edit_property.php?lang='.$oldlang.'&id='.$id_property);

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
} else {
		header('Location: ./login.php');		
		}


?>