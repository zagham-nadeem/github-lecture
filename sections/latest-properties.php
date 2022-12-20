<?php

$latestProperties = getLatestProperties($connect, $lang, $settings['st_recentproperties']);

require './sections/views/latest-properties.view.php';

?>