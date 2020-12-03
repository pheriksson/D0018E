<html>
<head>
<style>
  .topright {
    position: fixed;
    right: 5px; top: 5px;
    width: 200px;
    height:70px;
    background-color:lightgrey;
    padding: 5px;
}

  .large {
    width: 2000px; height: 500px;
    background-color: lightgray;
}
</style>
</head>
<body>

<!--                           Init                       -->
<?php
include "config.php";
?>



<!--               Display username or login          -->
<div class="topright">
  <?php
  if (isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
    echo "<a href='./profile.php'>".$_SESSION["uname"]."</a>";
    $uname = $_SESSION["uname"];
  }
  else{
    echo "<a href='./login.php'>Login</a>";
  }
  ?>

  <!--               Display amount                    -->
  <div style=" position: fixed; top: 5px; right: 5px; padding: 5px;">
      <?php
      if (isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
        $sqlCart = "SELECT * FROM cart WHERE user_id='$uname'";
        $resultCart = mysqli_query($conn,$sqlCart);
        $rowCart = mysqli_fetch_row($resultCart);
        echo $rowCart[1]." items.";
      }
      ?>
  </div>


  <!--                 Display total cost                   -->
  <div style=" position: fixed; top: 30px; right: 5px; padding: 5px;">
      <?php
      if (isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
        echo "Total: ";
        echo $rowCart[2];
        echo " kr.";
      }
      ?>
  </div>
  <div style=" position: fixed; bottom: 5px; right: 5px; padding: 5px;">
    <a href="profile.php">
      <img src="/pictures/profile.png" alt="Profile" style="width:10px;height:10px;">
    </a>
  </div>
  <div style=" position: fixed; bottom: 5px; left: 5px; padding: 5px;">
    <a href="/pictures/cart.php">
      <img src="cart.png" alt="Cart" style="width:10px;height:10px;">
    </a>
  </div>
</div>


</body>
</html>
