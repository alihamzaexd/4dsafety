<?php
    require_once(dirname(__FILE__).'/../db_connect.php');
	// building database connection
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();
	
	 echo "<script> 
			companySelect = document.getElementById('teamCompany');
			departmentSelect = document.getElementById('teamDepartment');
			divisionSelect = document.getElementById('teamDivision');
			locationSelect = document.getElementById('teamLocation');
		 </script>";
		 
	// fetching all companies 
	$sqlComp =<<<EOF
	  SELECT company_name,company_id from COMPANY;
EOF;
    $retComp = pg_query($conn, $sqlComp);
	while($row = pg_fetch_row($retComp)){
	    echo  "<script>
		  var opt = document.createElement('option');
			opt.value = '{$row[1]}';
			opt.innerHTML = '{$row[0]}';
			companySelect.appendChild(opt);
		  </script>";
		  
	} // populates company select menu	
?>
<script type='text/javascript'>

	function changeCompany(value)  // function that acts when the value of dropdown is changed
	{
	$.post("getSpecificCompanyUsers.php",{changedCompany:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamDivision").innerHTML = "<option value='' selected disabled> select division </option>"+x;
			}
			else{
				alert("No User Found");
				document.getElementById("teamDivision").innerHTML = "<option value='' selected disabled> No division for the company. </option>";
			}
		}); 
    }
	//=================================== Value Chanage listener on Division ===============================	
	function changeDivision(value)  // function that acts when the value of dropdown is changed
	{
	var company = document.getElementById("teamCompany").value;
	$.post("getSpecificCompanyUsers.php",{companyForDivision:company,changedDivision:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamDepartment").innerHTML = "<option value='' selected disabled> select department </option>"+x;
			}
			else{
				alert("No Division Found");
				document.getElementById("teamDepartment").innerHTML = "<option value='' selected disabled> No department for this division. </option>";
			}
		}); 
    }
	
	//=================================== Value Chanage listener on Department ===============================	
	
	function changeDepartment(value)  // function that acts when the value of dropdown is changed
	{
	var company = document.getElementById("teamCompany").value;
	var division = document.getElementById("teamDivision").value;
	$.post("getSpecificCompanyUsers.php",{companyForDepartment:company,divisionForDepartment:division,changedDepartment:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamSubDepartment").innerHTML = "<option value='' selected disabled> select sub-department </option>"+x;
			}
			else{
				alert("No Sub-Department Found");
				document.getElementById("teamSubDepartment").innerHTML = "<option value='' selected disabled> No sub-department for this department. </option>";
			}
		}); 
    }
	
	//=================================== Value Chanage listener on Department ===============================	
	
	function changeSubDepartment(value)  // function that acts when the value of dropdown is changed
	{
	var company = document.getElementById("teamCompany").value;
	var division = document.getElementById("teamDivision").value;
	var department = document.getElementById("teamDepartment").value;
	$.post("getSpecificCompanyUsers.php",{companyForSubDepartment:company,divisionForSubDepartment:division,departmentForSubDepartment:department,changedSubDepartment:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamLocation").innerHTML = "<option value='' selected disabled> select location </option>"+x;
			}
			else{
				alert("No Location Found");
				document.getElementById("teamLocation").innerHTML = "<option value='' selected disabled> No location for this department. </option>";
			}
		}); 
    }
	
	
	// ======================== action listener to fetch user matching filled form information ================
	
	function getCoaches()  // function that acts when the value of dropdown is changed
	{
	$.post("getSpecificCompanyUsers.php",{getCoaches:1}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamCoach").innerHTML ="<option value='' selected disabled> select team coach </option>"+x;
			}
			else{
				alert("No Coach Found");
				document.getElementById("teamCoach").innerHTML = "<option value='' selected disabled> No coach found. </option>";
			}
		}); 
    }
	$(document).ready(function() {
					getCoaches();
				});
	
	//============================= action listener to fetch canidates for champion role =====================
	
	function getChampions(value)  // function that acts when the value of dropdown is changed
	{
	var company = document.getElementById("teamCompany").value;
	var division = document.getElementById("teamDivision").value;
	var department = document.getElementById("teamDepartment").value;
	var subdepartment = document.getElementById("teamSubDepartment").value;
	var location = document.getElementById("teamLocation").value;
	$.post("getSpecificCompanyUsers.php",{companyForChampion:company,divisionForChampion:division,departmentForChampion:department,subdepartmentForChampion:subdepartment,locationForChampion:value,getChampions:1}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamChampion").innerHTML = "<option value='' selected disabled> select team champion </option>"+x;
			}
			else{
				alert("No Champion Found");
				document.getElementById("teamChampion").innerHTML = "<option value='' selected disabled> No employee found. </option>";
			}
		}); 
    }
	
	//============================= action listener to fetch canidates for team leader role =====================
	function changeChampion(value)  // function that acts when the value of dropdown is changed
	{
	var company = document.getElementById("teamCompany").value;
	var division = document.getElementById("teamDivision").value;
	var department = document.getElementById("teamDepartment").value;
	var subdepartment = document.getElementById("teamSubDepartment").value;
	var location = document.getElementById("teamLocation").value;
	var coach = document.getElementById("teamCoach").value;
	$.post("getSpecificCompanyUsers.php",{companyForLeader:company,divisionForLeader:division,departmentForLeader:department,subdepartmentForLeader:subdepartment,locationForLeader:location,coachForLeader:coach,changedChampion:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamLeader").innerHTML = "<option value='' selected disabled> select team leader </option>"+x;
			}
			else{
				alert("No Employee Found");
				document.getElementById("teamLeader").innerHTML = "<option value='' selected disabled> No employee found. </option>";
			}
		}); 
    }
	
	// ======================== action listener on team leader to populate canidates for team member =============
	function changeTeamLeader(value)  // function that acts when the value of dropdown is changed
	{
	var company = document.getElementById("teamCompany").value;
	var division = document.getElementById("teamDivision").value;
	var department = document.getElementById("teamDepartment").value;
	var subdepartment = document.getElementById("teamSubDepartment").value;
	var location = document.getElementById("teamLocation").value;
	var coach = document.getElementById("teamCoach").value;
	var champion = document.getElementById("teamChampion").value;
	$.post("getSpecificCompanyUsers.php",{companyForTeamMember:company,divisionForTeamMember:division,departmentForTeamMember:department,subdepartmentForTeamMember:subdepartment,locationForTeamMember:location,coachForTeamMember:coach,championForTeamMember:champion,changedTeamLeader:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamMember").innerHTML = "<label class='string required'> Team Members</label></br><select id='multi-select-demo' name='multi-select-demo[]' multiple='multiple' required='required'>"+x+"</select></div>";
				$(document).ready(function() {
					$('#multi-select-demo').multiselect();
				});
				
			}
			else{
				alert("No team member Found");
				document.getElementById("teamMember").innerHTML = "<label class='string required'> Team Members</label></br><select id='multi-select-demo' multiple='multiple' required='required'><option value='' disabled> No company employee found. </option></select></div>";
				$(document).ready(function() {
					$('#multi-select-demo').multiselect();
				});
			}
		}); 
    }
	// TO DO => now just insert form entries into the database in the related tables
	
</script>
<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
    <li>
	  <a onClick="loadAdminDetailsContent()">
	    <i class="fa fa-home" aria-hidden="true"></i> Home
	  </a>
	</li>
	<li>
	  <a onClick="loadAdminTeamsContent()">
	    <i class="fa fa-users" aria-hidden="true"></i> Teams
	  </a>
	</li>
	<li>
	  <a onClick="loadAddTeamForm()" style="color:grey;">
	    <i class="fa fa-plus" aria-hidden="true"></i> Add team
	  </a>
	</li>
</ul>

<!-- add team form -->
<div id="addTeamForm" class="admin_content col-md-offset-1 col-md-10">    
	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h4>New Team</h4>
	  	</div>
		<div class="panel-body">
		    <form role="form" class="simple_form new_account" id="addTeamForm" action="" accept-charset="UTF-8" method="post">
		    <input name="utf8" type="hidden" value="&#x2713;" />
			<div class="form-group col-md-12" style="border-bottom:3px solid #f7f7f9; padding-bottom:2%;">
				<div class="form-group col-md-6">				
		        	<label class="string required" for="teamName"> * Name</label>
		        	<input autofocus="autofocus" class="form-control" required="required" type="text" name="teamName" id="teamName" />
				</div>
				<div class="form-group col-md-6">
		        	<label class="string required" for="teamTag"> * Tag</label>
		        	<input autofocus="autofocus" class="form-control" required="required" type="text" name="teamTag" id="teamTag" />
		      	</div>
			</div>
			<div class="form-group col-md-12" style="border-bottom:3px solid #f7f7f9; padding-top:2%; padding-bottom:2%;">
				<div class="form-group col-md-12">
		        	<label class="string required" for="teamCompany"> Company</label>
		        	<select class="form-control" id="teamCompany" name="teamCompany" required="required" style="background-color:#f7f7f9;" onChange="changeCompany(this.value);">
						<!-- php function adds company options here -->
						<option value="" selected disabled> select company</option>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label class="string required" for="teamDivision"> Division</label>
		        	<select class="form-control" id="teamDivision" name="teamDivision" required="required" style="background-color:#f7f7f9;" onChange="changeDivision(this.value);">
						<!-- php function adds Division options here -->
						<option value="" selected disabled> select division</option>
					</select>
			    </div>
				<div class="form-group col-md-6">
					<label class="string required" for="teamDepartment"> Department</label>
		        	<select class="form-control" id="teamDepartment" name="teamDepartment" required="required" style="background-color:#f7f7f9;" onChange="changeDepartment(this.value);">
						<!-- php function adds Department options here -->
						<option value="" selected disabled> select department</option>
					</select>
			    </div>
				<div class="form-group col-md-6">
					<label class="string required" for="teamSubDepartment"> Sub-Department</label>
		        	<select class="form-control" id="teamSubDepartment" name="teamSubDepartment" required="required" style="background-color:#f7f7f9;" onChange="changeSubDepartment(this.value);">
						<!-- php function adds Department options here -->
						<option value="" selected disabled> select sub-department</option>
					</select>
			    </div>
				<div class="form-group col-md-6">
					<label class="string required" for="teamLocation"> Location</label>
		        	<select class="form-control" id="teamLocation" name="teamLocation" required="required" style="background-color:#f7f7f9;" onChange="getChampions(this.value);">
						<!-- php function adds Location options here -->
						<option value="" selected disabled> select location</option>
					</select>
				</div>
		    </div>
			<div class="form-group col-md-6">
					<label class="string required" for="teamCoach"> Coach</label>
		        	<select class="form-control" id="teamCoach" name="teamCoach" required="required" style="background-color:#f7f7f9;" onChange="changeCoach(this.value);">
						<!-- php function adds team coach options here -->
					</select>
			</div>
				<div class="form-group col-md-6">
					<label class="string required" for="teamChampion"> Champion</label>
		        	<select class="form-control" id="teamChampion" name="teamChampion" required="required" style="background-color:#f7f7f9;" onChange="changeChampion(this.value);">
						<!-- php function adds team leader options here -->
					</select>
				</div>
				<div class="form-group col-md-6">
					<label class="string required" for="teamLeader"> Team Leader</label>
		        	<select class="form-control" id="teamLeader" name="teamLeader" required="required" style="background-color:#f7f7f9;" onChange="changeTeamLeader(this.value);">
						<!-- php function adds team leader options here -->
					</select>
				</div>
				<div class="form-group col-md-6" id="teamMember">
				 
			    </div>
				<div class="form-group col-md-12">
					<input type="submit" name="addTeam" value="Add Team" class="btn btn-primary" /> 
		      	</div>
			</form>  
		</div>
	</div>
</div>