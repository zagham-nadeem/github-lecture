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
	header('Location: ./error.php');
	}

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
	$pt_reference = cleardata($_POST['pt_reference']);
	$pt_featured = cleardata($_POST['pt_featured']);
	$pt_direction = $_POST['pt_direction'];
	$pt_status = cleardata($_POST['pt_status']);
	$pt_floor = cleardata($_POST['pt_floor']);
	$pt_conditions = cleardata($_POST['pt_conditions']);
	$pt_video = cleardata($_POST['pt_video']);
	$pt_oldprice = cleardata($_POST['pt_oldprice']);
	$pt_offer = cleardata($_POST['pt_offer']);
	$pt_video = cleardata($_POST['pt_video']);
	$pt_image = $_FILES['pt_image']['tmp_name'];

	$imagefile = explode(".", $_FILES["pt_image"]["name"]);
	$renamefile = round(microtime(true)) . '.' . end($imagefile);

	$image_upload = '../../images/';

	move_uploaded_file($pt_image, $image_upload . 'property_' . $renamefile);

	$statment = $connect->prepare(
		"INSERT INTO properties (pt_id,pt_beds,pt_baths,pt_garages,pt_size,pt_type,pt_price,pt_rating,pt_latitude,pt_longitude,pt_city,pt_zone,pt_agent,pt_reference,pt_featured,pt_direction,pt_status,pt_floor, pt_conditions, pt_video, pt_oldprice, pt_offer, pt_date,pt_image) VALUES (null, :pt_beds, :pt_baths, :pt_garages, :pt_size, :pt_type, :pt_price, :pt_rating, :pt_latitude, :pt_longitude, :pt_city, :pt_zone, :pt_agent, :pt_reference, :pt_featured, :pt_direction, :pt_status, :pt_floor, :pt_conditions, :pt_video, :pt_oldprice, :pt_offer, CURRENT_TIMESTAMP, :pt_image)"
		);

	$statment->execute(array(
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
		':pt_reference' => $pt_reference,
		':pt_featured' => $pt_featured,
		':pt_direction' => $pt_direction,
		':pt_status' => $pt_status,
		':pt_floor' => $pt_floor,
		':pt_conditions' => $pt_conditions,
		':pt_video' => $pt_video,
		':pt_oldprice' => $pt_oldprice,
		':pt_offer' => $pt_offer,
		':pt_image' => 'property_' . $renamefile

		));

$statment = $connect->prepare('SELECT @@identity AS id');
$statment->execute();
$row = $statment->fetch(PDO::FETCH_ASSOC);
$id = $row["id"];

$tr_lang = cleardata($_POST['tr_lang']);
$tr_title = cleardata($_POST['tr_title']);
$tr_description = $_POST['tr_description'];
$tr_label = $_POST['tr_label'];

$converted_slug = convertSlug($_POST['tr_title']);
$exists = get_property_slug($connect, $converted_slug);

if ($exists > 0)
{
	$new_number = $exists + 1;
	$slug = $converted_slug."-".$new_number;

}else{

	$slug = $converted_slug;
}

$sentence = $connect->prepare("INSERT INTO tr_properties (tr_id,tr_property,tr_title,tr_lang,tr_description,tr_label,tr_slug) VALUES (null, :tr_property, :tr_title, :tr_lang, :tr_description, :tr_label, :tr_slug)");

$sentence->execute(array(
		':tr_property' => $id,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_description' => $tr_description,
		':tr_label' => $tr_label,
		':tr_slug' => $slug
		));

	$extras = $_POST['pe_extra'];

	$statment = $connect->prepare("INSERT INTO properties_extras (pe_extra,pe_property) VALUES (:pe_extra, :pe_property)");
	$statment->bindParam(':pe_extra', $idextra);
	$statment->bindParam(':pe_property', $id);

	foreach ($extras as $option_value)
	{
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


$statment = $connect->prepare(
    "INSERT INTO properties_gallery (pg_property,pg_name) VALUES (:pg_property,:pg_name)"
);

foreach ($uploadedFiles as $key => $value)
{
    $statment->execute(array(
         ':pg_property' => $id,
         ':pg_name' => $value['name']
    ));
}

    }

	header('Location: ./properties.php');

}

$languages = get_active_languages($connect);
$status = get_all_status($connect);
$types = get_all_types($connect);
$cities = get_all_cities($connect);
$conditions = get_all_conditions($connect);
$extras = get_all_extras($connect);
$users = get_active_users($connect);
$siteSettings = getSettings($connect);

require '../views/new.property.view.php';


}else{

	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
}else {
		header('Location: ./login.php');		
		}


?>