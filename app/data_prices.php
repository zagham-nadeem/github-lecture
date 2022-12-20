<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

$rangeOne = range(100, 1000, 200);
$rangeTwo = range(1000, 10000, 1000);
$rangeThree = range(20000, 100000, 10000);
$rangeFour = range(200000, 500000, 100000);
$rangeFive = range(1000000, 5000000, 1000000);

$data = array();

$array = array_merge($rangeOne, $rangeTwo, $rangeThree, $rangeFour, $rangeFive);

    foreach ($array as $row) {

        $price = $row;

        $data[] = array(
            'id'=> $price,
            'title'=> getPrice($price),
        );
    }

print json_encode($data, JSON_NUMERIC_CHECK);

?>