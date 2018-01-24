<?php
global $userRole;
//if(isset($_SESSION['role']))
//{
 //   $userRole = $_SESSION['role'];

?>
<script>
function loadAdminTeamsContent(){
    $("#pageContent").load("adminFiles/adminTeamsContent.php"); 
}
function loadAdminDivisionsContent(){
    $("#pageContent").load("adminFiles/adminDivisionsContent.php"); 
}
function loadAdminLocationsContent(){
    $("#pageContent").load("adminFiles/adminLocationsContent.php"); 
}
function loadAdminDepartmentsContent(){
    $("#pageContent").load("adminFiles/adminDepartmentsContent.php"); 
}

function loadAdminSubDepartmentsContent(){
    $("#pageContent").load("adminFiles/adminSubDepartmentsContent.php"); 
}

function loadAdminCompaniesContent(){
    $("#pageContent").load("adminFiles/adminCompaniesContent.php"); 
}

function loadAdminUsersContent(){
    $("#pageContent").load("adminFiles/adminUsersContent.php");
}

function loadAdminLookupsContent(){
    $("#pageContent").load("adminFiles/adminLookupsContent.php"); 
}

function loadAdminAssetsContent(){
    $("#pageContent").load("adminFiles/adminAssetsContent.php"); 
}

function loadAdminReportsContent(){
    $("#pageContent").load("adminFiles/adminReportsContent.php"); 
}
</script>

<div class="navbar navbar-custom navbar-static-top">
    <div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" onclick="loadAdminDetailsContent()">Home</a>
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  
		  <ul class="nav navbar-nav">
		    <li> <a onclick="loadAdminUsersContent()">Users</a></li>
		    <li> <a onclick="loadAdminCompaniesContent()">Companies</a></li>
		    <li role="presentation" class="dropdown ">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
				  Categories <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" >	
				<li> <a onclick="loadAdminDivisionsContent()">Divisions</a></li>
				<li> <a onclick="loadAdminDepartmentsContent()">Departments</a></li>
				<li> <a onclick="loadAdminSubDepartmentsContent()">Sub-Departments</a></li>
				<li> <a onclick="loadAdminLocationsContent()">Locations</a></li>
				<li> <a onclick="loadAdminTeamsContent()">Teams</a></li>
				<li> <a onclick="loadAdminLookupsContent()">Manage Lookup</a></li>
				<li> <a onclick="loadAdminAssetsContent()">Assets</a></li>
				</ul>
			</li>
            <li role="presentation" class="dropdown ">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
				  Reports <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" >	
				<li> <a onclick="loadAdminReportsContent()">Submitted Reports</a></li>
				<li> <a onclick="">Reports History</a></li>	
				</ul>
			</li>				
		  </ul>

		  <ul class="nav navbar-nav navbar-right">
			<li role="presentation" class="dropdown ">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
				  Profile <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" style="text-align:center">
					<li class=""><a onclick="loadResetPasswordForm()">Reset Password</a></li>
				</ul>
			</li>
			<li><a rel="nofollow" data-method="delete" href="logout.php">Logout</a></li>
		  </ul>

		</div>
    </div> 
</div>

<?php
//}
?>