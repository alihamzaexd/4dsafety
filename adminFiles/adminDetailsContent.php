<!-- admin profile details are presented through this page -->
<?php 
    // session needs to be started in order to get varibales in the session
    session_start();
?>

<style>
img {
    border: 1px solid #ddd;
    border-radius: 50%;
    padding: 5px;
    width: 150px;
	height: 150px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}

.container1 {
  position: relative;
  width: 150px;
  height: 150px;
  margin-left:41.5%;
}

.overlay {
  position: absolute;
  border-radius: 50%;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0);
  transition: background 0.5s ease;
}

.container1:hover .overlay {
  display: block;
  background: rgba(0, 0, 0, .3);
}

.button {
  position: absolute;
  width: 20px;
  left:34%;
  top: 45%;
  text-align: center;
  opacity: 0;
  transition: opacity .35s ease;
}

.button a {
  width: 10px;
  text-align: center;
  color: white;
  border: solid 1px white;
  z-index: 1;
}

.container1:hover .button {
  opacity: 1;
}

</style>

<script>
$(function(){
   $.post("userFiles/getUserProfilePicture.php",{}, function(x){
			if(x){ // x contains response of the function
				document.getElementById("userProfileImage").src = x;
			}
			else{
			}
		}); 
});

</script>
<!-- container with tabs to show admin account details -->
	    <div class="container" >
			  <ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#personalDetails">Personal Detail</a></li>
				<li><a data-toggle="tab" href="#contactDetails">Contact Info</a></li>
				<li><a data-toggle="tab" href="#addressDetails">Address Info</a></li>
			  </ul>	
			  
			<div class="tab-content" style="padding:2%;">
				<div id="personalDetails" class="tab-pane fade in active">
				 <!-- user profile image | default image: asset/image/defaultUserProfile.png -->	
					<div class="container1" align="center">
					  <img id ="userProfileImage" />
					  <div class="overlay"></div>
					  <div class="button"><button class='btn btn-xs btn-warning' data-toggle="modal" data-target="#editProfilePictureModal">update</button></div>
					</div>
					<br>
					<div class="row">
					  <div class="col-md-6 col-lg-6 " style="border-right: 3px solid grey;">
						<h4> First Name:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['firstName'])) {echo $_SESSION['firstName'];}?>
						</p>
						<h4> Last Name:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['lastName'])) {echo $_SESSION['lastName'];}?>
						</p>
						<h4> Username:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['username'])) {echo $_SESSION['username'];}?>
						</p>
						<h4> Email:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['email'])) {echo $_SESSION['email'];}?>
						</p>
					  </div>
					  <div class="col-md-6 col-lg-6 ">
						<h4> Gender:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['gender'])) {echo $_SESSION['gender'];}?>
						</p>
						<h4> Date of Birth:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['dob'])) {echo $_SESSION['dob'];}?>
						</p>
						<h4> CNIC:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['cnic'])) {echo $_SESSION['cnic'];}?>
						</p>
						<h4> Nationality:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['nationality'])) {echo $_SESSION['nationality'];}?>
						</p>
					  </div>
					</div>
					<span class="pull-right">
				<br>
				<a href="" data-original-title="Edit this user" data-toggle="modal" data-target="#editDetails"type=
"button" class="btn btn-sm btn-primary">Edit Details <i class="glyphicon glyphicon-edit"></i></a>
		      </span>
				</div>
				<div id="addressDetails" class="tab-pane fade">
				    <br><br>
					<div class="row">
					  <div class="col-md-6 col-lg-6 " style="border-right: 3px solid grey;">
						<h4> Address:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['address'])) {echo $_SESSION['address'];}?>
						</p>
						<h4> City:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['city'])) {echo $_SESSION['city'];}?>
						</p>
						<h4> Zip Code:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['zip'])) {echo $_SESSION['zip'];}?>
						</p>
					  </div>
					  <div class="col-md-6 col-lg-6 ">
					   <h4> State:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['state'])) {echo $_SESSION['state'];}?>
						</p>
						<h4> Country:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['country'])) {echo $_SESSION['country'];}?>
						</p>
						
					  </div>
					</div>
					<span class="pull-right">
				<br>
				<a href="" data-original-title="Edit this user" data-toggle="modal" data-target="#editAddressDetails"type=
"button" class="btn btn-sm btn-primary">Edit Details <i class="glyphicon glyphicon-edit"></i></a>
		      </span>
				</div>
				<div id="contactDetails" class="tab-pane fade">
				    <br><br>
					<div class="row">
					  <div class="col-md-6 col-lg-6 " style="border-right: 3px solid grey;">
						<h4> Email:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['email'])) {echo $_SESSION['email'];}?>
						</p>
						<h4> Mobile:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['mobile'])) {echo $_SESSION['mobile'];}?>
						</p>
						
						</p>
					  </div>
					  <div class="col-md-6 col-lg-6 ">
						<h4> Landline:</h4>
						<p style="border-bottom: 1px dotted grey;"> 
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['landline'])) {echo $_SESSION['landline'];}?>
						</p>
						<h4> Fax:</h4>
						<p style="border-bottom: 1px dotted grey;">
						  <span style="display:inline-block; width: 20%;"></span>
						  <?php if(isset($_SESSION['fax'])) {echo $_SESSION['fax'];}?>
						</p>
					  </div>
					</div>
					<span class="pull-right">
				<br>
				<a href="" data-original-title="Edit this user" data-toggle="modal" data-target="#editContactDetails"type=
"button" class="btn btn-sm btn-primary">Edit Details <i class="glyphicon glyphicon-edit"></i></a>
		      </span>
				</div>
				
			</div>				
	    </div> <!-- container -->