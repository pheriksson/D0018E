<?php

include "config.php";


$results = mysqli_query($conn, "SELECT * FROM users");

if($_SESSION["role"] != 3){
  header("Location:index.php");
}

?>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>

	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['email']; ?></td>
			<td>
				<a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>
			</td>
			<td>
				<a href="server.php?del=<?php echo $row['id']; ?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>
