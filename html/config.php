<?php
session_start();
$servername = "localhost";
$username = "webservice";
$password = "hqUQa6QDPauzYYyw!";
$dbname = 'test';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_query($conn, 'SET NAMES utf8');

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




function get_cart_amount($conn){
	$res=mysqli_query($conn,"SELECT SUM(amount) AS total_items FROM cart_items WHERE user_id=".$_SESSION['user_id']."");
	return mysqli_fetch_assoc($res)['total_items'];
}

function get_cart_value($conn){
	$res=mysqli_query($conn,"SELECT SUM(amount*cost_unit) AS total_cost FROM cart_items AS C INNER JOIN products AS P ON C.product_id=P.id WHERE C.user_id=".$_SESSION['user_id']."");
	return mysqli_fetch_assoc($res)['total_cost'];

}


?>
