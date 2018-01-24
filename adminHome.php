<?php
session_start();
global $username;
if($_SESSION['userType'] != 'slgadmin'){ # send invalid user back to login page
	header("Location: index.php");
}else
	{  	
		$username = $_SESSION['username'];
		require_once(dirname(__FILE__).'/db_connect.php');
		require_once(dirname(__FILE__).'/userFiles/userAccountHandler.php');
		require_once(dirname(__FILE__).'/adminFiles/adminActionManager.php');
		global $userAccountHanlder,$adminActionManager;
		$userAccountHanlder = new UserAccountHandler();
		$adminActionManager = new AdminActionManager();		
?>
<!DOCTYPE html>
<html>

<head>
    <script src="javascript/adminPageJavascript.js"> </script>
    <?php
    	// including Bootstrap, css and javascripts files
	    require_once(dirname(__FILE__).'/external_files.php');

	    // adding navigation bar to the page
	    require_once(dirname(__FILE__).'/adminFiles/adminNavbar.php');
	
	    // including file with db connector functions
	    require_once(dirname(__FILE__).'/db_connect.php');
    ?>
    <!-- pulgin scripts for multiple select -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>

    <!-- multi select stlyle files-->
    <link rel="stylesheet" href="css/bootstrap-multiselect/bootstrap-multiselect.css" type="text/css"> 
    <script type="text/javascript" src="js/bootstrap-multiselect/bootstrap-multiselect.js"></script>

	<!-- datatables pagination required files -->
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="asset/css/paginationStyling.css"/>
</head>

<body style="background-image:url(
http://www.template-joomspirit.com/template-joomla/template-107/images/background/light-red-NR.jpg);">

	<div id="errorDiv" class="alert alert-danger alert-dismissible" role="alert" style="display:none;">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
		<div id="errorMessage">
			<!-- Signup error messages are shown here. -->
		</div>
	</div>	
	
	<div id="successDiv" class="alert alert-success alert-dismissible" role="alert" style="display:none;" >
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
		<div id="successMessage">
			<!-- Signup success messages are shown here. -->
		</div>
	</div>
	<!-- modal -->
	<div class="modal fade" id="editDetails">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="modal_header">
					<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
	&times;</button>
				<center>	
				<br>
				<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
	!important;">Personal Details</h4>
				</center>
				<br>
				</div><!-- end modal-header -->
				<div class="modal-body">
					<div class="col-md-6">
						<form id="personForm" action="" method="post">
							<label>
							<b>*First Name: </b></label>  
							<input type="text" name="firstName" id="person_firstName" class="form-control" 
							value="<?php if(isset($_SESSION['firstName'])) {echo $_SESSION['firstName']; } ?>" >		
							<br><br>
							<label>
							<b>Middle Name: </b></label>  
							<input type="text" id="middleName" name="middleName" class="form-control"
							value="<?php if(isset($_SESSION['middleName'])) {echo $_SESSION['middleName']; } ?>">		
							<br><br>
							<label>
							<b>Last Name: </b></label>  
							<input type="text" id="lastName" name="lastName" class="form-control"
							value="<?php if(isset($_SESSION['lastName'])) {echo $_SESSION['lastName']; } ?>">		
							<br><br>
							<label>
							<b>CNIC: </b></label>  
							<input type="text" id="cnic" name="cnic" class="form-control"
							value="<?php if(isset($_SESSION['cnic'])) {echo $_SESSION['cnic']; } ?>">		
							<br><br>
							<label>
							<b>Date of Birth: </b></label>  
							<input type="date" id="dob" name="dob" class="form-control"
							value="<?php if(isset($_SESSION['dob'])) {echo $_SESSION['dob']; } ?>">		
							<br><br>
							<label>
							<b>Nationality: </b></label>  
							<input type="text" id="nationality" name="nationality" class="form-control" 
							value="<?php if(isset($_SESSION['nationality'])) {echo $_SESSION['nationality']; } ?>">		
							<br><br>
							<label>
							<b>Blood Group: </b></label> 
							<select id="bloodGroup" name="bloodGroup" class="form-control">
							<option>
							    <?php if(isset($_SESSION['bloodGroup'])) {echo $_SESSION['bloodGroup']; } ?>
							</option>
							<option>AB+</option>
							<option>AB-</option>
							<option>O+</option>
							<option>O-</option>
							<option>A+</option>
							<option>A-</option>
							<option>B+</option>
							<option>B-</option>
							</select>
							<br><br>
							<label>
							<b>Marital Status: </b></label> 
							<select id="maritalStatus" name="maritalStatus" class="form-control">
							<option>
							    <?php if(isset($_SESSION['maritalStatus'])) {echo $_SESSION['maritalStatus']; } ?>
							</option>
							<option>Single</option>
							<option>Married</option>
							<option>Divorced</option>
							<option>Widow</option>
							<option>Widower</option>
							</select>
							<br><br>
							<label>
							<b>Gender: </b></label> 
							<select id="gender" name="gender" class="form-control">
							<option 
							<?php if(isset($_SESSION['gender']) == true && $_SESSION['gender'] == 'Male') {echo "selected" ; } ?>
							>Male</option>
							<option
							<?php if(isset($_SESSION['gender']) == true && $_SESSION['gender'] == 'Female') {echo "selected" ; } ?>
							>Female</option>
							<option
							<?php if(isset($_SESSION['gender']) == true && $_SESSION['gender'] == 'Other') {echo "selected" ; } ?>
							>Other</option>
							</select>
							<br><br>
							<button name="updateUserPersonalDetails" type="submit" class="btn btn-primary">Save</button>
						</form>	
								
					</div>
				</div><!-- end modal-body -->
				<br>
				<div class="modal-footer">
					<button data-dismiss="modal">Back</button>
				</div><!-- end modal-footer -->
			</div><!-- end modal-content -->
		</div><!-- end modal-dialog --> 
	</div><!-- end modal -->
	<!-- modal ending -->
	
	<!-- contact modal -->
	<div class="modal fade" id="editContactDetails">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="modal_header">
					<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
	&times;</button>
				<center>	
				<br>
				<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
	!important;">Contact Details</h4>
				</center>
				<br>
				</div><!-- end modal-header -->
				<div class="modal-body">
					<div class="col-md-6">
						<form id="personForm" action="" method="post">
							<label>
							<b>*Email: </b></label>  
							<input type="text" name="email" id="email" class="form-control" 
							value="<?php if(isset($_SESSION['email'])) {echo $_SESSION['email']; } ?>" disabled>				
							<br><br>
							<label>
							<b>Mobile:</b></label>  
							<input type="text" id="mobile" name="mobile" class="form-control"
							value="<?php if(isset($_SESSION['mobile'])) {echo $_SESSION['mobile']; } ?>">		
							<br><br>
							<label>
							<b>Landline: </b></label>  
							<input type="text" id="landline" name="landline" class="form-control"
							value="<?php if(isset($_SESSION['landline'])) {echo $_SESSION['landline']; } ?>">		
							<br><br>
							<label>
							<b>Fax: </b></label>  
							<input type="text" id="fax" name="fax" class="form-control"
							value="<?php if(isset($_SESSION['fax'])) {echo $_SESSION['fax']; } ?>" >		
							<br><br>
							<button name="updateUserContactDetails" type="submit" class="btn btn-primary">Save</button>
						</form>	
								
					</div>
				</div><!-- end modal-body -->
				<br>
				<div class="modal-footer">
					<button data-dismiss="modal">Back</button>
				</div><!-- end modal-footer -->
			</div><!-- end modal-content -->
		</div><!-- end modal-dialog --> 
	</div><!-- end modal -->	
	<!-- modal ending -->
	
	<!-- address modal -->
	<div class="modal fade" id="editAddressDetails">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="modal_header">
					<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
	&times;</button>
				<center>	
				<br>
				<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
	!important;">Address Details</h4>
				</center>
				<br>
				</div><!-- end modal-header -->
				<div class="modal-body">
					<div class="col-md-6">
						<form id="personForm" action="" method="post">
							<label>
							<b>Address: </b></label>  
							<input type="text" name="address" id="address" class="form-control" 
							value="<?php if(isset($_SESSION['address'])) {echo $_SESSION['address']; } ?>">				
							<br><br>
							<label>
							<b>City:</b></label>  
							<input type="text" id="city" name="city" class="form-control"
							value="<?php if(isset($_SESSION['city'])) {echo $_SESSION['city']; } ?>">		
							<br><br>
							<label>
							<b>Zip Code: </b></label>  
							<input type="text" id="zip" name="zip" class="form-control"
							value="<?php if(isset($_SESSION['zip'])) {echo $_SESSION['zip']; } ?>">		
							<br><br>
							<label>
							<b>State: </b></label>  
							<input type="text" id="state" name="state" class="form-control"
							value="<?php if(isset($_SESSION['state'])) {echo $_SESSION['state']; } ?>" >	
                            <br><br>
							<label>
							<b>Country: </b></label>  
							<input type="text" id="country" name="country" class="form-control"
							value="<?php if(isset($_SESSION['country'])) {echo $_SESSION['country']; } ?>" >
                            <br><br>
							<label>
							<b>Address Type: </b></label>  
							<input type="text" id="addressDescription" name="addressDescription" class="form-control"
							value="<?php if(isset($_SESSION['addressDescription'])) {echo $_SESSION['addressDescription']; } ?>" >
							
							<br><br>
							<button name="updateUserAddressDetails" type="submit" class="btn btn-primary">Save</button>
						</form>	
								
					</div>
				</div><!-- end modal-body -->
				<br>
				<div class="modal-footer">
					<button data-dismiss="modal">Back</button>
				</div><!-- end modal-footer -->
			</div><!-- end modal-content -->
		</div><!-- end modal-dialog --> 
	</div><!-- end modal -->
	<!-- modal ending -->
	
	<!-- modal -->
	<div class="modal fade" id="editProfilePictureModal">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div id="modal_header">
					<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
	&times;</button>
				<center>	
				<br>
				<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
	!important;">Change Profile Picture</h4>
				</center>
				<br>
				</div><!-- end modal-header -->
				<div class="modal-body" style="padding:5%; height:150px; !important">
					<form id="personForm" action="" method="post" enctype="multipart/form-data">
						<label>
						<b>Profile Picture </b></label>  
						<input type="file" name="fileToUpload" id="fileToUpload" required="required">
						<br>
						<button name="updateUserProfilePicture" type="submit" class="btn btn-primary">Update</button>
					</form>			
				</div><!-- end modal-body -->
				<div class="modal-footer">
					<button data-dismiss="modal">Back</button>
				</div><!-- end modal-footer -->
			</div><!-- end modal-content -->
		</div><!-- end modal-dialog --> 
	</div><!-- end modal -->
	
	<div id="pageContent" style="margin:20px; !important">
	    <!-- content of this area comes from javascript based on user selection -->
    </div>
	<br><br>
	
	
	<?php 	

		// ================================= location section =================================
	    if(isset($_POST["addLocation"])){
           $adminActionManager->addLocations();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminLocationsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateLocation"])){
           $adminActionManager->updateLocations();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminLocationsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }	
		// ================================= division Section =================================
		elseif(isset($_POST["addDivision"])){
           $adminActionManager->addDivisions();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminDivisionsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateDivision"])){
           $adminActionManager->updateDivisions();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminDivisionsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }	
		
		// ============================    department Section ==================================
		elseif(isset($_POST["addDepartment"])){
           $adminActionManager->addDepartments();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminDepartmentsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateDepartment"])){
           $adminActionManager->updateDepartments();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminDepartmentsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
       // ============================  sub-department Section  ==================================
		elseif(isset($_POST["addSubDepartment"])){
           $adminActionManager->addSubDepartments();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminSubDepartmentsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateSubDepartment"])){
           $adminActionManager->updateSubDepartments();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminSubDepartmentsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }	
		// ================================= Teams Section =================================
		elseif(isset($_POST["addTeam"])){
           $adminActionManager->addTeams();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminTeamsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		// ============================    Companies Section ==================================
		elseif(isset($_POST["addCompany"])){
           $adminActionManager->addCompanies();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminCompaniesContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateCompany"])){
           $adminActionManager->updateCompanies();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminCompaniesContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["createCompanyObject"])){
           $adminActionManager->addCompanyObject();
        }
		
		// ================================= Lookup Types Section =================================
		elseif(isset($_POST["addLookupType"])){
           $adminActionManager->addLookupTypes();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminLookupsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateLookupType"])){
           $adminActionManager->updateLookupTypes();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminLookupsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		// ================================= Lookup Type Values Section =================================
		elseif(isset($_POST["addLookupTypeValue"])){
           $adminActionManager->addLookupTypeValues();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/lookupTypeValues.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateLookupTypeValue"])){
           $adminActionManager->updateLookupTypeValues();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/lookupTypeValues.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
       // ================================= Asset Section =================================
		elseif(isset($_POST["addAsset"])){
           $adminActionManager->addAssets();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminAssetsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		elseif(isset($_POST["updateAsset"])){
           $adminActionManager->updateAssets();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminAssetsContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }
		
		// ============================    Users Section ==================================
		elseif(isset($_POST["addUser"])){
           $adminActionManager->addUsers();
		   echo '<script> setTimeout(function(){$("#pageContent").load("adminFiles/adminUsersContent.php");document.getElementById("successDiv").style.display = "none";document.getElementById("errorDiv").style.display = "none";}, 2000);</script>';
        }else{
		echo '<script>
             $("#pageContent").load("adminFiles/adminUsersContent.php")
            </script>';
		}
		// ================================================================================= //
		
		if(isset($_POST['reset_password']))
		{	
			$userAccountHanlder->resetPassword();
			echo "<script> loadResetPasswordForm(); </script>";	
		}
		elseif(isset($_POST['updateUserProfilePicture']))
		{	
			$userAccountHanlder->updateUserProfilePicture();
			echo "<script> loadUserDetailsContent(); </script>";	
		}
		elseif(isset($_POST['updateUserPersonalDetails']))
		{
			$userAccountHanlder->updateUserPersonalDetails();
			$userAccountHanlder->getUserPersonalDetails();
			echo '<meta http-equiv="refresh" content="1">';
			echo "<script> loadUserDetailsContent(); </script>";
		}elseif(isset($_POST['updateUserContactDetails']))
		{
			$userAccountHanlder->updateUserContactDetails();
			$userAccountHanlder->getUserContactDetails();
			echo '<meta http-equiv="refresh" content="1">';
			echo "<script> loadUserDetailsContent(); </script>";
		}elseif(isset($_POST['updateUserAddressDetails']))
		{
			$userAccountHanlder->updateUserAddressDetails();
			$userAccountHanlder->getUserAddressDetails();
			echo '<meta http-equiv="refresh" content="1">';
			echo "<script> loadUserDetailsContent(); </script>";
		}
		else{
			$userAccountHanlder->getUserPersonalDetails();
			$userAccountHanlder->getUserAddressDetails();
			$userAccountHanlder->getUserContactDetails();
		    echo '<script> loadUserDetailsContent();  </script>';
		}
	?>
	
<script>	
// script to add DataTable pagination the #example1 table
   function addPagination() {
     $('#example1').DataTable();
  }
	$(function () {
    $('#example1').DataTable();
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
</body>
</html>

<?php 
} // enclosing page into else statement
?>