<!DOCTYPE html>
<html>


<style>
	table,
	th,
	td {
		padding: 10px;
		border: 1px solid black;
		border-collapse: collapse;
	}
</style>

<?php
include "config.php";
if(isset($_POST['send_bar'])){
	$read_field=$_POST['search_bar'];
	$query="SELECT * FROM products WHERE name LIKE '%$read_field%'";
}else{
	//default
	$query="SELECT * FROM products";
}
$search_result=mysqli_query($conn,$query);
if(!$search_result){
	die('Query failed');
}



?>




<form method="POST" action="table_frame.php">
	<div>
		<input type="text" name="search_bar">
		<input type="submit" name="send_bar" value="Search"> <br><br>
	</div>
	<div>
		<table>
		<tr>
			<td>Product</td>
			<td>Price</td>
			<td>In stock</td>
			<td>Place order</td>
		</tr>
		<?php while($row=mysqli_fetch_array($search_result)){
			echo "<tr> <td>" . $row['name']  . "</td>";
			echo "<td>" . $row['cost_unit']  . "</td>";
			if($row['stock']>0){
				echo "<td>YES</td>";
			}else{
				echo "<td>NO</td>";
			}

			//echo "<td> <input type="submit" name="place_order" value="place_order" </td> </tr>";
			echo "</tr>";
		}

		?>
		</table>


	</div>

</form>
</body>
</html>
