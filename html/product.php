
<!--
Update profiles fields för att hämta uppdatera data, förvärde databashämtning
Submit knapp kör sql $query
Duplicera users.php döp om till stock, hämta produkter ist för users
Ta  bort knapp, ist för att ta inaktiv på user gör du på orders
Sen bara visa lagersaldo typ med fields
-->


<?php
include "config.php";




if (isset($_GET['productid']) && $_GET['productid'] != "") {
	$product = $_GET['productid'];
	$results = mysqli_query($conn, "SELECT * FROM rating WHERE product_id = $product");

}
else{
  header("Location:index.php");
}



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock</title>
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
			<th>Score</th>
      			<th>Comment</th>
			<?php if($_SESSION['role']>1){ ?>
				<th>User ID</th>
				<th>Review ID</th>
			<?php } ?>
		</tr>
	</thead>

	<?php while($product = mysqli_fetch_array($results)){ ?>
		<tr>
			<td><?php echo $product['score']; ?></td>
      			<td><?php echo $product['comment']; ?></td>
			<?php if($_SESSION['role']>1){ ?>
      				<td><?php echo $product['user_id']; ?></td>
      				<td><?php echo $product['id']; ?></td>
			<?php } ?>

		</tr>
	<?php } ?>
</table>

</body>
</html>
