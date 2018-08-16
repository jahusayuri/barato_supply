<?php
include "../functions/retrieve_data.php";
session_start();
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}
?>
<html>
<head>	
  <meta charset="utf-8">
  <title>User Home - Barato Supply Co</title>
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
		<div align="center">
			<a class="btn btn-inverse btn-sm text-uppercase" href="./edit_info.php" >Edit Delivery Info</a>
			<a class="btn btn-inverse btn-sm text-uppercase" href="logout.php" >Logout</a>				
		</div>		
	</div>
	<div id="content">
		<!-- Top Part -->
		<div class="container">
			<h3>
				<strong>ITEMS FOR SALE:</strong>
			</h3>
			<div class="row">
				<div class="table-responsive">
					<?php
					//Get current stocks
					$result=get_stocks($conn);
					if($result->num_rows > 0){
						echo "<div class='table'>";
						echo "<div class='tr'><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Stocks Available</span><span class='th'>Price</span></div>";
						while ($row = $result->fetch_assoc()) {
							echo "<div class='tr'>";
							echo "<span class='td'>".$row['item_code']."</span ><span class='td'>".$row['item']."</span><span class='td'>".$row['remaining']."</span><span class='td'>P".number_format($row['price'],2,'.','')."</span>";
							echo "</div>";
						}
						echo "</div>";
					}
					?>						
				</div>					
			</div>					
			<form action="./place_orders.php">
				<input class="btn btn-inverse btn-block text-uppercase" type="submit" value="Place Order">
			</form>						
		</div>		
		<hr>
		<!-- Lower Part -->
		<div class="container">	
			<h3>
				<strong>ITEMS ORDERED:</strong>
			</h3>
			<div class="row">
				<div class="table-responsive">	
					<?php 
					//Check if user made orders
					$result=get_orders($conn);
					if($result->num_rows > 0){				
						echo "<div class='table'>";
						echo "<div class='tr'><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Quantity</span><span class='th'>Price</span><span class='th'>Amount</span><span class='th'>Status</span></div>";
						while ($row = $result->fetch_assoc()) {
							echo "<div class='tr'>";
							echo "<span class='td'>".$row['item_code']."</span><span class='td'>".$row['item']."</span><span class='td'>".$row['qty']."</span><span class='td'>P".$row['price']."</span><span class='td'>P".$row['amount']."</span><span class='td'>".$row['status']."</span>";
							echo "</div>";
						}
						echo "</div>";
						
					}else{
						echo "NO ORDERS ARE MADE. PLEASE MAKE AN ORDER.";
					}
					?>
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