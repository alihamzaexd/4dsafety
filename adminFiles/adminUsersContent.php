<?php
session_start();
require_once(dirname(__FILE__).'/adminActionManager.php');
$adminActionManager = new AdminActionManager();

?>

<div class="admin_content col-md-offset-1 col-md-10">
<script type='text/javascript'>
	function removeUser(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{deleteUser:value}, function(x){
			if(x=="success"){     // x contains response of the function
				document.getElementById('successMessage').innerHTML = 'User deleted successfully!';
				document.getElementById('successDiv').style.display = 'block';
                setTimeout(function(){$("#pageContent").load("adminFiles/adminUsersContent.php");document.getElementById('successDiv').style.display = 'none';  }, 2000);
			}
			else{
				document.getElementById('errorMessage').innerHTML = 'Problem in deletion! Probably user is involved in any Team.';
				document.getElementById('errorDiv').style.display = 'block'; 
			    setTimeout(function(){$("#pageContent").load("adminFiles/adminUsersContent.php");document.getElementById('errorDiv').style.display = 'none';  }, 3000);			
			}
		}); 
    }	
	function getSpecificUser(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{getCompany:value}, function(x){
			if(x){     // x contains response of the function
	            document.getElementById('pageContent').innerHTML = x;
			}
			else{
			    alert("Problem in connection!");		
			}
		}); 
    }

    function getCompanyObjects(value)  // function to show company objects page
	{
	    document.getElementById('pageContent').innerHTML = x;
    }	
</script>
<!-- overridden styling of the lable -->
<style>
label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
	color: #666 !important;
    font-weight: 400;
}
</style>
<ul class="breadcrumb" align="right"; style="background:rgba(255, 255, 255, .0);!important ">
    <li>
	  <a onClick="loadAdminDetailsContent()">
	    <i class="fa fa-home" aria-hidden="true"></i> Home
	  </a>
	</li>
	<li>
	  <a onClick="loadAdminUsersContent()" style="color:grey;">
	    <i class="fa fa-user" aria-hidden="true"></i> Users
	  </a>
	</li>
</ul>

  <div class="row sub-header">
    <script src="javascript/adminPageJavascript.js"> </script>
    <h2>Users 
    <div style="float:right; !important"><button class="btn btn-primary" onClick="loadAddUserForm()">Create User</button></div>
    </h2>
  </div>
  <br>
    <div class="container-fluid" style="background-color:white; border-radius:10px; padding-top:15px; padding-bottom:15px; !important">
	  <div class="table-responsive">
		<table id="example1"  class="table table-bordered table-striped">
		  <thead>
			<tr>
			  <th><a class="sort_link " >Name</a></th>
			  <th><a class="sort_link " >Email</a></th>
			  <th><a class="sort_link " >Accreditation No.</a></th>
			  <th><a class="sort_link " >Company</a></th>
			  <th><a class="sort_link " >Division</a></th>
			  <th><a class="sort_link " >Department</a></th>
			  <th><a class="sort_link " >Location</a></th>
			  <th><a class="sort_link " >Position</a></th>
			  <th></th>
			</tr>
		  </thead>
		  <tbody style="margin-bottom:10px; !important">
			<?php 
			$adminActionManager-> getUsers();
			?>
		  </tbody>
		</table>
	  </div>
    </div> <!-- container --> 
<script>
	// calling method to add pagination plugin on the table
	addPagination();
</script>
</div>