<?php
// include database connection file
require_once(dirname(__FILE__).'/../db_connect.php');
// starting session
session_start();
// creating database connection
$connectionClass = new DB_CONNECT();
$conn  = $connectionClass->connect();
 	
    $sql =<<<EOF
	    SELECT person_pic from PERSON WHERE person_username = '{$_SESSION['username']}';
EOF;
	$res = pg_query($conn, $sql);
	if($res){ // if there is some result
		$row = pg_fetch_row($res);
        if($row[0])		
		{
		    echo $row[0]; // echo fetched image link
		}else{
		    // otherwise return default profile image link
		    echo "asset/image/defaultUserProfile.png";
		}
	}else{
	    // else return default profile image link
	    echo "asset/image/defaultUserProfile.png";
	}
?>