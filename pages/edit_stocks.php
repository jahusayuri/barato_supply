<?php
include '../functions/check_credentials.php';
include "../functions/orders.php";
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}

check_credentials($conn,$_SESSION['id']);
$result=get_admin_details($conn);
$row= $result->fetch_assoc();
echo "Welcome ".$row['last_name'].", ".$row['first_name']."!";

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
	<?php
	if(isset($_POST['edit_stock'])) {
		$stock_id = $_POST['chosen_item'];
		$result = get_stocks_id($conn,$stock_id);
		echo "<div class='table'>";
		echo "<div class='tr'><span></span><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Stocks Available</span><span class='th'>Price</span></div>";
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			echo "<form class='tr' method='post' action=''>";
			echo "<span class='td'><input type='hidden' name='chosen_item' value='".$row['id']."'/></span><span class='td'><input type='text' name='item_code' value='".$row['item_code']."' /></span><span class='td'><input type='text' name='item' value='".$row['item']."' /></span><span class='td'><input type='text' name='remaining' value='".$row['remaining']."'/></span><span class='td'>P<input type='text' name='price' value='".$row['price']."'/></span>";
			echo "<input type='submit' name='update_stock' value='Update' />";
			echo "</form>";
		}else{

		}
		echo "</div>";
	}
	?>
</body>
</html>