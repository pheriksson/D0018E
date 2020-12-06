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
			<th colspan="2">Action</th>
		</tr>
	</thead>

	<?php
  $int = 1;
  $row = mysqli_fetch_array($results)
  foreach ($row as $user) {
    echo $int;
    $int= $int + 1;
    ?>
		<tr>
			<td><?php echo $user['email']; ?></td>
			<td>
				<a href="index.php?edit=<?php echo $user['id']; ?>">Edit</a>
			</td>
			<td>
				<a href="server.php?del=<?php echo $user['id']; ?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>
