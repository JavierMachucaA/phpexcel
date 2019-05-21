<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load("formato_excel.xlsx");

$sheet = $spreadsheet->getActiveSheet();
$highestRow = $sheet->getHighestRow();
$arrayCantidad = [];
$arrayEspecie  = [];
$arrayVariedad = [];
$arrayPrecio   = [];


$guardarCantidad = false;
for ($row = 0 ; $row <= $highestRow ; $row++){
	$val = $sheet->getCell("A".$row)->getValue();
	
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
            

            //echo "[$row] - a:'$valCantidad'| b :'$valEspecie'| c:'$valVariedad'| d:'$valPrecio'|\n";
            
			if($valCantidad=="" && $valEspecie=="" && $valVariedad=="" && $valPrecio==""){
				break;
			}
		}
	}
}

//print_r($arrayCantidad);
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Cantidad');
$sheet->setCellValue('B1', 'Especie');
$sheet->setCellValue('C1', 'Variedad');
$sheet->setCellValue('D1', 'Unitario');
$sheet->setCellValue('E2', 'Total');

$cantidad = count($arrayCantidad);
//print("cantidad: $cantidad");


for($i=0;$i<count($arrayCantidad); $i++){
    $r = $i+2;
    //if($i==1){ print("i :$i - r: $r"); die();}
    $sheet->setCellValue("A$r", $arrayCantidad[$i]);
    $sheet->setCellValue("B$r", $arrayEspecie[$i]);
    $sheet->setCellValue("C$r", $arrayVariedad[$i]);
    $sheet->setCellValue("D$r", $arrayPrecio[$i]);
    if($arrayPrecio[$i]!=='NETO '){
        $sheet->setCellValue("E$r", "=A$r*D$r");
    }else{
        $ant = $r-1;
        $cellTotal = $r+4;
        $cellIva = $r+3;
        $cellNeto = $r;

        /*$sheet->setCellValue("E$cellTotal", "=SUM(E1:E$ant)");
        $sheet->setCellValue("E$cellIva", "=E$cellTotal*0,19");
        /*$sheet->setCellValue("E$cellNeto", "=E$cellNeto/1,19");*/
    }
}



$name = 'hello_world.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($name);
// redirect output to client browser
/*header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=$name");
            $writer->save("php://output");*/
print("Termino");
exit;
