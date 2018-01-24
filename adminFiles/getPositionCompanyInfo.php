<?php
require_once(dirname(__FILE__).'/../db_connect.php');
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();

	// brings company name, department name, division name and location name of the selected position
	if(isset($_POST['changedPosition']))
	{ 	
	    $sql =<<<EOF
		    SELECT comp.company_name,div.division_name,dept.department_name,sdept.subdepartment_name,loc.location_name 
			from COMPANY as comp,DIVISION as div, Department as dept,SUB_Department as sdept, LOCATION as loc,POSITION as pos,COMPANY_OBJECT as co
			WHERE pos.position_id = '{$_POST['changedPosition']}' AND pos.companyobj_id = co.companyobj_id
			AND comp.company_id = co.company_id AND div.division_id = co.division_id
			AND dept.department_id = co.department_id AND sdept.subdepartment_id = co.subdepartment_id AND loc.location_id = co.location_id
		    ;
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
				echo '<div class="form-group col-md-6">				
		        	<label class="string required"> Company: </label>';echo " ".$row[0]; 
				echo '</div>
				<div class="form-group col-md-6">
		        	<label class="string required">Division: </label>';echo " ".$row[1];
		      	echo '</div>
				<div class="form-group col-md-6">
		        	<label class="string required"> Department: </label>';echo " ".$row[2];
				echo '</div>
				<div class="form-group col-md-6">
		        	<label class="string required"> Sub-Department: </label>';echo " ".$row[3];
		      	echo '</div>
				<div class="form-group col-md-6">				
		        	<label class="string required">Location: </label>';echo " ".$row[4];
				echo '</div>';
			}
		}
		else{
			echo "<label>No company information found for the selected position</label>";
		}	
	}
	
?>