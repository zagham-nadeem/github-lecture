<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

$rangeOne = range(50, 1000, 100);
$rangeTwo = range(1000, 9000, 500);

$data = array();

$array = array_merge($rangeOne, $rangeTwo);

    foreach ($array as $row) {

        $area = $row;

        $data[] = array(
            'id'=> $area,
            'title'=> getUnit($area),
        );
    }

print json_encode($data, JSON_NUMERIC_CHECK);

?>