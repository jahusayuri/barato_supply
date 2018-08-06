<?php
include "../functions/retrieve_data.php";
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
	<div>
		<form method="post" action="../functions/orders.php">
			<?php
			//Get the stocks first
			$result=get_stocks($conn);
				if($result->num_rows > 0){
					echo "<table style='width:100%;text-align:center;'><tr><th></th><th>Item Code</th><th>Item</th><th>Stocks Available</th><th>Price</th><th>Quantity</th></tr>";
					while ($row = $result->fetch_assoc()) {
						echo "<tr><td><input type='checkbox' name='chosen_item' value='".$row['id']."'></td><td>".$row['item_code']."</td><td>".$row['item']."</td><td>".$row['remaining']."</td><td>".$row['price']."</td><td><input type='number' name='quantity' min='5' value='5' required/></td></tr>";
					}
					echo "</table>";

				}
			?>
			<input type="submit" name="add_to_cart" style="margin-top:5px;" value="Add to Cart" />  
		</form>

	</div>
</body>
</html>
<a href="logout.php">Logout</a>