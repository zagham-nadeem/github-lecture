
<?php

require '../core.php';

if(isset($_POST['city']) && !empty($_POST['city']) && (int)($_POST['city'])){

	$city = clearGetData($_POST['city']);

	$stmt = $connect->prepare("SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name FROM pt_zones,tr_ptzones WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND pt_zones.pt_zone_city = :pt_city_id AND tr_ptzones.tr_lang = '".$lang."'");
	$stmt->execute(array(':pt_city_id' => $city));

	echo '<option selected value>'.echoOutput($translation['tr_23']).'</option>';
	
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo "<option value=".$row['pt_zone_id'].">".$row['tr_name']."</option>";
	}
	exit;
}

?>
