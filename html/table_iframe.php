<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body style= "background-color:white;">

<!-- table styling -->
<style>
      table,
      th,
      td {
        padding: 10px;
        border: 1px solid black;
        border-collapse: collapse;
      }
</style>

<!-- -->
<!-- -->
<!-- -->


<!-- 		FÖRSÖK TILL CONSTRUCTOR		-->

<?php
class TableState{
	public $cur_page;
	public $reset_table;
	public $cur_query;

	function __construct(){
		$this->cur_page=0;
		$this->reset_table=1;
		$this->cur_query="SELECT * FROM products";
	}
	function get_page(){
		return $this->cur_page;
	}
	function get_flag(){
		return $this->reset_table;
	}
	function set_flag(){
		$this->reset_table=0;
	}
	function reset_page(){
		$this->cur_page=0;
	}

	function next_page(){
		$this->cur_page+=10;
	}
	function prev_page(){
		$this->cur_page-=10;
	}
	function get_query(){
		return $this->cur_query;
	}

	function upd_query($new_query){
		$this->cur_query=$new_query;
	}
}

?>


<?php

//Kvar att göra, kolla att användare är inloggad -> om inloggad visa knappar, annars vissa ej knappar.


include "config.php";

//Init state for user.

if(empty($_SESSION['state'])){
	$_SESSION['state'] = new TableState();
}

//Cannot be in init since if you loog out you will still keep your state
if(isset($_SESSION['uname']) && ($_SESSION['uname']!="")){
	$logged_in=True;
}else{
	$logged_in=False;
}


//QUERY FOR table
if(isset($_POST['send_bar'])){
	if(!(empty($_POST['search_bar']))){
		$read_field = $_POST['search_bar'];
		$_SESSION['state']->upd_query("SELECT * FROM products WHERE name LIKE '$read_field%'");
	}else{
		$_SESSION['state']->upd_query("SELECT * FROM products");
	}
}


$query=$_SESSION['state']->get_query();

$huge_array= gen_array(mysqli_query($conn,$query));
$max_num_items= count($huge_array[0]);


//Next page, prev page
if(isset($_POST['prev_page'])){
	if(($_SESSION['state']->get_page())>=10){
		$_SESSION['state']->prev_page();
	}

}
if(isset($_POST['next_page'])){
	if(($_SESSION['state']->get_page()+10)<$max_num_items){
		$_SESSION['state']->next_page();
	}
}






//Should only be able to be called if user is logged in. Item (name of) to be stored in cart = $_POST[x]
if(isset($_POST['0'])){
}
elseif(isset($_POST['1'])){
}
elseif(isset($_POST['2'])){

}
elseif(isset($_POST['3'])){
}
elseif(isset($_POST['4'])){
}
elseif(isset($_POST['5'])){
	//echo "ORDER FOR " . $_POST['5'] . "TO BE IMPLEMENTED";
}
elseif(isset($_POST['6'])){
	//echo "ORDER FOR " . $_POST['6'] . "TO BE IMPLEMENTED";
}
elseif(isset($_POST['7'])){
	//echo "ORDER FOR " . $_POST['7'] . "TO BE IMPLEMENTED";
}
elseif(isset($_POST['8'])){
	//echo "ORDER FOR " . $_POST['8'] . "TO BE IMPLEMENTED";
}
elseif(isset($_POST['9'])){
	//echo "ORDER FOR " . $_POST['9'] . "TO BE IMPLEMENTED";
	
}



function gen_array($query_dump){
	$temp_arr = array(array(),array(),array(),array());
	$i=0;
	while($row=mysqli_fetch_array($query_dump)){
		$temp_arr[0][$i] = $row['name'];
		$temp_arr[1][$i] = $row['cost_unit'];
		$temp_arr[2][$i] = $row['stock'];
		$temp_arr[3][$i] = $row['id'];
		$i++;
	}
	return $temp_arr;

}

?>




<form method="POST" action="table_iframe.php">
	<div>
		<input type="text" name="search_bar" >
		<input type="submit" name="send_bar" value="Search"> <br><br> 
	</div>
	<div>
		<table>
		<tr>
			<td>Product</td>
			<td>Price</td>
			<td>In stock</td>
			<?php if($logged_in){echo "<td>Place Order</td>";}?>
		</tr>
		<?php $row_count = 0;?>
		<?php while(($row_count<10) And (($row_count+$_SESSION['state']->get_page()) < $max_num_items) ):?>
		<tr>
		<td><?php echo $huge_array[0][$row_count+$_SESSION['state']->get_page()];?></td>
		<td><?php echo $huge_array[1][$row_count+$_SESSION['state']->get_page()];?></td>
		<td><?php if($huge_array[2][$row_count+$_SESSION['state']->get_page()]>0){echo "YES";}else{echo "NO";}?> </td>
		<?php
			if($logged_in){
				echo "<td><button type='submit' name='" . $row_count ."' value='". $huge_array[0][$row_count+$_SESSION['state']->get_page()] ."'>Add to cart</button> </td>";
			}
		?>
		<?php $row_count++; ?>
		</tr>
		<?php endwhile;?>
		</table>
	<div>
		<input type="submit" name="prev_page" value="<<">
		<?php $page_calc = (intdiv($_SESSION['state']->get_page(),10)); echo "( $page_calc )"; ?>
		<input type="submit" name="next_page" value=">>">
	</div>



	</div



</form>

</body>
</html>

