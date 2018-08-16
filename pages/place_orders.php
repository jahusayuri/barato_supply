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
?>
<html>
<head>	
  <meta charset="utf-8">
  <title>Place Orders - Barato Supply Co</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- For div tables -->
  <link rel="stylesheet" type="text/css" href="../assets/style.css">
  <!-- Bootstrap CSS File -->
  <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Libraries CSS Files -->
  <link href="../assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">
  <link href="../assets/lib/owlcarousel/owl.theme.min.css" rel="stylesheet">
  <link href="../assets/lib/owlcarousel/owl.transitions.min.css" rel="stylesheet">
  <!-- Main Stylesheet File -->
  <link href="../assets/css/style.css" rel="stylesheet">   
</head>

<link rel="stylesheet" type="text/css" href="../assets/style.css">
<body class="page-index has-hero">
	<div id="navigation" class="wrapper">
		<!-- Header Region -->
		<div style="background-color: #000000;" class="header">
			<div class="header-inner container">
				<div class="row">
	        		<div  class="col-md-7">
						<?php
							$result=get_user_details($conn);
							$row= $result->fetch_assoc();
							echo "<h3 style='color:#ffffff;'> BARATO SUPPLY CO</h3> <p style='color:#ffffff;' class='text-uppercase'>Welcome ".$row['last_name'].", ".$row['first_name']."!</p>";
							echo "<p style='color:#ffffff;'>YOUR DELIVERY ADDRESS IS:</p>" ;
							if(!empty($row['address_1'])){
								echo "<p style='color:#ffffff;'><b>".$row['address_1'].":</b> ".$row['address_2']."</p>";
							}else{
								echo "<p style='color:#ffffff;'>".$row['address']."</p>";
							}
						?>								
					</div>
				</div>		
			</div>      					
		</div>
		<form method="post" action="#" align="center">
			<input type="submit" class="btn btn-inverse btn-sm text-uppercase" name="click_home" value="home">
			<input type="submit" class="btn btn-inverse btn-sm text-uppercase" name="click_logout" value="logout">				
		</form>		
	</div>
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="table-responsive">					
				<!-- Make orders here -->
					<?php
					//Get the stocks first
					$result=get_stocks($conn);
						if($result->num_rows > 0){
							echo "<div class='table'>";
							echo "<div class='tr'><span></span><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Stocks Available</span><span class='th'>Price</span><span class='th'>Quantity</span></div>";
							while ($row = $result->fetch_assoc()) {						
								echo "<form class='tr' method='post' action='#'>";
								echo "<span class='td'><input type='hidden' name='chosen_item' value='".$row['id']."'></span><span class='td'>".$row['item_code']."</span><span class='td'>".$row['item']."</span><span class='td'>".$row['remaining']."</span><span class='td'>P".number_format($row['price'],2,'.','')."</span><span class='td'><input type='number' name='quantity' min='0' max='".$row['remaining']."' value='1' required/></span>";
								echo "<input class='btn btn-inverse btn-sm form-control text-uppercase' type='submit' name='add_to_cart' value='Add to Cart' />  ";
								echo "</form>";
							}
							echo "</div>";
						}
					?>

				</div>
			</div>			
			<div class="row">
				<div class="table-responsive">
					<div class="table">
						<div class="tr"><span></span><span class="th">Item Code</span><span class="th">Item</span><span class="th">Price</span><span class="th">Quantity</span><span class="th">Amount</span></div>
						<?php
						$total = 0;
						$count = 0;
						$total_quantity = 0;
						$amount = array();
							//Show shopping cart if it exists
							if(isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])){
								$type = "";
								foreach ($_SESSION['shopping_cart'] as $key => $value) {
									echo "<form class='tr' method='post' action=''>";
									echo "<span class='td'><input type='hidden' name='chosen_item' value='".$value['chosen_item']."'></span><span class='td'>".$value['item_code']."</span><span class='td'>".$value['item']."</span><span class='td'>P".$value['price']."</span><span class='td'>".$value['quantity']."</span><span class='td'>P".number_format($value['quantity']*$value['price'],2,'.','')."</span>";
									echo "<input class='btn btn-inverse btn-sm' type='submit' name='delete_from_cart' value='Delete' />  ";
									echo "</form>";
									//Get individual amount
									$amount[$count] = number_format($value['quantity']*$value['price'], 2, '.','');
									$count++; //Increment count to traverse
									//Get total price
									$total = $total + ($value['quantity']*$value['price']);
									//var_dump($amount);
									//Get total quantity
									$total_quantity = $total_quantity + $value['quantity'];
								}				
							}else{					
								$type = "disabled";
							}
						?>
					</div>			
				</div>
				<b>Total: </b>P<?php echo $total ?>
				<form method="post" action="#">
					<input class='btn btn-inverse btn-block text-uppercase' type="submit" name="checkout" value="Checkout" <?php echo $type ?>><i><b>NOTE:</b> You cannot delete your items once you have clicked Checkout</i>
				</form>			
			</div>	
		</div>
	</div>
		<?php
		//Assuming checkout has been clicked
		if(isset($_POST['checkout'])){
			//echo "You clicked Checkout<br/>";
			//Check if cart is more than 5 (if 5 items)
			$cart_count = count($_SESSION['shopping_cart']);
			if($cart_count >= 4){				
				//Save array data into variable
				$array_to_pass = $_SESSION['shopping_cart'];
				//Call function to insert into database
				$result	= insert_into_orders($conn,$_SESSION['id'],$array_to_pass,$amount);
			}else{
				//If shopping cart is less than 5 but total items is equal to or greater than 5 still push
				if($total_quantity >= 5) {
					//Save array data into variable
					$array_to_pass = $_SESSION['shopping_cart'];
					//Call function to insert into database
					$result	= insert_into_orders($conn,$_SESSION['id'],$array_to_pass,$amount);
				}else{
					echo "<script>alert('You need at least 5 items to check out')</script>";
				}
			}
		}

		if(isset($_POST['click_logout'])){		
			unset($_SESSION['shopping_cart']);
			echo "<script>location.href = '../index.php';</script>";
		}

		if(isset($_POST['click_home'])){		
			unset($_SESSION['shopping_cart']);
			echo "<script>location.href = 'home.php';</script>";
		}
		?>

</body>
</html>