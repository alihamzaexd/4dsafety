<?php
    session_start();
	require_once(dirname(__FILE__).'/../db_connect.php');
	require_once(dirname(__FILE__).'/../userFiles/userAccountHandler.php');
	global $userDetialsHanlder;
	$userDetialsHanlder = new UserAccountHandler();
	$userDetialsHanlder->getUserEmployeeDetails();
?>
<style>
img {
    border: 1px solid #ddd;
    border-radius: 50%;
    padding: 2px;
    width: 150px;
	height: 150px;
}
</style>
<script type='text/javascript'>
	function changeCompany(value)  // function that acts when the value of dropdown is changed
	{
	$.post("getTeams.php",{changedCompany:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("team").innerHTML = x;
			}
			else{
				alert("Error while leading teams.");
			}
		}); 
    }
	
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	});
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
<?php
	$role = $_SESSION['role'];
	$employeeId = $_SESSION['employeeId'];

	// building database connection
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();
	
	// fetching companies supervised by the employee
	$sql1 =<<<EOF
	  SELECT company_name,company_id from COMPANY WHERE company_id IN 
		(SELECT company_id from COMPANY_OBJECT WHERE companyobj_id IN 
		  (SELECT DISTINCT companyobj_id from TEAM WHERE team_id IN
			(SELECT team_id from TEAM_ROLE WHERE employee_id = '{$employeeId}')
		  )
		);
EOF;

   $ret1 = pg_query($conn, $sql1);
   echo "<script> 
			companySelect = document.getElementById('company');
		 </script>";
   
	if($role == 'coach'){
		    echo  "<script>
				  var opt = document.createElement('option');
					opt.value = '';
					opt.innerHTML = 'Select company';
					opt.disabled = true;
					opt.selected = true;
					companySelect.appendChild(opt);
				  </script>";
		}
   while($row = pg_fetch_row($ret1)){
	    echo  "<script>
		  var opt = document.createElement('option');
			opt.value = '{$row[1]}';
			opt.innerHTML = '{$row[0]}';
			companySelect.appendChild(opt);
		  </script>";
		  $_SESSION['companyId'] = $row[1];
	} // populates company select menu with companies under employees supervision	
	
	if($role == 'champion'){
	    // calling function to populate teams of the company
		echo "<script> changeCompany(companySelect.value);
		              companySelect.disabled = true;
		</script>";
	    }
	if($role == 'team leader'){
	    // calling function to populate teams of the company
		echo    "<script> changeCompany(companySelect.value);
		        companySelect.disabled = true;
				</script>";
	    }
	
	// commitment statement retrival from database
	if(isset($_SESSION['employeeId']))
	{
        $sqlPersonStatement = "SELECT p.person_commitment FROM Person as p, Employee as emp 
	    WHERE p.person_id = emp.person_id AND emp.employee_id = '{$employeeId}'";
	    $retPersonStatement = pg_query($conn, $sqlPersonStatement);
	    if($retPersonStatement){
	        $row = pg_fetch_row($retPersonStatement);
            $_SESSION['commitmentStatement'] = $row[0];
        }
	}	

?>
	<div class="container">
	  <div class="row">
		<br>
		<div class="col-md-12">
		<div class="panel panel-default" style="padding:15px;">
		  <form class="new_report" id="new_report" action="" accept-charset="UTF-8" method="post">
			<div class="row">
				<div class="col-md-3">
				  <div class="panel panel-default" style="padding:10%; background-color:#EAECEE;">
				    <div align="center">
				      <img id ="userProfileImage" src="asset/image/defaultUserProfile.png" />
                    </div>				   
				    <strong> 
				      <h3 align="center">
				        <?php echo $_SESSION['firstName']; echo " ".$_SESSION['lastName'];?>
					  </h3>
					</strong>
				    <strong>
					  <h4 align="center" style="color:green"> 
					    <?php echo $_SESSION['role']; ?>
					  </h4>
					</strong>
					<?php if(isset($_SESSION['commitmentStatement'])){echo "<strong>Safety 4 Me Means:</strong> \"".$_SESSION['commitmentStatement']."\" <br>";}  ?>
					<br>
					<div  style="padding:10px; border-top: 2px solid #ccc;">
					<!-- div for just a horizontal line -->
					</div>
				  <h4>Site Safety Leadership Review</h4>
				  <p>The Review is rated against the CARES leadership framework.</p>
				  <h4>CARES:</h4>
				  <p>Creating an Achievement oriented, Relationship based, Endeavour, Sustainably."</p>
				  <p>
					It should answer the question:<br>
					How well has this crew embraced the principles of CARES?
					<ul>
					  <li>How well do safety leaders create Shared Meaning?</li>
					  <li>Do they focus on what's expected?</li>
					</ul>
				  </p>
				  <a data-toggle="modal" data-target="#SSLR" href="#">
					  View More
					<i class="fa fa-external-link" aria-hidden="true"></i>
				  </a>      
					<div class="modal fade" id="SSLR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					  <div class="modal-content">
						  <div id="modal_header">
							<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
					&times;</button>
							<center>	
							<br>
							<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
				!important;">Site Safety Leadership Review</h4>
							</center>
							<br>
						  </div><!-- end modal-header -->
						<div class="modal-body" style="padding:5%;">
						  <p>The Review is rated against the CARES leadership framework.</p>
						  <h4>CARES:</h4>
						  <p>Creating an Achievement oriented, Relationship based, Endeavour, Sustainably."</p>
						  <p>It should answer the question: How well has this crew embraced the principles of CARES.</p>
						  <ul>
							<li>How well do safety leaders create Shared Meaning?</li>
							<li>Do they focus on what's expected?</li>
							<li>Do they take action as needed?</li>
							<li>Do they promote achievement by paying attention to results?</li>
						  </ul>
						  <p>Purpose of the visit</p>
						  <ul>
							<li>Visible safety leadership - "walk the talk" - demonstrate the Company's commitment to being injury free.</li>
							<li>Improve our operational and safety performance. Ensure what is expected is happening. What gets expected and inspected gets respected.</li>
							<li>Provide feedback and development to help the team understand and apply the principles of 4D Safety Leadership.</li>
							<li>Talk with the employees to understand the way they are working.</li>
							<li>Review the relationship between employees and the leadership team.</li>
						  </ul>
						</div>
						<div class="modal-footer" style="background-color:#F0F0F0">
						  <button data-dismiss="modal" class="btn btn-danger">Back</button>
						</div>
					  </div>
					</div>
				  </div>
				  </div><!-- Modal panel-->
				</div> <!-- side area -->

				<div class="col-md-9">			
					<div  class="row">
						<div class="form col-md-8">
						  <div class="row">
							<!-- HTML Form (wrapped in a .bootstrap-iso div) -->
							<div class="col-md-6">
							  <label>Date</label>
								<div class="bootstrap-iso">
								   <div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input class="form-control" id="date" name="date" placeholder="DD/MM/YYYY" type="text"/>
								   </div>
								</div>
							</div>
							<div class="col-md-6">
							  <label>Time</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-time">
									</i>
								  </div>
								  <input class="form-control" id="time" name="time" 
								    value="<?php
								    date_default_timezone_set('Asia/Karachi');
								    echo date("g:i:s a");
                                    ?>"type="text"/>
								</div>
							</div>
						  </div> <!-- end of row -->
							  
						  <div class="row">
						  <br>
							<div class="col-md-12">
							  <label for="Company">Company</label>
							  <select class="form-control" id="company" onChange="changeCompany(this.value);" style="background-color:#EAECEE;" >
								<!-- php functions adds options here based on user logged in -->
							  </select>
							</div>
						  </div>
						  <div class="row">
						  <br>
							<div class="col-md-12">
							  <label for="team">Team</label>
							  <select class="form-control" id="team" style="background-color:#EAECEE;">
							  <option value="" disabled selected>Select team</option>
							  </select>
							</div>
						  </div> 
						</div> <!-- top fields row end -->
				    </div>
  
					<h3>On Location</h3>
					<p>The Review Team will review each of the four areas below.</p>
					<div class="col-md-12" style="margin:10px">  
					  <div class="row">
						<button type="button" class="btn btn-primary"><span class="badge">1</span> Belief (shared meaning) </button>
						<button type="button" class="btn btn-info"><span class="badge">2</span> Mindset (our focus) </button>
						<button type="button" class="btn btn-warning"> <span class="badge">3</span> Action </button>
						<button type="button" class="btn btn-danger"><span class="badge">4</span> Result </button>
					  </div>
					</div>
					<br><br>
	
					<h3>Review of Current Performance</h3>
					<p><b>Part 1. Review the implementation of agreed actions and ground rules from the crew start-up workshop.</b></p>
					<p>Column A scored on first observations/impression.<br>
					Column B scored after discussion and response with crew.<br>
					Column C indicates where recommendations for improvement have been made and further actions are required Y = Yes N = No</p>
					
					<h3><a data-toggle="modal" data-target=".bs-example-modal-lg" href="#">Scoring Guide</a></h3>
					<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
						<div class="modal-dialog modal-lg">
						  <div class="modal-content guide">
							  <div id="modal_header">
							<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
					&times;</button>
							<center>	
							<br>
							<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
				!important;">Scoring Guide</h4>
							</center>
							<br>
						  </div><!-- end modal-header -->
							<div class="modal-body" style="padding:5%;">
								<div class="col-md-12">
								  <p><b>The Review Team and the Leadership Team must discuss each question and score each out of 10.</b></p>
								  <div class="row" style="margin-left:10px;">
									<div class="row"><div class="col-md-1" style="background-color:red;">1</div><p>No evidence of safety leadership practices which will create the desired climate</p></div>
									<div class="row"><div class="col-md-1" style="background-color:red;">2</div><p>Very Poor safety leadership practices</p></div>
									<div class="row"><div class="col-md-1" style="background-color:red;">3</div><p>Poor leadership practices</p></div>
									<div class="row"><div class="col-md-1" style="background-color:red;">4</div><p>Not adequate</p></div>
									<div class="row"><div class="col-md-1" style="background-color:orange;">5</div><p>Developing</p></div>
									<div class="row"><div class="col-md-1" style="background-color:orange;">6</div><p>Increasing in effectiveness</p></div>
									<div class="row"><div class="col-md-1" style="background-color:orange;">7</div><p>Good but not great</p></div>
									<div class="row"><div class="col-md-1" style="background-color:green;">8</div><p>Great - proactive approach, more teamwork will help</p></div>
									<div class="row"><div class="col-md-1" style="background-color:green;">9</div><p>Great - excellent example of safety Leadership</p></div>
									<div class="row"><div class="col-md-1" style="background-color:green;">10</div><p>Great - outstanding example of safety Leadership</p></div>
								  </div>
								</div>
							</div>
							<div class="modal-footer" style="background-color:#F0F0F0" >
								  <button data-dismiss="modal" class="btn btn-danger">Back</button>
							</div>
						  </div>
						</div>
					</div>
	 
					<div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8" >
							<h5></h5>
						  </div>
						  <div class="col-md-1">
							<h5> A </h5>
						  </div>
						  <div class="col-md-1">
							<h5> B </h5>
						  </div>
						  <div class="col-md-1">
							<h5> C </h5>
						  </div>
						  </div>
					</div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>1.</b> Are the agreed KPI’s being measured and reviewed?</p>
						  </div>
						  <div class="col-md-1">
							<select name="a1" id="a1" style="margin-top:10px;border-radius:5px;" required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b1" id="b1"  style="margin-top:10px;border-radius:5px;" required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c1" id="c1"  style="margin-top:10px;border-radius:5px;" required="required">
								<option value="1">Y</option>
								<option value="2">N</option>
								
							</select>
						  </div>
						</div>
					</div>
						
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>2.</b> Are the Ground Rules displayed?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a2" id="a2" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b2" id="b2" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c2" id="c2" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div>
						
						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>3.</b> Does the crew refer to the ground rules?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a3" id="a3" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b3" id="b3" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c3" id="c3" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div>

						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>4.</b> Are the Ground Rules being followed by all on location, including other contractors?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a4" id="a4" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b4" id="b4" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c4" id="c4" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div>
						<span style="margin:10px; !important"> </span>
					  <p><b>Part 2. Review and assess observable safety leadership</b> </p>
					  <p>Leaders create the safety climate in their operations by:</p>
					  <ul>
						<li>Creating Shared Meaning</li>
						<li>Focusing on what's expected</li>
						<li>Taking Action as and where needed</li>
					  </ul>
					  <p>How well is the leadership team on this site doing each of these things?</p>
					  <h3><a data-toggle="modal" data-target=".bs-example-modal-lg" href="#">Scoring Guide</a></h3>
				  <div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
					<div class="row" style="padding-left:10px;">
					  <div class="col-md-8" >
						<h4>Shared Meaning</h4>
					  </div>
					  <div class="col-md-1">
						<h5> A </h5>
					  </div>
					  <div class="col-md-1">
						<h5> B </h5>
					  </div>
					  <div class="col-md-1">
						<h5> C </h5>
					  </div>
					</div>
				  </div>
					  <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>5.</b> How well are the supervisors engaged in having conversations to create the commitment to working injury free?<br>
							• Do supervisors have specific conversations with members of the crew to discuss and brainstorm what else they can do to create/improve safety on this site?</p>
						  </div>
						  <div class="col-md-1">
							<select name="a5" id="a5" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b5" id="b5" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c5" id="c5" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="1">N</option>
								
							</select>
						  </div>
						</div>
					  </div>
					
					  <div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>6.</b> How well are the crew members engaged in having conversations to create the commitment to working injury free?<br>
							• Do crew members “get it”? Do they demonstrate that they understand that they create their performance, minute by minute and day by day?<br>
							• Are the crew members involved and buying in? What is the attitude and intent like at pre-start meetings, JHA’s, etc.?
						   </p>
						  </div>
						  <div class="col-md-1">
							<select name="a6" id="a6" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b6" id="b6" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c6" id="c6" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="2">N</option>
								
							</select>
						  </div>
						</div>
					  </div>

						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>7.</b> Do all members of the site management team walk the talk? 
									<br>• Do they wear correct PPE all the time? (including arriving at site and when leaving)
									<br>• Never compromise safety in order to reach cost and schedule goals
									<br>• Do they enforce the Lifesaving rules and stop the job policy?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a7" id="a7" style="margin-top:10px;border-radius:5px;" required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b7" id="b7" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c7" id="c7" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div>
					
					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>8.</b> Do all members of the crew walk the talk? 
								<br>• Do they wear correct PPE all the time? (including arriving at site and when leaving) 
								<br>• Never seek to compromise safety in order to get the job done?</p>
						  </div>
						  <div class="col-md-1">
							<select name="a8" id="a8" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b8" id="b8" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c8" id="c8" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="2">N</option>
								
							</select>
						  </div>
						</div>
					</div>
				  <div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
					<div class="row" style="padding-left:10px;">
					  <div class="col-md-8">
						<h4>Focus (Consider where our focus is/what are we focused on?)</h4>
					  </div>
					  <div class="col-md-1">
						<h5> A </h5>
					  </div>
					  <div class="col-md-1">
						<h5> B </h5>
					  </div>
					  <div class="col-md-1">
						<h5> C </h5>
					  </div>
					  </div>
				  </div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>9.</b> How well are the supervisors engaged in having conversations to create the commitment to working injury free?<br>
							• Do supervisors have specific conversations with members of the crew to discuss and brainstorm what else they can do to create/improve safety on this site?</p>
						  </div>
						  <div class="col-md-1">
							<select name="a9" id="a9" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b9" id="b9" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c9" id="c9" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="1">N</option>
								
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>10.</b> How well are the crew members engaged in having conversations to create the commitment to working injury free?<br>
							• Do crew members “get it”? Do they demonstrate that they understand that they create their performance, minute by minute and day by day?<br>
							• Are the crew members involved and buying in? What is the attitude and intent like at pre-start meetings, JHA’s, etc.?
				   </p>
						  </div>
						  <div class="col-md-1">
							<select name="a10" id="a10" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b10" id="b10" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c10" id="c10" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="2">N</option>
								
							</select>
						  </div>
						</div>
					</div>

						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>11.</b> Do all members of the site management team walk the talk? 
									<br>• Do they wear correct PPE all the time? (including arriving at site and when leaving)
									<br>• Never compromise safety in order to reach cost and schedule goals
									<br>• Do they enforce the Lifesaving rules and stop the job policy?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a11" id="a11" style="margin-top:10px;border-radius:5px;" required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b11" id="b11" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c11" id="c11" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div>

						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>12.</b> Do all members of the crew walk the talk? 
									<br>• Do they wear correct PPE all the time? (including arriving at site and when leaving) 
									<br>• Never seek to compromise safety in order to get the job done?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a12" id="a12" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b12" id="b12" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c12" id="c12" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div>
						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>13.</b> Do all members of the site management team walk the talk? 
									<br>• Do they wear correct PPE all the time? (including arriving at site and when leaving)
									<br>• Never compromise safety in order to reach cost and schedule goals
									<br>• Do they enforce the Lifesaving rules and stop the job policy?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a13" id="a13" style="margin-top:10px;border-radius:5px;" required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b13" id="b13" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c13" id="c13" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div>
					
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>14.</b> Do all members of the crew walk the talk? 
									<br>• Do they wear correct PPE all the time? (including arriving at site and when leaving) 
									<br>• Never seek to compromise safety in order to get the job done?</p>
							  </div>
							  <div class="col-md-1">
								<select name="a14" id="a14" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="b14" id="b14" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							  </div>
							  <div class="col-md-1">
								<select name="c14" id="c14" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="1">Y</option>
									<option value="2">N</option>
									
								</select>
							  </div>
							</div>
						</div> <!-- till Q 14 -->
						<div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
						<div class="row" style="padding-left:10px;">
						  <div class="col-md-8">
							<h4>Results/Actions (Inattention to results is invariably a sign of a team that doesn’t believe in or is not committed to working towards being injury free)</h4>
						  </div>
						  <div class="col-md-1">
							<h5> A </h5>
						  </div>
						  <div class="col-md-1">
							<h5> B </h5>
						  </div>
						  <div class="col-md-1">
							<h5> C </h5>
						  </div>
						  </div>
				        </div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>15.</b> Has this site effectively implemented a Site Observation Improvement Plan?
							<br>• Are the results displayed? 
							<br>• Does the crew use these results to help mitigate risk?
						  </div>
						  <div class="col-md-1">
							<select name="a15" id="a15" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b15" id="b15" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c15" id="c15" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="1">N</option>
								
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>16.</b> Does the leadership team discuss and truly own their results (are they living above the line) and have they got a plan to improve or do they go below the line and seek to justify, or blame others.
				            </p>
						  </div>
						  <div class="col-md-1">
							<select name="a16" id="a16" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b16" id="b16" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c16" id="c16" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="2">N</option>
								
							</select>
						  </div>
						</div>
					</div>
					
					<span style="margin:2px;"> </span>
					<h3>Good to Great Climate</h3>
					<p>What's the climate like on this site? Great safety leaders create the climate by using Level 3 motivator to "RAMP up safety performance".</p>
					RAMP stands for:<br>
					<ul>
					  <li>R = Relationship</li>
					  <li>A = Autonomy</li>
					  <li>M = Mastery</li>
					  <li>P = Purpose</li>
					</ul>
					<p>Does this crew have an apporach which will RAMP up safety performance?</p>
					<h3><a data-toggle="modal" data-target=".bs-example-modal-lg" href="#">Scoring Guide</a></h3>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>17.</b> What are relationships to safety like on this site? 
							<br>• Do they demonstrate that they believe injury free is achievable? 
							<br>• Do they demonstrate through their actions that they are committed to making it happen?
						  </div>
						  <div class="col-md-1">
							<select name="a17" id="a17" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b17" id="b17" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c17" id="c17" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="1">N</option>
								
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>18.</b> What are relationships between people like on this site? (Are they a team) 
							<br>• At the management team level 
							<br>• Amongst the crew 
							<br>• Are communication barriers actively overcome? 
							<br>• Are individual differences and preferences OK or do we judge and make people wrong?
				            </p>
						  </div>
						  <div class="col-md-1">
							<select name="a18" id="a18" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b18" id="b18" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c18" id="c18" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="2">N</option>
								
							</select>
						  </div>
						</div>
					</div>
                    <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>19.</b> Are leaders using level 3 motivations? 
								<br>• Using the EARS approach in meetings? 
								<br>• Following the principles of the conversation for commitment Vs. the conversation for compliance. 
								<br>• Getting people to connect with Mastery ideals such as: “Do it right the first time” 
								<br>Are we creating engaged people who are committed to a common purpose – creating safety for themselves and their workmates. This is about Values Based Safety leadership practices.
						  </div>
						  <div class="col-md-1">
							<select name="a19" id="a19" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b19" id="b19" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c19" id="c19" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="1">N</option>
								
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>20.</b> Sustainable Safety Culture 
							<br>• Is there a Belief/Commitment – firstly that it’s possible and then to do the things they need to do. 
							<br>• Is there the Courage – to do what they know is right.
				            </p>
						  </div>
						  <div class="col-md-1">
							<select name="a20" id="a20" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="b20" id="b20" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						  </div>
						  <div class="col-md-1">
							<select name="c20" id="c20" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="1">Y</option>
								<option value="2">N</option>
								
							</select>
						  </div>
						</div>
					</div>	
					<span style="margin:2px;"> </span>
					<br><b>Action and follow up by the Review Team</b><br>
					  <p>Debrief with the senior leadership team on location to agree on the findings and recommendations</p>
					  <p>Verify closing of the findings on next visit or sooner</p>
					  <br>
					  <h4>Score for the Review</h4>
					  <p>Total score for all questions: <b>A = 0 B = 0</b></p>
					  <p>The goal is to have all leaders providing great safety leadership i.e. an overall score of 8 or higher. In addition, the score for each question should be in the green.</p>
					  
					  <div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
						<div class="row" style="padding-left:10px;">
						  <div class="col-md-6">
						  <h5></h5>
						  <br>
						  </div>
						  <div class="col-md-6">
						  <h5></h5>
						  </div>
						</div>
				      </div>
					  <div  class="col-md-12" style="background-color:#FBFCFC; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-6">
							<p style="margin:10px;">Summary of Observations and Comments
				            </p>
						  </div>
						  <div class="col-md-6">
							<textarea class="form-control" rows="5" id="comments"> </textarea>
						  </div>
						</div>
					  </div>
					  <div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-6">
							<p style="margin:10px;">Recommended Improvements
				            </p>
						  </div>
						  <div class="col-md-6">
							<textarea class="form-control" rows="5" id="improvments"> </textarea>
						  </div>
						</div>
					  </div>
					  
					  <span style="margin:2px;"> <br></span>
					  <span style="margin-left:42%"> </span>
					  <button  class="btn btn-md" style="background-color:#5B42DB;color:white;" type="submit" name="submit "value="sslrReview" >Submit </button>
					  
				</div><!-- right area date-time and questions -->
				
			  
			</div> <!-- main row holding both left and right panel -->
		  </form>
		</div>
		<script type="text/javascript">
		  $('.timepicker').timepicker();
		  $(document).ready(function(){
			is_coach = "true"
			team_info_on_ready("147242fe925c26d8234941c946decd04", "Site Safety Leadership Review", is_coach);
		  
			formmodified = 0;
			$('form *').change(function(){
			  formmodified=1;
			});
			window.onbeforeunload = confirmExit;
			function confirmExit() {
			  if (formmodified == 1) {
				return "New information not saved. Do you wish to leave the page?";
			  }
			}
			$("input[name='commit']").click(function() {
			  formmodified = 0;
			});
		  });
		</script>
	</div>
</div>
</div>
<!-- page footer -->
<div id="footer">
  <div class="container">
	<p class="muted credit text-center">©Copyright 2017 4D Safety Pty Ltd All Rights Reserved</p>
  </div>
</div>	
