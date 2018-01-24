function loadAdminDetailsContent(){
    $("#pageContent").load("adminFiles/adminDetailsContent.php"); 
}

// loads form for adding division
function loadAddDivisionForm(){
    $("#pageContent").load("adminFiles/addDivisionForm.html"); 
}

// shows form for adding new departments
function loadAddDepartmentForm(){
    $("#pageContent").load("adminFiles/addDepartmentForm.html"); 
}

// shows form for adding new sub-departments
function loadAddSubDepartmentForm(){
    $("#pageContent").load("adminFiles/addSubDepartmentForm.html"); 
}

// loads form that is used for adding a team under a company 
function loadAddTeamForm(){
    $("#pageContent").load("adminFiles/addTeamForm.php"); 
}

// loads form used to reset user password 
function loadResetPasswordForm(){
    $("#pageContent").load("resetPassword.php"); 
}

// loads form for creation of a location
function loadAddLocationForm(){
    $("#pageContent").load("adminFiles/addLocationForm.html"); 
}

// shows form for adding a company
function loadAddCompanyForm(){
    $("#pageContent").load("adminFiles/addCompanyForm.html"); 
}

// loads form for user creation
function loadAddUserForm(){
    $("#pageContent").load("adminFiles/addUserForm.php"); 
}

// function to load company objects pageContent
function loadCompanyObjectsDetailsPage(value){
	$.post("adminFiles/setCompanySessionId.php",{companySessionId:value}, function(x){
			if(x=="success"){
			     $("#pageContent").load("adminFiles/companyObjectsDetails.php");
			}else{
			    alert('Error occured while loading company objects.')
			}
		});    
}

// loads form for Asset creation
function loadAddAssetForm(){
    $("#pageContent").load("adminFiles/addAssetForm.html"); 
}


// loads form for adding lookup type
function loadAddLookupTypeForm(){
    $("#pageContent").load("adminFiles/addLookupTypeForm.html"); 
}
// loads form for adding lookup type value
function loadAddLookupTypeValueForm(){
    $("#pageContent").load("adminFiles/addLookupTypeValueForm.html"); 
}
// function to load lookup type values page Content
function loadLookupTypeValuesPage(value){
	$.post("adminFiles/setLookupTypeSessionId.php",{lookupTypeSessionId:value}, function(x){
			if(x=="success"){
			     $("#pageContent").load("adminFiles/lookupTypeValues.php");
			}else{
			    alert('Error occured while loading company objects.')
			}
		}); 
}