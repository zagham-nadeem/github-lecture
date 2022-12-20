<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

require '../../../core.php';

if(isset($_GET["lang"]) && !empty($_GET["lang"])){

$lang = $_GET["lang"];


if (PHP_SAPI == 'cli')
	die('Something Wrong');

/** Incluye PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
// Crear nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Propiedades del documento
$objPHPExcel->getProperties()->setCreator("Evora")
							 ->setLastModifiedBy("Evora")
							 ->setTitle("Properties Report")
							 ->setSubject("Properties Report")
							 ->setDescription("Properties Report")
							 ->setKeywords("Properties Report")
							 ->setCategory("Properties Report");



// Combino las celdas desde A1 hasta E1
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PROPERTIES')
            ->setCellValue('A2', 'REF')
            ->setCellValue('B2', 'TITLE')
            ->setCellValue('C2', 'BEDS')
            ->setCellValue('D2', 'BATHS')
			->setCellValue('E2', 'SIZE')
			->setCellValue('F2', 'TYPE')
			->setCellValue('G2', 'PRICE')
			->setCellValue('H2', 'RATING')
			->setCellValue('I2', 'CITY')
			->setCellValue('J2', 'ZONE')
			->setCellValue('K2', 'STATUS');
			
// Fuente de la primera fila en negrita
$boldArray = array('font' => array('bold' => true,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->applyFromArray($boldArray);		

	
			
//Ancho de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);	
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);			
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);		
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);						
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);		
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);		
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);		
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);		

    $con=@mysqli_connect($database['host'],$database['user'], $database['pass'], $database['db']);
    if(!$con){
        die("Connect failed: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

	$sql="SELECT properties.*, tr_properties.*, tr_ptstatus.tr_name AS status, tr_ptcities.tr_name AS city, tr_ptzones.tr_name AS zone, CAST(properties.pt_price AS UNSIGNED) AS price, CAST(properties.pt_size AS UNSIGNED) AS size, tr_pttypes.tr_name AS type, tr_ptconditions.tr_name AS conditions FROM properties LEFT JOIN tr_properties ON properties.pt_id = tr_properties.tr_property LEFT JOIN tr_ptstatus ON properties.pt_status = tr_ptstatus.tr_status AND tr_ptstatus.tr_lang = '".$lang."' LEFT JOIN tr_pttypes ON properties.pt_type = tr_pttypes.tr_type AND tr_pttypes.tr_lang = '".$lang."' LEFT JOIN tr_ptcities ON properties.pt_city = tr_ptcities.tr_city AND tr_ptcities.tr_lang = '".$lang."' LEFT JOIN tr_ptzones ON properties.pt_zone = tr_ptzones.tr_zone AND tr_ptzones.tr_lang = '".$lang."' LEFT JOIN tr_ptconditions ON properties.pt_conditions = tr_ptconditions.tr_conditions AND tr_ptconditions.tr_lang = '".$lang."' WHERE tr_properties.tr_lang = '".$lang."'";

	$query=mysqli_query($con,$sql);
	$cel=3;//Numero de fila donde empezara a crear  el reporte
	while ($row=mysqli_fetch_array($query)){
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
		
			$a="A".$cel;
			$b="B".$cel;
			$c="C".$cel;
			$d="D".$cel;
			$e="E".$cel;
			$f="F".$cel;
			$g="G".$cel;
			$h="H".$cel;
			$i="I".$cel;
			$j="J".$cel;
			$k="K".$cel;

			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($a, $pt_reference)
            ->setCellValue($b, $tr_title)
            ->setCellValue($c, $pt_beds)
            ->setCellValue($d, $pt_baths)
			->setCellValue($e, getUnit($pt_size))
			->setCellValue($f, $pt_type)
			->setCellValue($g, getPrice($pt_price))
			->setCellValue($h, ucwords($pt_rating))
			->setCellValue($i, $pt_city)
			->setCellValue($j, $pt_zone)
			->setCellValue($k, $pt_status);
			
	$cel+=1;
	}

/*Fin extracion de datos MYSQL*/
$rango="A2:$k";
$styleArray = array('font' => array( 'name' => 'Arial','size' => 10),
'borders'=>array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('argb' => 'FFF')))
);
$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
// Cambiar el nombre de hoja de cálculo
$objPHPExcel->getActiveSheet()->setTitle('Properties');


$objPHPExcel->setActiveSheetIndex(0);


// Redirigir la salida al navegador web de un cliente ( Excel5 )
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="properties.xls"');
header('Cache-Control: max-age=0');
// Si usted está sirviendo a IE 9 , a continuación, puede ser necesaria la siguiente
header('Cache-Control: max-age=1');

// Si usted está sirviendo a IE a través de SSL , a continuación, puede ser necesaria la siguiente
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

}

?>