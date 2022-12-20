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


$id = id_staff($_GET['id']);

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

$id_staff = id_staff($_GET['id']);
$oldlang = lang($_GET['lang']);
$lang = lang($_GET['to']);

$exists = check_staff($connect, $id_staff, $lang);


if (!$exists)
{

$staff = get_staff_per_id_by_language($connect, $id_staff, $oldlang);

$staff = $staff['0'];

$sentence = $connect->prepare( "INSERT INTO tr_staffs (tr_id,tr_staff,tr_lang,tr_job,tr_name) VALUES (null, :tr_staff, :tr_lang, :tr_job, :tr_name)");

$sentence->execute(array(
		':tr_staff' => $id_staff,
		':tr_lang' => $lang,
		':tr_job' => $staff['tr_job'],
		':tr_name' => $staff['tr_name']

		));

header('Location: ./edit_staff.php?lang='.$lang.'&id='.$id_staff);

}else{

header('Location: ./edit_staff.php?lang='.$oldlang.'&id='.$id_staff);

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