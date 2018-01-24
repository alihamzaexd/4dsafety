<?php
class SignupHandler{
	// function to valide user sign up interms to username and password
	function validateSignup(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$firstName = $_POST['account_firstname'];
		//$_SESSION['firstName'] = $_POST['account_firstname'];
		
		$username = $_POST['account_username'];
		//$_SESSION['username'] = $username;
		
		$email = $_POST['account_email'];
		//$_SESSION['email'] = $email;
		
		$password = $_POST['account_password'];
		//$_SESSION['password'] = $password;
		
		$confirmPassword = $_POST['account_confirm_password'];
		//$_SESSION['confirmPassword'] = $confirmPassword;
		
		// variable to hold error messages
		$errorMessage = null;
		if($password != $confirmPassword)
		{
			// update error massage
			$errorMessage = $errorMessage."<li>Password fields do not match.</li>";
		}
		$sql =<<<EOF
      SELECT * from PERSON where person_username = '{$username}';
EOF;
		$ret = pg_query($conn, $sql);
		$row = pg_fetch_row($ret);
		//echo count($row);
		if($row) 
		{
			$errorMessage = $errorMessage."<li> Username already exists.</li>";
		}
		if($errorMessage!= null){
			// show error to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<ul> ".$errorMessage." </ul>';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			return false;
		}else{
			return true;
		}	
	}// end of function

    // function to add new user to the database
	function addPerson(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$firstName = $_POST['account_firstname'];
		//$_SESSION['firstName'] = $_POST['account_firstname'];
		
		$username = $_POST['account_username'];
		//$_SESSION['username'] = $username;
		
		$email = $_POST['account_email'];
		//$_SESSION['email'] = $email;
		
		$password = $_POST['account_password'];
		//$_SESSION['password'] = $password;
	
		 $sql =<<<EOF
      INSERT INTO PERSON (person_firstname,person_username,person_email,person_password)
      VALUES ('{$firstName}', '{$username}','{$email}','{$password}');
EOF;

        $res = pg_query($conn, $sql);

        if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Signup Successfull !</strong> Your account needs to be activated by administrator.';</script>";
			// make error div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
        }
	    else{
            echo "Failed";
        }
	}// end of function
	
	function login(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$username = $_POST['account_username'];
		$password = $_POST['account_password'];
		//$_SESSION['password'] = $password;
		
		$databasePassword; $databasePersonId; $databasePersonType;$databaseEmail;
			// AUTHENTICATION SECTION
   $sql =<<<EOF
      SELECT person_id,person_password,person_email,person_type from PERSON WHERE person_username = '{$username}' or person_email = '{$username}' ;
EOF;
	   $ret = pg_query($conn, $sql);
	   if(!$ret) {
			// show error to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Database connection error occured.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
	   }else{ 
			$databasePassword=null;
	        while($row = pg_fetch_row($ret)) {
			$databasePersonId = $row[0]; // storing person ID in session, will be used in future
			$databasePassword = $row[1]; // fetching password stored in database	
			$databaseEmail = $row[2]; // fetching email stored in database	
			$databasePersonType = $row[3]; // determines if user is admin type or normal user
		    }
		    # later, here validation from database is done
            if(($password != null) && ($password == $databasePassword)){
			    // fetching team role of the employee from database  accordinglly
			    $sql2 =<<<EOF
        		SELECT teamrole_name from TEAM_ROLE WHERE employee_id IN (SELECT employee_id from EMPLOYEE WHERE person_id = '{$databasePersonId}');
EOF;
	            $ret2 = pg_query($conn, $sql2);
				if($ret2){
					while($row = pg_fetch_row($ret2)){
					$_SESSION['role']= $row[0];
				    }
					$_SESSION['userType'] = $databasePersonType;
				}else{
				    unset($_SESSION['role']);
				}
				
				$_SESSION['valid'] = true;
				$_SESSION['personId'] = $databasePersonId;
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $databaseEmail;
				// show success message to the specified div
			    echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Login Successfull !</strong>';</script>";
			    // make error div visible
			    echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
				
				if($databasePersonType == 'user'){ // if one of users, will be sent to user home otherwise will be sent to admin home page
				    header('Refresh: 1; URL = userHome.php');
				}else{
				    header('Refresh: 1; URL = adminHome.php');
				}
		    }else{
			    // show error to the specified div
			    echo "<script>  document.getElementById('errorMessage').innerHTML = 'Incorrect Username or Password.';</script>";
			    // make error div visible
			    echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			}
		}
	}// end of login function

}	
?>