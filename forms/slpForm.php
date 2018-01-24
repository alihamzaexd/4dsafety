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
				document.getElementById("team").innerHTML = "<option value='' selected disabled>Select team </option>"+x;
			}
			else{
				alert("No team found for the company");
				document.getElementById("team").innerHTML = "<option value='' selected disabled>No Teams</option>";
			}
		}); 
    }
	
	function changeTeam(value)  // function that acts when the value of dropdown is changed
	{
	$.post("getTeams.php",{changedTeam:value}, function(x){
			if(x){                                                          // x contains response of the function
				document.getElementById("teamLeader").innerHTML = "<option value='' selected disabled>Select team leader</option>"+x;
			}
			else{
				alert("No team leader found for the team.");
				document.getElementById("teamLeader").innerHTML = "<option value='' selected disabled>No Team Leader </option>";
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
	if($role == 'team member'){
	    // calling function to populate teams of the company
		echo "<script> changeCompany(companySelect.value);
		              companySelect.disabled = true;
		</script>";
	    }
?>
<div class="container">
	  <div class="row">
		<br>
		<div class="col-md-12">
		<div class="panel panel-default" style="padding:15px;">
		<div class="modal fade" id="SLP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					  <div class="modal-content">
						  <div id="modal_header">
							<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
					&times;</button>
							<center>	
							<br>
							<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
				!important;">Safety Leadership Profile</h4>
							</center>
							<br>
						  </div><!-- end modal-header -->
						<div class="modal-body" style="padding:5%;">
							  <p>Safety Leaders Group Pty Ltd is committed to ensuring that neither you or your work mates are injured at work and is committed to safety coming before production and schedule – hence our vision “insert company vision”.  We recognize that to achieve this we all need to be able to improve and help each other to follow safe work practices.</p>
							  <p>Old style leadership practice where people look to the Supervisor to set and enforce standards do not support our vision. For too long, organisations have been focused on systems and processes to make us safe. And it's been the job of the Supervisor to enforce those standards and make sure people are complying with the system. Supervisors and leaders were often seen as the COP - they controlled, gave orders and prescribed what got done and how. This needs to change.</p>
							  <p>Effective Safety Leaders do things differently. They steer and guide team performance in three important ways:</p>
							  <ol>
								<li>They create - Shared meaning. E.g. What should be done, what the standards are.</li>
								<li>They Focus on doing the right things. E.g. How things are done.</li>
								<li>They take Action - they 'Walk the Talk'</li>
							  </ol>
							  <p>Safety Leaders Group Pty Ltd invites you to be part of a team where everyone you work with is responsible for safety. Instead of being dependent on the Supervisor we are all interdependent team members who collectively create our safety. As a part of the team we are seeking your input to provide feedback to your Supervisors that you work with.</p>
							  <p>The Safety Leadership Profile (SLP) has been designed to provide a snapshot view of the leadership practices of your Supervisor. it's purposes are to:<br>
							  Provide you the opportunity to express your opinions about the leadership practices in your work group that supports safety and high performance.<br>Identify what is working well and what needs to be improved.<br>Improve the performance of your work group.<br>The SLP consists of 20 statements describing leadership practices. Please rate the Supervisor that you work with on each statement using the rating scale provided for each statement or question.</p>
							  <br>Completing the Questionnaire
							  <ol>
								<li>Read each item.</li>
								<li>When you feel as if you understand the item, select the button that best describes your opinion.</li>
								<li>Respond to every question</li>
								<li>If you have no information upon which to base an opinion, select `Don't Know`.</li>
							  </ol>
							  <p>There are no right or wrong answers and it is important that you respond as honestly as possible to each statement or question.</p>
							  <p>Please be assured that your individual responses will remain strictly nameless and no data for groups of less than three people will ever be reported.</p>
						</div>
						<div class="modal-footer" style="background-color:#F0F0F0">
						  <button data-dismiss="modal" class="btn btn-danger">Back</button>
						</div>
					  </div>
					</div>
				  </div>
				  
				  <!-- scoring guide modal -->
				  	<div class="modal fade bs-example-modal-lg" id="scoringGuide" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
		  <form class="new_report" id="new_report" action="" accept-charset="UTF-8" method="post">
		  <?php if($_SESSION['role'] == 'team leader'){echo "<fieldset disabled='disabled'>";}?>
			<div class="row">
				<div class="col-md-3">
				  <div class="panel panel-default" style="padding:10%; background-color:#EAECEE;">
				   <img id ="userProfileImage" src="asset/image/defaultUserProfile.png" />
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
					<br>
					<div  style="padding:10px; border-top: 2px solid #ccc;">
					<!-- div for just a horizontal line -->
					</div>
				  <h4>Safety Leadership Profile</h4>
				  <p>
					Safety Leaders Group Pty Ltd is committed to ensuring that neither you or your work mates are injured at work and is committed to safety coming before production and schedule. We recognise that to achieve this we all need to be able to improve and help each other to follow safe work practices.
				  </p>
				  <p>
					Old style leadership practices, where people look to the Supervisor to set and enforce standards, do not support our vision. For too long, organisations have been focused on systems processes to make us safe.
				  </p>
                    <a data-toggle="modal" data-target="#SLP" href="#">View More <span class="glyphicon glyphicon-new-window"></span></a>    
					
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
							  <label for="company">Company</label>
							  <select class="form-control" id="company" onChange="changeCompany(this.value);" style="background-color:#EAECEE;">
							
							  </select>
							</div>
						  </div> 
						  <div class="row">
						  <br>
							<div class="col-md-12">
							  <label for="team">Team</label>
							  <select class="form-control" id="team" onChange="changeTeam(this.value);" style="background-color:#EAECEE;">
							  <option value="" disabled selected>Select team</option>
							
							  </select>
							</div>
						  </div> 
						  <div class="row">
						  <br>
							<div class="col-md-12">
							  <label for="teamLeader">Team Leader you are rating is..</label>
							  <select class="form-control" id="teamLeader" style="background-color:#EAECEE;">
							  <option value="" disabled selected>Select team leader</option>
								
							  </select>
							</div>
						  </div> 
						  
						</div> <!-- top fields row end -->
				    </div>

					<h3>Safety Leadership Profile</h3>
					<p>Directions: Read each statement and then click on the answer that best describes your opinion. Respond to every item but if you have no information upon which to base an opinion, click on `Don't know`</p>
					<h3><a data-toggle="modal" data-target="#scoringGuide" href="#">Scoring Guide</a></h3>
	 
					<div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
					<div class="row" style="padding-left:10px;">
					  <div class="col-md-10" >
						<h4>My Supervisor</h4>
					  </div>
					  <div class="col-md-2">
						<h5></h5>
					  </div>
					</div>
				  </div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>1.</b> Walks the Talk – provides me the support I need to address safety issues.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a1" id="a1" style="margin-top:10px;border-radius:5px;" required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>
						
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>2.</b> Encourages and supports the ongoing development of my knowledge and skills.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a2" id="a2" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div>
						
						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>3.</b> Empowers us to take action to improve the quality and safety of our work.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a3" id="a3" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div>

								<!-- make all 10-2 partiotion question and answer scale from 1-10 
								 for this SLP form
								-->
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>4.</b> Respects me as a person.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a4" id="a4" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div>
						 <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>5.</b> Makes sure I understand the safety and operational standards by which my performance will be judged.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a5" id="a5" style="margin-top:10px;border-radius:5px;"  required="required">
							 <option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					  </div>
					
					  <div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>6.</b> Actively seeks my opinion and input about how to create a safer work environment.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a6" id="a6" style="margin-top:10px;border-radius:5px;"  required="required">
							  <option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					  </div>

						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>7.</b> Makes sure I have a clear understanding of my roles and responsibilities.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a7" id="a7" style="margin-top:10px;border-radius:5px;" required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div>
					
					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>8.</b> Applies performance standards fairly and consistently.</p>
						</div>
						  <div class="col-md-4">
							<select name="a8" id="a8" style="margin-top:10px;border-radius:5px;"  required="required">
							    <option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>9.</b> Never compromises safety in order to reach our cost and schedule goals.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a9" id="a9" style="margin-top:10px;border-radius:5px;"  required="required">
							   <option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>10.</b> Shows through actions that he/she is committed to safety.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a10" id="a10" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>

						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>11.</b> Accepts responsibility for his/her decisions and actions.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a11" id="a11" style="margin-top:10px;border-radius:5px;" required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div>
						
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>12.</b> Treats me fairly.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a12" id="a12" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div>
						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>13.</b> Provides timely and constructive feedback to help me perform better.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a13" id="a13" style="margin-top:10px;border-radius:5px;" required="required">
									<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div>
					
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-8">
								<p style="margin:10px;"><b>14.</b> Does a good job of recognizing and rewarding superior performance.</p>
							  </div>
							  <div class="col-md-4">
								<select name="a14" id="a14" style="margin-top:10px;border-radius:5px;"  required="required">
									<option value="" selected disabled >please select</option>
									<option value="1">Strongly Disagree</option>
									<option value="2">Disagree</option>
									<option value="3">Neither Agree nor Disagree</option>
									<option value="4">Agree</option>
									<option value="5">Strongly Agree</option>
									<option value="6">Don't Know</option>
								</select>
							  </div>
							</div>
						</div> <!-- till Q 14 -->
						
					    <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						  <div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>15.</b> Applies safety standards fairly and consistently.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a15" id="a15" style="margin-top:10px;border-radius:5px;"  required="required">
							   <option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>16.</b> Makes sure I get the information I need to do my job well.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a16" id="a16" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>
		
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>17.</b> Holds me accountable for my role and my results.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a17" id="a17" style="margin-top:10px;border-radius:5px;"  required="required">
							    <option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>18.</b> Helps us focus on solutions to enable better safety performance.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a18" id="a18" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>
					
                    <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>19.</b> Always behaves in a way that is in line with our safety work practices.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a19" id="a19" style="margin-top:10px;border-radius:5px;"  required="required">
								<option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;"><b>20.</b> Helps the team solve problems to remove barriers to safety performance.</p>
						  </div>
						  <div class="col-md-4">
							<select name="a20" id="a20" style="margin-top:10px;border-radius:5px;"  required="required">
							 <option value="" selected disabled >please select</option>
								<option value="1">Strongly Disagree</option>
								<option value="2">Disagree</option>
								<option value="3">Neither Agree nor Disagree</option>
								<option value="4">Agree</option>
								<option value="5">Strongly Agree</option>
								<option value="6">Don't Know</option>
							</select>
						  </div>
						</div>
					</div>	
					  
					  <span style="margin:2px;"> <br></span>
					  <span style="margin-left:42%"> </span>
					  <button  class="btn btn-md" style="background-color:#5B42DB;color:white;" type="submit" name="submit "value="sslrReview" >Submit </button>
					  
				</div><!-- right area date-time and questions -->
				
			  
			</div> <!-- main row holding both left and right panel -->
			<?php if($_SESSION['role'] == 'team leader'){echo "</fieldset>";}?>
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