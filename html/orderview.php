<?php
include "config.php";
$userid=$_SESSION['user_id'];


if($_SESSION["role"] < 1){
  header("Location:index.php");
}


if (isset($_GET['id']) && $_GET['id'] != "") {
	$id = $_GET['id'];
	$results = mysqli_query($conn, "SELECT order_items.*, products.name, products.cost_unit FROM order_items INNER JOIN products ON products.id=order_items.product_id WHERE user_id = $userid AND order_id = $id");
  unset($_GET['id']);
}
else{
  echo "Stop try to fiddle with this page";
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <style type="text/css">
    td, th
    {
      padding:0 15px;
    }
</style>
</head>
<body>
<table>
	<thead>
		<tr>
			<th>Product</th>
			<th>Amount</th>
      <th>Cost per unit</th>
      <th>Feedback</th>
		</tr>
	</thead>

	<?php
  $results2 = mysqli_query($conn, "SELECT order_sent FROM orders where id = $id");
  $order_sent = mysqli_fetch_row($results2);
  while($products = mysqli_fetch_array($results)){
    ?>
		<tr>
			<td><?php echo $products['name']; ?></td>
			<td><?php echo $products['amount']; ?></td>
      <td><?php echo $products['cost_unit']; ?></td>
			<td>
      <?php
      if($_SESSION["role"] == 1 && $order_sent[0]){
        echo "<a href='feedback.php?id=".$products['product_id']."'>Rate item</a>";
      }
      else{
        echo "";
      }
      ?>
			</td>
		</tr>
	<?php } ?>

</table>
<a href="orders.php" class="btn btn-default">Back</a>
</body>
</html>
