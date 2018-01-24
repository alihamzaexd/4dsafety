<?php

require_once(dirname(__FILE__).'/db_connect.php');
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();

	// brings all divisions in the selected company
	if(isset($_POST['changedCompany']))
	{ 	
	    $sql =<<<EOF
		    SELECT division_id,division_name from DIVISION WHERE division_id IN 
		      (SELECT DISTINCT division_id from COMPANY_OBJECT WHERE company_id = '{$_POST['changedCompany']}'
		      )
		    ;
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]}</option>";
			}
		}
		else{
			echo "<option value='' selected disabled> No company division found </option>";
		}	
	}

	// brings all departments in the selected division
	if(isset($_POST['changedDivision']))
	{ 	
	    $sql =<<<EOF
		    SELECT department_id,department_name from DEPARTMENT WHERE department_id IN 
		      (SELECT DISTINCT department_id from COMPANY_OBJECT WHERE company_id = '{$_POST['companyForDivision']}' AND division_id = '{$_POST['changedDivision']}'
		      )
		    ;
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]}</option>";
			}
		}
		else{
			echo "<option value='' selected disabled> No company department found </option>";
		}	
	}

	// brings sub-departments of the selected department
	if(isset($_POST['changedDepartment']))
	{ 	
	    $sql =<<<EOF
		    SELECT subdepartment_id,subdepartment_name from SUB_DEPARTMENT WHERE subdepartment_id IN 
		      (SELECT DISTINCT subdepartment_id from COMPANY_OBJECT WHERE company_id = '{$_POST['companyForDepartment']}' AND division_id = '{$_POST['divisionForDepartment']}' AND department_id = '{$_POST['changedDepartment']}' 
		      )
		    ;
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]}</option>";
			}
		}
		else{
			echo "<option value='' selected disabled> No sub-department found </option>";
		}	
	}
	
	// brings location of the selected sub-department
	if(isset($_POST['changedSubDepartment']))
	{ 	
	    $sql =<<<EOF
		    SELECT location_id,location_name from LOCATION WHERE location_id IN 
		      (SELECT DISTINCT location_id from COMPANY_OBJECT WHERE company_id = '{$_POST['companyForSubDepartment']}' AND division_id = '{$_POST['divisionForSubDepartment']}' AND department_id = '{$_POST['departmentForSubDepartment']}' AND subdepartment_id = '{$_POST['changedSubDepartment']}' 
		      )
		    ;
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]}</option>";
			}
		}
		else{
			echo "<option value='' selected disabled> No location found </option>";
		}	
	}
	
	// brings user for the filled company object information
	if(isset($_POST['getCoaches']))
	{ 	// selects only those employees who are coach
	    $sql =<<<EOF
		SELECT P.person_id,P.person_firstname,P.person_lastname FROM person as P, coach as C
		WHERE P.person_id = C.person_id
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]} {$row[2]}</option>";
			}
		}
		else{
			echo "<option value='' disabled> No Coach found. </option>";
		}	
	}
	
	// brings user for the filled company object information
	if(isset($_POST['getChampions']))
	{ 	// selects only those employees who are company users but also created as champion 
	    $sql = " SELECT per.person_id,per.person_firstname,per.person_lastname from PERSON as per, CHAMPION as   champ WHERE per.person_id IN
                (SELECT DISTINCT person_id from EMPLOYEE WHERE employee_id IN 
		            (SELECT DISTINCT emp.employee_id from EMPLOYEE as emp WHERE emp.employee_id IN
						(SELECT employee_id from EMPLOYEE WHERE position_id IN 
							(SELECT DISTINCT position_id from POSITION WHERE companyobj_id IN 
							  (SELECT DISTINCT companyobj_id from COMPANY_OBJECT WHERE company_id = '{$_POST['companyForChampion']}' AND division_id = '{$_POST['divisionForChampion']}' AND department_id = '{$_POST['departmentForChampion']}' AND subdepartment_id = '{$_POST['subdepartmentForChampion']}' AND location_id = '{$_POST['locationForChampion']}' 
							  )
							)
						)
				    )
				) AND per.person_id = champ.person_id;
				";
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
	            echo "<option value='{$row[0]}'";
				echo ">{$row[1]} {$row[2]}</option>";
			}
		}
		else{
			echo "<option value='' selected disabled> No Champion found. </option>";
		}	
	}
	
	// brings user for the filled company object information
	if(isset($_POST['changedChampion']))
	{ 	// selects only those employees who are just company users
	    $sql =<<<EOF
		SELECT person_id,person_firstname,person_lastname from PERSON WHERE person_id IN
                (SELECT person_id from EMPLOYEE WHERE employee_id IN 
		            (SELECT DISTINCT Emp.employee_id from TEAM_ROLE as TR,Employee as Emp 
					WHERE 
					Emp.employee_id NOT IN (SELECT employee_id from TEAM_ROLE) 
						AND Emp.employee_id IN 
						(SELECT employee_id from EMPLOYEE WHERE position_id IN 
							(SELECT DISTINCT position_id from POSITION WHERE companyobj_id IN 
							  (SELECT DISTINCT companyobj_id from COMPANY_OBJECT WHERE company_id = '{$_POST['companyForLeader']}' AND division_id = '{$_POST['divisionForLeader']}' AND department_id = '{$_POST['departmentForLeader']}' AND subdepartment_id = '{$_POST['subdepartmentForLeader']}' AND location_id = '{$_POST['locationForLeader']}'
							  )
							)
						)
				    )
				) AND person_id NOT IN (SELECT person_id FROM COACH) AND person_id NOT IN (SELECT person_id FROM CHAMPION)
		union
		SELECT person_id,person_firstname,person_lastname from PERSON WHERE person_id IN
			(SELECT person_id from EMPLOYEE WHERE employee_id IN 
				(SELECT employee_id from EMPLOYEE WHERE (select count(*) from    TEAM_ROLE)=0 AND position_id IN 
					(SELECT DISTINCT position_id from POSITION WHERE companyobj_id IN 
						(SELECT DISTINCT companyobj_id from COMPANY_OBJECT WHERE company_id =  '{$_POST['companyForLeader']}' AND division_id = '{$_POST['divisionForLeader']}' AND department_id = '{$_POST['departmentForLeader']}' AND subdepartment_id = '{$_POST['subdepartmentForLeader']}' AND location_id = '{$_POST['locationForLeader']}'
						)
					)
				)
			) AND person_id NOT IN (SELECT person_id FROM COACH) AND person_id NOT IN (SELECT person_id FROM CHAMPION)
		;
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
				if($row[0]!= $_POST['coachForLeader'] && $row[0]!= $_POST['changedChampion'] ) // to make sure that selected coach is not in these options
				{
				    echo "<option value='{$row[0]}'";
				    echo ">{$row[1]} {$row[2]}</option>";
			    }
			}
		}
		else{
			echo "<option value='' selected disabled> No Employee found. </option>";
		}	
	}

	
	// brings user for the filled company object information
	if(isset($_POST['changedTeamLeader']))
	{ 	// selects only those employees who are just company users but not selected as coach and champion
	    $sql =<<<EOF
		SELECT person_id,person_firstname,person_lastname from PERSON WHERE person_id IN
                (SELECT person_id from EMPLOYEE WHERE employee_id IN 
		            (SELECT DISTINCT Emp.employee_id from TEAM_ROLE as TR,Employee as Emp 
					WHERE 
					Emp.employee_id NOT IN (SELECT employee_id from TEAM_ROLE) 
						AND Emp.employee_id IN 
						(SELECT employee_id from EMPLOYEE WHERE position_id IN 
							(SELECT DISTINCT position_id from POSITION WHERE companyobj_id IN 
							  (SELECT DISTINCT companyobj_id from COMPANY_OBJECT WHERE company_id = '{$_POST['companyForTeamMember']}' AND division_id = '{$_POST['divisionForTeamMember']}' AND department_id = '{$_POST['departmentForTeamMember']}' AND subdepartment_id = '{$_POST['subdepartmentForTeamMember']}' AND location_id = '{$_POST['locationForTeamMember']}'
							  )
							)
						)
				    )
				) AND person_id NOT IN (SELECT person_id FROM COACH) AND person_id NOT IN (SELECT person_id FROM CHAMPION)
		union
		SELECT person_id,person_firstname,person_lastname from PERSON WHERE person_id IN
			(SELECT person_id from EMPLOYEE WHERE employee_id IN 
				(SELECT employee_id from EMPLOYEE WHERE (select count(*) from    TEAM_ROLE)=0 AND position_id IN 
					(SELECT DISTINCT position_id from POSITION WHERE companyobj_id IN 
						(SELECT DISTINCT companyobj_id from COMPANY_OBJECT WHERE company_id =  '{$_POST['companyForTeamMember']}' AND division_id = '{$_POST['divisionForTeamMember']}' AND department_id = '{$_POST['departmentForTeamMember']}' AND subdepartment_id = '{$_POST['subdepartmentForTeamMember']}' AND location_id = '{$_POST['locationForTeamMember']}'
						)
					)
				)
			) AND person_id NOT IN (SELECT person_id FROM COACH) AND person_id NOT IN (SELECT person_id FROM CHAMPION)
		;
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			while($row = pg_fetch_row($res)) 
			{
			if($row[0]!= $_POST['coachForTeamMember'] && $row[0]!= $_POST['changedTeamLeader'] && $row[0]!= $_POST['championForTeamMember'] ) // to make sure that selected coach is not in these options
				{
				echo "<option value='{$row[0]}'";
				echo ">{$row[1]} {$row[2]}</option>";
				}
			}
		}
		else{
			echo "<option value='' selected disabled> No Team member found. </option>";
		}	
	}



?>