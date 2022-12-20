<?php

require "core.php";

// Get Item Slug
$slugItem = clearGetData(getSlugItem());

if(empty($slugItem)){

	header('Location: '. $urlPath->home());
}

// Set Language
if (!isset($_GET['lang'])) {

$getLang = getLangByPageSlug($connect, $slugItem);

setLanguage($getLang['tr_lang']);

}

// Get ID By Slug
$getPageIDBySlug = getPageIDBySlug($connect, $slugItem);

$itemId = $getPageIDBySlug['id'];

// Page Details
$itemDetails = getPageById($connect, $itemId, $lang);

if(empty($itemDetails)){

	header('Location: '. $urlPath->error());
	
}

$getLanguagesByPage = getLanguagesByPage($connect, $itemId);

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], $itemDetails['tr_title']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3'], $itemDetails['tr_content'], $itemDetails['tr_seodescription']);

// Page Title
$pageTitle = $itemDetails['tr_title'];

include './header.php';
include './sections/header.php';
include './sections/page-title.php';
include './sections/views/header-ad.view.php';

// is Page Private
if ($itemDetails['page_private'] == 1 && !isLogged()) {

		require './views/private.view.php';

}else{

	if ($itemDetails['page_template'] == 'blank') {

		require './views/single-page.view.php';

	}elseif ($itemDetails['page_template'] == 'properties') {
		
		require './pages/properties.php';

	}elseif ($itemDetails['page_template'] == 'search') {
		
		require './pages/search.php';

	}elseif ($itemDetails['page_template'] == 'blog') {
		
		require './pages/blog.php';

	}elseif ($itemDetails['page_template'] == 'contact') {
		
		require './pages/contact.php';

	}else{

		require './views/single-page.view.php';
	}
	
}


include './sections/views/footer-ad.view.php';

if($itemDetails['page_footer'] == 1):
include './sections/footer.php';
endif;

include './footer.php';

?>