<?php

$counter = 0;

$featuredCities = getFeaturedCities($connect, $lang, $settings['st_featuredcities']);

require './sections/views/featured-cities.view.php';

?>