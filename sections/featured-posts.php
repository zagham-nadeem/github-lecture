<?php

$featuredPosts = getRecentsPosts($connect, $lang, $settings['st_featuredposts']);

require './sections/views/featured-posts.view.php';

?>