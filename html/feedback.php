<?php 

include "config.php";
//Check if user is logged in and all that jazz.


//if user not logged in -> unset GET['id'] && set header= bajs.
if($_SESSION['role'] < 1){
	header('location:index.php');
}


//Check for id validity and link to orders.php if user is trying something sneaky.

if(isset($_GET['id']) && $_GET['id'] != ""){
	if(validate_prod($conn,$_GET['id'])){
		//Check ok, item exists.
		$res=mysqli_query($conn,"SELECT * from products WHERE id=".$_GET['id']."");
		$item=mysqli_fetch_assoc($res)['name'];
	}else{
		//item does not exist.
		clean_posts();
		header('location:orders.php');
	}
}else{
	clean_posts();
	header('location:orders.php');
}


if(isset($_POST['submit'])){
	if(!isset($_POST['rating'])){
		echo "You need to give the product a rating.";
	}else{

		$rating=$_POST['rating'];
		$comment=$_POST['comment'];
		$query=mysqli_query($conn, "INSERT INTO rating(user_id, product_id, score, comment) VALUES(".$_SESSION['user_id'].",". $_GET['id'].",". $rating.",'$comment')");
		clean_posts();
		header('location:orders.php');
	}

}


function validate_prod($conn, $prod_id){
	$res=mysqli_query($conn,"SELECT active FROM products WHERE id=$prod_id AND active=1");
	if(mysqli_fetch_row($res)==0){
		return 0;
	}
	return 1;
}

function clean_posts(){
	unset($_POST['rating']);
	unset($_POST['comment']);
	unset($_POST['submit']);
}

?>



<html>
	<h2><?php echo "Review for product: ".$item;?></h2>
	<form method="POST">
	<textarea name='comment' style='resize:none; font-size:20px;' placeholder='Add a comment' rows='10' cols='50' maxlength='60'></textarea>
	<br><br>
		Score:
		<input type='radio' name='rating' value='1' id='star1'>
		<label for='star1'>1</label>
		<input type='radio' name='rating' value='2' id='star2'>
		<label for='star2'>2</label>
		<input type='radio' name='rating' value='3' id='star3'>
		<label for='star3'>3</label>
		<input type='radio' name='rating' value='4' id='star4'>
		<label for='star4'>4</label>
		<input type='radio' name='rating' value='5' id='star5'>
		<label for='star5'>5</label>
	<!-- button -->
		<input type="submit" name="submit" value="submit_rew">

	</form>

<!-- From submit post, after submit redirect to orders page (previouse page)-->


</html>
