<?php

require "core.php";

require_once __DIR__ . '/classes/mpdf/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

// Get Item Id
$idItem = clearGetData(getItemId());

if(empty($idItem)){

	header('Location: '. $urlPath->home());
}

// Property Details
$itemDetails = getPropertyById($connect, $idItem, $lang);

if(empty($itemDetails)){
	
	header('Location: '. $urlPath->error());
}

// Title
$titleSeoHeader = getSeoTitle($translation['tr_1']);

$itemsGallery = getGallery($connect, $idItem);
$itemsExtras = getExtrasByProperty($connect, $idItem, $lang);

ob_start();

require './views/print.view.php';

$html = ob_get_contents();

ob_end_clean();

$mpdf->WriteHTML($html);

$mpdf->Output();

?>