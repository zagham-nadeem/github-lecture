<?php

// Get Data

$cities = getCities($connect, $lang);
$conditions = getConditions($connect, $lang);
$status = getStatus($connect, $lang);
$types = getTypes($connect, $lang);
$extras = getExtras($connect, $lang);

include './sections/views/widget-search.view.php';

?>