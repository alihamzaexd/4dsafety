<?php
session_start();
require_once(dirname(__FILE__).'/adminActionManager.php');
$adminActionManager = new AdminActionManager();

?>

<div class="admin_content col-md-offset-1 col-md-10">
<script type='text/javascript'>
	function removeCompany(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{deleteCompany:value}, function(x){
			if(x=="success"){     // x contains response of the function
				document.getElementById('successMessage').innerHTML = 'Company deleted successfully!';
				document.getElementById('successDiv').style.display = 'block';
                setTimeout(function(){$("#pageContent").load("adminFiles/adminCompaniesContent.php");document.getElementById('successDiv').style.display = 'none';  }, 2000);
			}
			else{
				document.getElementById('errorMessage').innerHTML = 'Problem in deletion! Probably Company is being used by some Employee or Team.';
				document.getElementById('errorDiv').style.display = 'block'; 
			    setTimeout(function(){$("#pageContent").load("adminFiles/adminCompaniesContent.php");document.getElementById('errorDiv').style.display = 'none';  }, 3000);			
			}
		}); 
    }	
	function getSpecificCompany(value)  // function that acts when the value of dropdown is changed
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

    function setupCompany(value)  // function that acts when the value of dropdown is changed
	{
	$.post("adminFiles/adminActionManager.php",{setupCompany:value}, function(x){
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
	  <a onClick="loadAdminCompaniesContent()" style="color:grey;">
	    <i class="fa fa-building" aria-hidden="true"></i> Companies
	  </a>
	</li>
</ul>

<div class="row sub-header">
    <script src="javascript/adminPageJavascript.js"> </script>
    <h2>Companies 
    <div style="float:right; !important"><button class="btn btn-primary" onClick="loadAddCompanyForm()">Create Company</button></div>
    </h2>
  </div>
<br>
 <div class="container-fluid" style="background-color:white; border-radius:10px; padding-top:15px; padding-bottom:15px; !important">
	<div class="table-responsive">
	  <table class="table table-bordered table-striped" id="example1">
		<thead>
		  <tr>
			<th><a class="sort_link " >Id</a></th>
			<th><a class="sort_link " >Company Name</a></th>
			<th><a class="sort_link " >Company Status</a></th>
			<th></th>
		  </tr>
		</thead>
		<tbody >
			<?php 
			if(!isset($_SESSION['companyNameFilter'])==true && !isset($_SESSION['companyStatusFilter'])==true)
			{
			$adminActionManager-> getCompanies();
			}else{
			$adminActionManager-> getFilteredCompanies();
			}	
			?>
		</tbody>
	  </table>
	</div>
</div> 
<script>
	// calling method to add pagination plugin on the table
	addPagination();
</script>

</div>
  