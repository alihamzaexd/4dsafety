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
$objPHPExcel->getActiveSheet()->getCell('B2')->setValue('Site Safety Leadership Review');    
$objPHPExcel->getActiveSheet()->getStyle('A6:AE6')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A6:AE6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->SetCellValue('A6','Team Name');
$objPHPExcel->getActiveSheet()->SetCellValue('B6','Company Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C6','Date');
$objPHPExcel->getActiveSheet()->SetCellValue('D6','Time');
$objPHPExcel->getActiveSheet()->SetCellValue('E6','Created by');
$objPHPExcel->getActiveSheet()->SetCellValue('F6','Created on');
$objPHPExcel->getActiveSheet()->SetCellValue('G6','Updated by');
$objPHPExcel->getActiveSheet()->SetCellValue('H6','Updated on');
$objPHPExcel->getActiveSheet()->SetCellValue('I6','Comments');
$objPHPExcel->getActiveSheet()->SetCellValue('J6','Improvements');
$objPHPExcel->getActiveSheet()->SetCellValue('K6','Text Note');
$objPHPExcel->getActiveSheet()->SetCellValue('L6','Question 1');
$objPHPExcel->getActiveSheet()->SetCellValue('M6','Question 2');
$objPHPExcel->getActiveSheet()->SetCellValue('N6','Question 3');
$objPHPExcel->getActiveSheet()->SetCellValue('O6','Question 4');
$objPHPExcel->getActiveSheet()->SetCellValue('P6','Question 5');
$objPHPExcel->getActiveSheet()->SetCellValue('Q6','Question 6');
$objPHPExcel->getActiveSheet()->SetCellValue('R6','Question 7');
$objPHPExcel->getActiveSheet()->SetCellValue('S6','Question 8');
$objPHPExcel->getActiveSheet()->SetCellValue('T6','Question 9');
$objPHPExcel->getActiveSheet()->SetCellValue('U6','Question 10');
$objPHPExcel->getActiveSheet()->SetCellValue('V6','Question 11');
$objPHPExcel->getActiveSheet()->SetCellValue('W6','Question 12');
$objPHPExcel->getActiveSheet()->SetCellValue('X6','Question 13');
$objPHPExcel->getActiveSheet()->SetCellValue('Y6','Question 14');
$objPHPExcel->getActiveSheet()->SetCellValue('Z6','Question 15');
$objPHPExcel->getActiveSheet()->SetCellValue('AA6','Question 16');
$objPHPExcel->getActiveSheet()->SetCellValue('AB6','Question 17');
$objPHPExcel->getActiveSheet()->SetCellValue('AC6','Question 18');
$objPHPExcel->getActiveSheet()->SetCellValue('AD6','Question 19');
$objPHPExcel->getActiveSheet()->SetCellValue('AE6','Question 20');

// query to fetch team name 
$teamNameQuery = "SELECT team_name from TEAM  where team_id IN (Select team_id from SSLR where sslr_id = '{$reportId}')";
$teamNameResult = pg_query($teamNameQuery) or die ($teamNameQuery);
$teamNameRow=pg_fetch_row($teamNameResult);
$teamName = $teamNameRow[0];

// query to fetch company name 
$companyNameQuery = "SELECT company_name from COMPANY  where company_id IN (Select company_id from SSLR where sslr_id = '{$reportId}')";
$companyNameResult = pg_query($companyNameQuery) or die ($companyNameQuery);
$companyNameRow=pg_fetch_row($companyNameResult);
$companyName = $companyNameRow[0];

// report data retrival from databse.
$query = "Select * from SSLR where sslr_id = '{$reportId}';";
$export = pg_query($query) or die ($query);

// pointer of location/cell to write data
$rowcount1 = 7; 
while($row=pg_fetch_row($export))
{
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowcount1,$teamName); // team name
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowcount1,$companyName); // company name
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowcount1,$row[2]); // date
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowcount1,$row[3]); // time
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowcount1,$row[72]); // created by
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowcount1,$row[5]); // created on
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowcount1,$row[73]); // updated by
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowcount1,$row[5]); // updated on
	$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowcount1,$row[37]); // comments
	$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowcount1,$row[38]); // improvements
	$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowcount1,$row[69]); // text note
	$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowcount1,$row[6].",".$row[7].",".$row[8]); // Question 1
	$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowcount1,$row[9].",".$row[10].",".$row[11]); // Question 2
	$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowcount1,$row[12].",".$row[13].",".$row[14]); // Question 3
	$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowcount1,$row[15].",".$row[16].",".$row[17]); // Question 4
	$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowcount1,$row[18].",".$row[19].",".$row[20]); // Question 5
	$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowcount1,$row[21].",".$row[22].",".$row[23]); // Question 6
	$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowcount1,$row[24].",".$row[25].",".$row[26]); // Question 7
	$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowcount1,$row[27].",".$row[28].",".$row[29]); // Question 8
	$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowcount1,$row[30].",".$row[31].",".$row[32]); // Question 9
	$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowcount1,$row[33].",".$row[34].",".$row[35]); // Question 10
	$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowcount1,$row[39].",".$row[40].",".$row[41]); // Question 11
	$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowcount1,$row[42].",".$row[43].",".$row[44]); // Question 12
	$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowcount1,$row[45].",".$row[46].",".$row[47]); // Question 13
	$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowcount1,$row[48].",".$row[49].",".$row[50]); // Question 14
	$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowcount1,$row[51].",".$row[52].",".$row[53]); // Question 15
	$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowcount1,$row[54].",".$row[55].",".$row[56]); // Question 16
	$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowcount1,$row[57].",".$row[58].",".$row[59]); // Question 17
	$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowcount1,$row[60].",".$row[61].",".$row[62]); // Question 18
	$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowcount1,$row[63].",".$row[64].",".$row[65]); // Question 19
	$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowcount1,$row[66].",".$row[67].",".$row[68]); // Question 20
	// moving pointer row wise.
	$rowcount1++;
}
$rowcount1 = $rowcount1-1;
// applying formating to written columns
$objPHPExcel->getActiveSheet()->getStyle('A6:AE6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A7:AE7')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A6:AE6')->applyFromArray($BiStyle);
$objPHPExcel->getActiveSheet()->getStyle('A7:AE7')->applyFromArray($BiStyle);
//===============================================================================================================//

ob_end_clean();
ob_start();
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=Site Safety Leadership Review.xls");
header("Pragma: no-cache");
header("Expires: 0");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

file_put_contents('excel.txt',"donw with file downloading");


?>
