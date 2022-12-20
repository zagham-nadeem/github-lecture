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
require '../../classes/fileuploader.php';
require '../views/header.view.php';

$connect = connect($database);
if(!$connect){
header ('Location: ./error.php');
}

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
header('Location: ./home.php');
}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$pt_id = cleardata($_POST['pt_id']);
	$pt_beds = cleardata($_POST['pt_beds']);
	$pt_baths = cleardata($_POST['pt_baths']);
	$pt_garages = cleardata($_POST['pt_garages']);
	$pt_size = cleardata($_POST['pt_size']);
	$pt_type = cleardata($_POST['pt_type']);
	$pt_price = cleardata($_POST['pt_price']);
	$pt_rating = cleardata($_POST['pt_rating']);
	$pt_latitude = cleardata($_POST['pt_latitude']);
	$pt_longitude = cleardata($_POST['pt_longitude']);
	$pt_city = cleardata($_POST['pt_city']);
	$pt_zone = cleardata($_POST['pt_zone']);
	$pt_agent = cleardata($_POST['pt_agent']);
	$pt_status = cleardata($_POST['pt_status']);
	$pt_reference = cleardata($_POST['pt_reference']);
	$pt_featured = cleardata($_POST['pt_featured']);
	$pt_direction = $_POST['pt_direction'];
	$pt_visibility = cleardata($_POST['pt_visibility']);
	$pt_floor = cleardata($_POST['pt_floor']);
	$pt_conditions = cleardata($_POST['pt_conditions']);
	$pt_sold = cleardata($_POST['pt_sold']);
	$pt_oldprice = cleardata($_POST['pt_oldprice']);
	$pt_offer = cleardata($_POST['pt_offer']);
	$pt_video = cleardata($_POST['pt_video']);

	$imagefile = explode(".", $_FILES["pt_image"]["name"]);

	$image_save = $_POST['pt_image_save'];
	$pt_image = $_FILES['pt_image'];

	if (empty($pt_image['name'])) {
		$pt_image = $image_save;
	} else{
		$imagefile = explode(".", $_FILES["pt_image"]["name"]);
		$renamefile = round(microtime(true)) . '.' . end($imagefile);
		$image_upload = '../../images/';
		move_uploaded_file($_FILES['pt_image']['tmp_name'], $image_upload . 'property_' . $renamefile);
		$pt_image = 'property_' . $renamefile;
	}

	$statment = $connect->prepare(
		"UPDATE properties SET pt_id = :pt_id, pt_beds = :pt_beds, pt_baths = :pt_baths, pt_garages = :pt_garages, pt_size = :pt_size, pt_type = :pt_type, pt_price = :pt_price, pt_rating = :pt_rating, pt_latitude = :pt_latitude, pt_longitude = :pt_longitude, pt_city = :pt_city, pt_zone = :pt_zone, pt_agent = :pt_agent, pt_status = :pt_status, pt_reference = :pt_reference, pt_featured = :pt_featured, pt_direction = :pt_direction, pt_visibility = :pt_visibility, pt_floor = :pt_floor, pt_conditions = :pt_conditions, pt_sold = :pt_sold, pt_oldprice = :pt_oldprice, pt_offer = :pt_offer, pt_video = :pt_video, pt_updated = CURRENT_TIME, pt_image = :pt_image WHERE pt_id = :pt_id"
	);

	$statment->execute(array(

		':pt_id' => $pt_id,
		':pt_beds' => $pt_beds,
		':pt_baths' => $pt_baths,
		':pt_garages' => $pt_garages,
		':pt_size' => $pt_size,
		':pt_type' => $pt_type,
		':pt_price' => $pt_price,
		':pt_rating' => $pt_rating,
		':pt_latitude' => $pt_latitude,
		':pt_longitude' => $pt_longitude,
		':pt_city' => $pt_city,
		':pt_zone' => $pt_zone,
		':pt_agent' => $pt_agent,
		':pt_status' => $pt_status,
		':pt_reference' => $pt_reference,
		':pt_featured' => $pt_featured,
		':pt_direction' => $pt_direction,
		':pt_visibility' => $pt_visibility,
		':pt_floor' => $pt_floor,
		':pt_conditions' => $pt_conditions,
		':pt_sold' => $pt_sold,
		':pt_oldprice' => $pt_oldprice,
		':pt_offer' => $pt_offer,
		':pt_video' => $pt_video,
		':pt_image' => $pt_image

	));

	$tr_id = cleardata($_POST['tr_id']);
	$tr_property = cleardata($_POST['tr_property']);
	$tr_lang = cleardata($_POST['tr_lang']);
	$tr_title = cleardata($_POST['tr_title']);
	$tr_description = $_POST['tr_description'];
	$tr_label = cleardata($_POST['tr_label']);

	$tr_slug = cleardata($_POST['tr_slug']);

	if (empty($tr_slug)) {
		$slug = $_POST['tr_slug_save'];
	}else{

		$converted_slug = convertSlug($_POST['tr_slug']);
		$exists = get_property_slug($connect, $converted_slug);

		if ($exists > 0)
		{
			$new_number = $exists + 1;
			$slug = $converted_slug."-".$new_number;

		}else{

			$slug = $converted_slug;
		}

	}

	$sentence = $connect->prepare( "UPDATE tr_properties SET tr_title = :tr_title, tr_description = :tr_description, tr_label = :tr_label, tr_slug = :tr_slug WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_property = :tr_property");

	$sentence->execute(array(
		':tr_id' => $tr_id,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_description' => $tr_description,
		':tr_label' => $tr_label,
		':tr_slug' => $slug,
		':tr_property' => $tr_property
	));

	$extras = $_POST['pe_extra'];

	$statment = $connect->prepare("DELETE FROM properties_extras WHERE pe_property = :pt_id");
	$statment->bindParam(':pt_id', $pt_id);
	$statment->execute();

	$statment = $connect->prepare( "INSERT INTO properties_extras (pe_extra,pe_property) VALUES (:pe_extra, :pe_property)");
	$statment->bindParam(':pe_extra', $idextra);
	$statment->bindParam(':pe_property', $pt_id);

	foreach ($extras as $option_value){
		$idextra = $option_value;
		$statment->execute();
	}

	$FileUploader = new FileUploader('files', array(
		'uploadDir' => '../../images/',
		'title' => 'auto',
		'maxSize' => 4,
		'fileMaxSize' => 4,
		'extensions' => ['jpg', 'jpeg', 'png'],
		'replace' => true,
	));

// call to upload the files
	$data = $FileUploader->upload();

// if uploaded and success
	if($data['isSuccess'] && count($data['files']) > 0) {
// get uploaded files
		$uploadedFiles = $data['files'];

		$pt_id = cleardata($_POST['pt_id']);


		$statment = $connect->prepare(
			"INSERT INTO properties_gallery (pg_id,pg_property,pg_name) VALUES (null, :pg_property, :pg_name)");

		foreach ($uploadedFiles as $key => $value)
		{
			$statment->execute(array(
				':pg_property' => $pt_id,
				':pg_name' => $value['name']
			));
		}

	}

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	$id_property = id_property($_GET['id']);

	$lang = lang($_GET['lang']);

	$property = get_property_per_id_by_language($connect, $id_property, $lang);

	if (!$property){
		header('Location: ./home.php');
	}

	$property = $property['0'];

	$lang = lang($_GET['lang']);

	$languages = get_languages_by_property($connect, $id_property);
	$activelanguages = get_languages_not_property($connect, $id_property);
	$propertyextras = get_extras_by_property($connect, $id_property);
	$extras = get_extras_by_not_property($connect, $id_property);
	$status = get_all_status($connect);
	$types = get_all_types($connect);
	$cities = get_all_cities($connect);
	$zones = get_all_zones_by_city($connect, $property['pt_city']);
	$conditions = get_all_conditions($connect);
	$users = get_active_users($connect);
	$gallery = get_gallery($connect, $id_property);
	$siteSettings = getSettings($connect);

	require '../views/edit.property.view.php';

}

}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';

} else {
header('Location: ./login.php');		
}


?>