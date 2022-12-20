<?php

if(isset($_GET["lang"]) && !empty($_GET["lang"])){

$lang = $_GET["lang"];

require '../../../core.php';

$connection = mysqli_connect($database['host'],$database['user'], $database['pass'], $database['db']) 
or die("Connect failed");

$sql = "SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, CAST(properties.pt_price AS UNSIGNED) AS price, CAST(properties.pt_size AS UNSIGNED) AS size, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE tr_properties.tr_lang = '".$lang."'";
mysqli_set_charset($connection, "utf8");

if(!$result = mysqli_query($connection, $sql)) die();

$properties = array();

while($row = mysqli_fetch_array($result)) 
{	
        $pt_reference=$row['pt_reference'];
        $tr_title=$row['tr_title'];
        $pt_beds=$row['pt_beds'];
        $pt_baths=$row['pt_baths'];
        $pt_size=$row['pt_size'];
        $pt_type=$row['type'];
        $pt_price=$row['price'];
        $pt_rating=$row['pt_rating'];
        $pt_city=$row['city'];
        $pt_zone=$row['zone'];
        $pt_status=$row['status'];

    $properties[] = array(
    	'pt_reference'=> $pt_reference,
    	'tr_title'=> $tr_title,
    	'pt_beds'=> $pt_beds,
    	'pt_baths'=> $pt_baths,
        'pt_size'=> getUnit($pt_size),
        'pt_type'=> $pt_type,
        'pt_price'=> getPrice($pt_price),
        'pt_rating'=> $pt_rating,
        'pt_city'=> $pt_city,
        'pt_zone'=> $pt_zone,
    	'pt_status'=> $pt_status,
    	);

}
    
$close = mysqli_close($connection) 
or die("Disconnection failed");
  

$json_string = json_encode($properties);
print_r($json_string);


}

?>
