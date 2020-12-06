<?php

include "config.php";
echo '$_SESSION["role"]';



$results = mysqli_query($conn, "SELECT * FROM users");



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
