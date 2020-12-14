<?php

include "config.php";

//Check if user has privilage to view the page.
//if($_SESSION['role'] < 2){
//	header("Location:index.php");
//}






//Clean orders from users where order_sent=0 and user_id role=0 (inactive user) or keep to gather data of user patterns??.
if($_SESSION['role']>2){
	//check for get and update table (DONE).
	if(isset($_GET['confirm'])){
		confirm_order($conn, $_GET['confirm']);
	}

	//Prep query for orders.
	$query=mysqli_query($conn,"SELECT O.id AS order_id, U.id AS user_id, first_name, last_name, country, city, zip_code, adress, order_sent FROM orders AS O INNER JOIN users AS U ON O.user_id=U.id ORDER BY order_sent");

//User view.
}else if($_SESSION['role']==1){
	$query_orders=mysqli_query($conn,"SELECT * FROM orders WHERE user_id=".$_SESSION['user_id']." ORDER BY order_sent");
	//Get all products that user has "recieved" from an order. FIXA QUERY SÅ ATT NAMN PÅ PRODUKT OCKSÅ KOMMER MED.
	$query_feedback=mysqli_query($conn,"SELECT DISTINCT product_id FROM order_items AS OI INNER JOIN orders AS O ON O.id=OI.order_id AND O.user_id=OI.user_id WHERE O.order_sent=1 AND O.user_id=".$_SESSION['user_id']."");


//Not logged in -> redirect.
}else{
	header('location:index.php');
}

//Update order status.


//Behöver genomköras och testas för att dubbel kolla att allt fungerar, endast testat några gånger och då äre okej.
function confirm_order($conn, $order_id){
	//TODO senare fixa något fint, order_id fanns ej i requested stock så att man vet vilken produkt som ej finns kvar.
	//Tanke, upd shcema och lägga till tid då order blev skickad???
	//Kör med transaction för att minska antalet queries som måste göras.
	mysqli_begin_transaction($conn);
	$stock_aval=1;
	$check_stock=mysqli_query($conn,"SELECT product_id, amount, stock FROM orders AS O INNER JOIN order_items AS OI ON O.id=OI.order_id INNER JOIN products AS P ON OI.product_id=P.id WHERE O.id=$order_id");
	while($row=mysqli_fetch_array($check_stock)){
		$new_stock_val = $row['stock']-$row['amount'];
		if($new_stock_val < 0){
			//No stock avaliable, abbort.
			$stock_aval=0;
			break;
		}
		$prod=$row['product_id'];
		mysqli_query($conn,"UPDATE products SET stock=$new_stock_val WHERE id=$prod");

	}

	//Finaly update order_id.
	$upd_order_state=mysqli_query($conn,"UPDATE orders SET order_sent=1 WHERE id=$order_id");


	if($stock_aval && $upd_order_state){
		mysqli_commit($conn);
	}else{
		mysqli_rollback($conn);
		die("seomting fucky");
	}

}

?>





<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>

<div class="page-header">
	<h2>Orders</h2>
</div>
		<!-- FOR USER -->
	<?php if($_SESSION['role']==1){?>
	<!-- DISPLAY ORDERS FROM USER !-->
		<table class="table table-striped">
		<thead>
			<tr>
				<td>Order id</td>
				<td>Created at</td>
				<td>Order status</td>
			<tr>
		</thead>
		<?php while($row=mysqli_fetch_array($query_orders)) {?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['created_at']?></td>
				<td><?php if($row['order_sent']<1){echo "Awaiting confirmation.";}else{echo "Sent!";}?></td>
			</tr>
		<?php }?>

		</table>
	<!-- FOR USER TO GIVE FEEDBACK -->
		<h3>Feedback :) (jk, ill kill you)</h3>
		<table class="table table-striped">
		<?php while($row=mysqli_fetch_array($query_feedback)) {?>
			<tr>
				<td><?php echo "Prod id:".$row['product_id']; ?></td>
				<td>NAMN PÅ PROD PLACE HOLDER</td>
				<td><?php echo "<a href='feedback.php?id=".$row['product_id']."'>Give feedback(dont ill kill you, i know your ip bitch)</a>";?></td>
			</tr>
		<?php }?>

		</table>


	<!-- DISPLAY ALL PRODUCTS THAT USER HAS RECIEVED AND TEXT BOXT TO GIVE FEEDBACK ON THAT PRODUCT -->

	<?php } ?>


	<!-- FOR ADMIN SYS/STORE -->
	<?php if($_SESSION['role']>1){ ?>
		<table class="table table-striped">
		<thead>
			<tr>
				<td>Order id</td>
				<td>User id</td>
				<td>First name</td>
				<td>Last name</td>
				<td>Country</td>
				<td>City</td>
				<td>Zip code</td>
				<td>Address</td>
				<td>Order status</td>
			</tr>
		</thead>

		<?php while($row=mysqli_fetch_array($query)){ ?>
			<tr>
			<td><?php echo $row['order_id']; ?> </td>
			<td><?php echo $row['user_id']; ?> </td>
			<td><?php echo $row['first_name']; ?> </td>
			<td><?php echo $row['last_name']; ?> </td>
			<td><?php echo $row['country']; ?> </td>
			<td><?php echo $row['city']; ?> </td>
			<td><?php echo $row['zip_code']; ?> </td>
			<td><?php echo $row['adress']; ?> </td>
			<td><?php if($row['order_sent']==1){
					echo "Delivered";
				}else{
					echo "<a href='orders.php?confirm=".$row['order_id']."'>Confirm Order</a>";} ?> </td>
			</tr>
		<?php }?>
		</table>

	<?php } ?>





</html>
