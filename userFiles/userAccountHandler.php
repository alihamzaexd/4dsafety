<?php

class UserAccountHandler{
	
	// function to fetch user detials from database
	function getUserPersonalDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$sql =<<<EOF
      SELECT * from PERSON where person_username = '{$username}' or person_email = '{$email}';
EOF;
		$ret = pg_query($conn, $sql);
		$row = pg_fetch_row($ret);
		if($row) 
		{
		    $_SESSION['firstName'] = $row[0];
			$_SESSION['middleName'] = $row[15];
			$_SESSION['lastName'] = $row[1];
			$_SESSION['username'] = $row[2];
			$_SESSION['gender'] = $row[4];
			$_SESSION['nationality'] = $row[5];
			$_SESSION['bloodGroup'] = $row[8];
			$_SESSION['cnic'] = $row[7];
			$_SESSION['dob'] = $row[16];
			$_SESSION['email'] = $row[21];
			$_SESSION['maritalStatus'] = $row[6];
		}else{
				// show error message to the specified div
				echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing account details.';</script>";
				// make error div visible
				echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to fetch user detials from database
	function updateUserPersonalDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();

		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$firstName = $_POST['firstName'];
		$middleName = $_POST['middleName'];
		$lastName = $_POST['lastName'];
		$cnic = $_POST['cnic'];
		$dob = $_POST['dob'];
		$nationality = $_POST['nationality'];
		$bloodGroup = $_POST['bloodGroup'];
		$gender = $_POST['gender'];
		$maritalStatus = $_POST['maritalStatus'];
		
		$sql =<<<EOF
		UPDATE PERSON SET 
		person_firstname = '{$firstName}',
        person_middlename = '{$middleName}',
		person_lastname = '{$lastName}',
		person_nic = '{$cnic}',
		person_dob = '{$dob}',
		person_blood = '{$bloodGroup}',
		person_gender = '{$gender}',
		person_nationality = '{$nationality}',
		person_maritalstatus = '{$maritalStatus}'
		WHERE person_username = '{$username}' or person_email = '{$email}';
EOF;
		$res = pg_query($conn, $sql);

		if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'Personal details updated successfully!';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		}
		else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in connection. Personal details cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	
	// function to fetch user address detials from database
	function getUserAddressDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();

		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$sql =<<<EOF
      SELECT add.address_line1,add.address_state,add.address_city,add.address_country,add.address_zip,add.address_description from PERSON as prs,ADDRESS as add where (prs.person_username = '{$username}' or prs.person_email = '{$email}') and prs.address_id = add.address_id;
EOF;
		$ret = pg_query($conn, $sql);
		$row = pg_fetch_row($ret);
		if($row) 
		{
		    $_SESSION['address'] = $row[0];
			$_SESSION['state'] = $row[1];
			$_SESSION['city'] = $row[2];
			$_SESSION['country'] = $row[3];
			$_SESSION['zip'] = $row[4];
			$_SESSION['addressDescription'] = $row[5];
		}else{
				// show error message to the specified div
				echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing account details.';</script>";
				// make error div visible
				echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	
	// function to fetch user contact detials from database
	function getUserContactDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$sql =<<<EOF
      SELECT cnt.contact_fax,cnt.contact_mobile,cnt.contact_landline from PERSON as prs,CONTACT as cnt where (prs.person_username = '{$username}' or prs.person_email = '{$email}') and prs.contact_id = cnt.contact_id;
EOF;
		$ret = pg_query($conn, $sql);
		$row = pg_fetch_row($ret);
		if($row) 
		{
			$_SESSION['fax'] = $row[0];
			$_SESSION['mobile'] = $row[1];
			$_SESSION['landline'] = $row[2];
		}else{
				// show error message to the specified div
				echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing account details.';</script>";
				// make error div visible
				echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function

	// function to update user contact detials
	function updateUserContactDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();

		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$mobile = $_POST['mobile'];
		$landline = $_POST['landline'];
		$fax = $_POST['fax'];
		$date = date("Y-m-d",time());
		
		$sql =<<<EOF
		UPDATE CONTACT SET 
		contact_email = '{$email}',
        contact_mobile = '{$mobile}',
		contact_landline = '{$landline}',
		contact_fax = '{$fax}',
		contact_updatedby = '{$username}',
		contact_updationdate = '{$date}'
		WHERE contact_createdby = '{$username}' OR contact_createdby = '{$email}';
EOF;
		$res = pg_query($conn, $sql);

		if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'Contact details updated successfully!';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		}
		else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in connection. Contact details cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to update user contact detials
	function updateUserAddressDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();

		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$zip = $_POST['zip'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$description = $_POST['addressDescription'];
        $date = date("Y-m-d",time());
		
		$sql =<<<EOF
		UPDATE ADDRESS SET 
        address_line1 = '{$address}',
		address_city = '{$city}',
		address_zip = '{$zip}',
		address_state = '{$state}',
		address_country = '{$country}',
		address_updatedby = '{$username}',
		address_description = '{$description}',
		address_updationdate = '{$date}'
		WHERE address_createdby = '{$username}' OR address_createdby = '{$email}';
EOF;
		$res = pg_query($conn, $sql);

		if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'Address details updated successfully!';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		}
		else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in connection. Address details cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
    // function to update user password
	function resetPassword(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		
		$newPassword = $_POST['new_password'];
		$confirmPassword = $_POST['confirm_password'];
		
		if($newPassword == $confirmPassword)
	   {	
			 $sql =<<<EOF
		  UPDATE PERSON SET person_password = '{$newPassword}' WHERE person_username = '{$username}' or person_email = '{$email}';
EOF;
			$res = pg_query($conn, $sql);

			if($res){
				// show success message to the specified div
				echo "<script>  document.getElementById('successMessage').innerHTML = 'Password updated successfully!';</script>";
				// make success div visible
				echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			}
			else{
				// show error message to the specified div
				echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in connection. Password cannot be updated';</script>";
				// make error div visible
				echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			}
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Password fields do not match. Type carefully.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	
	// function to fetch user Employee detials from database
	function getUserEmployeeDetails(){
		$teamsUnderEmployee = array();
		$companyobjUnderEmployee = array();
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$personId = $_SESSION['personId'];

		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		// fetching position and employee IDs of the person
		$sql1 =<<<EOF
		  SELECT employee_id,position_id,employee_startdate from EMPLOYEE WHERE person_id = '{$personId}';
EOF;
	   $ret1 = pg_query($conn, $sql1);
	   while($row = pg_fetch_row($ret1)){
		$_SESSION['employeeId'] = $row[0];
		$_SESSION['positionId'] = $row[1];
		$_SESSION['empHiringDate'] = $row[2];
		}
		
		// fetching team supervised by employee
		$sql2 =<<<EOF
		  SELECT team_id from TEAM_ROLE WHERE employee_id = '{$_SESSION['employeeId']}';
EOF;
	   $ret2 = pg_query($conn, $sql2);
	   while($row = pg_fetch_row($ret2)){
		array_push($teamsUnderEmployee,$row[0]);
		}
		$_SESSION['teamsUnderEmployee'] = $teamsUnderEmployee;
		
		// nested query for getting list of companies supervised by the employee
		$sql3 =<<<EOF
		  SELECT DISTINCT companyobj_id from TEAM WHERE team_id IN (SELECT team_id from TEAM_ROLE WHERE employee_id = '{$_SESSION['employeeId']}');
EOF;
	   $ret3 = pg_query($conn, $sql3);
	   while($row = pg_fetch_row($ret3)){
			array_push($companyobjUnderEmployee,$row[0]);
		}
		$_SESSION['companyobjUnderEmployee'] = $companyobjUnderEmployee;
		
		// fetching information about comapny, location, department and division where the employee is employed
		$sql4 =<<<EOF
		  SELECT company_id,department_id,division_id,location_id from COMPANY_OBJECT WHERE companyobj_id IN (SELECT companyobj_id from POSITION WHERE position_id = '{$_SESSION['positionId']}');
EOF;
	   $ret4 = pg_query($conn, $sql4);
	   while($row = pg_fetch_row($ret4)){
		$_SESSION['empCompanyId'] = $row[0];
		$_SESSION['empDepartmentId'] = $row[1];
		$_SESSION['empDivisionId'] = $row[2];
		$_SESSION['empLocationId'] = $row[3];
		}
		
		$sql5 =<<<EOF
		  SELECT company.company_name,company.company_sector,department.department_name,division.division_name,location.location_name 
		  from COMPANY,LOCATION,DEPARTMENT,DIVISION 
		  WHERE (company.company_id = '{$_SESSION['empCompanyId']}') 
		    AND (department.department_id = '{$_SESSION['empDepartmentId']}')
            AND (location.location_id = '{$_SESSION['empLocationId']}')
            AND (division.division_id = '{$_SESSION['empDivisionId']}');
EOF;
	   $ret5 = pg_query($conn, $sql5);
	   while($row = pg_fetch_row($ret5)){
			$_SESSION['empCompanyName'] = $row[0];
			$_SESSION['empCompanySector'] = $row[1];
			$_SESSION['empDepartmentName'] = $row[2];
			$_SESSION['empDivisionName'] = $row[3];
			$_SESSION['empLocationName'] = $row[4];
		}
		
		$sql6 =<<<EOF
		  SELECT position_name from POSITION WHERE position_id = '{$_SESSION['positionId']}';
EOF;
	   $ret6 = pg_query($conn, $sql6);
	   while($row = pg_fetch_row($ret6)){
		$_SESSION['empPositionName'] = $row[0];
		}
		
	}// end of function
	
	
	// function to update user profile picture
	function updateUserProfilePicture(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();

		$username = $_SESSION['username'];
		// image upload section 
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    echo "<script>  document.getElementById('errorMessage').innerHTML = 'Sorry, your file is too large.';</script>";
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Sorry, only JPG, JPEG & PNG files are allowed.';</script>";
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Sorry, your file was not uploaded.';</script>";
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$sql =<<<EOF
					UPDATE PERSON SET 
					person_pic = '{$target_file}'
					WHERE person_username = '{$username}';
EOF;
					$res = pg_query($conn, $sql);
					if($res){
						// show success message to the specified div
						echo "<script>  document.getElementById('successMessage').innerHTML = 'Picture updated successfully!';</script>";
						// make success div visible
						echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
					}
					else{
						// show error message to the specified div
						echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem occured! Picture cannot be updated';</script>";
						// make error div visible
						echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
					}
				echo "<script>  document.getElementById('successMessage').innerHTML = 'Picture updated successfully!';</script>";
			    echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			} else {
				echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem occured. Picture cannot be updated';</script>";
			    echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			}
		} // end of image uploadOk if
	}// end of function
	
	
} // end of class	
?>