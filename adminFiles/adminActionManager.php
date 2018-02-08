<?php
require_once(dirname(__FILE__).'/../db_connect.php');
class AdminActionManager{
	
									//||=============================||
									//||    Admin Location Module    ||
									//||=============================||
	
	// function to fetch locations detials from database
	function getLocations(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
      SELECT * from LOCATION;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[9]} value={$row[9]}> <td>{$row[9]}</td> <td>{$row[1]}</td> <td>{$row[0]}</td> 
			  <td>
				<a onClick='getSpecificLocation({$row[9]})'>edit</a>
				<button class='btn btn-xs btn-danger' onClick='removeLocation({$row[9]})' > delete </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Locations.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to fetch locations detials from database
	function getSpecificLocations($locationId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$name="";$code="";$desc="";
		
		$sql =<<<EOF
      SELECT * from LOCATION WHERE location_id={$locationId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  $name = $row[1];
			  $code = $row[0];
			  $desc = $row[2];
			  $id = $row[9];
			  $_SESSION['editLocationId'] = $id;
		    }
			echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminLocationsContent()">
					<i class="fa fa-map-marker" aria-hidden="true"></i> Locations
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit location
				  </a>
				</li>
			</ul>
			     <div id="updateLocation" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Location</h4>
	  	           </div>
		           <div class="panel-body">
					 <form id="editLocationForm" action="" method="post">
					 <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editLocationId" id="editLocationId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<label>
						<b>Name: </b></label>  
						<input type="text" name="editLocationName" id="editLocationName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						<br>
						<label>
						<b>Code: </b></label>  
						<input type="text" id="editLocationCode" name="editLocationCode" class="form-control"
						value='; echo "'{$code}'"; echo'>
						<br>
						<label>
						<b>Description: </b></label>  
						<input type="text" id="editLocationDescription" name="editLocationDescription" class="form-control"
						value='; echo "'{$desc}'"; echo'>
						<br>
						<button name="updateLocation" type="submit" class="btn btn-primary">Save</button>
					</form>	
				</div>
			</div>
		</div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Locations.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete location reuqested for
	function deleteLocations($locationId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =" DELETE from LOCATION WHERE location_id={$locationId}; ";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function addLocations(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$locationName = $_POST['locationName'];
		$locationCode  = $_POST['locationCode'];
		$locationDesc  = $_POST['locationDesc'];
		$sql ="INSERT into LOCATION(location_code,location_name,location_description) VALUES('{$locationCode}','{$locationName}','{$locationDesc}');";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Location added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Location cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	function updateLocations(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$locationName = $_POST['editLocationName'];
		$locationCode  = $_POST['editLocationCode'];
		$locationId  = $_POST['editLocationId'];
		$locationDesc = $_POST['editLocationDescription'];
		$sql ="UPDATE LOCATION SET location_code='{$locationCode}',location_name='{$locationName}',location_description='{$locationDesc}' WHERE location_id={$locationId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Location updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Location cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
//================================================================================================================//
		
									//||=============================||
									//||    Admin Division Module    ||
									//||=============================||

    // function to fetch divisions detials from database
	function getDivisions(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
      SELECT * from DIVISION;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[9]} value={$row[9]}> <td>{$row[9]}</td> <td>{$row[1]}</td> <td>{$row[0]}</td> 
			  <td>
				<a onClick='getSpecificDivision({$row[9]})'>edit</a>
				<button class='btn btn-xs btn-danger' onClick='removeDivision({$row[9]})' > delete </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing divisions.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to fetch divisions detials from database
	function getSpecificDivisions($divisionId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$name="";$code="";$desc="";
		
		$sql =<<<EOF
      SELECT * from DIVISION WHERE division_id={$divisionId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  $row = pg_fetch_row($ret); 
		  $name = $row[1];
		  $code = $row[0];
		  $desc = $row[2];
		  $id = $row[9];
		  $_SESSION['editDivisionId'] = $id;
		    
			echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminDivisionsContent()">
					Divisions
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit division
				  </a>
				</li>
			</ul>
			     <div id="updateDivision" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Division</h4>
	  	           </div>
		           <div class="panel-body">
					 <form id="editDivisionForm" action="" method="post">
					 <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editDivisionId" id="editDivisionId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<label>
						<b>Name: </b></label>  
						<input type="text" name="editDivisionName" id="editDivisionName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						<br>
						<label>
						<b>Code: </b></label>  
						<input type="text" id="editDivisionCode" name="editDivisionCode" class="form-control"
						value='; echo "'{$code}'";echo'>
						<br>
						<b>Description: </b></label>  
						<input type="text" id="editDivisionDescription" name="editDivisionDescription" class="form-control"
						value='; echo "'{$desc}'"; echo'>
						<br>
						<button name="updateDivision" type="submit" class="btn btn-primary">Save</button>
					</form>	
				</div>
			</div>
		</div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Divisions.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete division reuqested for
	function deleteDivisions($divisionId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =" DELETE from DIVISION WHERE division_id={$divisionId}; ";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function addDivisions(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$divisionName = $_POST['divisionName'];
		$divisionCode  = $_POST['divisionCode'];
		$divisionDesc  = $_POST['divisionDesc'];
		$sql ="INSERT into DIVISION(division_code,division_name,division_description) VALUES('{$divisionCode}','{$divisionName}','{$divisionDesc}');";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Division added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Division cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	function updateDivisions(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$divisionName = $_POST['editDivisionName'];
		$divisionCode  = $_POST['editDivisionCode'];
		$divisionId  = $_POST['editDivisionId'];
		$divisionDesc  = $_POST['editDivisionDescription'];
		$sql ="UPDATE DIVISION SET division_code='{$divisionCode}',division_name='{$divisionName}',division_description='{$divisionDesc}' WHERE division_id={$divisionId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Division updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Division cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
//================================================================================================================//

									//||=============================||
									//||   Admin Department Module   ||
									//||=============================||

    // function to fetch Departments from database
	function getDepartments(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
      SELECT * from DEPARTMENT;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[9]} value={$row[9]}> <td>{$row[9]}</td> <td>{$row[1]}</td> <td>{$row[0]}</td> 
			  <td>
				<a onClick='getSpecificDepartment({$row[9]})'>edit</a>
				<button class='btn btn-xs btn-danger' onClick='removeDepartment({$row[9]})' > delete </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing departments.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to fetch Departments from database
	function getSpecificDepartments($departmentId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$name="";$code="";$desc="";
		
		$sql =<<<EOF
      SELECT * from DEPARTMENT WHERE department_id={$departmentId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  $row = pg_fetch_row($ret); 
		  $name = $row[1];
		  $code = $row[0];
		  $desc = $row[2];
		  $id = $row[9];
		  $_SESSION['editDepartmentId'] = $id;
		    
			echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminDepartmentsContent()">
					Departments
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit department
				  </a>
				</li>
			</ul>
			     <div id="updateDepartment" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Department</h4>
	  	           </div>
		           <div class="panel-body">
					 <form id="editDepartmentForm" action="" method="post">
					 <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editDepartmentId" id="editDepartmentId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<label>
						<b>Name: </b></label>  
						<input type="text" name="editDepartmentName" id="editDepartmentName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						<br>
						<label>
						<b>Code: </b></label>  
						<input type="text" id="editDepartmentCode" name="editDepartmentCode" class="form-control"
						value='; echo "'{$code}'";echo'>
						<br>
						<b>Description: </b></label>  
						<input type="text" id="editDepartmentDescription" name="editDepartmentDescription" class="form-control"
						value='; echo "'{$desc}'"; echo'>
						<br>
						<button name="updateDepartment" type="submit" class="btn btn-primary">Save</button>
					</form>	
				</div>
			</div>
		</div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Departments.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete department reuqested for
	function deleteDepartments($departmentId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =" DELETE from DEPARTMENT WHERE department_id={$departmentId}; ";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function addDepartments(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$departmentName = $_POST['departmentName'];
		$departmentCode  = $_POST['departmentCode'];
		$departmentDesc  = $_POST['departmentDesc'];
		$sql ="INSERT into DEPARTMENT(department_code,department_name,department_description) VALUES('{$departmentCode}','{$departmentName}','{$departmentDesc}');";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Department added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Department cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	function updateDepartments(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$departmentName = $_POST['editDepartmentName'];
		$departmentCode  = $_POST['editDepartmentCode'];
		$departmentId  = $_POST['editDepartmentId'];
		$departmentDesc  = $_POST['editDepartmentDescription'];
		$sql ="UPDATE DEPARTMENT SET department_code='{$departmentCode}',department_name='{$departmentName}',department_description='{$departmentDesc}' WHERE department_id={$departmentId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Department updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Department cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
//================================================================================================================//

									//||=================================||
									//||   Admin Sub-Department Module   ||
									//||=================================||

    // function to fetch Sub-Departments from database
	function getSubDepartments(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
        SELECT subdepartment_id,subdepartment_name,subdepartment_code from SUB_DEPARTMENT;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$row[0]}</td> <td>{$row[1]}</td> <td>{$row[2]}</td> 
			  <td>
				<a onClick='getSpecificSubDepartment({$row[0]})'>edit</a>
				<button class='btn btn-xs btn-danger' onClick='removeSubDepartment({$row[0]})' > delete </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing sub-departments.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to fetch Sub-Departments from database
	function getSpecificSubDepartments($subdepartmentId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$name="";$code="";$desc="";
		
		$sql =<<<EOF
        SELECT subdepartment_id,subdepartment_name,subdepartment_code,subdepartment_description from SUB_DEPARTMENT WHERE subdepartment_id={$subdepartmentId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  $row = pg_fetch_row($ret);
          $id = $row[0];		  
		  $name = $row[1];
		  $code = $row[2];
		  $desc = $row[3];
		  $_SESSION['editSubDepartmentId'] = $id;
		    
			echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminSubDepartmentsContent()">
					Sub departments
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit sub-department
				  </a>
				</li>
			</ul>
			     <div id="updateSubDepartment" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Sub-Department</h4>
	  	           </div>
		           <div class="panel-body">
					 <form id="editSubDepartmentForm" action="" method="post">
					 <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editSubDepartmentId" id="editSubDepartmentId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<label>
						<b>Name: </b></label>  
						<input type="text" name="editSubDepartmentName" id="editSubDepartmentName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						<br>
						<label>
						<b>Code: </b></label>  
						<input type="text" id="editSubDepartmentCode" name="editSubDepartmentCode" class="form-control"
						value='; echo "'{$code}'";echo'>
						<br>
						<b>Description: </b></label>  
						<input type="text" id="editSubDepartmentDescription" name="editSubDepartmentDescription" class="form-control"
						value='; echo "'{$desc}'"; echo'>
						<br>
						<button name="updateSubDepartment" type="submit" class="btn btn-primary">Save</button>
					</form>	
				</div>
			</div>
		</div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Sub-Departments.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete sub-department reuqested for
	function deleteSubDepartments($subdepartmentId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =" DELETE from SUB_DEPARTMENT WHERE subdepartment_id={$subdepartmentId}; ";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function addSubDepartments(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$subdepartmentName = $_POST['subdepartmentName'];
		$subdepartmentCode  = $_POST['subdepartmentCode'];
		$subdepartmentDesc  = $_POST['subdepartmentDesc'];
		$sql ="INSERT into SUB_DEPARTMENT(subdepartment_code,subdepartment_name,subdepartment_description) VALUES('{$subdepartmentCode}','{$subdepartmentName}','{$subdepartmentDesc}');";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Sub-Department added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Sub-Department cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	function updateSubDepartments(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$subdepartmentName = $_POST['editSubDepartmentName'];
		$subdepartmentCode  = $_POST['editSubDepartmentCode'];
		$subdepartmentId  = $_POST['editSubDepartmentId'];
		$subdepartmentDesc  = $_POST['editSubDepartmentDescription'];
		$sql ="UPDATE SUB_DEPARTMENT SET subdepartment_code='{$subdepartmentCode}',subdepartment_name='{$subdepartmentName}',subdepartment_description='{$subdepartmentDesc}' WHERE subdepartment_id={$subdepartmentId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Sub-Department updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Sub-Department cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function 
//================================================================================================================//
									//||=============================||
									//||     Admin Team Module       ||
									//||=============================||

    // function to fetch Teams from database
	function getTeams(){
        // building database connection
	    $connectionClass = new DB_CONNECT();
	    $conn  = $connectionClass->connect();
	
	    $sql =<<<EOF
        SELECT T.team_id,T.team_name,T.team_tag,C.company_id,C.company_name from TEAM as T,COMPANY_OBJECT as CO,COMPANY as C
        WHERE (T.companyobj_id = CO.companyobj_id) AND (CO.company_id = C.company_id) ;
EOF;
	    $ret = pg_query($conn, $sql);
	    if($ret){
	    while($row = pg_fetch_row($ret)) 
		    {
		      echo "<tr id={$row[0]} value={$row[0]}> <td>{$row[0]}</td> <td>{$row[1]}</td> <td>{$row[4]}</td> 
		      <td>
			    <a onClick='getSpecificTeam({$row[0]})'>edit</a>
			    <button class='btn btn-xs btn-danger' onClick='removeTeam({$row[0]})' > delete </button>
		      </td>
		      </tr>";
		    }
	    }else{
		    // show error message to the specified div
		    echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing teams.';</script>";
		    // make error div visible
		    echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
	    }
	}// end of function
	
	function addTeams(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
        $values = $_POST['multi-select-demo'];	// team members from the teamMember multiselect	
		
		$teamCompanyobj_id;$employeeId;$teamId; // to store IDs fetched from database
		$teamName = $_POST['teamName'];
		$teamTag  = $_POST['teamTag'];
		$teamCompany = $_POST['teamCompany'];
		$teamDivision  = $_POST['teamDivision'];
		$teamDepartment = $_POST['teamDepartment'];
		$teamSubDepartment = $_POST['teamSubDepartment'];
		$teamLocation  = $_POST['teamLocation'];
		$teamLeaderPersonId  = $_POST['teamLeader'];
		$teamCoachPersonId  = $_POST['teamCoach'];
		$teamChampionPersonId  = $_POST['teamChampion'];
		
		// get company object ID
		$sqlCompanyobj = "SELECT companyobj_id from COMPANY_OBJECT WHERE company_id = '{$teamCompany}' AND division_id = '{$teamDivision}' AND department_id = '{$teamDepartment}' AND subdepartment_id = '{$teamSubDepartment}' AND location_id = '{$teamLocation}';";
	    $retCompanyobj = pg_query($conn, $sqlCompanyobj);
		if($retCompanyobj){
		  while($row = pg_fetch_row($retCompanyobj))
		  {
		    $teamCompanyobj_id = $row[0];
		  }
		}
		// insert team
		$sqlInsertTeam ="INSERT into Team(team_name,team_tag,companyobj_id) VALUES('{$teamName}','{$teamTag}','{$teamCompanyobj_id}');";
		  $ret = pg_query($conn, $sqlInsertTeam);
		  
		// get newly inserted team ID  
		$sqlTeamId = "SELECT team_id from TEAM WHERE companyobj_id = '{$teamCompanyobj_id}' AND team_name = '{$teamName}' AND team_tag = '{$teamTag}';";
	    $retTeamId = pg_query($conn, $sqlTeamId);
		if($retTeamId){
		  while($row = pg_fetch_row($retTeamId))
		  {
		    $teamId = $row[0];
		  }
		}
	// insert team members
	    foreach ($values as $a)
		{
		    $sql="SELECT employee_id from EMPLOYEE WHERE person_id = '{$a}'";
		    $ret = pg_query($conn,$sql);
		    $row = pg_fetch_row($ret);
		    $employee_id = $row[0];
			$sqlInsertTeamMember ="INSERT into TEAM_ROLE(teamrole_name,team_id,employee_id) VALUES('team member','{$teamId}','{$employee_id}');";
		    $ret = pg_query($conn, $sqlInsertTeamMember);
		}
		
		// insert team coach
		 $sqlCoach="SELECT employee_id from EMPLOYEE WHERE person_id = '{$teamCoachPersonId}'";
		    $retCoachEmployeeId = pg_query($conn,$sqlCoach);
		    $rowCoachEmployeeId = pg_fetch_row($retCoachEmployeeId);
		    $coachEmployeeId = $rowCoachEmployeeId[0];
		$sqlInsertTeamCoach ="INSERT into TEAM_ROLE(teamrole_name,team_id,employee_id) VALUES('coach','{$teamId}','{$coachEmployeeId}');";
		    $ret = pg_query($conn, $sqlInsertTeamCoach);	
			
		// insert Team Champion
		 $sqlChampion="SELECT employee_id from EMPLOYEE WHERE person_id = '{$teamChampionPersonId}'";
		    $retChampionEmployeeId = pg_query($conn,$sqlChampion);
		    $rowChampionEmployeeId = pg_fetch_row($retChampionEmployeeId);
		    $championEmployeeId = $rowChampionEmployeeId[0];
		$sqlInsertTeamChampion ="INSERT into TEAM_ROLE(teamrole_name,team_id,employee_id) VALUES('champion','{$teamId}','{$championEmployeeId}');";
		    $ret = pg_query($conn, $sqlInsertTeamChampion);
			
		// insert Team Leader
		 $sqlLeader="SELECT employee_id from EMPLOYEE WHERE person_id = '{$teamLeaderPersonId}'";
		    $retLeaderEmployeeId = pg_query($conn,$sqlLeader);
		    $rowLeaderEmployeeId = pg_fetch_row($retLeaderEmployeeId);
		    $leaderEmployeeId = $rowLeaderEmployeeId[0];
		$sqlInsertTeamLeader ="INSERT into TEAM_ROLE(teamrole_name,team_id,employee_id) VALUES('team leader','{$teamId}','{$leaderEmployeeId}');";
		    $ret = pg_query($conn, $sqlInsertTeamLeader);
		  
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Team added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Team cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	
	// delete team reuqested for
	function deleteTeams($teamId){
		// building database connection
		echo $teamId;
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sqlDeleteTeamRoles ="DELETE from TEAM_ROLE WHERE team_id={$teamId}; ";
		$ret = pg_query($conn, $sqlDeleteTeamRoles);
		$sqlDeleteTeam ="DELETE from TEAM WHERE team_id={$teamId}; ";
		$ret1 = pg_query($conn, $sqlDeleteTeam);
		  if($ret1){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
//================================================================================================================//
									//||=============================||
									//||     Admin Company Module    ||
									//||=============================||

	// function to fetch companies detials from database
	function getCompanies(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
      SELECT * from COMPANY;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[9]} value={$row[9]}> <td>{$row[9]}</td> <td>{$row[0]}</td> <td>"; 
			  if($row[2]=='t'){
			    echo "Enabled";
			  }else{
			    echo "Disabled";
		      } 
			  echo "</td> 
			  <td>
				<a onClick='getSpecificCompany({$row[9]})'>edit</a>
				<button class='btn btn-xs btn-danger' onClick='removeCompany({$row[9]})' > delete </button>
				<button class='btn btn-xs btn-warning' onClick='setupCompany({$row[9]})' > setup </button>
				<button class='btn btn-xs btn-info' onClick='loadCompanyObjectsDetailsPage({$row[9]})' > Details </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Companies.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to fetch company detials from database
	function getSpecificCompanies($companyId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$name="";$status="";
		
		$sql =<<<EOF
      SELECT * from COMPANY WHERE company_id={$companyId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  $name = $row[0];
			  $status = $row[2];
			  $id = $row[9];
			  $_SESSION['editCompanyId'] = $id;
		    }
			echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminCompaniesContent()">
					<i class="fa fa-building" aria-hidden="true"></i> Companies
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit company
				  </a>
				</li>
			</ul>
			     <div id="updateCompany" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Company</h4>
	  	           </div>
		           <div class="panel-body">
					 <form id="editCompanyForm" action="" method="post">
					 <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editCompanyId" id="editCompanyId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<label>
						<b>Name: </b></label>  
						<input type="text" name="editCompanyName" id="editCompanyName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						<br>
						<label>
						<b>Company Status: </b></label> 
				         <select class="form-control" id="editCompanyStatus" name="editCompanyStatus" style="background-color:#f7f7f9;">';
						 if($status == 't')
						 {
						 echo '<option value="1" selected >Enabled</option>
							<option value="0">Disabled</option>
						  </select>';
						 }else{
							echo '<option value="1">Enabled</option>
							<option value="0" selected >Disabled</option>
						  </select>';
						 }						
						 
						echo '<br>
						<button name="updateCompany" type="submit" class="btn btn-primary">Save</button>
					</form>	
				</div>
			</div>
		</div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Companies.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// setup company object with dept. loc. div. objects
	function setupCompany($companyId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		echo '
		<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
			<li>
			  <a onClick="loadAdminDetailsContent()">
				<i class="fa fa-home" aria-hidden="true"></i> Home
			  </a>
			</li>
			<li>
			  <a onClick="loadAdminCompaniesContent()" >
				<i class="fa fa-building" aria-hidden="true"></i> Companies
			  </a>
			</li>
			<li>
			  <a onClick="" style="color:grey;">
				<i class="fa fa-cog" aria-hidden="true"></i> Setup company
			  </a>
			</li>
		</ul>

			<div id="setupCompany" class="admin_content col-md-offset-1 col-md-10">    
	            <div class="panel panel-default">
	  	            <div class="panel-heading">
	    	          <h4>Setup Company</h4>
	  	            </div>
		            <div class="panel-body">
					    <form id="editCompanyForm" action="" method="post">
					    <label>
						  <b>Company Name: </b>
						 </label>';
		
		$sqlCompany =<<<EOF
        SELECT company_id,company_name from COMPANY WHERE company_id = '{$companyId}';
EOF;
		$retCompany = pg_query($conn, $sqlCompany);
		if($retCompany){
		    while($row = pg_fetch_row($retCompany)) 
		    {
			    echo '<input type="text" name="companyId" id="companyId" style="display:none" class="form-control" 
						value='; echo "'{$row[0]}'"; echo 'placeholder = '; echo "'{$row[1]}'/>"; 
						 echo '<input type="text" name="companyName" id="companyName" class="form-control" 
						value='; echo "'{$row[1]}'"; echo 'disabled/>'; 
		    }
			echo '</br><label><b>Division Name: </b></label>
				<select class="form-control" id="divisionId" name="divisionId" style="background-color:#f7f7f9;" required="required">
				<option value="" selected disabled>select division</option>';
			$sqlDivision =<<<EOF
			SELECT division_id,division_name from DIVISION;
EOF;
			$retDivision = pg_query($conn, $sqlDivision);
			while($row = pg_fetch_row($retDivision)) 
			   {
					echo '<option value=';echo "'{$row[0]}'>"; 
					echo $row[1]; echo "</option>";
				}
			echo '</select></br><label><b>Department Name: </b></label>
			    <select class="form-control" id="departmentId" name="departmentId" style="background-color:#f7f7f9;" required="required">
				<option value="" selected disabled>select department</option>';
			$sqlDepartment =<<<EOF
			SELECT department_id,department_name from DEPARTMENT;
EOF;
			$retDepartment = pg_query($conn, $sqlDepartment);
			while($row = pg_fetch_row($retDepartment)) 
				{
					echo '<option value=';echo "'{$row[0]}'>"; 
					echo $row[1]; echo "</option>";
				}
			echo '</select></br><label><b>Sub-Department Name: </b></label>
			    <select class="form-control" id="subdepartmentId" name="subdepartmentId" style="background-color:#f7f7f9;" required="required">
				<option value="" selected disabled>select sub-department</option>';
			$sqlSubDepartment =<<<EOF
			SELECT subdepartment_id,subdepartment_name from SUB_DEPARTMENT;
EOF;
			$retSubDepartment = pg_query($conn, $sqlSubDepartment);
			while($row = pg_fetch_row($retSubDepartment)) 
				{
					echo '<option value=';echo "'{$row[0]}'>"; 
					echo $row[1]; echo "</option>";
				}
				
			echo '</select></br><label><b>Location Name: </b></label>
			    <select class="form-control" id="locationId" name="locationId" style="background-color:#f7f7f9;" required="required">
				<option value="" selected disabled>select location</option>';
			$sqlLocation =<<<EOF
			SELECT location_id,location_name from LOCATION;
EOF;
			$retLocation = pg_query($conn, $sqlLocation);
			while($row = pg_fetch_row($retLocation)) 
				{
					echo '<option value=';echo "'{$row[0]}'>"; 
					echo $row[1]; echo "</option>";
				}
		    echo '  </select>
		                </br>
			            <button name="createCompanyObject" type="submit" class="btn btn-primary">Create Company Object</button>
					</form>	
				</div>
			  </div>
		    </div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Companies.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete company reuqested for
	function deleteCompanies($companyId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql ="DELETE from COMPANY WHERE company_id= {$companyId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function addCompanies(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$companyName = $_POST['companyName'];
		$companyStatus  = $_POST['companyStatus'];
		$companySector  = $_POST['companySector'];
		$sql ="INSERT into COMPANY(company_name,company_status,company_sector) VALUES('{$companyName}','{$companyStatus}','{$companySector}');";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Company added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Company cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	function updateCompanies(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$companyName = $_POST['editCompanyName'];
		$companyStatus  = $_POST['editCompanyStatus'];
		$companyId  = $_POST['editCompanyId'];
		$sql ="UPDATE COMPANY SET company_name='{$companyName}',company_status='{$companyStatus}' WHERE company_id={$companyId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Company updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Company cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	
	function addCompanyObject(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$companyId = $_POST['companyId'];
		$divisionId  = $_POST['divisionId'];
		$departmentId  = $_POST['departmentId'];
		$subdepartmentId  = $_POST['subdepartmentId'];
		$locationId = $_POST['locationId'];
		
		// checks if company object formed already exists in database or not
		$sqlCompanyObject = "SELECT count(*) from COMPANY_OBJECT WHERE company_id = '{$companyId}' AND division_id = '{$divisionId}' AND department_id = '{$departmentId}' AND subdepartment_id = '{$subdepartmentId}' AND location_id = '{$locationId}'";
		
		$retCompanyObject = pg_query($conn, $sqlCompanyObject);
		$row = pg_fetch_row($retCompanyObject);
		if($row[0]==0) // if company object doesn't exist
		{
		    $sql ="INSERT into COMPANY_OBJECT (company_id,division_id,department_id,subdepartment_id,location_id) VALUES('{$companyId}','{$divisionId}','{$departmentId}','{$subdepartmentId}','{$locationId}');";
		    $ret = pg_query($conn, $sql);
		    if($ret){
			  // show success message to the specified div
			  echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Company object created successfully!</strong>';</script>";
			  // make success div visible
			  echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			  echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminCompaniesContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
		    }else{
			  // show error message to the specified div
			  echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem occured!</strong> Company object cannot be created';</script>";
			  // make error div visible
			  echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
		}else{
		    // show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem occured!</strong> Company object already exists';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminCompaniesContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
		}
	}// end of function
	
	function getCompanyObjects($companyId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
		 SELECT CO.companyobj_id,company_name,department_name,subdepartment_name,division_name,location_name 
		 from COMPANY_OBJECT as CO, COMPANY as C, DEPARTMENT as DP, SUB_DEPARTMENT as SDP, DIVISION as DV, LOCATION as L
         WHERE 	CO.company_id = '{$companyId}' AND CO.company_id = C.company_id AND CO.department_id= DP.department_id AND CO.subdepartment_id= SDP.subdepartment_id AND CO.division_id = DV.division_id AND CO.location_id = L.location_id;
EOF;

		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$row[0]}</td> <td>{$row[1]}</td>
			  <td>{$row[2]}</td><td>{$row[3]}</td><td>{$row[4]}</td><td>{$row[5]}</td>
			  <td>
				<button class='btn btn-xs btn-danger' onClick='removeCompanyObject({$row[0]})'> delete </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Company objects.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	
	// delete company reuqested for
	function deleteCompanyObject($companyObjectId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql ="DELETE from COMPANY WHERE company_id= {$companyId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function getCompaniesForAssetAssignment(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
		 SELECT CO.companyobj_id,company_name,department_name,subdepartment_name,division_name,location_name 
		 from COMPANY_OBJECT as CO, COMPANY as C, DEPARTMENT as DP, SUB_DEPARTMENT as SDP, DIVISION as DV, LOCATION as L
         WHERE 	CO.company_id = C.company_id AND CO.department_id= DP.department_id AND CO.subdepartment_id= SDP.subdepartment_id AND CO.division_id = DV.division_id AND CO.location_id = L.location_id ;
EOF;

		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			// checking either asset is assigned to user or not
			$assetId = $_SESSION['companyAssetId'];
            $sqlForAssetAssignmentStatus = "
	        SELECT count(*) from company_asset WHERE asset_id = {$assetId} AND companyobj_id = {$row[0]}; 
	        ";
	        $res = pg_query($conn, $sqlForAssetAssignmentStatus);
            $assetAssignedRow = pg_fetch_row($res);
            $status = $assetAssignedRow[0];
			
			  echo "<tr id={$row[0]} value={$row[0]}> 
			  <td>
			  <input type='checkbox' id='checkbox{$row[0]}' onClick='assignAssetToCompany({$row[0]})' ";
			  if($status > 0){echo "checked";} // is asset is already assigned
			  echo"/>
			  </td><td>{$row[0]}</td><td>{$row[1]} </td><td>{$row[2]}</td><td>{$row[3]}</td><td>{$row[4]}</td><td>{$row[5]}</td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Company objects.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
//================================================================================================================//
									//||=============================||
									//||     Admin Users Module      ||
									//||=============================||

    // function to fetch Departments from database
	function getUsers(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =<<<EOF
	    SELECT p.person_id,p.person_firstname,p.person_lastname,p.person_email,comp.company_name,div.division_name,
	    dept.department_name,loc.location_name,pos.position_name
	    FROM POSITION as pos, PERSON as p,EMPLOYEE as emp, COMPANY as comp,DEPARTMENT as dept,DIVISION as div,
	    LOCATION as loc,COMPANY_OBJECT as co
	    WHERE p.person_id = emp.person_id AND emp.position_id = pos.position_id
	    AND co.companyobj_id = pos.companyobj_id AND co.department_id = dept.department_id
	    AND co.division_id = div.division_id AND co.location_id = loc.location_id
	    AND co.company_id = comp.company_id
	    ;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$row[1]} {$row[2]}</td> <td>{$row[3]}</td>
			  <td>";
			  // accreditation number retrival 
			  $sql = "SELECT accred_number from ACCREDITATION where person_id= '{$row[0]}'";
			  $row1 = pg_fetch_row(pg_query($conn, $sql));
			  if($row1[0]){echo $row1[0];}
			  echo "</td><td>{$row[4]}</td><td>{$row[5]}</td><td>{$row[6]}</td><td>{$row[7]}</td><td>{$row[8]}</td> 
			  <td>
				
				<button class='btn btn-xs btn-danger' onClick='removeUser({$row[0]})' > delete </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing users.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	function getUsersForAssetAssignment(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =<<<EOF
	    SELECT p.person_id,p.person_firstname,p.person_lastname,p.person_email,comp.company_name,div.division_name,
	    dept.department_name,loc.location_name,pos.position_name
	    FROM POSITION as pos, PERSON as p,EMPLOYEE as emp, COMPANY as comp,DEPARTMENT as dept,DIVISION as div,
	    LOCATION as loc,COMPANY_OBJECT as co
	    WHERE p.person_id = emp.person_id AND emp.position_id = pos.position_id
	    AND co.companyobj_id = pos.companyobj_id AND co.department_id = dept.department_id
	    AND co.division_id = div.division_id AND co.location_id = loc.location_id
	    AND co.company_id = comp.company_id
	    ;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			// checking either asset is assigned to user or not
			$assetId = $_SESSION['userAssetId'];
            $sqlForAssetAssignmentStatus = "
	        SELECT count(*) from employee_asset WHERE asset_id = {$assetId} AND employee_id IN 
			(SELECT employee_id from EMPLOYEE WHERE person_id ={$row[0]}) 
	        ";
	        $res = pg_query($conn, $sqlForAssetAssignmentStatus);
            $assetAssignedRow = pg_fetch_row($res);
            $status = $assetAssignedRow[0];
			
			  echo "<tr id={$row[0]} value={$row[0]}> 
			  <td>
			  <input type='checkbox' id='checkbox{$row[0]}' onClick='assignAssetToUser({$row[0]})' ";
			  if($status > 0){echo "checked";} // is asset is already assigned
			  echo"/>
			  </td><td>{$row[1]} {$row[2]}</td><td>{$row[4]}</td><td>{$row[5]}</td><td>{$row[6]}</td><td>{$row[7]}</td><td>{$row[8]}</td> 
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing users.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	function addUsers(){
	
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = strtolower($_POST['accountEmail']);
		$username = strtolower($_POST['accountUsername']);
		$password = $_POST['password'];
		$userType = $_POST['type'];
		$positionId = $_POST['position'];
		$commitmentStatement = $_POST['commitmentStatement'];
		$personContactId; $personAddressId;$personObjId;
		
		// image upload section 
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "<script> alert('Sorry, file already exists.');</script>";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "<script> alert('Sorry, your file is too large.');</script>";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			echo "<script> alert('Sorry, only JPG, JPEG & PNG files are allowed.');</script>";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "<script> alert('Sorry, your file was not uploaded.');</script>";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "<script> alert('The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.');</script>";
			} else {
				echo "<script> alert('Sorry, there was an error uploading your file.');</script>";
			}
		}
		if($uploadOk == 0) // save path to database only if file was uploaded successfully
		{
		    $target_file=null;
		}
		
		// insert contact and get its ID
		$sqlInsertPersonContact ="INSERT into CONTACT(contact_createdby) VALUES('{$username}');";
		$retInsertPersonContact = pg_query($conn, $sqlInsertPersonContact);
		if($retInsertPersonContact){
		    $sqlContactId = "SELECT contact_id from CONTACT WHERE contact_createdby = '{$username}'";
			$retContactId = pg_query($conn, $sqlContactId);
		    $row = pg_fetch_row($retContactId);
			$personContactId = $row[0];
		}
		
		// insert address and get its ID
		$sqlInsertPersonAddress ="INSERT into ADDRESS(address_createdby) VALUES('{$username}');";
		$retInsertPersonAddress = pg_query($conn, $sqlInsertPersonAddress);
		if($retInsertPersonAddress){
		    $sqlAddressId = "SELECT address_id from ADDRESS WHERE address_createdby = '{$username}'";
			$retAddressId = pg_query($conn, $sqlAddressId);
		    $row = pg_fetch_row($retAddressId);
			$personAddressId = $row[0];
		}
		// insert person details
		$sqlInsertPersonDetails ="INSERT into PERSON	(person_firstname,person_lastname,person_username,person_email,person_password,person_type,person_accountstatus,contact_id,address_id,person_commitment,person_pic)
		VALUES('{$firstName}','{$lastName}','{$username}','{$email}','{$password}','{$userType}',true,'{$personContactId}','{$personAddressId}','{$commitmentStatement}','{$target_file}');";
		  $retInsertPersonDetails = pg_query($conn, $sqlInsertPersonDetails);
		  if($retInsertPersonDetails){
			
		    // get person ID
		    $sqlPID =<<<EOF
	        SELECT person_id from PERSON WHERE person_username = '{$username}';
EOF;
		    $retPID = pg_query($conn, $sqlPID);
		    $row = pg_fetch_row($retPID);
			$personObjId = $row[0];
			
			if(isset($_POST['accreditationNumber'])){
			// add user accreitation number if he/she is champion or choach			
			$sqlInsertAccredNumber =<<<EOF
	        INSERT into ACCREDITATION(person_id,accred_number) VALUES('{$personObjId}','{$_POST['accreditationNumber']}');
EOF;
		    $retInsertAccredNumber = pg_query($conn, $sqlInsertAccredNumber);
			}

            // add user as employee for the specified post under related company			
			$sqlInsertEmployee =<<<EOF
	        INSERT into EMPLOYEE(person_id,position_id) VALUES('{$personObjId}','{$positionId}');
EOF;
		    $retInsertEmployee = pg_query($conn, $sqlInsertEmployee);
			
			if(isset($_POST['isCoach']) && isset($_POST['isChampion']))
			{
				$sqlInsertCoach ="INSERT into COACH(person_id) VALUES('{$personObjId}');";
		        pg_query($conn, $sqlInsertCoach);
				
				$sqlInsertChampion ="INSERT into CHAMPION(person_id) VALUES('{$personObjId}');";
		        pg_query($conn, $sqlInsertChampion);
			}
			elseif(isset($_POST['isCoach']))
			{
				$sqlInsertCoach ="INSERT into COACH(person_id) VALUES('{$personObjId}');";
		        pg_query($conn, $sqlInsertCoach);
			}
			elseif(isset($_POST['isChampion']))
			{
			    $sqlInsertChampion ="INSERT into CHAMPION(person_id) VALUES('{$personObjId}');";
		        pg_query($conn, $sqlInsertChampion);
				
				if(isset($_POST['coachSelect']))
				{
				    $coaches = $_POST['coachSelect'];
				    foreach ($coaches as $coach)
				    {
					    $sqlInsertUserCoach ="INSERT into USER_COACHES(user_id,coach_id) VALUES('{$personObjId}','{$coach}');";
					    pg_query($conn, $sqlInsertUserCoach);
				    }
				}
			}
			else
			{
			    if(isset($_POST['coachSelect'])){  // if coach accounts are selected for the user
	                $coaches = $_POST['coachSelect'];
				    foreach ($coaches as $coach)
					{
						$sqlInsertUserCoach ="INSERT into USER_COACHES(user_id,coach_id) VALUES('{$personObjId}','{$coach}');";
						pg_query($conn, $sqlInsertUserCoach);
					}
				}
				if(isset($_POST['championSelect'])){ // if champion accounts are selected for the user
				    $champs = $_POST['championSelect'];
				    foreach ($champs as $champ)
					{
						$sqlInsertUserChamp ="INSERT into USER_CHAMPIONS(user_id,champion_id) VALUES('{$personObjId}','{$champ}');";
						pg_query($conn, $sqlInsertUserChamp);
					}
				}
			}
			if($retInsertEmployee)	{
				// show success message to the specified div
				echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>User account created successfully!</strong>';</script>";
				// make success div visible
				echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			}else{
				echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem occured!</strong> User account cannot be added';</script>";
			    // make error div visible
			    echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			} // all details inserted till this point.
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem occured!</strong> User account cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
//===============================================================================================================//	
									//||=================================||
									//||    Admin Lookup Types Module    ||
									//||=================================||

    // function to fetch lookup types detials from database
	function getLookupTypes(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
      SELECT type_id,type_name from LOOKUP_TYPES;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$row[0]}</td> <td>{$row[1]}</td>
			  <td>
				<a onClick='getSpecificLookupType({$row[0]})'>edit</a>
				<button class='btn btn-xs btn-danger' onClick='removeLookupType({$row[0]})' > delete </button>
				<button class='btn btn-xs btn-info' onClick='loadLookupTypeValuesPage({$row[0]})' > values </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing lookup types.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	
	// function to fetch lookup types detials from database
	function getSpecificLookupTypes($lookupTypeId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$id;$name="";
		
		$sql =<<<EOF
      SELECT type_id,type_name from LOOKUP_TYPES WHERE type_id={$lookupTypeId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  $row = pg_fetch_row($ret); 
		  $id = $row[0];
		  $name = $row[1];
		  $_SESSION['editLookupTypeId'] = $id;
		    
			echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminLookupsContent()" >
					Lookup Types
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit lookup type
				  </a>
				</li>
			</ul>
			     <div id="updateLookupType" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Lookup Type</h4>
	  	           </div>
		           <div class="panel-body">
					 <form id="editlookupTypeForm" action="" method="post">
					 <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editLookupTypeId" id="editLookupTypeId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<label>
						<b>Lookup Type:</b></label>  
						<input type="text" name="editLookupTypeName" id="editLookupTypeName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						<br>
						<button name="updateLookupType" type="submit" class="btn btn-primary">Save</button>
					</form>	
				</div>
			</div>
		</div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Lookup Types.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete lookup type reuqested for
	function deleteLookupTypes($lookupTypeId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql ="DELETE from LOOKUP_TYPES WHERE type_id={$lookupTypeId}; ";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function addLookupTypes(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$lookupTypeName = $_POST['lookupTypeName'];
		$sql ="INSERT into LOOKUP_TYPES(type_name) VALUES('{$lookupTypeName}');";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Lookup Type added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Lookup Type cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	
	function updateLookupTypes(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$lookupTypeId = $_POST['editLookupTypeId'];
		$lookupTypeName = $_POST['editLookupTypeName'];
		
		$sql ="UPDATE LOOKUP_TYPES SET type_name='{$lookupTypeName}' WHERE type_id={$lookupTypeId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Lookup type updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Lookup type cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
//================================================================================================================//
									//||=======================================||
									//||    Admin Lookup Type Values Module    ||
									//||=======================================||

    // function to fetch lookup type values from database
	function getLookupTypeValues(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
      SELECT value_id,value_name from LOOKUP_VALUES where type_id = {$_SESSION['getlookupTypeValues']} ;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$row[0]}</td> <td>{$row[1]}</td>
			  <td>
				<a onClick='getSpecificLookupTypeValue({$row[0]})'>edit</a>
				<button class='btn btn-xs btn-danger' onClick='removeLookupTypeValue({$row[0]})' > delete </button>
			  </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing lookup type values.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	
	// function to fetch lookup type value detials from database
	function getSpecificLookupTypeValues($lookupTypeValueId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$id;$name="";
		
		$sql =<<<EOF
      SELECT value_id,value_name from LOOKUP_VALUES WHERE value_id={$lookupTypeValueId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  $row = pg_fetch_row($ret); 
		  $id = $row[0];
		  $name = $row[1];
		  $_SESSION['editLookupTypeValueId'] = $id;
		    
			echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminLookupsContent()">
					Lookup Types
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit lookup values
				  </a>
				</li>
			</ul>
			     <div id="updateLookupTypeValue" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Value</h4>
	  	           </div>
		           <div class="panel-body">
					 <form id="editlookupTypeValueForm" action="" method="post">
					 <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editLookupTypeValueId" id="editLookupTypeValueId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<label>
						<b>Lookup Type:</b></label>  
						<input type="text" name="editLookupTypeValueName" id="editLookupTypeValueName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						<br>
						<button name="updateLookupTypeValue" type="submit" class="btn btn-primary">Save</button>
					</form>	
				</div>
			</div>
		</div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Lookup Type Values.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete lookup type reuqested for
	function deleteLookupTypeValues($lookupTypeValueId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql ="DELETE from LOOKUP_VALUES WHERE value_id={$lookupTypeValueId}; ";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	
	function addLookupTypeValues(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$lookupTypeValueName = $_POST['lookupTypeValueName'];
		$sql ="INSERT into LOOKUP_VALUES(type_id,value_name) VALUES('{$_SESSION['getlookupTypeValues']}','{$lookupTypeValueName}');";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Value added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Value cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	function updateLookupTypeValues(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$lookupTypeValueId = $_POST['editLookupTypeValueId'];
		$lookupTypeValueName = $_POST['editLookupTypeValueName'];
		
		$sql ="UPDATE LOOKUP_VALUES SET value_name='{$lookupTypeValueName}' WHERE value_id={$lookupTypeValueId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Value updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Value cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
//===============================================================================================================//	
									//||==========================||
									//||    Admin Asset Module    ||
									//||==========================||

    // function to fetch Asset detials from database
	function getAssets(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$sql =<<<EOF
      SELECT asset_id,asset_name,asset_code,asset_status,asset_maintainancetype,asset_repairedondate,asset_nextmaintainance,asset_comments from Asset;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$row[1]}</td> <td>{$row[2]}</td> <td>{$row[3]}</td>
              <td>{$row[4]}</td> <td>{$row[5]}</td> <td>{$row[6]}</td><td>{$row[7]}</td>			  
			  <td>
				<a onClick='getSpecificAsset({$row[0]})'>edit</a>
				<button style='margin:2px;' class='btn btn-xs btn-danger' onClick='removeAsset({$row[0]})' > delete </button>
				<button style='margin:2px;' class='btn btn-xs btn-warning' onClick='loadAssignAssetUsersContent({$row[0]})' > assign user </button>
				<button style='margin:2px;' class='btn btn-xs btn-info' onClick='loadAssignAssetCompaniesContent({$row[0]})' > assign company </button>
              </td>
			  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing assets.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// function to fetch Asset detials from database
	function getSpecificAssets($assetId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$name="";$code="";$status="";$maintainanceType="";$repairedOnDate="";$nextMaintianance="";$comments="";
		
		$sql =<<<EOF
        SELECT asset_id,asset_name,asset_code,asset_status,asset_maintainancetype,asset_repairedondate,asset_nextmaintainance,asset_comments from ASSET WHERE asset_id={$assetId};
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  $row = pg_fetch_row($ret); 
		  $id = $row[0];
		  $name = $row[1];
		  $code = $row[2];
		  $status = $row[3];
		  $maintainanceType = $row[4];
		  $repairedOnDate = $row[5];
		  $nextMaintianance = $row[6];
		  $comments = $row[7];
		  $_SESSION['editAssetId'] = $id;
		    
		    echo '
			<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
				<li>
				  <a onClick="loadAdminDetailsContent()">
					<i class="fa fa-home" aria-hidden="true"></i> Home
				  </a>
				</li>
				<li>
				  <a onClick="loadAdminAssetsContent()">
					Assets
				  </a>
				</li>
				<li>
				  <a onClick="" style="color:grey;">
					<i class="fa fa-pencil" aria-hidden="true"></i> Edit asset
				  </a>
				</li>
			</ul>
			    <div id="updateAsset" class="admin_content col-md-offset-1 col-md-10">    
	             <div class="panel panel-default">
	  	           <div class="panel-heading">
	    	         <h4>Edit Asset</h4>
	  	           </div>
		            <div class="panel-body">
					  <form id="editAssetForm" action="" method="post">
					    <label style="display:none; !important" >
						<b>ID: </b></label>  
						<input type="text" name="editAssetId" id="editAssetId" class="form-control" 
						value='; echo $id; echo' style="display:none; !important" >				
						<br>
						<div class="form-group col-md-6">
						<label>
						<b>Name: </b></label>  
						<input type="text" name="editAssetName" id="editAssetName" class="form-control" 
						value='; echo "'{$name}'"; echo'>				
						</div>
						<div class="form-group col-md-6">
						<label>
						<b>Code: </b></label>  
						<input type="text" id="editAssetCode" name="editAssetCode" class="form-control"
						value='; echo "'{$code}'";echo'>
						</div>
						<div class="form-group col-md-6">
						<label>
						<b>Status: </b></label>  
						<input type="text" id="editAssetStatus" name="editAssetStatus" class="form-control"
						value='; echo "'{$status}'"; echo'>
						</div>
						<div class="form-group col-md-6">
						<label>
						<b>Maintainnance Type: </b></label>  
						<input type="text" id="editAssetMaintainanceType" name="editAssetMaintainanceType" class="form-control"
						value='; echo "'{$maintainanceType}'"; echo'>
						</div>
						<div class="form-group col-md-6">
						<label>
						<b>Repaired On: </b></label>  
						<input type="date" id="editAssetRepairedOn" name="editAssetRepairedOn" class="form-control"
						value='; echo "'{$repairedOnDate}'"; echo'>
						</div>
						<div class="form-group col-md-6">
						<label>
						<b>Next Maintainance: </b></label>  
						<input type="date" id="editAssetNextMaintainance" name="editAssetNextMaintainance" class="form-control"
						value='; echo "'{$nextMaintianance}'"; echo'>
						</div>
						<div class="form-group col-md-12">
						<label>
						<b>Comments: </b></label> 
                        <textarea class="form-control" rows="3" id="editAssetComments" name="editAssetComments"> '; echo $comments; echo'</textarea>
						</div>
						<div class="form-group col-md-6">
						    <button name="updateAsset" type="submit" class="btn btn-primary">Save</button>
						</div>
					  </form>	
				    </div>
			      </div>
		        </div>';
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing Assets.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	// delete asset reuqested for
	function deleteAsset($assetId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql ="DELETE from ASSET WHERE asset_id={$assetId}; ";
		  $ret = pg_query($conn, $sql);
		  if($ret){
		    // show success message to the specified div
			echo "success";
			
		  }else{
			echo "error";
		  }
	}// end of function
	
	function addAssets(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$assetName = $_POST['assetName'];
		$assetCode  = $_POST['assetCode'];
		$assetStatus  = $_POST['assetStatus'];
		$assetMaintainanceType = $_POST['assetMaintainanceType'];
		$assetRepiredOn ="NULL"; $assetNextMaintainance ="NULL";$assetPurchaseDate ="NULL";
		if(strlen($_POST['assetRepiredOn']) >0){
		    $assetRepiredOn  = "'".$_POST['assetRepiredOn']."'";
		}
		if(strlen($_POST['assetNextMaintainance']) >0){
		    $assetNextMaintainance  = "'".$_POST['assetNextMaintainance']."'";
		}
		if(strlen($_POST['assetPurchaseDate']) >0){
		    $assetPurchaseDate = "'".$_POST['assetPurchaseDate']."'";
		}
		$assetComments = trim($_POST['assetComments']);
		$sql ="INSERT into ASSET(asset_name,asset_code,asset_status,asset_maintainancetype,asset_repairedondate,asset_nextmaintainance,asset_comments,asset_purchasedate) 
		VALUES('{$assetName}','{$assetCode}','{$assetStatus}','{$assetMaintainanceType}',{$assetRepiredOn},{$assetNextMaintainance},'{$assetComments}',{$assetPurchaseDate});";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Asset added successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Asset cannot be added';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
	
	function updateAssets(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$assetId = $_POST['editAssetId'];
		$assetName = $_POST['editAssetName'];
		$assetCode  = $_POST['editAssetCode'];
		$assetStatus  = $_POST['editAssetStatus'];
		$assetMaintainanceType = $_POST['editAssetMaintainanceType'];
		$assetRepiredOn ="NULL"; $assetNextMaintainance ="NULL";
		if(strlen($_POST['editAssetRepairedOn']) >0){
		    $assetRepiredOn  = "'".$_POST['editAssetRepairedOn']."'";
		}
		if(strlen($_POST['editAssetNextMaintainance']) >0){
		    $assetNextMaintainance  = "'".$_POST['editAssetNextMaintainance']."'";
		}
		$assetComments = trim($_POST['editAssetComments']);
		$sql ="UPDATE ASSET SET asset_name='{$assetName}',asset_code='{$assetCode}',asset_status='{$assetStatus}',asset_maintainancetype='{$assetMaintainanceType}',asset_repairedondate={$assetRepiredOn},asset_nextmaintainance={$assetNextMaintainance},asset_comments='{$assetComments}' WHERE asset_id={$assetId};";
		  $ret = pg_query($conn, $sql);
		  if($ret){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Asset updated successfully!</strong>';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
		  }else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Problem in connection!</strong> Asset cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		  }
	}// end of function
		
//===============================================================================================================//	
									//||============================||
									//||    Admin Reports Module    ||
									//||============================||

    // function to fetch All types of submitted reports from database
	function getReports(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$connectionErrorFlag = 0;
		
		// ======= SSLR reports retrival =======//
		$sqlSslrReports =<<<EOF
        SELECT sslr_id,sslr.date,t.team_name,comp.company_name,p.person_firstname,p.person_lastname
	    FROM COMPANY as comp, TEAM as t, PERSON as p,SSLR
	    WHERE sslr.team_id = t.team_id AND comp.company_id = sslr.company_id 
	        AND p.person_username = sslr.created_by;
EOF;
        $reportName = "Site Safety Leadership Review";
		$retSslrReports = pg_query($conn, $sqlSslrReports);
		if($retSslrReports){
		  while($row = pg_fetch_row($retSslrReports)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$reportName}</td> <td>{$row[1]}</td> <td>{$row[4]} {$row[5]}</td> <td></td> <td>{$row[2]}</td> <td>{$row[3]}</td> 
			  <td></td><td></td><td></td><td></td>			  
			  <td>
				<button style='margin:2px;' class='btn btn-xs btn-success' onClick='showPDFSSLR({$row[0]})' > Show PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-warning' onClick='exportPDFSSLR({$row[0]})' > Export PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-info' onClick='exportCSVSSLR({$row[0]})' > Export CSV </button>
              </td>
			  </tr>";
		    }
		}else{
		    $connectionErrorFlag = 1;
		}
		// ======= SLPSA reports retrival =======//
		$sqlSslrReports =<<<EOF
        SELECT slpsa_id,slpsa.date,t.team_name,p.person_firstname,p.person_lastname
	    FROM TEAM as t, PERSON as p,SLPSA
	    WHERE slpsa.team_id = t.team_id AND p.person_username = slpsa.created_by;
EOF;
        $reportName = "Safety Leadership Practices Self-Assessment";
		$retSslrReports = pg_query($conn, $sqlSslrReports);
		if($retSslrReports){
		  while($row = pg_fetch_row($retSslrReports)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$reportName}</td> <td>{$row[1]}</td> <td>{$row[3]} {$row[4]}</td> <td></td> <td>{$row[2]}</td> <td></td> 
			  <td></td><td></td><td></td><td></td>			  
			  <td>
				<button style='margin:2px;' class='btn btn-xs btn-success' onClick='showPDFSLPSA({$row[0]})' > Show PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-warning' onClick='exportPDFSLPSA({$row[0]})' > Export PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-info' onClick='exportCSVSLPSA({$row[0]})' > Export CSV </button>
              </td>
			  </tr>";
		    }
		}else{
		    $connectionErrorFlag = 1;
		}
		// ======= STJ reports retrival =======//
		$sqlSslrReports =<<<EOF
        SELECT stj_id,stj.date,t.team_name,comp.company_name,p.person_firstname,p.person_lastname
	    FROM COMPANY as comp, TEAM as t, PERSON as p,STJ
	    WHERE stj.team_id = t.team_id AND comp.company_id = stj.company_id 
	        AND p.person_username = stj.created_by;
EOF;
        $reportName = "Stop the Job Meeting Review";
		$retSslrReports = pg_query($conn, $sqlSslrReports);
		if($retSslrReports){
		  while($row = pg_fetch_row($retSslrReports)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$reportName}</td> <td>{$row[1]}</td> <td>{$row[4]} {$row[5]}</td> <td></td> <td>{$row[2]}</td> <td>{$row[3]}</td> 
			  <td></td><td></td><td></td><td></td>			  
			  <td>
				<button style='margin:2px;' class='btn btn-xs btn-success' onClick='showPDFSTJ({$row[0]})' > Show PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-warning' onClick='exportPDFSTJ({$row[0]})' > Export PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-info' onClick='exportCSVSTJ({$row[0]})' > Export CSV </button>
              </td>
			  </tr>";
		    }
		}else{
		    $connectionErrorFlag = 1;
		}
		// ======= EARSON reports retrival =======//
		$sqlSslrReports =<<<EOF
        SELECT earson_id,earson.date,t.team_name,comp.company_name,p.person_firstname,p.person_lastname
	    FROM COMPANY as comp, TEAM as t, PERSON as p,EARSON
	    WHERE earson.team_id = t.team_id AND comp.company_id = earson.company_id 
	        AND p.person_username = earson.created_by;
EOF;
        $reportName = "EARSON 4 Safety Review";
		$retSslrReports = pg_query($conn, $sqlSslrReports);
		if($retSslrReports){
		  while($row = pg_fetch_row($retSslrReports)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$reportName}</td> <td>{$row[1]}</td> <td>{$row[4]} {$row[5]}</td> <td></td> <td>{$row[2]}</td> <td>{$row[3]}</td> 
			  <td></td><td></td><td></td><td></td>			  
			  <td>
				<button style='margin:2px;' class='btn btn-xs btn-success' onClick='showPDFEARSON({$row[0]})' > Show PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-warning' onClick='exportPDFEARSON({$row[0]})' > Export PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-info' onClick='exportCSVEARSON({$row[0]})' > Export CSV </button>
              </td>
			  </tr>";
		    }
		}else{
		    $connectionErrorFlag = 1;
		}
		// ======= SLP reports retrival =======//
		$sqlSlpReports =<<<EOF
        SELECT slp_id,slp.date,t.team_name,comp.company_name,p.person_firstname,p.person_lastname,slp.person_id,slp.team_id
	    FROM COMPANY as comp, TEAM as t, PERSON as p,SLP as slp
	    WHERE slp.team_id = t.team_id AND comp.company_id = slp.company_id 
	          AND p.person_username = slp.created_by;
EOF;
        $reportName = "Safety Leadership Profile";
		$retSlpReports = pg_query($conn, $sqlSlpReports);
		if($retSlpReports){
		  while($row = pg_fetch_row($retSlpReports)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$reportName}</td> <td>{$row[1]}</td> <td>{$row[4]} {$row[5]}</td>";
			  // team leader name retrival
			  $teamLeaderSql = "SELECT person_firstname,person_lastname from PERSON WHERE person_id = '{$row[6]}';";
			  $retTeamLeader = pg_query($conn, $teamLeaderSql);
			  $leaderRow = pg_fetch_row($retTeamLeader);
			  
			  $sqlCompanyInfo = "SELECT div.division_name,dept.department_name,sdept.subdepartment_name,loc.location_name
			  FROM DEPARTMENT as dept,SUB_DEPARTMENT as sdept,LOCATION as loc, DIVISION as div,COMPANY_OBJECT as compObj
			  WHERE dept.department_id = compObj.department_id AND sdept.subdepartment_id = compObj.subdepartment_id AND div.division_id = compObj.division_id AND loc.location_id = compObj.location_id 
			  AND compObj.companyobj_id IN (SELECT companyobj_id FROM TEAM where team_id = '{$row[7]}')";
			   $retCompanyInfo = pg_query($conn, $sqlCompanyInfo);
			  $companyInfoRow = pg_fetch_row($retCompanyInfo);
			  
			  echo "<td>{$leaderRow[0]} {$leaderRow[1]}</td> <td>{$row[2]}</td> <td>{$row[3]}</td> 
			  <td>{$companyInfoRow[0]}</td><td>{$companyInfoRow[1]}</td><td>{$companyInfoRow[2]}</td><td>{$companyInfoRow[3]}</td>			  
			  <td>
				<button style='margin:2px;' class='btn btn-xs btn-success' onClick='showPDFSLP({$row[0]})' > Show PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-warning' onClick='exportPDFSLP({$row[0]})' > Export PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-info' onClick='exportCSVSLP({$row[0]})' > Export CSV </button>
              </td>
			  </tr>";
		    }
		}else{
		    $connectionErrorFlag = 1;
		}
	    // ========= SLPA reports retrival ========//
		$sqlSlpaReports =<<<EOF
        SELECT slpa_id,slpa.date,t.team_name,comp.company_name,p.person_firstname,p.person_lastname,slpa.person_id,slpa.team_id
	    FROM COMPANY as comp, TEAM as t, PERSON as p,SLPA as slpa
	    WHERE slpa.team_id = t.team_id AND comp.company_id = slpa.company_id 
	          AND p.person_username = slpa.created_by;
EOF;
        $reportName = "Safety Leadership Practices Assessment";
		$retSlpaReports = pg_query($conn, $sqlSlpaReports);
		if($retSlpaReports){
		  while($row = pg_fetch_row($retSlpaReports)) 
		    {
			  echo "<tr id={$row[0]} value={$row[0]}> <td>{$reportName}</td> <td>{$row[1]}</td> <td>{$row[4]} {$row[5]}</td>";
			  // team leader name retrival
			  $teamLeaderSql = "SELECT person_firstname,person_lastname from PERSON WHERE person_id = '{$row[6]}';";
			  $retTeamLeader = pg_query($conn, $teamLeaderSql);
			  $leaderRow = pg_fetch_row($retTeamLeader);
			  
			  $sqlCompanyInfo = "SELECT div.division_name,dept.department_name,sdept.subdepartment_name,loc.location_name
			  FROM DEPARTMENT as dept,SUB_DEPARTMENT as sdept,LOCATION as loc, DIVISION as div,COMPANY_OBJECT as compObj
			  WHERE dept.department_id = compObj.department_id AND sdept.subdepartment_id = compObj.subdepartment_id AND div.division_id = compObj.division_id AND loc.location_id = compObj.location_id 
			  AND compObj.companyobj_id IN (SELECT companyobj_id FROM TEAM where team_id = '{$row[7]}')";
			   $retCompanyInfo = pg_query($conn, $sqlCompanyInfo);
			  $companyInfoRow = pg_fetch_row($retCompanyInfo);
			  
			  echo "<td>{$leaderRow[0]} {$leaderRow[1]}</td> <td>{$row[2]}</td> <td>{$row[3]}</td> 
			  <td>{$companyInfoRow[0]}</td><td>{$companyInfoRow[1]}</td><td>{$companyInfoRow[2]}</td><td>{$companyInfoRow[3]}</td>			  
			  <td>
				<button style='margin:2px;' class='btn btn-xs btn-success' onClick='showPDFSLPA({$row[0]})' > Show PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-warning' onClick='exportPDFSLPA({$row[0]})' > Export PDF </button>
				<button style='margin:2px;' class='btn btn-xs btn-info' onClick='exportCSVSLPA({$row[0]})' > Export CSV </button>
              </td>
			  </tr>";
		    }
		}else{
		    $connectionErrorFlag = 1;
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing reports.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
//================================================================================================================//

} // end of class	

$adminClass = new AdminActionManager();
// location function calls
if(isset($_POST['deleteLocation'])){
    $adminClass->deleteLocations($_POST['deleteLocation']);
}
if(isset($_POST['getLocation'])){
    $adminClass->getSpecificLocations($_POST['getLocation']);
}

// division function calls
if(isset($_POST['deleteDivision'])){
    $adminClass->deleteDivisions($_POST['deleteDivision']);
}
if(isset($_POST['getDivision'])){
    $adminClass->getSpecificDivisions($_POST['getDivision']);
}

// sub-department function calls
if(isset($_POST['deleteSubDepartment'])){
    $adminClass->deleteSubDepartments($_POST['deleteSubDepartment']);
}
if(isset($_POST['getSubDepartment'])){
    $adminClass->getSpecificSubDepartments($_POST['getSubDepartment']);
}

// department function calls
if(isset($_POST['deleteDepartment'])){
    $adminClass->deleteDepartments($_POST['deleteDepartment']);
}
if(isset($_POST['getDepartment'])){
    $adminClass->getSpecificDepartments($_POST['getDepartment']);
}

// team function calls
if(isset($_POST['deleteTeam'])){
    $adminClass->deleteTeams($_POST['deleteTeam']);
}

// company function calls
if(isset($_POST['deleteCompany'])){
    $adminClass->deleteCompanies($_POST['deleteCompany']);
}
if(isset($_POST['getCompany'])){
    $adminClass->getSpecificCompanies($_POST['getCompany']);
}
if(isset($_POST['setupCompany'])){
    $adminClass->setupCompany($_POST['setupCompany']);
}

// lookup types function calls
if(isset($_POST['deleteLookupType'])){
    $adminClass->deleteLookupTypes($_POST['deleteLookupType']);
}
if(isset($_POST['getLookupType'])){
    $adminClass->getSpecificLookupTypes($_POST['getLookupType']);
}

// lookup type values function calls
if(isset($_POST['deleteLookupTypeValue'])){
    $adminClass->deleteLookupTypeValues($_POST['deleteLookupTypeValue']);
}
if(isset($_POST['getLookupTypeValue'])){
    $adminClass->getSpecificLookupTypeValues($_POST['getLookupTypeValue']);
}

// Asset function calls
if(isset($_POST['deleteAsset'])){
    $adminClass->deleteAsset($_POST['deleteAsset']);
}
if(isset($_POST['getAsset'])){
    $adminClass->getSpecificAssets($_POST['getAsset']);
}


?>