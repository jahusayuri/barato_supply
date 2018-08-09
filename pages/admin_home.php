<?php
session_start();
include "../functions/orders.php";
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}

$result=get_admin_details($conn);
$row= $result->fetch_assoc();
echo "Welcome ".$row['last_name'].", ".$row['first_name']."!";
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
	<!-- Edit/Create New Stocks -->
	<div align="center">
		<?php
		//Get the stocks first
		$result=get_stocks($conn);
			if($result->num_rows > 0){
				echo "<div class='table'>";
				echo "<div class='tr'><span></span><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Stocks Available</span><span class='th'>Price</span></div>";
				while ($row = $result->fetch_assoc()) {						
					echo "<form class='tr' method='post' action='edit_stocks.php'>";
					echo "<span class='td'><input type='hidden' name='chosen_item' value='".$row['id']."'></span><span class='td'>".$row['item_code']."</span><span class='td'>".$row['item']."</span><span class='td'>".$row['remaining']."</span><span class='td'>P".$row['price']."</span>";
					echo "<input type='submit' name='edit_stock' value='Edit' />";
					echo "</form>";
				}
				echo "</div>";
			}
		?>
	</div>
	<hr/>
	<!-- Shows all the orders of the customers -->
	<div align="center">
		<?php
		//Get the stocks first
		$result=get_all_orders($conn);
			if($result->num_rows > 0){
				echo "<div class='table'>";
				echo "<div class='tr'><span></span><span class='th'>Ordered by</span><span class='th'>Phone Number</span><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Quantity</span><span class='th'>Price</span><span class='th'>Amount</span></div>";
				while ($row = $result->fetch_assoc()) {						
					echo "<form class='tr' method='post' action='#'>";
					echo "<span class='td'><input type='hidden' name='chosen_item' value='".$row['id']."'></span><span class='td'>".$row['last_name'].", ".$row['first_name']."</span><span class='td'>".$row['contact_number']."</span><span class='td'>".$row['item_code']."</span><span class='td'>".$row['item']."</span><span class='td'>".$row['qty']."</span><span class='td'>P".$row['price']."</span><span class='td'>P".$row['amount']."</span>";
					echo "<input type='submit' name='cancel_order' value='Cancel' />";
					echo "<input type='submit' name='approve_order' value='Approve' />";
					echo "</form>";
				}
				echo "</div>";
			}
		?>
	</div>
</body>
</html>
<a href="logout.php">Logout</a>