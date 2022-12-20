<?php

include_once "core.php";

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1']);

$fullHeight = true;

require './header.php';
require './views/error.view.php';
require './footer.php';

?>