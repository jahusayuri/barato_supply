<?php
include "retrieve_data.php";
if (isset($_POST['add_to_cart'])) {	
	/* For testing purposes:
	echo "Cart is received <br/>";
	echo "ID received is: ".$_POST['chosen_item']."<br/>";
	echo "Quantity Received is: ".$_POST['quantity']."<br/>";
	*/
	//Get stocks from the database using given id: chosen_item
	$result = get_stocks_id($conn,$_POST['chosen_item']);
	if($result->num_rows > 0){
		//Get the data
		$row = $result->fetch_assoc(); 
		$item_code = $row['item_code'];
		$item = $row['item'];
		$price = $row['price'];		
	}else{
		echo "Issa empty <br/>";
	}
	if(isset($_SESSION['shopping_cart'])){
		$item_array_id = array_column($_SESSION['shopping_cart'],'chosen_item');		//Check if item already added

		if (!in_array($_POST['chosen_item'], $item_array_id)) {
			$count = count($_SESSION['shopping_cart']);
			$new_item_array = array(
			'chosen_item' => $_POST['chosen_item'], 
			'quantity' => $_POST['quantity'], 
			'item_code' => $item_code,
			'item' => $item,
			'price' => $price,
			);
			$_SESSION['shopping_cart'][$count] = $new_item_array;

		}else{
			echo "<script>alert('Item already added! Please delete item first.')</script>";
		}
	}else{
		$item_array = array(
			'chosen_item' => $_POST['chosen_item'], 
			'quantity' => $_POST['quantity'], 
			'item_code' => $item_code,
			'item' => $item,
			'price' => $price,
		);

		//Set initial session array
		$_SESSION['shopping_cart'][0] = $item_array;
	}
}
if(isset($_POST['delete_from_cart'])) {
	/*
	echo "Ya clicked delete <br/>";
	echo "ID Received: ".$_POST['chosen_item']."<br/>";
	var_dump($_SESSION['shopping_cart']);
	*/
	foreach ($_SESSION['shopping_cart'] as $key => $value) {
		if ($value['chosen_item'] == $_POST['chosen_item']) {
			unset($_SESSION['shopping_cart'][$key]);
			//echo "Succesfully Unset<br/>";
		}
	}
}

function insert_into_orders($conn,$user_id,$data_array,$amount_array){
	echo "User ID is: ".$user_id."<br/>";
	echo "<br/>Array data is: ";
	var_dump($data_array);
	echo "<br/>Amount is: ";
	var_dump($amount_array);
	//Loop through the data
	$count = 0;
	foreach ($data_array as $key => $value) {
		$order_details = $value['chosen_item'];
		$qty = $value['quantity'];
		$amount = $amount_array[$count];
		$sql = "INSERT INTO orders (id,ordered_by,order_details,qty,amount,status) VALUES (NULL,'$user_id','$order_details','$qty','$amount','PENDING')";
		$result = $conn->query($sql);
		$count++;
		
		//Update the stocks
		update_remaining_stocks($conn,$qty,$order_details);	
		}
		//Check if successfully processed.
		if ($result) {
			echo "Successfully inserted<br/>";
			unset($_SESSION['shopping_cart']);
			return 1;
		}else{
			echo "Error! Please contact IT.";
			return 0;
		}	
}

function update_remaining_stocks($conn,$quantity,$id){
	$sql = "UPDATE stocks SET remaining=remaining-$quantity WHERE id=$id";
	$result = $conn->query($sql);
}


?>