<?php

include "config.php";


$results = mysqli_query($conn, "SELECT * FROM users");

if($_SESSION["role"] != 3){
  header("Location:index.php");
}


if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($conn, "DELETE FROM users WHERE id=$id");
  unset($_GET['del']);
	header('location: users.php');
}


?>

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
