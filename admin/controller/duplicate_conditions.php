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


$id = id_conditions($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_conditions = id_conditions($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_conditions($connect, $id_conditions, $lang);


if (!$exists)
{

$conditions = get_conditions_per_id_by_language($connect, $id_conditions, $oldlang);

$conditions = $conditions['0'];

$slug = convertSlug($conditions['tr_name']);

$newslug = $slug."-".$lang;

$sentence = $connect->prepare( 'INSERT INTO tr_ptconditions (tr_id,tr_conditions,tr_lang,tr_slug,tr_name) VALUES (null, :tr_conditions, :tr_lang, :tr_slug, :tr_name)' );

$sentence->execute(array(
		':tr_conditions' => $id_conditions,
		':tr_lang' => $lang,
		':tr_slug' => $newslug,
		':tr_name' => $conditions['tr_name']."-".$lang

		));

header('Location: ./edit_conditions.php?lang='.$lang.'&id='.$id_conditions);

}else{

header('Location: ./edit_conditions.php?lang='.$oldlang.'&id='.$id_conditions);

}

}else{

	header('Location:'.SITE_URL);

}

require '../views/footer.view.php';

} else {
	header('Location: ./login.php');		
}


?>