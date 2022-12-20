<?php

$getPosts = getPosts($settings['st_bloglimit'], $connect, $lang);

$items = $getPosts['items'];
$total = $getPosts['total'];

$numPages = numTotalPages($total, $settings['st_bloglimit']);

// Get Category
if (getSlugCategory()) {
	$categoryDetails = getCurrentCategory($connect, getSlugCategory(), $lang);
}

require './pages/views/blog.view.php';

?>