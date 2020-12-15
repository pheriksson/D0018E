<?php
// Include config file and get user-data.
echo $_SESSION["role"];
echo $_SESSION["uname"];
echo $_SESSION["user_id"];
echo $_SESSION['user_id'];

//Update profiles fields för att hämta uppdatera data, förvärde databashämtning
//Submit knapp kör sql $query
//Duplicera users.php döp om till stock, hämta produkter ist för users
//Ta  bort knapp, ist för att ta inaktiv på user gör du på orders
//Sen bara visa lagersaldo typ med fields
?>

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


$results = mysqli_query($conn, "SELECT * FROM products");


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
                <form method="get" action="stock.php">
                    <div>
                        <label>Email</label>
                        <input type="text" name="Product" value="">
                        <span class="help-block"></span>
                        <input type="submit" class="btn btn-primary" value="Search">
                    </div>
                </form>
<table>
	<thead>
		<tr>
			<th>Product</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>

	<?php
  while($product = mysqli_fetch_array($results)){
    ?>
		<tr>
			<td><?php echo $product['name']; ?></td>
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
