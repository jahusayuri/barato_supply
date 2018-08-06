<?php
include "../assets/connection_profile.php";

//Retrieve paramater form URL (if any request is made)
if(isset($_GET['function_to_call']) && !empty($_GET['function_to_call']) && $id = $_GET['id']){
	$function_to_call = $_GET['function_to_call'];
	//Call function
	$function_to_call($id,$conn);
}

function get_address_through_id($id,$conn){
	//Get address using passed id
	$sql = "SELECT * FROM delivery_options WHERE id=$id";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {		
		$row = $result->fetch_assoc();
		if ($row['delivery_type'] == "SHIPPING") {
			echo "<textarea rows='3' cols='40' name='input_address' form='user_signup' placeholder='ENTER ADDRESS...' required></textarea>";
		}else{
			echo $row['address_1']."<br/>".$row['address_2'];
		}
		
	}else{
		echo "Error";
	}
}

function get_delivery_type($conn){
	//Get delivery types
	$sql = "SELECT * FROM delivery_options";
	return $conn->query($sql);
}

function get_orders($conn){
	//Get orders
	$id = $_SESSION['id'];
	$sql = "SELECT * FROM orders a, user b, stocks c WHERE a.ordered_by = $id AND a.order_details = c.id AND b.id = $id";
	return $conn->query($sql);
}

function get_stocks($conn){
	//Get stocks
	$sql = "SELECT * FROM stocks";
	return $conn->query($sql);
}

function get_user_details($conn){
	//Get user details
	$id = $_SESSION['id'];
	$sql = "SELECT * FROM user WHERE id = $id";
	return $conn->query($sql);

}
?>