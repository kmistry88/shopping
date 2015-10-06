<?php
session_start();

//connect to database
$mysqli = mysqli_connect("localhost", "kmistry88", "Avan!5mar", "testDB");

//Set useful variables for paypal form
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypal_id = 'business@shopping.com'; //Business Email

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Store</title>
</head>
<body>
	<?php
		//fetch products from the database
		$get_prod_sql ="SELECT * FROM store_shoppertrack";
		$get_prod_res = mysqli_query($mysqli, $get_prod_sql) or die(mysqli_error($mysqli));
		
		 while ($prod_info = mysqli_fetch_array($get_prod_res)) 
		{
	?>
    Order_id<?php echo $prod_info['id']; ?>
    <br/>Session_id<?php echo $prod_info['session_id']; ?>
    <br/>Item_id<?php echo $prod_info['sel_item_id']; ?>
    <br/>Item_qty<?php echo $prod_info['sel_item_qty']; ?>
    <br/>Item_size<?php echo $prod_info['sel_item_size']; ?>
    <br/>Item_color<?php echo $prod_info['sel_item_color']; ?>
	<br/>Date<?php echo $prod_info['date_added']; ?>
	 <?php } ?>
	 
	 <br/>Total Price<?php echo $_SESSION['total_price']; ?>
    <form action="<?php echo $paypal_url; ?>" method="post">

        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
        
        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        
        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="<?php echo $prod_info['sel_item_id']; ?>">
        <input type="hidden" name="item_number" value="<?php echo $prod_info['id']; ?>">
        <input type="hidden" name="amount" value="<?php echo $_SESSION['total_price']; ?>">
        <input type="hidden" name="currency_code" value="USD">
        
        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost/shopping/cancel.php'>
		<input type='hidden' name='return' value='http://localhost/shopping/success.php'>

        
        <!-- Display the payment button. -->
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
    
    </form>
   
</body>
</html>
