<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel</title>
</head>
<body>
<h1>Leer Archivo Excel</h1>

<?php
set_include_path(implode(PATH_SEPARATOR, [
    realpath(__DIR__ . '/Classes'), // assuming Classes is in the same directory as this script
    get_include_path()
]));

require_once 'PHPExcel.php';

//C:\xampp\htdocs\phpexcel\phpexcel\Classes\PHPExcel.php
$archivo = 'formato_excel.xlsx';
$objPHPExcel = new PHPExcel();
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);

//Tiene una hoja
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

$arrayCantidad = [];
$arrayEspecie  = [];
$arrayVariedad = [];
$arrayPrecio   = [];

$guardarCantidad = false;
for ($row = 0 ; $row <= $highestRow ; $row++){
	$val = $sheet->getCell("A".$row)->getValue();
	//echo $val."\n";
	if($val === 'Cantidad'){
		$saveRow = $row;
		$guardarCantidad = true;
	}else{
		if($guardarCantidad){
			$valCantidad = $sheet->getCell("A".$row)->getValue();
			$valEspecie = $sheet->getCell("B".$row)->getValue();
			$valVariedad = $sheet->getCell("C".$row)->getValue();
			$valPrecio = $sheet->getCell("I".$row)->getValue();
	
			array_push($arrayCantidad, $valCantidad);
			array_push($arrayEspecie, $valEspecie);
			array_push($arrayVariedad, $valVariedad);
			array_push($arrayPrecio, $valPrecio);

			if($valCantidad==="" && $valEspecie==="" && $valVariedad==="" && $valPrecio===""){
				break;
			}
		}
	}
}


$doc = new PHPExcel();
 
// set active sheet 
$doc->setActiveSheetIndex(0);
 
// read data to active sheet
$doc->getActiveSheet()->setCellValueByColumnAndRow(0,0, 'Product');
 
//save our workbook as this file name
$filename = 'just_some_random_name.xls';
//mime type
header('Content-Type: application/vnd.ms-excel');
//tell browser what's the file name
header('Content-Disposition: attachment;filename="' . $filename . '"');
 
header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
 
$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
 
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');

/*
$worksheet->setCellValueByColumnAndRow(0, $row, 'Product');
$worksheet->setCellValueByColumnAndRow(1, $row, 'price');
$worksheet->setCellValueByColumnAndRow(2, $row, 'amount');
$worksheet->setCellValueByColumnAndRow(3, $row, 'Total price');
*/


/*
echo "Cantidad | Especie | Variedad | Precio \n";
echo "\n\n";
print_r($arrayCantidad);
print_r($arrayEspecie);
print_r($arrayVariedad);
print_r($arrayPrecio);*/
/*for($i = 0; $i < count($arrayCantidad) ; $i++){
	echo $arrayCantidad[$i]." | ". $arrayEspecie[$i]." | ".$arrayVariedad[$i]." | ".$arrayPrecio[$i]." \n";
}*/

?>