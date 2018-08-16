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
	/*echo "User ID is: ".$user_id."<br/>";
	echo "<br/>Array data is: ";
	var_dump($data_array);
	echo "<br/>Amount is: ";
	var_dump($amount_array);*/
	//Loop through the data
	$count = 0;
	$result = 0;
	foreach ($data_array as $key => $value) {
		$order_details = $value['chosen_item'];
		$qty = $value['quantity'];
		$amount = $amount_array[$count];

		//Check if same order already exists
		$check_order_sql = "SELECT id FROM orders WHERE ordered_by='$user_id' AND order_details='$order_details'";
		//var_dump($conn->query($check_order_sql));
		if($conn->query($check_order_sql)->num_rows > 0){
			echo "<script>alert('YOUR ORDER FOR ".strtoupper($value['item'])." ALREADY EXISTS!');</script>";
		}else{
			//Check if stock is still available
			$number_stock = $conn->query("SELECT * FROM stocks WHERE id = '$order_details'");
			$row = $number_stock->fetch_assoc();
			if($row['remaining'] < 0 ){
				echo "<script>alert('SORRY BUT WE RAN OUT OF STOCK FOR ".strtoupper($row['item'])."')</script>";
			}else{
				$sql = "INSERT INTO orders (id,ordered_by,order_details,qty,amount,status) VALUES (NULL,'$user_id','$order_details','$qty','$amount','PENDING')";
				$result = $conn->query($sql);				
				//Update the stocks
				update_remaining_stocks($conn,$qty,$order_details);	
			}			
		}		
		$count++;		
		}
		//Check if successfully processed.
		if ($result) {
			echo "Successfully inserted<br/>";
			unset($_SESSION['shopping_cart']);
			echo "<script>location.href = '../pages/home.php';</script>";
			return 1;
		}else{
			echo "<script>alert('PLEASE CONTACT BARATO SUPPLY CO TO REMOVE YOUR ORDER(S)')</script>";
			return 0;
		}	
}

if(isset($_POST['cancel_order'])){	
	$id = $_POST['chosen_item'];
	$user_id = $_POST['user_id'];
	$status = strtoupper('cancelled');	
	update_order_status($conn,$status,$id,$user_id);
	echo "<script>location.href='../pages/admin_home.php#pending_orders'</script>";
}

if(isset($_POST['change_order_status'])){
	$id = $_POST['chosen_item'];
	$user_id = $_POST['user_id'];
	if($_POST['change_order_status'] == strtoupper('approve')){
		$status = strtoupper('approved');
		update_order_status($conn,$status,$id,$user_id);
	}elseif($_POST['change_order_status'] == strtoupper('pack order')){
		$status = strtoupper('packing order');
		update_order_status($conn,$status,$id,$user_id);
	}elseif($_POST['change_order_status'] == strtoupper('deliver order')){		
		$status = strtoupper('delivering');
		update_order_status($conn,$status,$id,$user_id);
	}else{
		echo "<script>alert('Package already delivered')</script>";
	}	
	echo "<script>location.href='../pages/admin_home.php#pending_orders'</script>";
}

if(isset($_POST['clear_orders'])){
	echo "<script>
	if(confirm('Are you sure you want to clear orders?')){
		location.href='../functions/orders.php?clear_orders=1';
	}
	</script>";
}

if(isset($_POST['clear_items'])){
	echo "<script>
	if(confirm('Are you sure you want to clear items?')){
		location.href='../functions/orders.php?clear_items=1';
	}
	</script>";
}

if(isset($_GET['clear_items'])){
	//Check if there are orders
	if($conn->query("SELECT * FROM orders")->num_rows > 0){
		echo "<script>alert('Please clear orders first!');</script>";
	}else{
		//Turn constraints OFF first
		$conn->query("SET FOREIGN_KEY_CHECKS=0");
		$sql = "TRUNCATE TABLE stocks";
		$conn->query($sql);
		echo "<script>alert('Successfully cleared items!');</script>";
		//Turn constraints ON 
		$conn->query("SET FOREIGN_KEY_CHECKS=1");
	}	
	echo "<script>location.href='../pages/admin_home.php';</script>";
}

if(isset($_GET['clear_orders'])){
	$sql = "TRUNCATE TABLE orders";
	if($conn->query($sql)){
		echo "<script>alert('Successfully cleared orders!');</script>";
	}
	echo "<script>location.href='../pages/admin_home.php';</script>";
}

function update_order_status($conn,$status,$id,$user_id){
	$sql = "UPDATE orders SET status='$status' WHERE order_details=$id AND ordered_by=$user_id";
	return $conn->query($sql);
}

function update_remaining_stocks($conn,$quantity,$id){
	$sql = "UPDATE stocks SET remaining=remaining-$quantity WHERE id=$id";
	return $conn->query($sql);
}

function update_stocks($conn,$id,$item_code,$item,$remaining,$price){
	$sql = "UPDATE stocks SET item_code='$item_code', item='$item', remaining='$remaining', price='$price' WHERE id=$id";
	return $conn->query($sql);
}

function add_stocks($conn,$item_code,$item,$remaining,$price){
	$sql = "INSERT INTO stocks (id,item,item_code,remaining,price) VALUES (NULL,'$item','$item_code',$remaining,$price)";
	return $conn->query($sql);
}


?>