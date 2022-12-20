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


	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$pt_city_id = cleardata($_POST['pt_city_id']);
		$pt_city_featured = cleardata($_POST['pt_city_featured']);

		$imagefile = explode(".", $_FILES["pt_city_image"]["name"]);

		$image_save = $_POST['pt_city_image_save'];
		$pt_city_image = $_FILES['pt_city_image'];

		if (empty($pt_city_image['name'])) {
			$pt_city_image = $image_save;
		} else{
			$imagefile = explode(".", $_FILES["pt_city_image"]["name"]);
			$renamefile = round(microtime(true)) . '.' . end($imagefile);
			$image_upload = '../../images/';
			move_uploaded_file($_FILES['pt_city_image']['tmp_name'], $image_upload . 'city_' . $renamefile);
			$pt_city_image = 'city_' . $renamefile;
		}


		$statment = $connect->prepare("UPDATE pt_cities SET pt_city_id = :pt_city_id, pt_city_featured = :pt_city_featured, pt_city_image = :pt_city_image WHERE pt_city_id = :pt_city_id");

		$statment->execute(array(

			':pt_city_id' => $pt_city_id,
			':pt_city_featured' => $pt_city_featured,
			':pt_city_image' => $pt_city_image
		));

		$tr_name = cleardata($_POST['tr_name']);
		$tr_city = cleardata($_POST['tr_city']);
		$tr_id = cleardata($_POST['tr_id']);
		$tr_lang = cleardata($_POST['tr_lang']);
		$tr_slug = cleardata($_POST['tr_slug']);

		$slug = convertSlug($_POST['tr_slug']);

		$sentence = $connect->prepare("UPDATE tr_ptcities SET tr_slug = :tr_slug, tr_name = :tr_name WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_city = :tr_city");

		$sentence->execute(array(

			':tr_slug' => $slug,
			':tr_name' => $tr_name,
			':tr_id' => $tr_id,
			':tr_lang' => $tr_lang,
			':tr_city' => $tr_city

		));

		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}else{

		$id_city = id_city($_GET['id']);

		$lang = lang($_GET['lang']);

		$city = get_city_per_id_by_language($connect, $id_city, $lang);

		if (!$city){
			header('Location: ./home.php');
		}

		$city = $city['0'];

		$languages = get_languages_by_city($connect, $id_city);
		$activelanguages = get_languages_not_city($connect, $id_city);

		require '../views/edit.city.view.php';

	}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';

} else {
header('Location: ./login.php');		
}


?>