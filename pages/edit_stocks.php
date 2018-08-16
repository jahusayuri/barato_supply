<?php
include '../functions/check_credentials.php';
include "../functions/orders.php";
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Item - Barato Supply Co</title>
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
							echo "<h3 style='color:#ffffff;'> BARATO SUPPLY CO</h3> <p style='color:#ffffff;' class='text-uppercase'>Welcome ".$row['last_name'].", ".$row['first_name']."!</p>";							
						?>								
					</div>
				</div>		
			</div>      					
		</div>
		<div align="center">			
			<a class="btn btn-inverse btn-sm text-uppercase" href="admin_home.php" >Home/Cancel</a>
			<a class="btn btn-inverse btn-sm text-uppercase" href="logout.php" >Logout</a>								
		</div>
		<div id="content">
			<div class="container">
				<div class="panel-body">
						<?php
							if(isset($_POST['edit_stock'])) { 

								$stock_id = $_POST['chosen_item'];
								$result = get_stocks_id($conn,$stock_id);	
							if($result->num_rows > 0){
									$row = $result->fetch_assoc();
						?>
									<form id='edit_stock' method='post' action=''>
										<fieldset>
											<div class="form-group">
												<input class="form-control" type='hidden' name='chosen_item' value='<?php echo $row['id']; ?> '/>
												Item Code: <input class="form-control" type='text' name='item_code' value='<?php echo $row['item_code']; ?>'/>
												Item: <input class="form-control" type='text' name='item' value='<?php echo $row['item'] ?>' />
												Quantity: <input class="form-control" type='text' name='remaining' value='<?php echo $row['remaining'] ?>'/>
												Price: <input class="form-control" type='text' name='price' value='<?php echo $row['price'] ?>'/>										
											</div>
										</fieldset>										
									</form>
						<?php		
								} 
							}
							//Update stocks
							if(isset($_POST['update_stock'])){
								$id = $_POST['chosen_item'];
								$item_code = $_POST['item_code'];
								$item = $_POST['item'];
								$remaining = $_POST['remaining'];
								$price = $_POST['price'];

								//Pass to update_stocks
								update_stocks($conn,$id,$item_code,$item,$remaining,$price);
								header("Refresh:0; url=admin_home.php");
							}
						?>						
						<div align="center">
							<input form="edit_stock" class='btn btn-inverse btn-block' type='submit' name='update_stock' value='UPDATE' />						
						</div>	
					</div>				
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