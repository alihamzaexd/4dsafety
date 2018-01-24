<?php 
	session_start();
	require_once(dirname(__FILE__).'/db_connect.php');
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();
	if(isset($_POST['changedCompany']))
	{ 	
		$sqlTeams = "SELECT team_name,team_id from TEAM WHERE companyobj_id IN (SELECT companyobj_id from COMPANY_OBJECT WHERE company_id = '{$_POST['changedCompany']}')";
		$resTeams = pg_query($conn, $sqlTeams);
		
		if($resTeams){
			while($row = pg_fetch_row($resTeams)) 
			{
				echo "<option value='{$row[1]}'";
				if(($_SESSION['teamsUnderEmployee'][0]==$row[1]) && ($_SESSION['role'] == 'team leader'))
				{echo "selected";}
				if(($_SESSION['teamsUnderEmployee'][0]==$row[1]) && ($_SESSION['role'] == 'team member'))
				{echo "selected";}
				echo ">{$row[0]} </option>";
			}
		}
		else{
			echo "<option value='' selected disabled> No team found </option>";
		}	
	}
	
	if(isset($_POST['changedTeam']))
	{ 	
	    $sqlTeamLeader = "
		SELECT person_id,person_firstname,person_lastname from PERSON WHERE person_id IN 
		  (SELECT person_id from EMPLOYEE WHERE employee_id IN 
		    (SELECT employee_id from TEAM_ROLE WHERE teamrole_name = 'team leader' AND team_id = '  {$_POST['changedTeam']}'
		    )
		  )
		";
		$resLeader = pg_query($conn, $sqlTeamLeader);
		
		if($resLeader){
			while($row = pg_fetch_row($resLeader)) 
			{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]} {$row[2]}</option>";
			}
		}
	}
	
	if(isset($_POST['memberOfChangedTeam']))
	{ 	
	    $sqlTeamLeader = "
		SELECT person_id,person_firstname,person_lastname from PERSON WHERE person_id IN 
		  (SELECT person_id from EMPLOYEE WHERE employee_id IN 
		    (SELECT employee_id from TEAM_ROLE WHERE team_id = '{$_POST['memberOfChangedTeam']}')
		  )
		";
		$resLeader = pg_query($conn, $sqlTeamLeader);
		
		if($resLeader){
			while($row = pg_fetch_row($resLeader)) 
			{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]} {$row[2]}</option>";
			}
		}
	}
	
?>