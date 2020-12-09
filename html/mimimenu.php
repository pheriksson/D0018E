<html>
<head>
<style>
  .topright {
    position: fixed;
    right: 5px; top: 5px;
    width: 200px;
    height:80px;
    background-color:lightgrey;
    padding: 5px;
}
</style>
<style>
	.frame{
	margin: auto;
	width: 60%;
	border: 2px solid #FFFF00;
	padding: 10px;
}
</style>
</head>
<body>

<!--                           Init                       -->
<?php
include "config.php";
$loggedin = (isset($_SESSION["uname"]) && !empty($_SESSION["uname"]))
?>



<!--               Display username or login          -->
<div class="topright">
  <?php
  if ($loggedin){
    echo "<a href='./profile.php'>".$_SESSION["uname"]."</a>";
    $uname = $_SESSION["uname"];
  }
  else{
    echo "<a href='./login.php'>Login</a>";
  }
  ?>


  <!-- icons -->
  <div style=" position: absolute; bottom: 5px; left: 5px; padding: 5px;">
    <?php
    if($loggedin){
    echo "<a href='profile.php'><img src='/pictures/profile.png' alt='Profile' style='width:30px;height:30px;'></a>";
    }
    ?>
  </div>
  <div style=" position: absolute; bottom: 5px; right: 5px; padding: 5px;">
    <?php
    if($loggedin){
    echo "<a href='cart.php'><img src='/pictures/cart.png' alt='Cart' style='width:30px;height:30px;'></a>";
    }
    ?>
  </div>


  <!--               Display amount                    -->
  <div style=" position: fixed; top: 5px; right: 5px; padding: 5px;">
      <?php
      if ($loggedin){
	echo "Items:".(int)get_cart_amount($conn);
      }
      ?>
  </div>


  <!--                 Display total cost                   -->
  <div style=" position: fixed; top: 30px; right: 5px; padding: 5px;">
      <?php
      if ($loggedin){
        echo "Total: ". (int)get_cart_value($conn). " kr." ;
      }
      ?>
  </div>
</div>

<div>
</div>
</body>
</html>
