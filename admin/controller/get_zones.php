<?php

require '../../config.php';
require '../functions.php';

$connect = connect($database);

$check_access = check_access($connect);

if ($check_access['user_role'] == 1 || $check_access['user_role'] == 2){

if($_POST['city_id'])
{
	$city_id = $_POST['city_id'];

	$stmt = $connect->prepare("SELECT pt_zones.*,tr_ptzones.tr_name AS tr_name FROM pt_zones,tr_ptzones WHERE pt_zones.pt_zone_id = tr_ptzones.tr_zone AND  pt_zone_city = :city_id GROUP BY tr_ptzones.tr_zone");
	$stmt->execute(array(':city_id' => $city_id));
	?><?php
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
		<option value="<?php echo $row['pt_zone_id']; ?>"><?php echo $row['tr_name']; ?></option>
		<?php
	}
}

}else{

	header('Location:'.SITE_URL);

}
?>