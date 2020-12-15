
<!--
Update profiles fields för att hämta uppdatera data, förvärde databashämtning
Submit knapp kör sql $query
Duplicera users.php döp om till stock, hämta produkter ist för users
Ta  bort knapp, ist för att ta inaktiv på user gör du på orders
Sen bara visa lagersaldo typ med fields
-->


<?php
include "config.php";



if($_SESSION["role"] != 3){
  header("Location:index.php");
}


if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($conn, "UPDATE users SET role = 0 WHERE id = $id");
  unset($_GET['del']);
	header('location: stock.php');
}

if (isset($_GET['product']) && $_GET['product'] != "") {
	$product = $_GET['product'];
	$results = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$product%'");
  $productToModify = $product;
  //unset($_GET['product']);
  if (isset($_GET['stockModify']) && $_GET['stockModify'] != NULL){
    $add = $_GET['stockModify'];
    $sql = "update products SET stock = stock + $add WHERE name = '$productToModify'";
    $result = mysqli_query($conn, $sql);
  }
}
else{
  $results = mysqli_query($conn, "SELECT * FROM products");
}
//test



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
                <form method="get" action="stock.php">
                    <div>
                        <label>Product</label>
                        <input type="text" name="product" value="">
                        <span class="help-block"></span>
                        <input type="submit" class="btn btn-primary" value="Search">
                    </div>
                    <div>
                        <label>Number to add/subtract</label>
                        <input type="number" name="stockModify" value="">
                        <span class="help-block"></span>
                        <input type="submit" class="btn btn-primary" value="Modify stock">
                    </div>
                </form>
<table>
	<thead>
		<tr>
			<th>Product</th>
      <th>ID</th>
      <th>Left in stock</th>
      <th>Cost per unit</th>
      <th>Active status</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>

	<?php
  while($product = mysqli_fetch_array($results)){
    ?>
		<tr>
			<td><?php echo $product['name']; ?></td>
      <td><?php echo $product['id']; ?></td>
      <td><?php echo $product['stock']; ?></td>
      <td><?php echo $product['cost_unit']; ?></td>
      <td><?php echo $product['active']; ?></td>
			<td>
				<a href="profile.php?edit=<?php echo $user['email']; ?>">Edit</a>
			</td>
			<td>
				<a href="stock.php?del=<?php echo $product['id']; ?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>

</body>
</html>
