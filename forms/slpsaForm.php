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
   while($row = pg_fetch_row($ret1)){
		  $_SESSION['companyId'] = $row[1];
		  echo "<script> changeCompany('{$_SESSION['companyId']}');
		</script>";
	} // populates company select menu with companies under employees supervision

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
					    <?php if(isset($_SESSION['role'])){echo $_SESSION['role'];}else{ echo "Free User";} ?>
					  </h4>
					</strong>
					
					<?php if(isset($_SESSION['commitmentStatement'])){echo "<strong>Safety 4 Me Means:</strong> \"".$_SESSION['commitmentStatement']."\" <br>";}  ?>
					<br>
					<div  style="padding:10px; border-top: 2px solid #ccc;">
					<!-- div for just a horizontal line -->
					</div>
				  <h4>Safety Leadership Practices Self-Assessment</h4>
                    <p>Before completing this assessment it is important that you understand the overall concepts of 4D Safety and the Who CARES Wins framework. To download the introduction to 4D Safety and who CARES Wins Booklet click here:</p>
                    <a target="_blank" href="http://safetyleaders.squarespace.com/4d-safety/">
						<span class="glyphicon glyphicon-file"></span>
                        4D Safety and Who CARES Wins Booklet
                    </a>       
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
							  <label for="team">Team</label>
							  <select class="form-control" id="team" style="background-color:#EAECEE;">
							  <option value="" disabled selected>Select team</option>
							  </select>
							</div>
						  </div> 
						</div> <!-- top fields row end -->
				    </div>
  
					<p style="margin-right:5%;"><br>To get the most benefit from this assessment it is important to understand the meaning we assign to specific words and terms. These words and terms are underlined in the assessment statements and are explained/defined in the booklet.</p>
					<div class="col-md-12" style="margin:10px">  
					  <div class="row">
						<button type="button" class="btn btn-primary"><span class="badge">1</span> Belief (shared meaning) </button>
						<button type="button" class="btn btn-info"><span class="badge">2</span> Mindset (our focus) </button>
						<button type="button" class="btn btn-warning"> <span class="badge">3</span> Action </button>
						<button type="button" class="btn btn-danger"><span class="badge">4</span> Result </button>
					  </div>
					</div>
					<br><br>
	
					<h3>Cares:</h3>
					<p>Creating an Achievement oriented, Relationship based, Endeavour, Sustainably.</p>
					
					<h3><a data-toggle="modal" data-target=".bs-example-modal-lg" href="#">Scoring Guide</a></h3>
					<p>This assessment has 21 statements that are descriptors of what great safety leaders do. Rate yourself against each statement on a scale of 1-10, 10 being the highest and a perfect example of great safety leadership.</p>
					
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
					<div class="row" style="padding-left:10px;">
					  <div class="col-md-10" >
						<h4>Am I Creating Shared Meaning?</h4>
					  </div>
					  <div class="col-md-2">
						<h5>Score 1-10</h5>
					  </div>
					</div>
				  </div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>1.</b> I am <u>committed to safety</u> and I have <u>clarity</u> about what I value, what’s important and what’s expected in terms of great safety performance. (This is fully aligned with the company’s stated values and expectations)</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>
						
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>2.</b> I have an action plan for achieving the expected <u>commitment to safety</u> on my <u>Site</u> which is consistent with the engagement and empowerment principles of <u>RAMP Up</u> safety.</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div>
						
						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>3.</b> I am effectively communicating my action plan to all of my team.</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div>

						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>4.</b> I have regular conversations with other safety leaders on this <u>Site</u> to create an aligned approach with a common purpose – we have agreed what we want.</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div>
						 <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>5.</b> As leaders we have a shared perception about what’s driving the current <u>safety climate</u> and creating the overall <u>culture of safety</u> on this <u>Site</u>.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					  </div>
					
					  <div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>6.</b> I am having regular specific conversations with other leaders to discuss and brainstorm what else I can do to improve safety on this <u>Site</u>.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					  </div>
				    <div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
						<div class="row" style="padding-left:10px;">
						  <div class="col-md-10" >
							<h4>Where’s My Focus?</h4>
						  </div>
						  <div class="col-md-2">
							<h5>Score 1-10</h5>
						  </div>
						</div>
				    </div>
					 

						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>7.</b> I <u>understand</u> and focus on the things I need to do to improve my performance as a safety leader.</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div>
					
					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>8.</b> As a safety leadership team on this <u>Site</u> we have identified what we will focus on to close the gaps that we have agreed exist.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>9.</b> I track and monitor our progress to achieve our agreed goals and objectives for personal and process safety improvement.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>10.</b> I regularly go out on the <u>Site</u> with the express purpose of talking to the guys about safety and looking at the operations.  (Consider – what does it say about my commitment to safety if I am not doing this daily?)</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>

						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>11.</b> Each day I’m clear about what I am focused on, what my expectations are and what has been achieved.</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div>
						
					<div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
						<div class="row" style="padding-left:10px;">
						  <div class="col-md-10" >
							<h4>Do I Take Action?</h4>
						  </div>
						  <div class="col-md-2">
							<h5>Score 1-10</h5>
						  </div>
						</div>
   				    </div>

						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>12.</b> I 'walk the talk', all the time.  My leadership is always <u>above the line</u> and creates the climate that ,generates great safety performance.</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div>
						<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>13.</b> I use <u>level 3 motivation</u> .i.e. giving my team autonomy, focusing on mastery and getting aligned on a common purpose?</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div>
					
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>14.</b> I always complete a safety observation when I see something that is unsafe and regularly recognize safe actions and conditions.</p>
							  </div>
							  <div class="col-md-2">
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
							</div>
						</div> <!-- till Q 14 -->
						
					    <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						  <div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>15.</b> I regularly have effective one on one safety conversations with my team members. Where they are about improvements, I always follow up with that person and recognize their improved behaviour or up the ante if the behaviour has not changed.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>16.</b> As safety leaders we are taking the right actions to create the safety performance that we are committed to.
                             a. We always participate in pre-starts for high risk activities e.g. confined space entry, working at heights, etc.
                             b. I maximize every opportunity to recognize someone’s efforts around safety. I make sure I don’t miss opportunities to reinforce and support what we expect.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>
		
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>17.</b> The safety leadership team on this <u>Site</u> regularly reviews our current performance in regards to:  How are we performing?  What is working?  What else could we do to improve performance?</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>18.</b> I am <u>committed to safety</u> improvement. I have conversations as needed with my Supervisor about changing things that are not within my control.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>
					
					<div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">
						<div class="row" style="padding-left:10px;">
						  <div class="col-md-10" >
							<h4>Results – Do we learn from Experience?</h4>
						  </div>
						  <div class="col-md-2">
							<h5>Score 1-10</h5>
						  </div>
						</div>
   				    </div>
					
                    <div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>19.</b> I take every opportunity to learn from experience and improve my performance as a safety leader.</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>

					<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>20.</b> As safety leaders we take action based on results and learn from our experience. Observations – how are we going, good number, and the right quality?  Are we doing enough to make a positive difference?</p>
						  </div>
						  <div class="col-md-2">
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
						</div>
					</div>	
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>21.</b> My Supervisor acts on the concerns that I raise.</p>
						  </div>
						  <div class="col-md-2">
							<select name="a21" id="a21" style="margin-top:10px;border-radius:5px;"  required="required">
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

<script>
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
</script>