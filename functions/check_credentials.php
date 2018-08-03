<?php
include "../assets/connection_profile.php";
//Start session once user tries to log in
session_start();

if(isset($_POST['p_number']) &&
	!empty($_POST['p_number']) &&
	isset($_POST['password']) &&
	!empty($_POST['password'])
	){
	$pnumber = $_POST['p_number'];
	$password = $_POST['password'];
	user_login($conn, $pnumber, $password);
}
//For admin login
if(isset($_POST['username']) &&
	!empty($_POST['username']) &&
	isset($_POST['password']) &&
	!empty($_POST['password'])
	){
	$username = $_POST['username'];
	$password = $_POST['password'];
	admin_login($conn, $username, $password);
}


function user_login($conn, $pnumber, $password){
	//Check if user exists; if user exists start session.
	$sql = "SELECT * FROM user WHERE password='$password' AND contact_number='$pnumber'";
	$result = $conn->query($sql);

	//Give session
	if($result->num_rows){
		$_SESSION['login_user'] = $pnumber;
		echo "Login Success! Redirecting...";
		header("Refresh:5; url=../pages/home.php");
	}else{
		echo "User does not exists. Password Incorrect";
		//Destroy the failed session
		session_destroy();
		header("Refresh:3; url=../index.php");
	}
}

function admin_login($conn, $username, $password){
	//Check if user exists; if user exists start session.
	$sql = "SELECT * FROM admin WHERE password='$password' AND username='$username'";
	$result = $conn->query($sql);

	//Give session
	if($result->num_rows){
		$_SESSION['login_user'] = $username;
		echo "Login Success! Redirecting...";
		header("Refresh:5; url=../pages/home.php");
	}else{
		echo "User does not exists. Password Incorrect";
		//Destroy the failed session
		session_destroy();
		header("Refresh:3; url=../index.php");
	}
}
?>