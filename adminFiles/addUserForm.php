<?php
//TODO

// Add user to coach and champion tables if selected
// create user_coaches and user_champions tables,add coaches and champions to user if assigned by admin

    require_once(dirname(__FILE__).'/../db_connect.php');
	// building database connection
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();
	echo "<script> 
	        positionSelect = document.getElementById('position');
		</script>";
		 
	// fetching all positions 
	$sqlPosition =<<<EOF
	  SELECT position_name,position_id from POSITION;
EOF;
    $retPosition = pg_query($conn, $sqlPosition);
	while($row = pg_fetch_row($retPosition)){
	    echo  "<script>
		  var opt = document.createElement('option');
			opt.value = '{$row[1]}';
			opt.innerHTML = '{$row[0]}';
			positionSelect.appendChild(opt);
		  </script>";
		  
	} // populates position select menu

	 echo "<script> 
			coachAccountSelect = document.getElementById('coachSelect');
		 </script>";	 
   $sqlCoaches =<<<EOF
	  SELECT P.person_firstname,P.person_lastname,C.coach_id from PERSON as P,COACH as C
	  WHERE P.person_id = C.person_id;
EOF;
    $retCoaches = pg_query($conn, $sqlCoaches);
	while($row = pg_fetch_row($retCoaches)){
	    echo  "<script>
		  var opt = document.createElement('option');
			opt.value = '{$row[2]}';
			opt.innerHTML = '{$row[0]} {$row[1]}';
			coachAccountSelect.appendChild(opt);
		  </script>";	  
	} // populates company select menu		
?>

<script>
//============================= action listener to fetch company information of the position =====================
	
	function changePosition(value)  // function that acts when the value of dropdown is changed
	{
	document.getElementById("isCoach").disabled = false;
	document.getElementById("isChampion").disabled = false;
	document.getElementById("coachAccountDiv").style.display = "block";
	document.getElementById("championAccountDiv").style.display = "block";
	$.post("adminFiles/getPositionCompanyInfo.php",{changedPosition:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("positionCompanyInfo").innerHTML = x;
				document.getElementById("positionCompanyInfo").style.display = "block";
			}
			else{
				alert("No company information found");
				document.getElementById("positionCompanyInfo").innerHTML = "No Company Information found for the selected Position";
				document.getElementById("positionCompanyInfo").style.display = "block";
			}
		}); 
	$.post("adminFiles/getInfoForUserCreation.php",{changedPosition:value}, function(x){
			if(x){     			// x contains response of the function
			document.getElementById("championAccountDiv").innerHTML = "<div class='form-group col-md-6'><label> Champion Account</label></br><select id='championSelect' name='championSelect[]' multiple='multiple' style='background-color:#f7f7f9;'>"+x+"</select></div>";
			$(document).ready(function() {
				  $('#championSelect').multiselect();
				});
			}
			else{
			}
		}); 
    }

//============================= function to validate email/current username (both)  ===============================
function changeEmail(value)  // function that acts when the value of dropdown is changed
	{
	var username = document.getElementById("accountUsername").value;
	$.post("adminFiles/validateUser.php",{changedEmail:value,currentUsername:username}, function(x){
			if(x=="valid"){                                                          // x contains response of the function
				document.getElementById("successMessage").innerHTML = "<strong>Available!</strong>";
				document.getElementById("successDiv").style.display = "block";
				document.getElementById("errorDiv").style.display = "none";
				document.getElementById("addUser").disabled = false;
				setTimeout(function(){document.getElementById("successDiv").style.display = "none";}, 3000);
			}
			else{
				if(x=="invalid email"){
				document.getElementById("errorMessage").innerHTML = "<strong>Email already exists.</strong> Try different.";
				}else if(x=="invalid username"){
				document.getElementById("errorMessage").innerHTML = "<strong>Username already exists.</strong> Try different.";
				}else{
				document.getElementById("errorMessage").innerHTML = "<strong>Both Email and Username already exist.</strong> Try different.";
				}
				document.getElementById("errorDiv").style.display = "block";
				document.getElementById("successDiv").style.display = "none";
				document.getElementById("addUser").disabled = true;
				setTimeout(function(){document.getElementById("errorDiv").style.display = "none";}, 3000);
			}
		}); 
    }

//============================== function to validate username/current email (both) ================================
function changeUsername(value)  // function that acts when the value of dropdown is changed
	{
	var email = document.getElementById("accountEmail").value;
	$.post("adminFiles/validateUser.php",{changedUsername:value,currentEmail:email}, function(x){
			if(x=="valid"){                      // x contains response of the function
				document.getElementById("successMessage").innerHTML = "<strong>Available!</strong>";
				document.getElementById("successDiv").style.display = "block";
				document.getElementById("errorDiv").style.display = "none";
				document.getElementById("addUser").disabled = false;
				setTimeout(function(){document.getElementById("successDiv").style.display = "none";}, 3000);
			}
			else{
				if(x=="invalid email"){
				document.getElementById("errorMessage").innerHTML = "<strong>Email already exists.</strong> Try different.";
				}else if(x=="invalid username"){
				document.getElementById("errorMessage").innerHTML = "<strong>Username already exists.</strong> Try different.";
				}else{
				document.getElementById("errorMessage").innerHTML = "<strong>Both Email and Username already exist.</strong> Try different.";
				}
				document.getElementById("errorDiv").style.display = "block";
				document.getElementById("successDiv").style.display = "none";
				document.getElementById("addUser").disabled = true;
				setTimeout(function(){document.getElementById("errorDiv").style.display = "none";}, 3000);
			}
		}); 
    }
	
//========================================= function to show/hide coach accounts ===================================
function isCoachCheckbox(value)  // function that acts when the checkbox is checked or unchecked
	{
		var isCoachCheck = document.getElementById("isCoach");
		if(isCoachCheck.checked)
		{
		    document.getElementById("accreditationNumber").disabled = false;
			document.getElementById("coachAccountDiv").style.display = "none";
			document.getElementById("championAccountDiv").style.display = "none";
		}else{
		    document.getElementById("coachAccountDiv").style.display = "block";
			if(!document.getElementById("isChampion").checked)
			{
			    document.getElementById("accreditationNumber").disabled = true;
			    document.getElementById("championAccountDiv").style.display = "block";
			}
		}
    }

//========================================= function to show/hide champion accounts ===============================
function isChampionCheckbox(value)  // function that acts when the checkbox is checked or unchecked
	{
		var isChampionCheck = document.getElementById("isChampion");
		if(isChampionCheck.checked)
		{
		    document.getElementById("accreditationNumber").disabled = false;
			document.getElementById("championAccountDiv").style.display = "none";
		}else{
		if(!document.getElementById("isCoach").checked)
		    {
			document.getElementById("accreditationNumber").disabled = true;
			document.getElementById("championAccountDiv").style.display = "block";
			}
		}
    }
</script>
<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
    <li>
	  <a onClick="loadAdminDetailsContent()">
	    <i class="fa fa-home" aria-hidden="true"></i> Home
	  </a>
	</li>
	<li>
	  <a onClick="loadAdminUsersContent()">
	     <i class="fa fa-user" aria-hidden="true"></i> Users
	  </a>
	</li>
	<li>
	  <a onClick="loadAddUserForm()" style="color:grey;">
		<i class="fa fa-user-plus" aria-hidden="true"></i> Add user
	  </a>
	</li>
</ul>

<!-- add team form -->
<div id="addUserDiv" class="admin_content col-md-offset-1 col-md-10">    
	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h4>New User</h4>
	  	</div>
		<div class="panel-body">
		    <form role="form" class="simple_form new_account" id="addUserForm" action="" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
		    <input name="utf8" type="hidden" value="&#x2713;" />
			<div class="form-group col-md-12" style="border-bottom:3px solid #f7f7f9; padding-bottom:2%;">
				<div class="form-group col-md-6">				
		        	<label class="string required" for="firstName"> * First Name</label>
		        	<input autofocus="autofocus" class="form-control" required="required" type="text" name="firstName" id="firstName" />
				</div>
				<div class="form-group col-md-6">
		        	<label class="string required" for="lastName"> Last Name</label>
		        	<input autofocus="autofocus" class="form-control" type="text" name="lastName" id="lastName" />
		      	</div>
				<div class="form-group col-md-12">				
		        	<label for="accountEmail"> * Email</label>
		        	<input autofocus="autofocus" class="form-control" required="required" type="email" name="accountEmail" id="accountEmail" onChange="changeEmail(this.value);"/>
				</div>
				<div class="form-group col-md-6">				
		        	<label class="string required" for="accountUsername"> * Username</label>
		        	<input autofocus="autofocus" class="form-control" required="required" type="text" name="accountUsername" id="accountUsername" onChange="changeUsername(this.value);"/>
				</div>
				
				<div class="form-group col-md-6">
		        	<label class="string required" for="password"> * Password</label>
		        	<input autofocus="autofocus" class="form-control" required="required" type="text" name="password" id="password" />
		      	</div>
			</div>
			<div class="form-group col-md-12" style="border-bottom:3px solid #f7f7f9; padding-bottom:2%; padding-top:2%;">
			    <div class="form-group col-md-6">
		        	<label class="string required" for="type"> Role</label>
		        	<select class="form-control" id="type" name="type" required="required" style="background-color:#f7f7f9;">
						<!-- php function adds company options here -->
						<option value="" selected disabled> select role</option>
						<option value="slgadmin" > Admin</option>
						<option value="user" > Company User</option>
					</select>
				</div>
				<div class="form-group col-md-6" id="positionDiv">
		        	<label class="string required" for="position"> Position</label>
		        	<select class="form-control" id="position" name="position" required="required" style="background-color:#f7f7f9;" onChange="changePosition(this.value);">
						<!-- php function adds company options here -->
						<option value="" selected disabled> select position</option>
					</select>
				</div>
				<div class="form-group col-md-12">
		        	<label class="string required" for="accreditationNumber"> Accreditation Number</label>
		        	<input autofocus="autofocus" class="form-control" required="required" type="text" name="accreditationNumber" id="accreditationNumber" disabled />
		      	</div>
				<div class="form-group col-md-12">
				    <input type="checkbox" name="isCoach" id="isCoach" value="coach" onClick="isCoachCheckbox(this.value);"  disabled> Is Coach<br>
                    <input type="checkbox" name="isChampion" id="isChampion" value="champion" onClick="isChampionCheckbox(this.value);" disabled> Is Champion<br>
				</div>
				<div id="coachAccountDiv" style="display:none;">
				    <div class="form-group col-md-6">
		        	    <label> Coach Account</label></br>
					    <select id='coachSelect' name='coachSelect[]' multiple='multiple' style="background-color:#f7f7f9;">
					    </select>
				    </div>
				</div>
				<div id="championAccountDiv" style="display:none;">
				    <div class="form-group col-md-6">
					    <label > Champion Account</label></br>
					    <select id='championSelect' name='championSelect[]' multiple='multiple' style="background-color:#f7f7f9;">
						<option value="" selected disabled> No Coach Available</option>
					    </select>
				    </div>
				</div>
				<script>
				    $(document).ready(function() {
					    $('#coachSelect').multiselect();
						$('#championSelect').multiselect();
				    });
				</script>
				
		    </div>
			<div id="positionCompanyInfo" name="positionCompanyInfo" class="form-group col-md-12" style="border-bottom:3px solid #f7f7f9; padding-bottom:2%; display:none;">
			<!-- div to show company information for the position selected above -->
			</div>
			
			<div class="form-group col-md-12">
				<div class="form-group col-md-12">
					<label for="fileToUpload">Profile Picture</label>
					<input type="file" name="fileToUpload" id="fileToUpload">
				</div>
				 
				<div class="form-group col-md-12">
					<label class="string required" for="commitmentStatement"> Commitment Statement</label>
					<textarea class="text optional form-control" name="commitmentStatement" id="commitmentStatement">
					</textarea>
				</div>
			</div>
			
			<div class="form-group col-md-12" style="padding-top:2%; padding-bottom:2%;">
				<div class="form-group col-md-12">
					<input type="submit" id="addUser" name="addUser" value="Create User" class="btn btn-primary" /> 
		      	</div>  
		    </div>
			</form>
		</div>
	</div>
</div>