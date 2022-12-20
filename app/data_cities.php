<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {



$sqlQuery = "SELECT pt_cities.*,tr_ptcities.tr_name AS tr_name FROM pt_cities,tr_ptcities WHERE pt_cities.pt_city_id = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".getParamsLang()."' GROUP BY pt_cities.pt_city_id";

$sentence = $connect->prepare($sqlQuery);

$sentence->execute();

$qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach ($qResults as $row) {

	$id = $row['pt_city_id'];
    $title = $row['tr_name'];
    $image = $row['pt_city_image'];
    $featured = $row['pt_city_featured'];

    $data[] = array(
    	'id'=> $id,
    	'title'=> html_entity_decode($title),
    	'image'=> getImage($image),
    	'featured'=> $featured
    	);
}

print json_encode($data, JSON_NUMERIC_CHECK);

}else{

    $InvalidMSG = 'error';
     
    $InvalidMSGJSon = json_encode($InvalidMSG);
     
    print $InvalidMSGJSon;

}

?>