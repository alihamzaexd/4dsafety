<div class="navbar navbar-custom navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" onclick="loadDefautContent()">4DSafety</a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=
"#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="">
          <a onclick="loadAboutContent()">About</a>
        </li>		
      </ul>

      <ul class="nav navbar-nav navbar-right">
          <li>
              <a  onclick="
			  <?php if(isset($_SESSION['role']))
			          { header('Refresh: 1; URL = userHome.php'); }
			        else
					  { echo "loadLoginForm()"; }
			  ?>
			  ">Login</a>
          </li>
      </ul>

    </div>
   </div> 
</div>