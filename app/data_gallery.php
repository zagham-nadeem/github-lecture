<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsID()) {

	$sqlQuery = "SELECT * FROM properties_gallery WHERE pg_property = '".getParamsID()."'";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

	$data = array();

    foreach ($qResults as $row) {

        $id = $row['pg_id'];
        $image = getImage($row['pg_name']);

        $data[] = array(
            'url'=> $image,
        );
    }

	print json_encode($data, JSON_NUMERIC_CHECK);

}else{

    $InvalidMSG = 'error';
    
    $InvalidMSGJSon = json_encode($InvalidMSG);
    
    print $InvalidMSGJSon;

}

?>