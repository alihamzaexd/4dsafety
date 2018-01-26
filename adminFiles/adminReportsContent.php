<?php
session_start();
require_once(dirname(__FILE__).'/adminActionManager.php');
$adminActionManager = new AdminActionManager();
?>

<div class="admin_content col-md-offset-1 col-md-10">
<!-- overridden styling of the lable -->
<script type='text/javascript'>
    // Javascript function to call PHP scripts to download selected report as excel
	function exportCSVSSLR(value)  
	{ 
	    var url = "adminFiles/reports/excelExportScriptSSLR.php?id="+value;
	    window.open(url,"_self");
    }	
	function exportCSVSLP(value)  
	{ 
	    var url = "adminFiles/reports/excelExportScriptSLP.php?id="+value;
	    window.open(url,"_self");
    }
    function exportCSVSLPA(value)  
	{ 
	    var url = "adminFiles/reports/excelExportScriptSLPA.php?id="+value;
	    window.open(url,"_self");
    }	
	function exportCSVSTJ(value)  
	{ 
	    var url = "adminFiles/reports/excelExportScriptSTJ.php?id="+value;
	    window.open(url,"_self");
    }	
	function exportCSVEARSON(value)  
	{ 
	    var url = "adminFiles/reports/excelExportScriptEARSON.php?id="+value;
	    window.open(url,"_self");
    }
    function exportCSVSLPSA(value)  
	{ 
	    var url = "adminFiles/reports/excelExportScriptSLPSA.php?id="+value;
	    window.open(url,"_self");
    }	
</script>

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
	  <a onClick="loadAdminReportsContent()" style="color:grey;">
	    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Submitted reports
	  </a>
	</li>
</ul>

<div class="row sub-header">
    <script src="javascript/adminPageJavascript.js"> </script>
    <h2>
	    Reports 
    </h2>
  </div>
  <br>
<div class="container-fluid" style="background-color:white; border-radius:10px; padding-top:15px; padding-bottom:15px; !important">  
	<div class="table-responsive">
	  <table class="table table-bordered table-striped" id="example1">
		<thead>
		  <tr>
			<th><a class="sort_link " >Report Name</a></th>
			<th><a class="sort_link " >Submission Date</a></th>
			<th><a class="sort_link " >Submitted By</a></th>
			<th><a class="sort_link " >Team Leader</a></th>
			<th><a class="sort_link " >Team</a></th>
			<th><a class="sort_link " >Company</a></th>
			<th><a class="sort_link " >Division</a></th>
			<th><a class="sort_link " >Department</a></th>
			<th><a class="sort_link " >Sub-Department</a></th>
			<th><a class="sort_link " >Location</a></th>
			<th></th>
		  </tr>
		</thead>
		<tbody >
			<?php 
			$adminActionManager-> getReports();	
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
  