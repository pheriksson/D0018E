<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<style>
	.c {
		margin:auto;
		position:relative;
		width:125px;
		height:200px;
	}

	.b {
		margin:auto;
		position:relative;
		width: 450px;
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
                $this->cur_query="";
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
include "config.php";



//Cleanup of inactive items for all users in 'cart_items'
mysqli_query($conn,"DELETE cart_items FROM cart_items INNER JOIN products ON cart_items.product_id=products.id WHERE active=0");



//Init state for user on cart.

if(!(isset($_SESSION['state_cart'])) || !$_SESSION['user_id']){
	//Check to see if user is logged in.
        if(!$_SESSION['user_id']){
		header('Location: login.php');
	}
	$_SESSION['state_cart'] = new TableState();
}

//Fråga efter alla status här så att vi kan plocka bort sen.
$_SESSION['state_cart']->upd_query("SELECT amount, name, cost_unit, product_id, stock FROM cart_items AS C INNER JOIN products AS P ON C.product_id=P.id WHERE C.user_id=".$_SESSION['user_id']."");


if(isset($_POST['0'])){
	//$_POST['X'] is the product_id that customer has in cart and want to remove.
	delete_item($conn,$_SESSION['user_id'],$_POST['0']);
	unset($_POST['0']);
}
elseif(isset($_POST['1'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['1']);
	unset($_POST['1']);
}
elseif(isset($_POST['2'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['2']);
	unset($_POST['2']);
}
elseif(isset($_POST['3'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['3']);
	unset($_POST['3']);
}
elseif(isset($_POST['4'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['4']);
	unset($_POST['4']);
}
elseif(isset($_POST['5'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['5']);
	unset($_POST['5']);
}
elseif(isset($_POST['6'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['6']);
	unset($_POST['6']);
}
elseif(isset($_POST['7'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['7']);
	unset($_POST['7']);
}
elseif(isset($_POST['8'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['8']);
	unset($_POST['8']);
}
elseif(isset($_POST['9'])){
	delete_item($conn,$_SESSION['user_id'],$_POST['9']);
	unset($_POST['9']);
}

//Positionering viktigt här, annars kommer html uppdateras innan vi ändrar värde för 'amount' i table, och table kommer därav att "lagga" efter.
$query=$_SESSION['state_cart']->get_query();
$huge_array= gen_array(mysqli_query($conn,$query));
$max_num_items=count($huge_array[0]); //used for loop when creating table.
$total_cost= get_total_cost($huge_array[1],$huge_array[2],$max_num_items); //ha[1][x]*ha[2][x] = cost for num of items in that row.



//Next page, prev page
if(isset($_POST['prev_page'])){
        if(($_SESSION['state_cart']->get_page())>=10){
                $_SESSION['state_cart']->prev_page();
        }
	unset($_POST['prev_page']);

}
if(isset($_POST['next_page'])){
        if(($_SESSION['state_cart']->get_page()+10)<$max_num_items){
                $_SESSION['state_cart']->next_page();
        }
	unset($_POST['next_page']);

}


if(isset($_POST['sub_order'])){
	order_items($conn,$huge_array);
	unset($_POST['sub_order']); //Funkar inte??
}



//Table är efter sql state.
function delete_item($conn, $user_id, $prod_id){
	//TO BE IMPLEMENTED.
	//check if amount <2 (then the amount row for prod_id, user_id will be removed from the cart_items table.)
	$query_amount="SELECT amount FROM cart_items WHERE user_id='$user_id' AND product_id='$prod_id'";
	$res_query=mysqli_query($conn,$query_amount);
	$row= mysqli_fetch_array($res_query);
	if((int)$row['amount']<2){
		//Remove record from cart_items.
		$query_amount="DELETE FROM cart_items WHERE user_id='$user_id' AND product_id='$prod_id'";
	}else{
		//Lower amount by 1.
		$new_amount=(int)$row['amount']-1;
		$query_amount="UPDATE cart_items SET amount='$new_amount' WHERE user_id='$user_id' AND product_id='$prod_id'";
	}
	$ret_val=mysqli_query($conn,$query_amount);

}



function gen_array($query_dump){
        $temp_arr = array(array(),array(),array(),array(),array());
        $i=0;
        while($row=mysqli_fetch_array($query_dump)){
           	$temp_arr[0][$i] = $row['product_id'];	//
                $temp_arr[1][$i] = $row['amount'];	//Amount that user wants to buy of item X.
                $temp_arr[2][$i] = $row['cost_unit'];	//Cost per said unit.
                $temp_arr[3][$i] = $row['name'];	//Name of said unit.
                $temp_arr[4][$i] = $row['stock'];	//Stock of said unit.
                $i++;
        }
        return $temp_arr;
}






function order_items($conn,$items){

	//To be implemented.
	if(empty($items[3][0])){
		echo "no items in cart";
	}else{

	//START TRANSACTION.
	mysqli_begin_transaction($conn); //Begin transaction



	// <----------------- CHECK TO SE IF ITEMS IN CART IS IN STOCK --------------------> //
	$items_in_stock=True;
	$item_not_in_stock=array();
	$n=0;
	$query="SELECT amount, stock, name FROM products AS P INNER JOIN cart_items AS C ON C.product_id=P.id WHERE C.user_id=" .$_SESSION['user_id']. "";
	$res_1 = mysqli_query($conn,$query);
	while($res_arr = mysqli_fetch_array($res_1)){
		if($res_arr['stock'] < $res_arr['amount']){
			$item_not_in_stock[$n]=$res_arr['name'];
			$items_in_stock=False;
			$n++;
		}
	}

	// <------------------- Create empty order with order_status set to null (default) since we need to link product_items to a order ---------> //

	$query="INSERT INTO orders(user_id) VALUES(".$_SESSION['user_id'] .")";
	$res_1= mysqli_query($conn, $query);

	// <------------- Fetch the order id from the order previously created (we cannot know the id from previous query and we need it for the order items) ------> //

	$query="SELECT id FROM orders WHERE order_sent IS NULL AND user_id=".$_SESSION['user_id']."";
	$res_2= mysqli_query($conn, $query);
	$order_id = mysqli_fetch_array($res_2)['id'];

	//Now we have the id of the fucking order that is to be processed.


	// <----------------- Fetch the information from the cart_items to be transfered to order_items ------------------> //

	$query="SELECT cart_items.product_id, cart_items.amount, products.cost_unit FROM cart_items INNER JOIN products ON cart_items.product_id = products.id WHERE user_id=".$_SESSION['user_id']."";
	$res_3 = mysqli_query($conn, $query);
	$create_oi=1; //Create order items: if one of the queries fails to create a order_item -> create_oi = false.

	while($res_arr=mysqli_fetch_array($res_3)){
		//$temp_pid=$res_arr['product_id'];
		//$temp_amount=$res_arr['amount'];
		$fml_1 = mysqli_query($conn, "INSERT INTO order_items(order_id, product_id, user_id, amount, cost_snapshot) VALUES(".$order_id.",".$res_arr['product_id'].",".$_SESSION['user_id'].",".$res_arr['amount'].",".$res_arr['cost_unit'].")");
		if(!$fml_1){
			$create_oi=0;
		}
	}




	//Now all order items created. Left to do: delete all cart_items and set order_sent on the order table to false.


	// <----------------------------- Remove all cart_items for user id ----------------------------->//

	$query="DELETE FROM cart_items WHERE user_id=".$_SESSION['user_id']."";
	$res_4=mysqli_query($conn, $query);

	// <----------------------------- Update order 'order_sent' --------------------------------------->//

	$query="UPDATE orders SET order_sent=0 WHERE user_id=".$_SESSION['user_id']." AND order_sent IS NULL";
	$res_5=mysqli_query($conn, $query);

	// <-------------------------- Check all flags, if all queries passed commit, else rollback ------------------>//

	if($items_in_stock && $create_oi && $res_1 && $res_2 && $res_3 && $res_4 && $res_5){
		mysqli_commit($conn);
		echo "<meta http-equiv='refresh' content='0'>"; //Refresh page to update table.
	}else{
		mysqli_rollback($conn);
	}

	}





}

function get_total_cost($cost_arr, $amount_arr, $n){
	$res = 0;
	for($i=0; $i < $n; $i++){
		$res+=$cost_arr[$i]*$amount_arr[$i];
	}
	return $res;
}






?>


<form method="POST" action="cart.php">

		<div> 
			<a href='./orders.php'>View orders</a>
		</div> 

		<div class="container">
                <table class="table table-striped table-dark">
			<thead class="thead-dark">
                		<tr>
                        		<th scope="col">Product</th>
                        		<th scope="col">Cost per unit</th>
                        		<th scope="col">Amount requested</th>
					<th scope="col">Cost</th>
					<th scope="col">Remove</th>
                		</tr>
			</thead>
		<tbody>
                <?php $row_count = 0;?>
		<?php while(($row_count<10) And (($row_count+$_SESSION['state_cart']->get_page()) < $max_num_items) ):?>
                	<?php $index=$row_count+$_SESSION['state_cart']->get_page(); ?>
			<tr>
                	<th scope="row"><?php echo $huge_array[3][$index];?></th>
                	<td><?php echo $huge_array[2][$index];?></td>
                	<td><?php echo $huge_array[1][$index];?></td>
			<td><?php echo $huge_array[2][$index]*$huge_array[1][$index];?> </td>
                	<td><?php echo "<button class='btn btn-danger' type='submit' name='" . $row_count ."' value='". $huge_array[0][$index] ."'>Remove item</button>";?></td>
                	<?php $row_count++; ?>
                	</tr>
                <?php endwhile;?>
		</tbody>
                </table>
		</div>
		<div class="c">
        		<div class="c btn-group" role="group" aria-label="Secret">
                	<input type="submit" class="btn btn-info" name="prev_page" value="<<">
                	<text class="btn btn-info"><?php $page_calc = (intdiv($_SESSION['state_cart']->get_page(),10)); echo " $page_calc "; ?></text>
                	<input type="submit" class="btn btn-info" name="next_page" value=">>">
        		</div>
		</div>

		<div class="b">
		<?php echo "Total cost: ". $total_cost;
		      echo "<input class='btn btn-primary' type='submit' name='sub_order' value='Confirm order'>";
		?>
		</div>



</form>




</html>
