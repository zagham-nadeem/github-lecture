<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {



$sqlQuery = "SELECT pt_conditions.*,tr_ptconditions.* FROM pt_conditions,tr_ptconditions WHERE pt_conditions.pt_conditions_id = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".getParamsLang()."'";

$sentence = $connect->prepare($sqlQuery);

$sentence->execute();

$qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach ($qResults as $row) {

    $id = $row['pt_conditions_id'];
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