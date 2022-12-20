<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {



$sqlQuery = "SELECT pt_types.*,tr_pttypes.* FROM pt_types,tr_pttypes WHERE pt_types.pt_type_id = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".getParamsLang()."'";

$sentence = $connect->prepare($sqlQuery);

$sentence->execute();

$qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach ($qResults as $row) {

    $id = $row['pt_type_id'];
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