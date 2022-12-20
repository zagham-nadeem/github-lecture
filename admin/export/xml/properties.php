<?php 

require '../../../core.php';

if(isset($_GET["lang"]) && !empty($_GET["lang"])){

$lang = $_GET["lang"];

/** create XML file */ 
$mysqli = new mysqli($database['host'],$database['user'], $database['pass'], $database['db']);

/* check connection */
if ($mysqli->connect_errno) {

   echo "Connect failed ".$mysqli->connect_error;

   exit();
}

$query = "SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, CAST(properties.pt_price AS UNSIGNED) AS price, CAST(properties.pt_size AS UNSIGNED) AS size, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE tr_properties.tr_lang = '".$lang."'";

function createXMLfile($itemsArray){
  
   $filePath = 'properties.xml';

   $dom = new DOMDocument('1.0', 'utf-8'); 

   $root = $dom->createElement('properties'); 

   for($i=0; $i<count($itemsArray); $i++){
     
     $pt_reference =  $itemsArray[$i]['pt_reference'];  

     $tr_title = htmlspecialchars($itemsArray[$i]['tr_title']);

     $pt_beds =  $itemsArray[$i]['pt_beds']; 

     $pt_baths =  $itemsArray[$i]['pt_baths']; 

     $pt_size =  $itemsArray[$i]['pt_size']; 

     $pt_type =  $itemsArray[$i]['type'];	

     $pt_price =  $itemsArray[$i]['pt_price'];  

     $pt_rating =  $itemsArray[$i]['pt_rating'];  

     $pt_city =  $itemsArray[$i]['city'];  

     $pt_zone =  $itemsArray[$i]['zone']; 

     $pt_status =  $itemsArray[$i]['status'];  

     $property = $dom->createElement('property');

     /*$property->setAttribute('reference', $pt_reference);*/

     $reference = $dom->createElement('reference', $pt_reference); 

     $property->appendChild($reference); 

     $title = $dom->createElement('title', $tr_title); 

     $property->appendChild($title); 

     $beds = $dom->createElement('beds', $pt_beds); 

     $property->appendChild($beds); 

     $bath = $dom->createElement('bath', $pt_baths); 

     $property->appendChild($bath); 

     $size = $dom->createElement('size', getUnit($pt_size)); 

     $property->appendChild($size); 
     
     $type = $dom->createElement('type', $pt_type); 

     $property->appendChild($type);
 
     $price = $dom->createElement('price', getPrice($pt_price)); 

     $property->appendChild($price);

     $rating = $dom->createElement('rating', $pt_rating); 

     $property->appendChild($rating);

     $city = $dom->createElement('city', $pt_city); 

     $property->appendChild($city);

     $zone = $dom->createElement('zone', $pt_zone); 

     $property->appendChild($zone);

     $status = $dom->createElement('status', $pt_status); 

     $property->appendChild($status);

     $root->appendChild($property);

   }

   $dom->appendChild($root); 
   
   $dom->save($filePath); 

    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename='.basename($filePath));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;

 } 


$itemsArray = array();

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {

       array_push($itemsArray, $row);
    }
  
    if(count($itemsArray)){

         createXMLfile($itemsArray);

     }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();

}

?>