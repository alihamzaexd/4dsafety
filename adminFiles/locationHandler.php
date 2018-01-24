<?php
require_once(dirname(__FILE__).'/../db_connect.php');
// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		echo "<script> alert('function called');</script>";
		if(isset($_POST['deleteLocationId']))
		{
		  echo "<script> alert('function called');</script>";
		  $locationId = $_POST['deleteLocationId']; // id of the location to be delete
		  $sql =<<<EOF
      DELETE from LOCATION WHERE location_id = {$locationId};
EOF;
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show error message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'Location deleted successfully.';</script>";
			// make error div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in location deletion.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
		}

		
		
?>