<?php
session_start();
include "../functions/orders.php";
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("Refresh: 0; url=../index.php");
}
$result=get_admin_details($conn);
$row= $result->fetch_assoc();
echo "Welcome ".$row['last_name'].", ".$row['first_name']."!";
?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
	<?php
	if(isset($_POST['add_stock'])) {
		echo "<div class='table'>";
		echo "<div class='tr'><span class='th'>Item Code</span><span class='th'>Item</span><span class='th'>Stocks Available</span><span class='th'>Price</span></div>";
		echo "<form class='tr' method='post' action=''>";
		echo "<span class='td'><input type='text' name='item_code'/></span><span class='td'><input type='text' name='item' /></span><span class='td'><input type='text' name='remaining' /></span><span class='td'>P<input type='text' name='price' /></span>";
		echo "<input type='submit' name='add_final' value='Add' /><i><b>Note: </b> Make sure your data is final.</i>";
		echo "</form>";
		}else{

		}
		echo "</div>";


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
</body>
</html>