<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {



$sqlQuery = "SELECT pt_status.*,tr_ptstatus.* FROM pt_status,tr_ptstatus WHERE pt_status.pt_status_id = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".getParamsLang()."'";

$sentence = $connect->prepare($sqlQuery);

$sentence->execute();

$qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach ($qResults as $row) {

    $id = $row['pt_status_id'];
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