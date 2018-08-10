<?php
session_start();
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
<form  id="update_user" action="../functions/update_user.php" method="post">
		Delivery Option: 
		<select form="update_user" name="delivery_option" onchange="getAddress(this.value)" required>
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
		<input type="submit" name="submit" value="Update">	
</form>

</body>
</html>