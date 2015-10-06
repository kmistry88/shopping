<?php
session_start();

//connect to database
$mysqli = mysqli_connect("localhost", "kmistry88", "Avan!5mar", "testDB");

$display_block = "<h1>Your Shipping Details</h1>";

//Set useful variables for paypal form
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypal_id = 'info@codexworld.com'; //Business Email



//close connection to MySQL
mysqli_close($mysqli);

?>
<!DOCTYPE html>
<html>
<head>
<title>My Store</title>
<style type="text/css">
	table {
		border: 1px solid black;
		border-collapse: collapse;
	}
	th {
		border: 1px solid black;
		padding: 6px;
		font-weight: bold;
		background: #ccc;
		text-align: center;
	}
	td {
		border: 1px solid black;
		padding: 6px;
		vertical-align: top;
		text-align: center;
	}
</style>
</head>
<body>
<?php echo $display_block; ?>

</body>
</html>




