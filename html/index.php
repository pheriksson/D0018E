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
      if ($loggedin){
        echo "Total: ";
        echo $rowCart[2];
        echo " kr.";
      }
      ?>
  </div>
</div>
<iframe width="1280" height="721" src="https://www.youtube.com/embed/TnRZhLRv6eM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</body>
</html>
