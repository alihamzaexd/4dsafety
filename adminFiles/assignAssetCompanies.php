<?php
session_start();
require_once(dirname(__FILE__).'/adminActionManager.php');
$adminActionManager = new AdminActionManager();
?>
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

<script>
//  function gets called when a user is checked or otherwise. To remove and assign asset to selected user
function assignAssetToCompany(value){
    var checkBoxId = "checkbox"+value;
    var checkBox = document.getElementById(checkBoxId);
	if(checkBox.checked){ // if user seleced for asset assignment
		$.post("adminFiles/assetAssignmentScript.php",{companyIdForAssetAssignment:value}, function(x){
			if(x=="success"){     // x contains response of the function
			    alert("Asset assigned!")
				$("#pageContent").load("adminFiles/assignAssetCompanies.php"); 
			}
			else{
				alert("Problem Occured! Asset could not be assigned.");		
			}
	    }); 
	}else{  // if the assignment check box was unchecked
		$.post("adminFiles/assetAssignmentScript.php",{companyIdForAssetRemoval:value}, function(x){
			if(x=="success"){     // x contains response of the function
			    alert("Asset removed!")
				$("#pageContent").load("adminFiles/assignAssetCompanies.php"); 
			}
			else{
				alert("Problem Occured! Asset could not be unassigned.");		
			}
	    }); 
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
	  <a onClick="loadAdminAssetsContent()">
	    Assets
	  </a>
	</li>
	<li>
	  <a onClick="" style="color:grey;">
	    <i class="fa fa-check" aria-hidden="true"></i> Assign companies
	  </a>
	</li>
</ul>

<div class="admin_content col-md-offset-1 col-md-10">


  <div class="row sub-header">
    <script src="javascript/adminPageJavascript.js"> </script>
    <h2>Company Asset Assignment
    </h2>
  </div>
  <br>
    <div class="container-fluid" style="background-color:white; border-radius:10px; padding-top:15px; padding-bottom:15px; !important">
	  <div class="table-responsive">
		<table id="example1"  class="table table-bordered table-striped">
		  <thead>
			<tr>
			  <th></th>
			  <th><a class="sort_link " >Id</a></th>
			  <th><a class="sort_link " >Company</a></th>
			  <th><a class="sort_link " >Department</a></th>
			  <th><a class="sort_link " >Sub-Department</a></th>
			  <th><a class="sort_link " >Division</a></th>
			  <th><a class="sort_link " >Location</a></th>
			  
			</tr>
		  </thead>
		  <tbody style="margin-bottom:10px; !important">
			<?php 
			$adminActionManager-> getCompaniesForAssetAssignment();
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
