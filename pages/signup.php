<?php
include "../functions/retrieve_data.php";
?>
<html>
<head>
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
	<form id="user_signup" action="../functions/client_signup.php" method="post">
		First Name: <input type="text" name="fname" placeholder="e.g. John" required/><br/>
		Last Name: <input type="text" name="lname" placeholder="e.g. Doe" required/><br/>
		Contact Number: <input type="text" name="pnumber" placeholder="e.g. 09xxxxxxxxx" required/><br/>
		Password: <input type="password" name="password" required/><br/>
		Delivery Option: 
		<select form="user_signup" name="delivery_option" onchange="getAddress(this.value)" required>
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
		Address:<p id="address"></p>
	</form>

	<button type="submit" form="user_signup">Submit</button>		
	<button onclick="location.href='../index.php'">Cancel</button>
</body>
</html>