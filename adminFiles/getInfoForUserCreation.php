<?php
require_once(dirname(__FILE__).'/../db_connect.php');
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();

	// brings company name, department name, division name and location name of the selected position
	if(isset($_POST['changedPosition']))
	{ 	
	 echo "<script> 
			championAccountSelect = document.getElementById('championSelect');
		 </script>";
		 
	   $sql =<<<EOF
		SELECT champ.champion_id,p.person_firstname,p.person_lastname
		FROM PERSON as p, EMPLOYEE as emp,CHAMPION as champ
		WHERE p.person_id = champ.person_id AND p.person_id = emp.person_id
		  AND emp.position_id = '{$_POST['changedPosition']}';  
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			echo "";
			while($row = pg_fetch_row($res)) 
			{
			    echo  "<option value='{$row[0]}'> {$row[1]} {$row[2]} </option>";
			}
		}
		
	   
	}
?>