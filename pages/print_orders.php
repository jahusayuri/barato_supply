<?php
use SimpleExcel\SimpleExcel;
include '../functions/retrieve_data.php';
include_once('../assets/SimpleExcel/SimpleExcel.php');
if (isset($_POST['print_orders'])) {
	$result = get_all_orders($conn);
	$excel = new SimpleExcel('csv');

	//Set the headers
	$excel->writer->addRow(
		array(
			"Full Name",
			"Contact Number",
			"Item Code",
			"Item",
			"Quantity",
			"Amount",
			"Address",
			"Status",
		)
	);

	//Put into new data
	while($rows = $result->fetch_assoc()){
		//Get full name
		$full_name = $rows['first_name']." ".$rows['last_name'];

		//Get their address
		if($rows['delivery_option'] == 3){
			$address = $rows['address'];
		}else{
			$address = $rows['address_1'].": ".$rows['address_2'];
		}
		//Place everything in an array
		$to_push = array(
			$full_name,
			$rows['contact_number'],
			$rows['item_code'],
			$rows['item'],
			$rows['qty'],
			$rows['amount'],
			$address,
			$rows['status'],
		);	
		$excel->writer->addRow($to_push);		
	}	
	$excel->writer->setDelimiter(","); 
	$excel->writer->saveFile("test");
}
?>
<html>
<head>
</head>
<body>
	<p>Printing rows now.</p>
</body>
</html>
