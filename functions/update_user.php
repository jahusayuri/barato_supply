<?php
include "../assets/connection_profile.php";
include "./retrieve_data.php";

session_start();

if(isset($_POST['delivery_option']) && !empty($_POST['delivery_option'])){
	$delivery_type = $_POST['delivery_option'];
	$input_address = "";
	if($delivery_type == 3){
		if(isset($_POST['input_address']) && !empty($_POST['input_address'])){
			$input_address = $_POST['input_address'];			
		}else{
			echo "Address is not received! </br>";
			header("Refresh: 2; url=../pages/edit_info.php");
		}
	}	
	update_user_delivery_info($conn,$delivery_type,$input_address);
}else{
	echo "Didn't get anything fam.";
}

function update_user_delivery_info($conn,$delivery_type,$address){
	$user_id = $_SESSION['id'];
	//Make query to insert new data
	if (!empty($address)) {
		$sql = "UPDATE user SET address='$address' , delivery_option='$delivery_type' WHERE id=$user_id";
	}else{
		$sql = "UPDATE user SET address=NULL , delivery_option='$delivery_type'WHERE id=$user_id";
	}

	//Run query 
	$result = $conn->query($sql);

	if($result){
		echo "Update Success!";
	}else{
		echo "Update Failed. Please contact IT";
		$result->error;
		var_dump($result);
	}
	header('Refresh:2; url=../pages/home.php');
}
?>