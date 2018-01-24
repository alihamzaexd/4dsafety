<?php
session_start();
global $username;
if($_SESSION['valid']!= true){ # send invalid user back to login page
	header("Location: index.php");
}else
	{  	
		$username = $_SESSION['username'];
		global $reloadCount;
		$reloadCount = 0;
		require_once(dirname(__FILE__).'/../userFiles/userAccountHandler.php');
		global $userAccountHanlder;
		$userAccountHanlder = new UserAccountHandler();
?>
<!DOCTYPE html>
<html>
<script src="javascript/userPageJavascript.js"> </script>

<head>
<?php
	// including Bootstrap, css and javascripts files
	require_once(dirname(__FILE__).'/../external_files.php');

	// adding navigation bar to the page
	require_once(dirname(__FILE__).'/../userFiles/userNavbar.php');
	
	// including file with db connector functions
	require_once(dirname(__FILE__).'/../db_connect.php');
	
	// including file with account handler functions
	require_once(dirname(__FILE__).'/../userFiles/userAccountHandler.php');
?>
</head>

<body style="background-image:url(
http://www.template-joomspirit.com/template-joomla/template-107/images/background/light-red-NR.jpg);">

	<div class="container">
	  <div class="row">
		<br>
		<div class="col-md-12">
		<div class="panel panel-default" style="padding:15px;">
		  <form class="new_report" id="new_report" action="" accept-charset="UTF-8" method="post">
			<div class="row">
				<div class="col-md-3">
				  <div class="panel panel-default" style="padding:10%; background-color:#EAECEE;">
				  <h4>Stop the Job Meeting Review</h4>
				  <p>
					One of our best safety defences is that everyone has the right to Stop The Job. As safety leaders we must have situational awareness i.e. what's the job that's being performed and what's my role in this job. This is called the baseline - what things should look like, sound like, smell like and feel like.
				  </p>
				  <p>
					If you are involved in a job and are unclear about the job or your role in that job - you should Stop The Job and get clarity.
				  </p>
				  <h4>Who CARES Wins</h4>
				  <p>"Leadership: Creating an Achievement oriented, Relationship based, Endeavour Sustainably."</p>
                    <a data-toggle="modal" data-target="#STJMR" href="#">View More <span class="glyphicon glyphicon-new-window"></span></a>    
					<div class="modal fade" id="STJMR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					  <div class="modal-content">
						  <div id="modal_header">
							<button class="close" data-dismiss="modal" style="color:white !important; padding-right:5px;">
					&times;</button>
							<center>	
							<br>
							<h4 class="modal-title" style="color:white !important;font-style: normal !important;font-size:22px 
				!important;">Stop the Job Meeting Review</h4>
							</center>
							<br>
						  </div><!-- end modal-header -->
						<div class="modal-body" style="padding:5%;">
						   <p>
							One of our best safety defences is that everyone has the right to Stop The Job. As safety leaders we must have situational awareness i.e. what's the job that's being performed and what's my role in this job. This is called the baseline - what things should look like, sound like, smell like and feel like.
						  </p>
						  <p>
							If you are involved in a job and are unclear about the job or your role in that job - you should Stop The Job and get clarity.
						  </p>
						  <h4>Who CARES Wins</h4>
						  <p>"Leadership: Creating an Achievement oriented, Relationship based, Endeavour Sustainably."</p>
						  <p>
							You can't create what you don't understand!! If you do not understand the critical details of the job being performed or do not understand your role in the task and what is expected of you, then you have an insufficient relationship with the job being performed. When this happens you are at risk and you may put your workmates at risk.
						  </p>
						  <p>
							Achieving injury free operations is based on everyone being able to perform their job when needed. We plan for this and train for this and most of the time things go to plan. But what if they don't? Or what if our training hasn't covered something and we find ourselves not knowing what's going on or what to do next. That's when we Stop The Job.
						  </p>
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
							  <label for="team">Company</label>
							  <select class="form-control" id="company" style="background-color:#EAECEE;">
							  <option value="" disabled selected>Select company</option>
								<option>ExD LHR</option>
								<option>ExD LHR</option>
								<option>ExD LHR</option>
								<option>ExD LHR</option>
							  </select>
							</div>
						  </div> 
						  <div class="row">
						  <br>
							<div class="col-md-12">
							  <label for="team">Team</label>
							  <select class="form-control" id="team" style="background-color:#EAECEE;">
							  <option value="" disabled selected>Select team</option>
								<option>ExD Development</option>
								<option>ExD Testing</option>
								<option>ExD Automation</option>
								<option>ExD Graphic designing</option>
							  </select>
							</div>
						  </div>
						  
						</div> <!-- top fields row end -->
				    </div>

					<h3>EARS ON 4 Safety Review</h3>
					<p>Score each the areas below on a scale of 1-10, with 10 being the best.</p>
					
					<div  class="col-md-12" style="background-color:#EBF5FB;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-8">
							<p style="margin:10px;">Reason for Meeting</p>
						  </div>
						  <div class="col-md-4">
							<select name="q1" id="q1" style="margin-top:10px;border-radius:5px;" required="required">
								<option value="someoneSTJ">Someone Stopped the Job</option>
								<option value="incidentOccured">An Incident Occured</option>
							</select>
						  </div>
						</div>
					</div>
					<p>When we Stop The Job we must make sure that everyone knows why we stopped and is clear about the work plan and their role in that plan.</p>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;">What was your level of situational awareness when the job was stopped?</p>
						  </div>
						  <div class="col-md-2">
							<select name="q2" id="q2" style="margin-top:10px;border-radius:5px;" required="required">
								<option value="low">Low</option>
								<option value="med">Medium</option>
								<option value="high">High</option>
								<option value="veryHigh">Very High</option>
							</select>
						  </div>
						</div>
					</div>
					
					<div  class="col-md-12" style="background-color:#5B42DB; color: #ffffff;padding: 1% 1%;">	
					<div class="row" style="padding-left:10px;">
					  <div class="col-md-10" >
						<h4>Process</h4>
					  </div>
					  <div class="col-md-2">
						<h5>Score 1-10</h5>
					  </div>
					</div>
				  </div>
					<div  class="col-md-12" style="background-color:#FBFCFC;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;"><b>E.</b> Did we make sure everyone understood why the job was stopped?</p>
						  </div>
						  <div class="col-md-2">
							<select name="e" id="e" style="margin-top:10px;border-radius:5px;" required="required">
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
								<p style="margin:10px;"><b>A.</b> How well did the team members review the task and clarify their steps?</p>
							  </div>
							  <div class="col-md-2">
								<select name="a1" id="a1" style="margin-top:10px;border-radius:5px;"  required="required">
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

								<!-- make all 10-2 partiotion question and answer scale from 1-10 
								 for this SLP form
								-->
						<div  class="col-md-12" style="background-color:#EBF5FB; padding: 1% 1%;">
							<div class="row" >
							  <div class="col-md-10">
								<p style="margin:10px;"><b>R.</b> How well did the Leader confirm & reinforce any key information?</p>
							  </div>
							  <div class="col-md-2">
								<select name="r" id="r" style="margin-top:10px;border-radius:5px;"  required="required">
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
							<p style="margin:10px;"><b>S.</b> How well did individuals show how complicated steps were to be carried out?</p>
						  </div>
						  <div class="col-md-2">
							<select name="s" id="s" style="margin-top:10px;border-radius:5px;"  required="required">
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
					  <div  class="col-md-12" style="background-color:#EBF5FB;padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-10">
							<p style="margin:10px;">What’s your level of situational awareness now?</p>
						  </div>
						  <div class="col-md-2">
							<select name="q3" id="q3" style="margin-top:10px;border-radius:5px;" required="required">
								<option value="low">Low</option>
								<option value="med">Medium</option>
								<option value="high">High</option>
								<option value="veryHigh">Very High</option>
							</select>
						  </div>
						</div>
					</div>
					<div  class="col-md-12" style="background-color:#FBFCFC; padding: 1% 1%;">
						<div class="row" >
						  <div class="col-md-6">
							<p style="margin:10px;">What specific things could we do to improve on the effectiveness of our planning and pre-task meetings?
				            </p>
						  </div>
						  <div class="col-md-6">
							<textarea class="form-control" rows="5" id="improvements"> </textarea>
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

	
</body>

</html>


<?php 
} // enclosing page into else statement
?>