<?php

$page = 1;
if(!empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if(false === $page) {
        $page = 1;
    }
}

$limit = 10;
if(!empty($_GET['limit'])) {
    $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
}

$offset = ($page - 1) * $limit;

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {

    $connect = connect();

    $sqlQuery = "SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions, CAST(properties.pt_price AS UNSIGNED) AS price, CAST(properties.pt_size AS UNSIGNED) AS size FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".getParamsLang()."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".getParamsLang()."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".getParamsLang()."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".getParamsLang()."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".getParamsLang()."' WHERE properties.pt_visibility = 1 AND properties.pt_sold = 0 AND tr_properties.tr_lang = '".getParamsLang()."'";

    if(getParamsReference() && !empty(getParamsReference())){

        $sqlQuery .= " AND properties.pt_reference = '".getParamsReference()."'";
    }

    if(getParamsCity() && getParamsCity() != "any"){

        $sqlQuery .= " AND properties.pt_city = '".getParamsCity()."'";
    }

    if(getParamsZone() && getParamsZone() != "any"){

        $sqlQuery .= " AND properties.pt_zone = '".getParamsZone()."'";
    }

    if(getParamsType() && getParamsType() != "any"){

        $sqlQuery .= " AND properties.pt_type = '".getParamsType()."'";
    }

    if(getParamsStatus() && getParamsStatus() != "any"){

        $sqlQuery .= " AND properties.pt_status = '".getParamsStatus()."'";
    }

    if(getParamsCondition() && getParamsCondition() != "any"){

        $sqlQuery .= " AND properties.pt_conditions = '".getParamsCondition()."'";
    }

    if(getParamsOffers() && getParamsOffers() == "1"){

        $sqlQuery .= " AND properties.pt_offer = '".getParamsOffers()."'";
    }

    if(getParamsMinBeds() && getParamsMinBeds() != "any"){

        $sqlQuery .= "AND properties.pt_beds >= '".getParamsMinBeds()."'";
    }

    if(getParamsMinBaths() && getParamsMinBaths() != "any"){

        $sqlQuery .= "AND properties.pt_baths >= '".getParamsMinBaths()."'";
    }

    if (!getParamsMinArea() || getParamsMinArea() == 'any') {
        $q_minarea = '0';
    }else{
        $q_minarea = getParamsMinArea();
    }

    if (!getParamsMaxArea() || getParamsMaxArea() == 'any') {
        $q_maxarea = '9999999999';
    }else{
        $q_maxarea = getParamsMaxArea();
    }

    $sqlQuery .= " AND properties.pt_size BETWEEN $q_minarea AND $q_maxarea";

    if (!getParamsMinPrice() || getParamsMinPrice() == 'any') {
        $q_minprice = '0';
    }else{
        $q_minprice = getParamsMinPrice();
    }

    if (!getParamsMaxPrice() || getParamsMaxPrice() == 'any') {
        $q_maxprice = '9999999999';
    }else{
        $q_maxprice = getParamsMaxPrice();
    }

    $sqlQuery .= " AND properties.pt_price BETWEEN $q_minprice AND $q_maxprice";

    if(getParamsExtras()){

        $q_extras = array(getParamsExtras());

        if (is_array($q_extras)) {

            if (count($q_extras) > 1) {

                $sqlQuery .= " AND properties.pt_id IN (SELECT pe_property FROM properties_extras WHERE pe_extra IN (";

                $numOptions = count($q_extras);
                $i = 0;
                foreach ($q_extras as $option){
                    if(++$i === $numOptions) {
                        $sqlQuery .= "'$option') GROUP BY pe_property HAVING COUNT(DISTINCT pe_extra)=$numOptions)";
                    }else{
                        $sqlQuery .= " '$option',";
                    }
                }

            }else{

                $single_extra = $q_extras[0];

                $sqlQuery .= " AND properties.pt_id IN (SELECT pe_property FROM properties_extras WHERE pe_extra = $single_extra)";
            }
        }
    }

    if (getParamsSort()) {

        $sortby = getParamsSort();

        if($sortby == 'default') {

            $sqlQuery .= " ORDER BY properties.pt_date DESC";

        }elseif($sortby == 'price-asc') {

            $sqlQuery .= " ORDER BY price ASC";

        }elseif ($sortby == 'price-desc') {

            $sqlQuery .= " ORDER BY price DESC";
            
        }elseif($sortby == 'date-asc') {

            $sqlQuery .= " ORDER BY properties.pt_date ASC";

        }elseif ($sortby == 'date-desc') {

            $sqlQuery .= " ORDER BY properties.pt_date DESC";
            
        }elseif($sortby == 'size-asc') {

            $sqlQuery .= " ORDER BY size ASC";

        }elseif ($sortby == 'size-desc') {

            $sqlQuery .= " ORDER BY size DESC";
        }

    }else{

        $sqlQuery .= " ORDER BY properties.pt_date DESC";
    }

    if(isset($_GET['page']) && !empty($_GET['page'])) {
        $sqlQuery .= " LIMIT ".$offset.",".$limit;
    }

    if(isset($_GET['limit']) && !empty($_GET['limit']) && !isset($_GET['page'])) {
        $sqlQuery .= " LIMIT ".$limit;
    }

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
        );
    }

    print json_encode($data, JSON_NUMERIC_CHECK);

}else{

    $InvalidMSG = 'error';
    
    $InvalidMSGJSon = json_encode($InvalidMSG);
    
    print $InvalidMSGJSon;

}

?>