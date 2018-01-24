<?php
require_once(dirname(__FILE__).'/../db_connect.php');
//require_once(dirname(__FILE__).'/../PHPExcel.php');
    // building database connection
		
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();
	
	/*
	$sql =<<<EOF
      SELECT sslr_id,sslr.date,t.team_name,comp.company_name,p.person_firstname,p.person_lastname
	  FROM COMPANY as comp, TEAM as t, PERSON as p,SSLR
	  WHERE sslr.team_id = t.team_id AND comp.company_id = sslr.company_id 
	        AND p.person_username = sslr.created_by;
EOF;
        $reportName = "Site Safety Leadership Review";
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			echo $reportName." ";
			print_r($row);
			echo "<br>";
		    }
		}else{
		    echo "no result found.";
		}
		
    */
	// php code for generating an excel file
	$output = '';
	$sql1 =<<<EOF
      SELECT * from PERSON where person_id<10;
EOF;
		$ret1 = pg_query($conn, $sql1);
		if($ret1){
		    $output .= '
			<table class="table" border="1px solid black">
			    <tr >
				    <th style="background-color:#85C1E9;">First Name</th>
					<th style="background-color:#85C1E9;">Last Name</th>
					<th style="background-color:#85C1E9;">Username</th>
				</tr>
				';
				
		    while($row = pg_fetch_row($ret1)) 
		    {
			 $output .= '
			    <tr>
				    <td style="background-color:#D6EAF8;">'.$row[0].'</td>
					<td style="background-color:#F2F3F4;">'.$row[1].'</td>
					<td style="background-color:#D6EAF8;">'.$row[2].'</td>
				</tr>
				';
		    }
			$output .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=4DsafetyUsers.xls");
            echo "<h2>Test Export Users</h2>".$output; 			
		}else{
		    echo "no result found.";
		}

?>


