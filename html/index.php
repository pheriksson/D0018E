<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body style= "background-color:white;">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

<style>
      .c {
		margin:auto;
		position:relative;
		width:125px;
		height:200px;
      }
</style>


<?php
class TableState{
	public $cur_page;
	public $reset_table;
	public $cur_query;

	function __construct(){
		$this->cur_page=0;
		$this->reset_table=1;
		$this->cur_query="SELECT * FROM products WHERE active=1";
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

include "minimenu.php";

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
		//Sanitize input field to prevent sql injections .
		$read_field = $_POST['search_bar'];
		$_SESSION['state']->upd_query("SELECT * FROM products WHERE name LIKE '$read_field%' AND active=1");
	}else{
		$_SESSION['state']->upd_query("SELECT * FROM products WHERE active=1");
	}
}


$query=$_SESSION['state']->get_query();

$huge_array= gen_array(mysqli_query($conn,$query),$conn);
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
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['0']);
}
elseif(isset($_POST['1'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['1']);
}
elseif(isset($_POST['2'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['2']);
}
elseif(isset($_POST['3'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['3']);
}
elseif(isset($_POST['4'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['4']);
}
elseif(isset($_POST['5'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['5']);
}
elseif(isset($_POST['6'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['6']);
}
elseif(isset($_POST['7'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['7']);
}
elseif(isset($_POST['8'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['8']);
}
elseif(isset($_POST['9'])){
	add_item_to_cart($conn,$_SESSION['user_id'],$_POST['9']);
}

function add_item_to_cart($conn,$user_id,$prod_id){
	$query="SELECT * FROM cart_items WHERE user_id='$user_id' AND product_id='$prod_id'";
	$res_query=mysqli_query($conn, $query);
	$row=mysqli_fetch_row($res_query);
	$count= $row[0];
	if($count>0){
		//Item exists, upd amount.
		$res_query2=mysqli_query($conn, $query);
		$row=mysqli_fetch_array($res_query2);
		$new_amount= (int)$row['amount']+1;
		$query="UPDATE cart_items SET amount='$new_amount' WHERE user_id='$user_id' AND product_id='$prod_id'";

	}else{
		$query="INSERT INTO cart_items(user_id, product_id, amount) VALUES($user_id, $prod_id,1)";
	}

	$ret_val=mysqli_query($conn,$query);
	if(!$ret_val){
		die("query failed, query that failed = ".$query);
	}
  Header('Location: index.php');
}

function gen_array($query_dump,$conn){
	$temp_arr = array(array(),array(),array(),array(),array());
	$i=0;
	while($row=mysqli_fetch_array($query_dump)){
		$temp_arr[0][$i] = $row['name'];
		$temp_arr[1][$i] = $row['cost_unit'];
		$temp_arr[2][$i] = $row['stock'];
		$temp_arr[3][$i] = $row['id'];
		$uggly_res_fetch_score = mysqli_query($conn,"SELECT AVG(score) as S FROM rating WHERE product_id=".$temp_arr[3][$i]."");
		$temp_arr[4][$i] = mysqli_fetch_assoc($uggly_res_fetch_score)['S'];
		$i++;
	}
	return $temp_arr;

}

?>




<form method="POST" action="index.php">
	<div class="container">
	<div class="c">
		<div class="container">
			<input type="text" name="search_bar" >
			<input class="btn btn-primary" type="submit" name="send_bar" value="Search"> <br><br>
		</div>
	</div>
		<table class="table table-striped table-dark">
		<thead>
			<tr>
				<th scope="col">Product</th>
				<th scope="col">Price</th>
				<th scope="col">In stock</th>
				<th scope="col">Rating</th>
				<th><?php if($logged_in){echo "Place Order";}?></th>
			</tr>
		</thead>

		<tbody>
		<?php $row_count = 0;?>
		<?php while(($row_count<10) And (($row_count+$_SESSION['state']->get_page()) < $max_num_items) ):?>
			<?php $index = $row_count+$_SESSION['state']->get_page(); ?>
			<tr>
			<th scope="row"><?php echo $huge_array[0][$index];?></th>
			<td><?php echo $huge_array[1][$index];?></td>
			<td><?php if($huge_array[2][$index]>0){echo "YES";}else{echo "NO";}?> </td>
			<td><?php if(!is_null($huge_array[4][$index])){
					echo (int)$huge_array[4][$index]."/5";
				}else{echo "not rated.";} ?></td>
			<td><?php
				if($logged_in){
					echo "<button class='btn btn-info' type='submit' name='" . $row_count ."' value='". $huge_array[3][$index] ."'>Add to cart</button>";
				}?> </td>
			<?php $row_count++; ?>
			</tr>
		<?php endwhile;?>
		</tbody>
		</table>

	<div class="c">
		<div class="c btn-group" role="group" aria-label="Secret2">
			<input class="btn btn-info" type="submit" name="prev_page" value="<<">
			<text class="btn btn-info"><?php $page_calc = (intdiv($_SESSION['state']->get_page(),10)); echo "$page_calc"; ?></text>
			<input class="btn btn-info" type="submit" name="next_page" value=">>">
		</div>
	</div>
	</div>





</form>

</body>
</html>
