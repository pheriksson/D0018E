<?php
include "config.php";



if($_SESSION["role"] != 3){
  header("Location:index.php");
}


if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($conn, "DELETE FROM users WHERE id=$id");
  unset($_GET['del']);
	header('location: users.php');
}

if (isset($_GET['email'])) {
	$email = $_GET['email'];
	$results = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
  unset($_GET['email']);
}
else{
  $results = mysqli_query($conn, "SELECT * FROM users");
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
                <form method="get" action="users.php">
                    <div>
                        <label>Email</label>
                        <input type="text" name="email" value="Search">
                        <span class="help-block"></span>
                        <input type="submit" class="btn btn-primary" value="Search">
                    </div>
                </form>
<table>
	<thead>
		<tr>
			<th>Name</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>

	<?php
  while($user = mysqli_fetch_array($results)){
    ?>
		<tr>
			<td><?php echo $user['email']; ?></td>
			<td>
				<a href="profile.php?edit=<?php echo $user['email']; ?>">Edit</a>
			</td>
			<td>
				<a href="users.php?del=<?php echo $user['id']; ?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>

</body>
</html>
