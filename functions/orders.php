<?php
if(isset($_POST['add_to_cart'])){
	echo "Cart is received <br/>";
	if($_POST['chosen_item']){
		echo "ID received is: ".$_POST['chosen_item'];
	}else{
		echo "Didn't get anything";
	}
}else{
	echo "No item added yet";
}
?>