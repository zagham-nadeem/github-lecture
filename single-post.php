<?php

require "core.php";

// Get Item Id
$idItem = clearGetData(getItemId());

if(empty($idItem)){

	header('Location: '. $urlPath->home());
}

// Post Details
$itemDetails = getPostById($connect, $idItem, $lang);

if(empty($itemDetails)){
	
	header('Location: '. $urlPath->error());
}

// Get Default Blog Page Info
$blogPage = getDefaultBlogPage($connect, $lang);

// Seo Title
$titleSeoHeader = getSeoTitle($itemDetails['tr_title']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3'], $itemDetails['tr_content'], $itemDetails['tr_seodescription']);

// Page Title
$pageTitle = $blogPage['tr_title'];

// Related Posts
$itemsRelated = getRelatedPosts($connect, $itemDetails['post_id'], $itemDetails['post_category'], $lang);


include './header.php';
require './views/single-post.view.php';
include './footer.php';

?>