<?php
session_start();
require_once(dirname(__FILE__).'/adminActionManager.php');
$adminActionManager = new AdminActionManager();

?>

<div class="admin_content col-md-offset-1 col-md-10">
<script type='text/javascript'>
	function removeAsset(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{deleteAsset:value}, function(x){
			if(x == "success"){     // x contains response of the function
				document.getElementById('successMessage').innerHTML = 'Asset deleted successfully!';
				document.getElementById('successDiv').style.display = 'block';
                setTimeout(function(){$("#pageContent").load("adminFiles/adminAssetsContent.php");document.getElementById('successDiv').style.display = 'none';  }, 2000);
			}
			else{
				document.getElementById('errorMessage').innerHTML = 'Problem in deletion! Probably Asset is being used by some company or user.';
				document.getElementById('errorDiv').style.display = 'block'; 
			    setTimeout(function(){$("#pageContent").load("adminFiles/adminAssetsContent.php");document.getElementById('errorDiv').style.display = 'none';  }, 3000);			
			}
		}); 
    }	
	function getSpecificAsset(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{getAsset:value}, function(x){
			if(x){     // x contains response of the function
	            document.getElementById('pageContent').innerHTML = x;
			}
			else{
			    alert("Problem in connection!");		
			}
		}); 
    }	

	function loadAssignAssetUsersContent(value){
	    $.post("adminFiles/assetAssignmentScript.php",{userAssetId:value}, function(x){
			if(x=="success"){     // x contains response of the function
	            $("#pageContent").load("adminFiles/assignAssetUsers.php"); 
			}
			else{
			    alert("Problem Occured! Asset assignment page cannot be loaded.");		
			}
		});
	}
	
	function loadAssignAssetCompaniesContent(value){
	    $.post("adminFiles/assetAssignmentScript.php",{companyAssetId:value}, function(x){
			if(x=="success"){     // x contains response of the function
	            $("#pageContent").load("adminFiles/assignAssetCompanies.php"); 
			}
			else{
			    alert("Problem Occured! Asset assignment page cannot be loaded.");		
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
	  <a onClick="loadAdminAssetsContent()" style="color:grey;">
	    Assets
	  </a>
	</li>
</ul>

<div class="row sub-header">
    <script src="javascript/adminPageJavascript.js"> </script>
    <h2>Assets 
    <div style="float:right; !important"><button class="btn btn-primary" onClick="loadAddAssetForm()">Add Asset</button></div>
    </h2>
  </div>
  <br>
<div class="container-fluid" style="background-color:white; border-radius:10px; padding-top:15px; padding-bottom:15px; !important">
	<div class="table-responsive">
	  <table class="table table-bordered table-striped" id="example1">
		<thead>
		  <tr>
			<th><a class="sort_link " >Name</a></th>
			<th><a class="sort_link " >Code</a></th>
			<th><a class="sort_link " >Status</a></th>
			<th><a class="sort_link " >Maintainance Type</a></th>
			<th><a class="sort_link " >Repaired On</a></th>
			<th><a class="sort_link " >Next Maintainance</a></th>
			<th><a class="sort_link " >Comments</a></th>
			<th></th>
		  </tr>
		</thead>
		<tbody >
			<?php 
			$adminActionManager-> getAssets();
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
  