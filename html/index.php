<html>
<head>
<style>
  .topright {
    position: fixed;
    right: 5px; top: 5px;
    width: 200px;
    height:40px;
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

<?php
include "config.php";
?>

<div class="topright">
  <?php
  if (isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
    echo "<a href='./profile.php'>".$_SESSION["uname"]."</a>";
  }
  else{
    echo "<a href='./login.php'>Login</a>";
  }
  ?>

  <div style=" position: fixed; top: 5px; right: 5px; padding: 5px;">
      <?php
      if (isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
        // String amount = SQL for cart amount
        echo "X items."; //Replace X with "<a href='./cart.php'>amount</a>";
      }
      ?>
  </div>

  <div style=" position: fixed; top: 30px; right: 5px; padding: 5px;">
      <?php
      if (isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
        echo "Total: ";
        echo "X"; //replace with sql-call
        echo " kr.";
      }
      ?>
  </div>


</div>


</body>
</html>
