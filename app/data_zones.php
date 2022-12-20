<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';



if (getParamsLang()) {

    $sqlQuery = "SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name FROM pt_zones,tr_ptzones WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND pt_zones.pt_zone_city = '".getParamsCity()."'";

    $sqlQuery .= " AND tr_ptzones.tr_lang = '".getParamsLang()."'";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

    $data = array();

    foreach ($qResults as $row) {

        $id = $row['pt_zone_id'];
        $title = $row['tr_name'];

        $data[] = array(
            'id'=> $id,
            'title'=> html_entity_decode($title)
            );
    }

    print json_encode($data, JSON_NUMERIC_CHECK);

}else{

    $InvalidMSG = 'error';
     
    $InvalidMSGJSon = json_encode($InvalidMSG);
     
    print $InvalidMSGJSon;

}

?>