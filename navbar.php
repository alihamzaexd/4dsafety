<div class="navbar navbar-custom navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="/admin">4DSafety</a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="">
          <a href="#">Users</a>
        </li>
        <li class="">
          <a href="#">Companies</a>
        </li>

        <li class="dropdown active">
          <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Categories<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Business Functions</a></li>
            <li class=""><a href="#">Regions</a></li>
            <li class=""><a href="#">Countries</a></li>
            <li class=""><a href="#">Assets</a></li>
            <li class=""><a href="#">Business Units</a></li>
            <li class=""><a href="#">Departments</a></li>
            <li class=""><a href="#">Teams</a></li>
          </ul>
        </li>
		
		<li class="dropdown ">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Reports<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li class=""><a href="#">Reports Submitted</a></li>
            <li class=""><a href="#">Report History</a></li>
          </ul>
        </li>
		<li class="dropdown ">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Setup<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li id="org"><a href="Organizations.php">Organizations</a></li>
            <li id="loc"><a href="Locations.php">Locations</a></li>			
            <li id="div"><a href="Divisions.php">Divisions</a></li>
            <li id="dept"><a href="Departments.php">Departments</a></li>
            <li id="grade"><a href="Grades.php">Grades</a></li>
            <li id="grade"><a href="Jobs.php">Job Levels</a></li>
            <li id="position"><a href="Positions.php">Positions</a></li>
          </ul>
        </li>
		<li class="dropdown ">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Employee Management<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li id="org"><a href="Employees.php">Employee Master</a></li>
          </ul>
        </li>		
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li role="presentation" class="dropdown ">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
            SLG <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li class=""><a href="/admin/profile/edit">Profile</a></li>
            <li class=""><a href="/admin/profile/edit_password">Reset Password</a></li>
          </ul>
        </li>
        <li><a rel="nofollow" data-method="delete" href="/accounts/sign_out">Logout</a></li>
      </ul>

    </div>
   </div> 
</div>