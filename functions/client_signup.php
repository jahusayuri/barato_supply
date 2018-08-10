<?php
include "../assets/connection_profile.php";

//Check if all important data is filled up
if(isset($_POST['fname']) &&
	!empty($_POST['fname']) &&
	isset($_POST['lname']) &&
	!empty($_POST['lname']) &&
	isset($_POST['delivery_option']) &&
	!empty($_POST['delivery_option']) &&
	isset($_POST['pnumber']) &&
	!empty($_POST['pnumber']) &&
	isset($_POST['password']) &&
	!empty($_POST['password'])
	){
	$delivery_option = $_POST['delivery_option'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$pnumber = $_POST['pnumber'];
	$password = $_POST['password'];
	$input_address = "";

	//Check if delivery_option SHIPPING is used ID=3 (will vary on database); If SHIPPING is used, check if there is an inputted address
	if($delivery_option == 3){
		if(isset($_POST['input_address']) && !empty($_POST['input_address'])){
			$input_address = $_POST['input_address'];
		}else{
			echo "Address is not received";
		}
	}

	//Pass all variables to function signup
	signup($conn, $pnumber, $fname, $lname, $delivery_option, $input_address, $password);

}

function signup($conn,$pnumber, $fname, $lname, $delivery_option, $input_address, $password){
	//Make query to insert new data
	if (!empty($input_address)) {
		$sql = "INSERT INTO user (id,last_name,first_name,password,contact_number,delivery_option,address) VALUES (NULL,'$lname','$fname','$password','$pnumber','$delivery_option','$input_address')";
	}else{
		$sql = "INSERT INTO user (id,last_name,first_name,password,contact_number,delivery_option) VALUES (NULL,'$lname','$fname','$password','$pnumber','$delivery_option')";
	}
	//Run query 
	$result = $conn->query($sql);

	if($result){
		echo "Adding Success!";
	}else{
		echo "Adding Failed. Please contact IT";
	}
	header('Refresh:3; url=../index.php');
}
?>