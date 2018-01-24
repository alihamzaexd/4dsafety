<!DOCTYPE html>
<script src="javascript/indexPageJavascript.js"> </script>
<html>
<!-- created by Ali Hamza -->
<?php
session_start();

if(isset($_SESSION['userType']))
{
    if($_SESSION['userType'] == 'user')
	{
	  header("Location: userHome.php");
	}
	if($_SESSION['userType'] == 'slgadmin')
	{
	  header("Location: adminHome.php");
	}
} // if for userType ends

?>
<head>
<?php
	// including Bootstrap, css and javascripts files
	require_once(dirname(__FILE__).'/external_files.php');

	// adding navigation bar to the page
	require_once(dirname(__FILE__).'/indexFiles/indexNavbar.php');
	
	// including file with db connector functions
	require_once(dirname(__FILE__).'/db_connect.php');
	
	// including file with account validation functions
	require_once(dirname(__FILE__).'/indexFiles/signupHandler.php');
?>
</head>

<body style="background-image:url('http://www.template-joomspirit.com/template-joomla/template-107/images/background/light-red-NR.jpg');">
	
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

	<div id="pageContent">
	<!-- content of this area comes from javascript based on user selection -->
	</div>
	<?php 	
		$signupHandler = new SignupHandler();
		if(isset($_POST['signup']))
		{	
			$actionResult = $signupHandler->validateSignup();
			if($actionResult == true) // insert user to database
			{
			    $signupHandler->addPerson();
			}
			echo "<script> loadSignupForm(); </script>";	
		}
		else if(isset($_POST['login'])){
			$signupHandler->login();
			echo "<script> loadLoginForm(); </script>";
		}
		else{
		    echo "<script> loadDefautContent(); </script>";
		}
	?>	
</body>

<!-- Calling javascripts to load page content dynamically based on what user selects -->

</html>
