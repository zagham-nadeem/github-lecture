<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {



$sqlQuery = "SELECT categories.*,tr_categories.tr_name AS tr_name FROM categories,tr_categories WHERE categories.category_id = tr_categories.tr_category AND tr_categories.tr_lang = '".getParamsLang()."'";

$sentence = $connect->prepare($sqlQuery);

$sentence->execute();

$qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach ($qResults as $row) {

    $id = $row['category_id'];
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