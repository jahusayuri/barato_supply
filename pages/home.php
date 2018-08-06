<?php
include "../functions/retrieve_data.php";
include "../functions/orders.php";
session_start();
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}

$result=get_user_details($conn);
$row= $result->fetch_assoc();
echo "Welcome ".$row['last_name'].", ".$row['first_name']."!";
?>
<html>
<body>
	<!-- Top Part -->
	<div align="center">
		<?php
		//Get current stocks
		$result=get_stocks($conn);
		if($result->num_rows > 0){
			echo "<table style='width:50%;text-align:center;'><tr><th>Item Code</th><th>Item</th><th>Stocks Available</th><th>Price</th></tr>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>".$row['item_code']."</td><td>".$row['item']."</td><td>".$row['remaining']."</td><td>".$row['price']."</td></tr>";
			}
			echo "</table>";

		}
		?>
		<form action="./place_orders.php">
			<input type="submit" value="Place Order">
		</form>
		
	</div>
	<hr>
	<!-- Lower Part -->
	<div align="center">		
		<?php 
		//Check if user made orders
		$result=get_orders($conn);
		if($result->num_rows > 0){
			echo "<table style='width:50%;text-align:center;'><tr><th>Item Code</th><th>Item</th><th>Quantity</th><th>Amount</th></tr>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>".$row['item_code']."</td><td>".$row['item']."</td><td>".$row['qty']."</td><td>".$row['amount']."</td></tr>";
			}
			echo "</table>";
			
		}else{
			echo "NO ORDERS ARE MADE. PLEASE MAKE AN ORDER.";
		}
		?>
	</div>
</body>
</html>
<a href="logout.php">Logout</a>