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


$id = id_post($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1){


$id_post = id_post($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_post($connect, $id_post, $lang);


if (!$exists)
{

$post = get_post_per_id_by_language($connect, $id_post, $oldlang);

$post = $post['0'];

$sentence = $connect->prepare( 'INSERT INTO tr_posts (tr_id,tr_post,tr_title,tr_lang,tr_slug,tr_content) VALUES (null, :tr_post, :tr_title, :tr_lang, :tr_slug, :tr_content)' );

$sentence->execute(array(
		':tr_post' => $id_post,
		':tr_title' => $post['tr_title']."-".$lang,
		':tr_lang' => $lang,
		':tr_slug' => $post['tr_slug']."-".$lang,
		':tr_content' => $post['tr_content']

		));


header('Location: ./edit_post.php?lang='.$lang.'&id='.$id_post);

}else{

header('Location: ./edit_post.php?lang='.$oldlang.'&id='.$id_post);

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