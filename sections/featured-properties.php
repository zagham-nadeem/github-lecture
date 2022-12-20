<?php

$featuredProperties = getFeatredProperties($connect, $lang, $settings['st_featuredproperties']);

require './sections/views/featured-properties.view.php';

?>