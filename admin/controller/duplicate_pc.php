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


$id = id_pc($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1){


$id_pc = id_pc($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_pc($connect, $id_pc, $lang);


if (!$exists)
{

$pc = get_pc_per_id_by_language($connect, $id_pc, $oldlang);

$pc = $pc['0'];

$sentence = $connect->prepare( 'INSERT INTO tr_preferred_choice (tr_id,tr_pc,tr_title,tr_lang,tr_content) VALUES (null, :tr_pc, :tr_title, :tr_lang, :tr_content)' );

$sentence->execute(array(
		':tr_pc' => $id_pc,
		':tr_title' => $pc['tr_title']."-".$lang,
		':tr_lang' => $lang,
		':tr_content' => $pc['tr_content']

		));


header('Location: ./edit_pc.php?lang='.$lang.'&id='.$id_pc);

}else{

header('Location: ./edit_pc.php?lang='.$oldlang.'&id='.$id_pc);

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