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
  <title>Add Item - Barato Supply Co</title>
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
	</div>
	<div align="center">			
		<a class="btn btn-inverse btn-sm text-uppercase" href="admin_home.php" ><i style="color:#ffffff;" class="fa fa-home text-primary "></i>Home/Cancel</a>
		<a class="btn btn-inverse btn-sm text-uppercase" href="logout.php" ><i style="color:#ffffff;" class="fa fa-sign-out text-primary "></i>Logout</a>								
	</div>
	<div id="content">
		<div class="container">
			<div class="row panel-body">
				<?php
					if(isset($_POST['add_stock'])) { ?>
						<form method='post' action=''>
							<fieldset>								
								<div class="form-group">
									Item Code: <input class="form-control" type='text' name='item_code'/>
									Item:<input class="form-control" type='text' name='item' />
									Quantity:<input class="form-control" type='text' name='remaining' />
									Price:<input class="form-control" type='text' name='price' />									
								</div>								
							</fieldset>
							<input class='btn btn-inverse btn-block' type='submit' name='add_final' value='Add' /><i><b>Note: </b> Make sure your data is final.</i>					
						</form>	
				<?php 
					}
					//Update stocks
					if(isset($_POST['add_final'])){
						$item_code = $_POST['item_code'];
						$item = $_POST['item'];
						$remaining = $_POST['remaining'];
						$price = $_POST['price'];

						//Pass to update_stocks
						add_stocks($conn,$item_code,$item,$remaining,$price);
						header("Refresh: 1; url=admin_home.php");
					}
				?>	
			</div>
		</div>
	</div>	

	
</body>
</html>