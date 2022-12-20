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

if ( empty($_GET["lang"]) && empty($_GET["id"]) ) {
	header('Location: ./home.php');
	}

$check_access = check_access($connect);
if ($check_access['user_role'] == 1){

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$post_id = cleardata($_POST['post_id']);
	$post_visibility = cleardata($_POST['post_visibility']);
	$post_category = cleardata($_POST['post_category']);
	$post_featured = cleardata($_POST['post_featured']);

	$imagefile = explode(".", $_FILES["post_image"]["name"]);

	$image_save = $_POST['post_image_save'];
	$post_image = $_FILES['post_image'];

	if (empty($post_image['name'])) {
		$post_image = $image_save;
	} else{
			$imagefile = explode(".", $_FILES["post_image"]["name"]);
			$renamefile = round(microtime(true)) . '.' . end($imagefile);
		$image_upload = '../../images/';
		move_uploaded_file($_FILES['post_image']['tmp_name'], $image_upload . 'post_' . $renamefile);
		$post_image = 'post_' . $renamefile;
	}

$statment = $connect->prepare("UPDATE posts SET post_id = :post_id, post_visibility = :post_visibility, post_category = :post_category, post_featured = :post_featured, post_image = :post_image WHERE post_id = :post_id");

$statment->execute(array(

		':post_id' => $post_id,
		':post_visibility' => $post_visibility,
		':post_category' => $post_category,
		':post_featured' => $post_featured,
		':post_image' => $post_image
		));

$tr_id = cleardata($_POST['tr_id']);
$tr_post = cleardata($_POST['tr_post']);
$tr_lang = cleardata($_POST['tr_lang']);
$tr_title = cleardata($_POST['tr_title']);
$tr_seotitle = cleardata($_POST['tr_seotitle']);
$tr_seodescription = cleardata($_POST['tr_seodescription']);
$tr_content = $_POST['tr_content'];

$tr_slug = cleardata($_POST['tr_slug']);

if (empty($tr_slug)) {
	$slug = $_POST['tr_slug_save'];
}else{

	$converted_slug = convertSlug($_POST['tr_slug']);
	$exists = get_post_slug($connect, $converted_slug);

	if ($exists > 0)
	{
		$new_number = $exists + 1;
		$slug = $converted_slug."-".$new_number;

	}else{

		$slug = $converted_slug;
	}

}

$sentence = $connect->prepare("UPDATE tr_posts SET tr_title = :tr_title, tr_content = :tr_content, tr_slug = :tr_slug, tr_seotitle = :tr_seotitle, tr_seodescription = :tr_seodescription WHERE tr_id = :tr_id AND tr_lang = :tr_lang AND tr_post = :tr_post");

$sentence->execute(array(
		':tr_id' => $tr_id,
		':tr_post' => $tr_post,
		':tr_title' => $tr_title,
		':tr_lang' => $tr_lang,
		':tr_slug' => $slug,
		':tr_content' => $tr_content,
		':tr_seotitle' => $tr_seotitle,
		':tr_seodescription' => $tr_seodescription
		));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

$id_post = id_post($_GET['id']);

$lang = lang($_GET['lang']);

$post = get_post_per_id_by_language($connect, $id_post, $lang);

    if (!$post){
    header('Location: ./home.php');
}

$post = $post['0'];

$languages = get_languages_by_post($connect, $id_post);
$activelanguages = get_languages_not_post($connect, $id_post);
$categories = get_all_categories($connect);

require '../views/edit.post.view.php';

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