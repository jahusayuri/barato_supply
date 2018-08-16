<?php
include "../functions/retrieve_data.php";
?>
<html>
<head>

  <meta charset="utf-8">
  <title>User Signup - Barato Supply Co</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  
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

<body class="page-register">
	<div align="center" class="row">
		<div id="content">			
	    	<div class="col-sm-7 col-sm-offset-3">
	      		<div class="panel panel-default">
	      			<div class="panel-heading">
	      				<h3 class="panel-title">
	      					Barato Supply Co
	      				</h3>
	      			</div>
	            	<div align="left" class="panel-body">
						<form id="user_signup" action="../functions/client_signup.php" method="post" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions'); return false; }">
							<fieldset>
								<div class="form-group">
									First Name: <input class="form-control" type="text" name="fname" placeholder="e.g. John" required/><br/>									
									Last Name: <input  class="form-control" type="text" name="lname" placeholder="e.g. Doe" required/><br/>
									Contact Number: <input class="form-control" type="text" name="pnumber" placeholder="e.g. +639xxxxxxxxx" required/><br/>
									Password: <input class="form-control" type="password" name="password" required/><br/>										
									Delivery Option: 
									<select class="form-control" form="user_signup" name="delivery_option" onchange="getAddress(this.value)" required>
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
									</select>
								</div>								
								Address:<p id="address"></p>
								<div class="form-group" align="center">
									<b>Terms and Conditions</b><br/>
									<div class="form-group" style="overflow:auto;width:100%;height:50%;" align="left">
										<b>GUIDE, TERMS & CONDITIONS - THE RESELLER NETWORK </b><br/>
										Please read these guides, terms and conditions carefully before agreeing to become a BSCO Reseller. Barato Supply Company is a trading name and registered trademark of Printahe Graphics & Garments. In these terms and conditions BSCO is referred to as ‘we’ or ‘us’ and you (Reseller) are referred to as ‘you’.<br/><br/>
										<b>I. PRODUCTION & RESERVATION</b><br/>
										1.1 Every week, we have two (2) batches of (limited) clothes for release scheduled every <b>WEDNESDAY</b> and <b>SATURDAY</b>.<br/>
										1.2 Designs every batch vary, if you want an item which was released on the 1st batch, you might not find it on the next one. Please understand that we don't want excessive number produced on a single item for we don't want to cause a "sunflower mob"-like incident.<br/>
										1.3 <b>RESERVATION</b> for 1st batch starts on Sunday evening and ends on Tuesday night. <b>RESERVATION</b> for 2nd batch starts on Wednesday evening and ends on Friday night.<br/>
										1.4 We have over 180 resellers (active and idle), so we highly encourage you to be highly attentive to updates on page and GC (group chat) on Facebook.<br/>
										1.5 We recommend buying on hand items first before selling, you might not be able to buy any after a day.<br/><br/>
										<b>II. ORDER</b><br/>
										2.1 Place order on this system, please follow steps.<br/>
										2.2 We require minimum of 5 pieces- assorted on every batch purchase.<br/>
										2.3 Payment upon pick up. If you have picked shipping, payment must be done as soon as you are done placing order. Your order will be on hold while we wait for the payment to be settled.<br/><br/>
										<b>III. DELIVERY</b><br/>
										3.1 Please see delivery options below:<br/>
										3.1.1 <b>PICK-UP.</b> Location: APM MALL: The Brand Ensembles Boutique. Payment over the counter.<br/>
										3.1.2 <b>SHIPPING.</b> Courier: JRS Express. Shipping fee will automatically be added on your check out.<br/>
										3.1.3 <b>WALK IN.</b> Location: Printahe Graphics,M1 Building, 2nd floor (in front of Mood Night Bar), Pitogo, Consolacion, Cebu.<br/>
										3.2 DROP-OFF TIME. Usually around 10AM-1PM. Please pick-up your orders 48 hours prior to delivery date. You will have enough time until mall closes at 8PM.<br/><br/>
										<b>IV. UPDATES & GROUP CHAT (GC)</b><br/>
										4.1 Please message us on our personal accounts for faster assistance.<br/>
										<p style="padding-left: 2em">Facebook: Nikki Rivera/ Jenn Rivera <br/>
										Contact number: 09275822316/ 09266530838</p>
										4.2 Updates with photo inspirations will be uploaded on facebook page.<br/>
										4.3 Updates on stocks, announcements and prices can be found on GC. Please message Nikki Rivera/Jenn Rivera to assist you on entering GC.<br/><br/>
										<b>V. PENALTY & CANCELLATIONS</b><br/>
										5.1 Not claiming within 48 hours after delivery. Name, link to profile, and face will be posted on our page.<br/>
										5.2 Cancellations cannot be done after you have clicked 'Check Out'. Please be very sure of your orders.<br/><br/>
										<b>VI. EVICTION</b><br/>
										6.1 Inactive resellers for three (3) batches will be evicted.<br/>
										6.2 You may request for reconsideration by messaging admins (Nikki Rivera/Jenn Rivera) on facebook.<br/>
										6.3 Request for reconsideration is only valid five (5) days after eviction<br/>
									</div>
									<div class="checkbox">
										<input type="checkbox" name="checkbox" value="check" id="agree" /> <i>I have read and agree to the Terms and Conditions</i>
									</div>
								</div>
							</fieldset>
						</form>
						<input class="btn btn-lg btn-inverse btn-block" type="submit" name="submit" value="Submit" form="user_signup">	
						<button class="btn btn-lg btn-inverse btn-block" onclick="location.href='../index.php'">Cancel</button>
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