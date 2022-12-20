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


$id = id_city($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){

$id_city = id_city($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_city($connect, $id_city, $lang);


if (!$exists)
{

$city = get_city_per_id_by_language($connect, $id_city, $oldlang);

$city = $city['0'];

$slug = convertSlug($city['tr_name']);

$newslug = $slug."-".$lang;

$sentence = $connect->prepare( 'INSERT INTO tr_ptcities (tr_id,tr_city,tr_lang,tr_slug,tr_name) VALUES (null, :tr_city, :tr_lang, :tr_slug, :tr_name)' );

$sentence->execute(array(
		':tr_city' => $id_city,
		':tr_lang' => $lang,
		':tr_slug' => $newslug,
		':tr_name' => $city['tr_name']."-".$lang

		));

header('Location: ./edit_city.php?lang='.$lang.'&id='.$id_city);

}else{

header('Location: ./edit_city.php?lang='.$oldlang.'&id='.$id_city);

}


}else{

	header('Location:'.SITE_URL);

}

require '../views/footer.view.php';

} else {
	header('Location: ./login.php');		
}


?>