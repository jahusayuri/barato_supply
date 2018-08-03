<?php
include "assets/connection_profile.php";
?>
<html>
<body>
	<form action="functions/check_credentials.php" method="post">
		Phone Number: <input type="text" name="p_number" required/><br/>
		Password: <input type="password" name="password" required/><br/>
		<input type="submit">
	</form>

	No account yet? <br/>
	<a href="pages/signup.php">Sign Up</a><br/>
	Admin?
	<a href="./admin_login.php">Click Here</a><br/>

</body>
</html>