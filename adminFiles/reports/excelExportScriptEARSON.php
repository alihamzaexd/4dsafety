<?php

require_once(dirname(__FILE__).'/../../PHPExcel/IOFactory.php');
require_once(dirname(__FILE__).'/../../PHPExcel/PHPExcel.php');
$objPHPExcel = new PHPExcel();

require_once(dirname(__FILE__).'/../../db_connect.php');
$connectionClass = new DB_CONNECT();
$conn  = $connectionClass->connect();
///////////////////// Styling ///////////////////////
$heading = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => '0000FF'),
		'size'  => 10,
		'name'  => 'Arial'
	),
  );
$styleArray = array(
	'font'  => array(
		'bold'  => true
	)
  );   
$bgColor = array(
	'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'E94848')
	)
  ); 
$bgColor1 = array(
	'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4AD100')
	)
  );   
$BtStyle = array(
  'borders' => array(
	'top' => array(
	  'style' => PHPExcel_Style_Border::BORDER_THIN
	)
  )
);
$BiStyle = array(
  'borders' => array(
	'inside' => array(
	  'style' => PHPExcel_Style_Border::BORDER_THIN
	)
  )
);

$BStyle = array(
  'borders' => array(
	'outline' => array(
	  'style' => PHPExcel_Style_Border::BORDER_THIN
	)
  )
);

///////////////////////// Main Sheet ////////////////////////
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Users');

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('4DSafety');
$objDrawing->setDescription('4DSafety logo');
$objDrawing->setPath(dirname(__FILE__).'/../../asset/image/4dlogo.png');
$objDrawing->setCoordinates('A1');                      
//setOffsetX works properly
$objDrawing->setOffsetX(10); 
$objDrawing->setOffsetY(10);                
//set width, height
$objDrawing->setWidth(150); 
$objDrawing->setHeight(70); 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Main Heading of the Report 
$objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($heading); // applying heading styles
// setting width of columns
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);

$reportId;
$reportId = $_GET['id'];
//========================================== SSLR Report Export ================================================//
$objPHPExcel->getActiveSheet()->getCell('B2')->setValue('EARS ON 4 Safety Review');    
$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->SetCellValue('A6','Team Name');
$objPHPExcel->getActiveSheet()->SetCellValue('B6','Company Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C6','Date');
$objPHPExcel->getActiveSheet()->SetCellValue('D6','Time');
$objPHPExcel->getActiveSheet()->SetCellValue('E6','Created by');
$objPHPExcel->getActiveSheet()->SetCellValue('F6','Created on');
$objPHPExcel->getActiveSheet()->SetCellValue('G6','Updated by');
$objPHPExcel->getActiveSheet()->SetCellValue('H6','Updated on');
$objPHPExcel->getActiveSheet()->SetCellValue('I6','Improvement');
$objPHPExcel->getActiveSheet()->SetCellValue('J6','Task Done');
$objPHPExcel->getActiveSheet()->SetCellValue('K6','Text Note');
$objPHPExcel->getActiveSheet()->SetCellValue('L6','Question 1');
$objPHPExcel->getActiveSheet()->SetCellValue('M6','Question 2');
$objPHPExcel->getActiveSheet()->SetCellValue('N6','Question 3');
$objPHPExcel->getActiveSheet()->SetCellValue('O6','Question 4');
$objPHPExcel->getActiveSheet()->SetCellValue('P6','Question 5');
$objPHPExcel->getActiveSheet()->SetCellValue('Q6','Question 6');
$objPHPExcel->getActiveSheet()->SetCellValue('R6','Question 7');
$objPHPExcel->getActiveSheet()->SetCellValue('S6','Question 8');

// query to fetch team name 
$teamNameQuery = "SELECT team_name from TEAM  where team_id IN (Select team_id from EARSON where earson_id = '{$reportId}')";
$teamNameResult = pg_query($teamNameQuery) or die ($teamNameQuery);
$teamNameRow=pg_fetch_row($teamNameResult);
$teamName = $teamNameRow[0];

// query to fetch company name 
$companyNameQuery = "SELECT company_name from COMPANY  where company_id IN (Select company_id from EARSON where earson_id = '{$reportId}')";
$companyNameResult = pg_query($companyNameQuery) or die ($companyNameQuery);
$companyNameRow=pg_fetch_row($companyNameResult);
$companyName = $companyNameRow[0];

// report data retrival from databse.
$query = "Select * from EARSON where earson_id = '{$reportId}';";
$export = pg_query($query) or die ($query);

// pointer of location/cell to write data
$rowcount1 = 7; 
while($row=pg_fetch_row($export))
{
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowcount1,$teamName); // team name
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowcount1,$companyName); // company name
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowcount1,$row[2]); // date
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowcount1,$row[3]); // time
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowcount1,$row[20]); // created by
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowcount1,$row[5]); // created on
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowcount1,$row[21]); // updated by
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowcount1,$row[4]); // updated on
	$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowcount1,$row[15]); // improvement
	$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowcount1,$row[6]); // task done
	$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowcount1,$row[17]); // text note
	$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowcount1,$row[7]); // Question 1
	$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowcount1,$row[8]); // Question 2
	$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowcount1,$row[9]); // Question 3
	$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowcount1,$row[10]); // Question 4
	$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowcount1,$row[11]); // Question 5
	$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowcount1,$row[12]); // Question 6
	$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowcount1,$row[13]); // Question 7
	$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowcount1,$row[14]); // Question 8
	// moving pointer row wise.
	$rowcount1++;
}
$rowcount1 = $rowcount1-1;
// applying formating to written columns
$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A7:S7')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->applyFromArray($BiStyle);
$objPHPExcel->getActiveSheet()->getStyle('A7:S7')->applyFromArray($BiStyle);
//===============================================================================================================//

ob_end_clean();
ob_start();
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=EARS ON 4 Safety Review.xls");
header("Pragma: no-cache");
header("Expires: 0");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>
