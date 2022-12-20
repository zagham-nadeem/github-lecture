<?php

$getProperties = getSearchProperties($settings['st_searchlimit'], $connect, $lang);

$items = $getProperties['items'];
$total = $getProperties['total'];

$numPages = numTotalPages($total, $settings['st_searchlimit']);

require './pages/views/search.view.php';

?>