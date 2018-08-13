<?php
session_start();
include "../functions/retrieve_data.php";
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

	<script> 
	function getAddress(address_id){
		if (address_id.length == 0) { 
        	document.getElementById("address").innerHTML = "";
        	return;
    	} else {
        	var xmlhttp = new XMLHttpRequest();
        	xmlhttp.onreadystatechange = function() {
            	if (this.readyState == 4 && this.status == 200) {
                	document.getElementById("address").innerHTML = this.responseText;
            	}
        };
        xmlhttp.open("GET", "../functions/retrieve_data.php?function_to_call=get_address_through_id&id=" + address_id, true);
        xmlhttp.send();
		}
	}
	</script>
</head>
<body>
	<div class="page-index has-hero">
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
		</div>
		<div id="content">
			<div class="container">				
				<h3>
					<strong>EDIT YOUR ADDRESS:</strong>
				</h3>
				<div class="row ">					
					<div class="col-md-5">					
						<form  id="update_user" action="../functions/update_user.php" method="post">
							<fieldset>
								<div class="form-group">									
									Delivery Option: 
									<select class="form-control" form="update_user" name="delivery_option" onchange="getAddress(this.value)" required>
										<option value="">SELECT...</option>
										<?php
										//Retrieve data
										$result = get_delivery_type($conn);
										if($result->num_rows > 0){
											//Output data of each row
											while($row = $result->fetch_assoc()){
												echo '<option value="'.$row['id'].'">'.$row['delivery_type'].'</option>';
											}
										}
										?>
									</select><br/>
									Address:<p id="address"></p><br/>							
								</div>	
							</fieldset>							
						</form>
						<input form="update_user" class="btn btn-inverse btn-sm text-uppercase" type="submit" name="submit" value="Update">							
						<a class="btn btn-inverse btn-sm text-uppercase" href="./home.php">Cancel</a>				
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