<?php
require_once(dirname(__FILE__).'/../db_connect.php');
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();

	// checks either an email exists in database or not
	if(isset($_POST['changedEmail']))
	{ 	
	    $email = strtolower($_POST['changedEmail']);
		$username = strtolower($_POST['currentUsername']);
	    $sqlEmail =<<<EOF
		    SELECT count(*) from person WHERE person_email = '{$email}'; 
EOF;
		$sqlUsername =<<<EOF
		    SELECT count(*) from person WHERE person_username = '{$username}'; 
EOF;
		$resEmail = pg_query($conn, $sqlEmail);
		$rowEmail = pg_fetch_row($resEmail) ;
		
		$resUsername = pg_query($conn, $sqlUsername);
		$rowUsername = pg_fetch_row($resUsername) ;
		if($rowUsername[0]>0 && $rowEmail[0]>0){
		    echo "invalid both";
		}else if($rowUsername[0]>0)
		{
		    echo "invalid username";
		}else if($rowEmail[0]>0 )
		{
		    echo "invalid email";
		}
		else{
			echo "valid";
		}	
	}
	
	// checks either a username exists in database or not
	if(isset($_POST['changedUsername']))
	{ 	
	    $username = strtolower($_POST['changedUsername']);
		$email = strtolower($_POST['currentEmail']);
	     $sqlEmail =<<<EOF
		    SELECT count(*) from person WHERE person_email = '{$email}'; 
EOF;
		$sqlUsername =<<<EOF
		    SELECT count(*) from person WHERE person_username = '{$username}'; 
EOF;
		$resEmail = pg_query($conn, $sqlEmail);
		$rowEmail = pg_fetch_row($resEmail) ;
		
		$resUsername = pg_query($conn, $sqlUsername);
		$rowUsername = pg_fetch_row($resUsername) ;
		if($rowUsername[0]>0 && $rowEmail[0]>0){
		   echo "invalid both";
		}else if($rowUsername[0]>0)
		{
		    echo "invalid username";
		}else if($rowEmail[0]>0)
		{
		    echo "invalid email";
		}
		else{
			echo "valid";
		}	
	}
	
?>