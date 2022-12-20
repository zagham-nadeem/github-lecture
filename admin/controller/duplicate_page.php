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


$id = id_page($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1){


$id_page = id_page($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_page($connect, $id_page, $lang);


if (!$exists)
{

$page = get_page_per_id_by_language($connect, $id_page, $oldlang);

$page = $page['0'];

$sentence = $connect->prepare( 'INSERT INTO tr_pages (tr_id,tr_page,tr_title,tr_lang,tr_slug,tr_content) VALUES (null, :tr_page, :tr_title, :tr_lang, :tr_slug, :tr_content)' );

$sentence->execute(array(
		':tr_page' => $id_page,
		':tr_title' => $page['tr_title']."-".$lang,
		':tr_lang' => $lang,
		':tr_slug' => $page['tr_slug']."-".$lang,
		':tr_content' => $page['tr_content']

		));


header('Location: ./edit_page.php?lang='.$lang.'&id='.$id_page);

}else{

header('Location: ./edit_page.php?lang='.$oldlang.'&id='.$id_page);

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