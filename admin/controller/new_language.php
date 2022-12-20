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

	$connect = connect($database);
	if(!$connect){
		header('Location: ./error.php');
	} 

	$check_access = check_access($connect);

	if ($check_access['user_role'] == 1){

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$language_name = cleardata($_POST['language_name']);
			$language_code = cleardata($_POST['language_code']);
			$language_type = cleardata($_POST['language_type']);

			$statment = $connect->prepare('INSERT INTO languages (language_id,language_name,language_code,language_type) VALUES (null, :language_name, :language_code, :language_type)');

			$statment->execute(array(
				':language_name' => $language_name,
				':language_code' => $language_code,
				':language_type' => $language_type
			));
		}

	}elseif($check_access['user_role'] == 2){

		require '../views/denied.view.php';

	}else{

		header('Location:'.SITE_URL);
	}


}else {
	header('Location: ./login.php');		
}


?>