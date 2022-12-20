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


$id = id_extra($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


$id_extra = id_extra($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_extra($connect, $id_extra, $lang);


if (!$exists)
{

$extra = get_extra_per_id_by_language($connect, $id_extra, $oldlang);

$extra = $extra['0'];

$sentence = $connect->prepare( 'INSERT INTO tr_ptextras (tr_id,tr_extra,tr_lang,tr_name) VALUES (null, :tr_extra, :tr_lang, :tr_name)' );

$sentence->execute(array(
		':tr_extra' => $id_extra,
		':tr_lang' => $lang,
		':tr_name' => $extra['tr_name']."-".$lang

		));

header('Location: ./edit_extra.php?lang='.$lang.'&id='.$id_extra);

}else{

header('Location: ./edit_extra.php?lang='.$oldlang.'&id='.$id_extra);

}

}else{
	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';

}else{
	header('Location: ./login.php');		
}


?>