<?php

$featuredPosts = getFeaturedPosts($connect, $lang, 10);
$getCategories = getCategories($connect, $lang);

require './sections/views/blog-sidebar.view.php';

?>