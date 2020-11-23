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
?>
