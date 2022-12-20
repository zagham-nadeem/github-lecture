<?php

require "core.php";

// Get Item Id
$idItem = clearGetData(getItemId());

if(empty($idItem)){

	header('Location: '. $urlPath->home());
}

// Property Details
$itemDetails = getPropertyById($connect, $idItem, $lang);

if(empty($itemDetails)){
	
	header('Location: '. $urlPath->error());
}

// Seo Title
$titleSeoHeader = getSeoTitle($itemDetails['tr_title']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3'], $itemDetails['tr_description']);

// Property Gallery
$itemsGallery = getGallery($connect, $idItem);

// Property Extras
$itemsExtras = getExtrasByProperty($connect, $idItem, $lang);

// Related Properties
$itemsRelated = getRelatedProperties($connect, $lang, $itemDetails['pt_price'], $itemDetails['pt_type'], $itemDetails['pt_city'], $itemDetails['pt_id'], $settings['st_similarproperties']);

// Check if user have saved the item into favorites

if (isLogged()) {
	$isFav = isPropertyInFav($connect, $userInfo['user_id'], $idItem);
}


include './header.php';
require './views/single-property.view.php';
include './footer.php';

?>