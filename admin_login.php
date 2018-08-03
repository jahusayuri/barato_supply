<?php
include "assets/connection_profile.php";
?>
<html>
<body>
	<form action="functions/check_credentials.php" method="post">
		Username: <input type="text" name="username" required/><br/>
		Password: <input type="password" name="password" required/><br/>
		<input type="submit">
	</form>

	User? <br/>
	<a href="./index.php">User Login</a><br/>

</body>
</html>