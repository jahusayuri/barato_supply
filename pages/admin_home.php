<?php
session_start();
include "../functions/orders.php";
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Home - Barato Supply Code</title>
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

<body class="page-index has-hero">
	<div id="navigation" class="wrapper">
		<!-- Header Region -->
		<div style="background-color: #000000;" class="header">
			<div class="header-inner container">
				<div class="row">
	        		<div  class="col-md-5">
						<?php
							$result=get_admin_details($conn);
							$row= $result->fetch_assoc();
							echo "<h3 style='color:#ffffff;'> BARATO SUPPLY COMPANY </h3> <p style='color:#ffffff;' class='text-uppercase'>Welcome ".$row['last_name'].", ".$row['first_name']."!</p>";							
						?>								
					</div>
				</div>		
			</div>      					
		</div>
		<div align="center">			
			<a class="btn btn-inverse btn-sm text-uppercase" href="logout.php" >Logout</a>				
		</div>		
	</div>
	<div id="content">
		<div class="container">
			<h3>
				<strong>AVAILABLE ITEMS:</strong>
			</h3>
			<div class="row">
				<div class="table-responsive">	
					<!-- Edit/Create New Stocks -->
					<?php
					//Get the stocks first
					$result=get_stocks($conn);
						if($result->num_rows > 0){
							echo "<div class='table'>";
							echo "<div class='tr'><span></span><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Stocks Available</span><span class='th'>Price</span></div>";
							while ($row = $result->fetch_assoc()) {						
								echo "<form class='tr' method='post' action='edit_stocks.php'>";
								echo "<span class='td'><input type='hidden' name='chosen_item' value='".$row['id']."'></span><span class='td'>".$row['item_code']."</span><span class='td'>".$row['item']."</span><span class='td'>".$row['remaining']."</span><span class='td'>P".$row['price']."</span>";
								echo "<input class='btn btn-inverse btn-sm text-uppercase' type='submit' name='edit_stock' value='Edit' />";
								echo "</form>";
							}
							echo "</div>"; 
						}
					?>
				</div>				
				<div align="center">
					<form method="post" action="./add_stocks.php">
						<input class='btn btn-inverse btn-block text-uppercase' type="submit" name="add_stock" value="ADD ITEM">
					</form>							
				</div>
			</div>
		</div>
		<hr/>
		<div id="pending_orders" class="container">
			<h3>
				<strong>PENDING ORDERS:</strong>
			</h3>
			<div class="row">
				<div class="table-responsive">	
				<!-- Shows all the orders of the customers -->
					<?php
					//Get the stocks first
					$result=get_all_orders($conn);
						if($result->num_rows > 0){
							echo "<div class='table'>";
							echo "<div class='tr'><span></span><span class='th'>Ordered by</span><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Quantity</span><span class='th'>Price</span><span class='th'>Amount</span></div>";
							while ($row = $result->fetch_assoc()) {						
								echo "<form class='tr' method='post' action=''>";
								echo "<input type='hidden' name='user_id' value='".$row['ordered_by']."'/>";
								echo "<span class='td'><input type='hidden' name='chosen_item' value='".$row['order_details']."'></span><span class='td'>".$row['last_name'].", ".$row['first_name']."</span><span class='td'>".$row['item_code']."</span><span class='td'>".$row['item']."</span><span class='td'>".$row['qty']."</span><span class='td'>P".$row['price']."</span><span class='td'>P".$row['amount']."</span>";
								if ($row['status'] == strtoupper('pending')) {								
									echo "<input class='btn btn-inverse btn-sm' type='submit' name='cancel_order' value='CANCEL ORDER' />";				
									echo "<input class='btn btn-inverse btn-sm' type='submit' name='change_order_status' value='APPROVE' />";
								}elseif($row['status'] == strtoupper('approved')){
									echo "<input class='btn btn-inverse btn-sm' type='submit' name='change_order_status' value='PACK ORDER' />";
								}elseif($row['status'] == strtoupper('packing order')){
									echo "<input class='btn btn-inverse btn-sm' type='submit' name='change_order_status' value='DELIVER ORDER' />";	
								}elseif($row['status'] == strtoupper('delivering')){
									echo "<input class='btn btn-success btn-sm' type='submit' name='change_order_status' value='DELIVERED' disabled/>";	
								}else{
									echo "<input class='btn btn-danger btn-sm' type='submit' value='CANCELLED' disabled/>";
								}
								echo "</form>";
							}
							echo "</div>";
						}
					?>
				</div>
				<div align="center">						
					<form method="post" action="./print_orders.php"> 
						<input class="btn btn-inverse btn-block" type="submit" name="print_orders" value="PRINT ORDERS">
					</form>					
				</div>			
			</div>
		</div>
	</div>
</body>
  <!-- Required JavaScript Libraries -->
  <script src="../assets/lib/jquery/jquery.min.js"></script>
  <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="../assets/lib/stellar/stellar.min.js"></script>
  <script src="../assets/lib/waypoints/waypoints.min.js"></script>
  <script src="../assets/lib/counterup/counterup.min.js"></script>
  <script src="../assets/contactform/contactform.js"></script>

  <!-- Template Specisifc Custom Javascript File -->
  <script src="../assets/js/custom.js"></script>

  <!--Custom scripts demo background & colour switcher - OPTIONAL -->
  <script src="../assets/js/color-switcher.js"></script>

  <!--Contactform script -->
  <script src="../assets/contactform/contactform.js"></script>
</html>