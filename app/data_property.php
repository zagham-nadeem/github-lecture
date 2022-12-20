<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {

	

	$sqlQuery = "SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".getParamsLang()."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".getParamsLang()."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".getParamsLang()."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".getParamsLang()."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".getParamsLang()."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND tr_properties.tr_lang = '".getParamsLang()."' AND properties.pt_id = '".getParamsID()."'";

	$sqlQuery .= " LIMIT 1";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

	$data = array();

    foreach ($qResults as $row) {

        $id = $row['pt_id'];
        $title = $row['tr_title'];
        $image = $row['pt_image'];
        $price = $row['pt_price'];
        $label = $row['tr_label'];
        $oldprice = $row['pt_oldprice'];
        $status = $row['status'];
        $conditions = $row['conditions'];
        $type = $row['type'];
        $city = $row['city'];
        $zone = $row['zone'];
        $direction = $row['pt_direction'];
        $reference = $row['pt_reference'];
        $rating = $row['pt_rating'];
        $size = $row['pt_size'];
        $beds = $row['pt_beds'];
        $baths = $row['pt_baths'];
        $garages = $row['pt_garages'];
        $floor = $row['pt_floor'];
        $description = $row['tr_description'];
        $latitude = $row['pt_latitude'];
        $longitude = $row['pt_longitude'];

        $data[] = array(
            'id'=> $id,
            'title'=> html_entity_decode($title),
            'image'=> getImage($image),
            'price'=> getPrice($price),
            'label'=> html_entity_decode($label),
            'oldprice'=> getPrice($oldprice),
            'status'=> html_entity_decode($status),
            'discount'=> getDiscount($price, $oldprice),
            'status'=> html_entity_decode($status),
            'conditions'=> html_entity_decode($conditions),
            'type'=> html_entity_decode($type),
            'city'=> html_entity_decode($city),
            'zone'=> html_entity_decode($zone),
            'direction'=> html_entity_decode($direction),
            'address'=> html_entity_decode(getAddress($city, $zone)),
            'reference'=> html_entity_decode($reference),
            'rating'=> html_entity_decode($rating),
            'size'=> getUnit($size),
            'beds'=> html_entity_decode($beds),
            'baths'=> html_entity_decode($baths),
            'garages'=> html_entity_decode($garages),
            'floor'=> $floor,
            'description'=> html_entity_decode($description),
            'latitude'=> $latitude,
            'longitude'=> $longitude,
        );
    }

	print json_encode($data, JSON_NUMERIC_CHECK);

}else{

    $InvalidMSG = 'error';
    
    $InvalidMSGJSon = json_encode($InvalidMSG);
    
    print $InvalidMSGJSon;

}

?>