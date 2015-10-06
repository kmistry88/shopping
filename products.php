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

<body>
<h1>Your Billing Cart Details</h1>
	<?php
		//fetch products from the database
		$get_prod_sql ="select store_shoppertrack.sel_item_id,store_shoppertrack.sel_item_qty,store_shoppertrack.sel_item_size,store_shoppertrack.sel_item_color,store_shoppertrack.date_added,store_items.item_title,store_items.item_price,store_items.item_desc 
FROM store_items JOIN store_shoppertrack WHERE store_shoppertrack.sel_item_id=store_items.id";
		$get_prod_res = mysqli_query($mysqli, $get_prod_sql) or die(mysqli_error($mysqli));
		?>
	
	<table>
    <tr>
    <th>ORDER ID</th>
    <th>ITEM</th>
    <th>Color</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Size</th>
	</tr>
	<?php $item_desc_total='';
		  $item_qty_total=0;	
	
		 while ($prod_info = mysqli_fetch_array($get_prod_res)) 
		{
	?>	
	<tr>
    <td><?php echo $prod_info['sel_item_id']; ?></td>
	<td><?php echo $prod_info['item_title']; ?></td>
	<td><?php echo $prod_info['sel_item_color']; ?></td>
    <td><?php echo '$ '.$prod_info['item_price']; ?></td>
    <td><?php echo $prod_info['sel_item_qty']; ?></td>
    <td><?php echo $prod_info['sel_item_size']; ?></td>
	</tr>
	<br/>
	<?php  
		
		$item_desc_total.=$prod_info['item_title'].' | '; 
		$item_qty_total += $prod_info['sel_item_qty'];
	?>
	
	 <?php } ?>
	</table>
	
	 
	 <br/>Total Price<?php echo '$ '.$_SESSION['total_price']; ?><br/>
	 

	 
    <form action="<?php echo $paypal_url; ?>" method="post">

        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypal_id; ?>"><br/>
        
        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        
        <!-- Specify details about the item that buyers will purchase. -->

		<input type="hidden" name="item_name" value="<?php echo $item_desc_total; ?>">
        <input type="hidden" name="item_number" value="<?php echo $item_qty_total; ?>">
        <input type="hidden" name="amount" value="<?php echo $_SESSION['total_price']; ?>">
        <input type="hidden" name="currency_code" value="USD">
        
        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost/shopping/shopping/cancel.php'>
		<input type='hidden' name='return' value='http://localhost/shopping/shopping/success.php'>

        
        <!-- Display the payment button. -->
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
    
    </form>

</body>
</html>
