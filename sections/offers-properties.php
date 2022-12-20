<?php

$offersProperties = getOffersProperties($connect, $lang, $settings['st_offersproperties']);

require './sections/views/offers-properties.view.php';

?>