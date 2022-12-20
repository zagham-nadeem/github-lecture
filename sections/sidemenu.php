<?php

// Get Menu Header

$headerMenu = getHeaderMenu($connect, $lang);

$navigationHeader = getNavigation($connect, $headerMenu['menu_id'], $lang);

require './sections/views/sidemenu.view.php';

?>