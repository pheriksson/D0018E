<!DOCTYPE html>
<html>
<body>
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
//$_SESSION['user_id'] //user id
//$_SESSION['uname'] //user email.
//$_SESSION['state_cart'] //user state for cart.
//Knapp för att bekräfta order -> flytta cart_items -> order_items, samt skapa en order. När admin bekräftar order -> transaction.




//Init state for user on cart.

if(empty($_SESSION['state_cart'])){
        $_SESSION['state_cart'] = new TableState();
	$_SESSION['state_cart']->upd_query("SELECT amount, name, cost_unit, product_id, stock FROM cart_items AS C INNER JOIN products AS P ON C.product_id=P.id WHERE C.user_id='".$_SESSION['user_id']."'");
}

//Cannot be in init since if you log out you will still keep your state
if(isset($_SESSION['uname']) && ($_SESSION['uname']!="")){
        $logged_in=True;
}else{
        $logged_in=False;
}








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

}
if(isset($_POST['next_page'])){
        if(($_SESSION['state_cart']->get_page()+10)<$max_num_items){
                $_SESSION['state_cart']->next_page();
        }
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
	if(!$ret_val){
		die("query failed, query that failed =".$query_amount);
	}

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

function order_items(){
	//To be implemented.
}

function get_total_cost($cost_arr, $amount_arr, $n){
	$res = 0;
	for($i=0; $i < $n; $i++){
		$res+=$cost_arr[$i]*$amount_arr[$i];
	}
	return $res;
}






?>

<div>
<form method="POST" action="cart.php">
        <div>
	<div>
		Total cost for this KALAS = <?php echo $total_cost;?> bukake dollars. 	<input type="submit" name="sub_order" value="Confirm order">
	</div>
                <table>
                <tr>
                        <td>Product</td>
                        <td>Cost per unit</td>
                        <td>Amount requested</td>
			<td>Remove</td>
                </tr>
                <?php $row_count = 0;?>
                <?php while(($row_count<10) And (($row_count+$_SESSION['state_cart']->get_page()) < $max_num_items) ):?>
                <tr>
                <td><?php echo $huge_array[3][$row_count+$_SESSION['state_cart']->get_page()];?></td>
                <td><?php echo $huge_array[2][$row_count+$_SESSION['state_cart']->get_page()];?></td>
                <td><?php echo $huge_array[1][$row_count+$_SESSION['state_cart']->get_page()];?></td>
                <td><?php echo "<button type='submit' name='" . $row_count ."' value='". $huge_array[0][$row_count+$_SESSION['state_cart']->get_page()] ."'>Remove item</button>";?></td>
                <?php $row_count++; ?>
                </tr>
                <?php endwhile;?>
                </table>
        <div>
                <input type="submit" name="prev_page" value="<<">
                <?php $page_calc = (intdiv($_SESSION['state_cart']->get_page(),10)); echo "( $page_calc )"; ?>
                <input type="submit" name="next_page" value=">>">
        </div>
        </div



</form>

</div>



</body>
</html> 
