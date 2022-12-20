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
	header('Location: ./error.php');
	} 

$check_access = check_access($connect);

if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$post_visibility = cleardata($_POST['post_visibility']);
	$post_category = cleardata($_POST['post_category']);
	$post_featured = cleardata($_POST['post_featured']);

	$post_image = $_FILES['post_image']['tmp_name'];

	$imagefile = explode(".", $_FILES["post_image"]["name"]);
	$renamefile = round(microtime(true)) . '.' . end($imagefile);

	$image_upload = '../../images/';

	move_uploaded_file($post_image, $image_upload . 'post_' . $renamefile);

	$statment = $connect->prepare("INSERT INTO posts (post_id, post_visibility, post_category, post_featured, post_date, post_image) VALUES (null, :post_visibility, :post_category, :post_featured, CURRENT_TIMESTAMP, :post_image)");

	$statment->execute(array(
		':post_visibility' => $post_visibility,
		':post_category' => $post_category,
		':post_featured' => $post_featured,
		':post_image' => 'post_' . $renamefile
		));

$statment = $connect->prepare('SELECT @@identity AS id');
$statment->execute();
$row = $statment->fetch(PDO::FETCH_ASSOC);
$id = $row["id"];

$tr_lang = cleardata($_POST['tr_lang']);
$tr_title = cleardata($_POST['tr_title']);
$tr_content = $_POST['tr_content'];
$tr_seotitle = cleardata($_POST['tr_seotitle']);
$tr_seodescription = cleardata($_POST['tr_seodescription']);

$converted_slug = convertSlug($_POST['tr_title']);
$exists = get_post_slug($connect, $converted_slug);

if ($exists > 0)
{
	$new_number = $exists + 1;
	$slug = $converted_slug."-".$new_number;

}else{

	$slug = $converted_slug;
}

$sentence = $connect->prepare("INSERT INTO tr_posts (tr_id,tr_post,tr_title,tr_lang,tr_slug,tr_content,tr_seotitle,tr_seodescription) VALUES (null, :tr_post, :tr_title, :tr_lang, :tr_slug, :tr_content, :tr_seotitle, :tr_seodescription)");

$sentence->execute(array(
		':tr_post' => $id,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_slug' => $slug,
		':tr_content' => $tr_content,
		':tr_seotitle' => $tr_seotitle,
		':tr_seodescription' => $tr_seodescription
		));

	header('Location: ./posts.php');

}

$categories = get_all_categories($connect);
$languages = get_active_languages($connect);

require '../views/new.post.view.php';

}elseif($check_access['user_role'] == 2){

	require '../views/denied.view.php';
	
}else{
	
	header('Location:'.SITE_URL);
}

require '../views/footer.view.php';
    
}else {
		header('Location: ./login.php');		
		}


?>