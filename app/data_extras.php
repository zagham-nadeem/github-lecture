<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {

    

    if (getParamsID()) {

        $sqlQuery = "SELECT properties_extras.*,tr_ptextras.* FROM properties_extras,tr_ptextras WHERE properties_extras.pe_extra = tr_ptextras.tr_extra AND properties_extras.pe_property = '".getParamsID()."' AND tr_ptextras.tr_lang = '".getParamsLang()."'";

    }else{

        $sqlQuery = "SELECT pt_extras.*,tr_ptextras.* FROM pt_extras,tr_ptextras WHERE pt_extras.pt_extra_id = tr_ptextras.tr_extra AND tr_ptextras.tr_lang = '".getParamsLang()."'";

    }

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

    $data = array();

    foreach ($qResults as $row) {

        $id = $row['tr_extra'];
        $title = $row['tr_name'];

        $data[] = array(
            'id'=> $id,
            'title'=> html_entity_decode($title),
        );
    }

    print json_encode($data, JSON_NUMERIC_CHECK);

}else{

    $InvalidMSG = 'error';
    
    $InvalidMSGJSon = json_encode($InvalidMSG);
    
    print $InvalidMSGJSon;

}

?>