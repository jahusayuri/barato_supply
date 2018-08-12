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
							<p>Username:</p> <input type="text" name="username" required/><br/>
							<p>Password:</p> <input type="password" name="password" required/><br/>
							<input type="submit">
						</form>

						User? <br/>
						<a href="./index.php">User Login</a><br/>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>