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


if ( empty($_GET["lang"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

$lang = lang($_GET['lang']);
$table = "translate_".$lang;
$exists = check_table($connect, $table);


if (!$exists)
{

try {

     $create ="CREATE TABLE $table LIKE translations";
     $connect->exec($create);

     $insert ="INSERT INTO $table SELECT * FROM translations";
     $connect->exec($insert);

     $update ="UPDATE languages SET language_translated = 1 WHERE language_code = '".$lang."'";
     $connect->exec($update);
     /*print("Created $table Table.\n");*/

} catch(PDOException $e) {
    echo $e->getMessage();
}

header('Location: ./languages.php');

}else{

header('Location: ./edit_translation.php?lang='.$lang);

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