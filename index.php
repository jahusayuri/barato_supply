<?php
include "assets/connection_profile.php";
?>
<html>
<head>	
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900" rel="stylesheet">

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
            	<div class="panel-body">
            		<div class="form-group">
						<form action="functions/check_credentials.php" method="post">
							<p>Phone Number:</p> <input type="text" name="p_number" required/><br/>
							<p>Password:</p> <input type="password" name="password" required/><br/>
							<input class="form-control" type="submit" value="Submit">
						</form>

						No account yet? <br/>
						<a href="pages/signup.php">Sign Up</a><br/>
						Admin?	<br/>
						<a href="./admin_login.php">Click Here</a><br/>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>