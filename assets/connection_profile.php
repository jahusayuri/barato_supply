<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "barato_supply";

//Connect to database
$conn = mysqli_connect($servername,$username,$password,$database);

//Check connection
if (!$conn) {
	die("Connection Failed:".mysqli_connect_error());
}
?>