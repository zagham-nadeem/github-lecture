<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {

	$langTable = "translate_".getParamsLang();

	$exists = checkTable($connect, $langTable);

	if (!$exists){

		$sqlQuery = "SELECT * FROM translations";

	}else{

		$sqlQuery = "SELECT * FROM $langTable";
	}

	$sentence = $connect->prepare($sqlQuery);

	$sentence->execute();

	$qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

	$data = array();

	foreach ($qResults as $row) {

		$tr_1 = $row['tr_termsandconds'];
		$tr_2 = $row['tr_aboutus'];

		$data[] = array(
			'tr_termsandconds'=> formatHTML($tr_1),
			'tr_aboutus'=> formatHTML($tr_2)
		);
	}

	print json_encode($data, JSON_NUMERIC_CHECK);

}else{

	$InvalidMSG = 'error';

	$InvalidMSGJSon = json_encode($InvalidMSG);

	print $InvalidMSGJSon;

}

?>