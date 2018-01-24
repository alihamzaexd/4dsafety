<?php
global $userRole;
if(isset($_SESSION['role']))
{
    $userRole = $_SESSION['role'];
}else {$userRole = "";}
?>
<script>
function loadUserDefault(){
    $('#pageContent').load('userFiles/userDefaultContent.html');
}
</script>

<div class="navbar navbar-custom navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" onclick="loadUserDefault()"> Home</a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       <li role="presentation" class="dropdown ">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
              Have Your Say <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu" >
				<?php
				    // populating forms dropdown menu based on type of logged in user
				    if($userRole == "coach"){
						echo '<li><a onclick="loadSslrForm()">Site Safety Leadership Review</a></li>';
						echo '<li><a onclick="loadSlpaForm()">Safety Leadership Practices Assesment</a></li>';
						echo '<li><a onclick="loadSlpForm()">Safety Leadership Profile</a></li>';
						echo '<li><a onclick="loadEarsForm()">EARS ON</a></li>';
						echo '<li><a onclick="loadStjForm()">Stop The Job</a></li>';
					}elseif($userRole == "champion"){
						echo '<li><a onclick="loadSslrForm()">Site Safety Leadership Review</a></li>';
						echo '<li><a onclick="loadSlpaForm()">Safety Leadership Practices Assesment</a></li>';
						echo '<li><a onclick="loadSlpForm()">Safety Leadership Profile</a></li>';
						echo '<li><a onclick="loadEarsForm()">EARS ON</a></li>';
						echo '<li><a onclick="loadStjForm()">Stop The Job</a></li>';
					}elseif($userRole == "team leader"){
						echo '<li><a onclick="loadSslrForm()">Site Safety Leadership Review</a></li>';
						echo '<li><a onclick="loadSlpsaForm()">Safety Leadership Practices Self-Assesment</a></li>';
						echo '<li><a onclick="loadSlpForm()">Safety Leadership Profile</a></li>';
						echo '<li><a onclick="loadEarsForm()">EARS ON</a></li>';
						echo '<li><a onclick="loadStjForm()">Stop The Job</a></li>';
					}elseif($userRole == "team member"){
						echo '<li><a onclick="loadSlpForm()">Safety Leadership Profile</a></li>';
						echo '<li><a onclick="loadEarsForm()">EARS ON</a></li>';
						echo '<li><a onclick="loadStjForm()">Stop The Job</a></li>';
					}else{
						echo '<li><a onclick="loadSlpsaForm()">Safety Leadership Practices Self-Assesment</a></li>';
					}
				?>
            </ul>
        </li>		
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li role="presentation" class="dropdown ">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
              Profile <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu" style="text-align:center">
                <li class=""><a onclick="loadUserDetailsContent()">Edit Profile</a></li>
				<li class=""><a onclick="loadResetPasswordForm()">Reset Password</a></li>
            </ul>
        </li>
        <li><a rel="nofollow" data-method="delete" href="logout.php">Logout</a></li>
      </ul>

    </div>
   </div> 
</div>

<?php

?>