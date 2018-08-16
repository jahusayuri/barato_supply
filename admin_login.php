<?php
include "assets/connection_profile.php";
?>
<html>
<head>	
  <meta charset="utf-8">
  <title>Admin Login - Barato Supply Co</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Bootstrap CSS File -->
  <link href="assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/lib/owlcarousel/owl.theme.min.css" rel="stylesheet">
  <link href="assets/lib/owlcarousel/owl.transitions.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>
<body class="fullscreen-centered page-login">
	<div id="content">			
    	<div class="col-sm-6 col-sm-offset-3">
  			<div class="panel panel-default">
      			<div class="panel-heading">
      				<h3 class="panel-title text-uppercase">
      					Barato Supply Co
      				</h3>
      			</div>
    			<div class="panel-body">
						<form action="functions/check_credentials.php" method="post">
							<fieldset>
								<div class="form-group">
									<div class="input-group input-group-lg">
										<span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
										<input class="form-control" type="text" name="username" placeholder="Username" required/><br/>
									</div>									
								</div>
								<div class="form-group">
									<div class="input-group input-group-lg">
										<span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
										<input class="form-control" type="password" name="password" placeholder="Password" required/><br/>
									</div>
								</div>
									<input class="btn btn-lg btn-inverse btn-block" type="submit" value="SUBMIT">
							</fieldset>
						</form>
						<p class="m-b-0 m-t">User? <br/>
						<a href="./index.php" style="color:#3B5998;">User Login</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
  <!-- Required JavaScript Libraries -->
  <script src="assets/lib/jquery/jquery.min.js"></script>
  <script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="assets/lib/stellar/stellar.min.js"></script>
  <script src="assets/lib/waypoints/waypoints.min.js"></script>
  <script src="assets/lib/counterup/counterup.min.js"></script>
  <script src="assets/contactform/contactform.js"></script>

  <!-- Template Specisifc Custom Javascript File -->
  <script src="assets/js/custom.js"></script>

  <!--Custom scripts demo background & colour switcher - OPTIONAL -->
  <script src="assets/js/color-switcher.js"></script>

  <!--Contactform script -->
  <script src="assets/contactform/contactform.js"></script>
</html>