<?php

$getProperties = getProperties($settings['st_propertieslimit'], $connect, $lang);

$items = $getProperties['items'];
$total = $getProperties['total'];

$numPages = numTotalPages($total, $settings['st_propertieslimit']);

// Get City
if (getSlugCity()) {

	$getCityBySlug = getCityBySlug($connect, getSlugCity());
	$cityDetails = getCurrentCity($connect, $getCityBySlug['id'], $lang);

}

// Get Zone
if (getSlugZone()) {

	$getZoneBySlug = getZoneBySlug($connect, getSlugZone());
	$zoneDetails = getCurrentZone($connect, $getZoneBySlug['id'], $lang);
}

// Get Status
if (getSlugStatus()) {

	$getStatusBySlug = getStatusBySlug($connect, getSlugStatus());
	$statusDetails = getCurrentStatus($connect, $getStatusBySlug['id'], $lang);
}

// Get Type
if (getSlugType()) {

	$getTypeBySlug = getTypeBySlug($connect, getSlugType());
	$typeDetails = getCurrentType($connect, $getTypeBySlug['id'], $lang);
}

// Get Condition
if (getSlugCondition()) {

	$getConditionBySlug = getConditionBySlug($connect, getSlugCondition());
	$conditionDetails = getCurrentCondition($connect, $getConditionBySlug['id'], $lang);
}

require './pages/views/properties.view.php';

?>