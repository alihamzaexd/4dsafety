<?php
session_start();
require_once(dirname(__FILE__).'/adminActionManager.php');
$adminActionManager = new AdminActionManager();

?>

<div class="admin_content col-md-offset-1 col-md-10">
<script type='text/javascript'>
	function removeLocation(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{deleteLocation:value}, function(x){
			if(x == "success"){     // x contains response of the function
				document.getElementById('successMessage').innerHTML = 'Location deleted successfully!';
				document.getElementById('successDiv').style.display = 'block';
                setTimeout(function(){$("#pageContent").load("adminFiles/adminLocationsContent.php");document.getElementById('successDiv').style.display = 'none';  }, 2000);
			}
			else{
				document.getElementById('errorMessage').innerHTML = 'Problem in deletion! Probably location is being used by some company.';
				document.getElementById('errorDiv').style.display = 'block'; 
			    setTimeout(function(){$("#pageContent").load("adminFiles/adminLocationsContent.php");document.getElementById('errorDiv').style.display = 'none';  }, 3000);			
			}
		}); 
    }	
	function getSpecificLocation(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{getLocation:value}, function(x){
			if(x){     // x contains response of the function
	            document.getElementById('pageContent').innerHTML = x;
			}
			else{
			    alert("poor response");
                //setTimeout(function(){$("#pageContent").load("adminFiles/adminLocationsContent.php");document.getElementById('errorDiv').style.display = 'none';  }, 3000);			
			}
		}); 
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
	  <a onClick="loadAdminLocationsContent()" style="color:grey;">
	    <i class="fa fa-map-marker" aria-hidden="true"></i> Locations
	  </a>
	</li>
</ul>

<div class="row sub-header">
    <script src="javascript/adminPageJavascript.js"> </script>
    <h2>Locations 
    <div style="float:right; !important"><button class="btn btn-primary" onClick="loadAddLocationForm()">Add Location</button></div>
    </h2>
  </div>
  <br>
<div class="container-fluid" style="background-color:white; border-radius:10px; padding-top:15px; padding-bottom:15px; !important">
	<div class="table-responsive">
	  <table class="table table-bordered table-striped" id="example1">
		<thead>
		  <tr>
			<th><a class="sort_link " >Id</a></th>
			<th><a class="sort_link " >Name</a></th>
			<th><a class="sort_link " >Code</a></th>
			<th></th>
		  </tr>
		</thead>
		<tbody >
			<?php 
			if(!isset($_SESSION['locationNameFilter'])==true && !isset($_SESSION['locationCodeFilter'])==true)
			{
			$adminActionManager-> getLocations();
			}else{
			$adminActionManager-> getFilteredLocations();
			}	
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
  