<?php
session_start();
include "../functions/orders.php";
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}elseif (isset($_SESSION['shopping_cart'])) {
	//echo "<br/>";
	//var_dump($_SESSION['shopping_cart']);

	//Uncomment to reset the shoppin_cart list
	//$_SESSION['shopping_cart'] = null;
}

$result=get_user_details($conn);
$row= $result->fetch_assoc();
echo "<br/>Welcome ".$row['last_name'].", ".$row['first_name']."!<br/>";
?>
<html>
<link rel="stylesheet" type="text/css" href="../assets/style.css">
<body>
	<a href="home.php">Home</a>
	<!-- Make orders here -->
	<div align="center">
		<?php
		//Get the stocks first
		$result=get_stocks($conn);
			if($result->num_rows > 0){
				echo "<div class='table'>";
				echo "<div class='tr'><span></span><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Stocks Available</span><span class='th'>Price</span><span class='th'>Quantity</span></div>";
				while ($row = $result->fetch_assoc()) {						
					echo "<form class='tr' method='post' action='#'>";
					echo "<span class='td'><input type='hidden' name='chosen_item' value='".$row['id']."'></span><span class='td'>".$row['item_code']."</span><span class='td'>".$row['item']."</span><span class='td'>".$row['remaining']."</span><span class='td'>P".$row['price']."</span><span class='td'><input type='number' name='quantity' min='5' max='".$row['remaining']."' value='5' required/></span>";
					echo "<input type='submit' name='add_to_cart' value='Add to Cart' />  ";
					echo "</form>";
				}
				echo "</div>";
			}
		?>
	</div>
	<hr/>
	<!-- Show orders -->
	<div align="center">
		<div class="table">
			<div class="tr"><span></span><span class="th">Item Code</span><span class="th">Item</span><span class="th">Price</span><span class="th">Quantity</span><span class="th">Amount</span></div>
			<?php
			$total = 0;
			$count = 0;
			$amount = array();
				//Show shopping cart if it exists
				if(isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])){
					$type = "";
					foreach ($_SESSION['shopping_cart'] as $key => $value) {
						echo "<form class='tr' method='post' action='#'>";
						echo "<span class='td'><input type='hidden' name='chosen_item' value='".$value['chosen_item']."'></span><span class='td'>".$value['item_code']."</span><span class='td'>".$value['item']."</span><span class='td'>P".$value['price']."</span><span class='td'>".$value['quantity']."</span><span class='td'>P".number_format($value['quantity']*$value['price'], 2)."</span>";
						echo "<input type='submit' name='delete_from_cart' value='Delete' />  ";
						echo "</form>";
						//Get individual amount
						$amount[$count] = number_format($value['quantity']*$value['price'], 2);
						$count++; //Increment count to traverse
						//Get total price
						$total = $total + ($value['quantity']*$value['price']);
						//var_dump($amount);
					}				
				}else{					
					$type = "disabled";
				}

			?>			
		</div>
		<b>Total: </b>P<?php echo $total ?>
		<form method="post" action="#">
			<input type="submit" name="checkout" value="Checkout" <?php echo $type ?>><i><b>NOTE:</b> You cannot delete your items once you have clicked Checkout</i>
		</form>		
	</div>
		<?php
		//Assuming checkout has been clicked
		if(isset($_POST['checkout'])){
			echo "You clicked Checkout<br/>";
			//Save array data into variable
			$array_to_pass = $_SESSION['shopping_cart'];
			//Call function to insert into database
			$result	= insert_into_orders($conn,$_SESSION['id'],$array_to_pass,$amount);
		}
		?>

</body>
</html>
<br/>
<a href="logout.php">Logout</a>