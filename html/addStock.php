<?php
// Include config file and get user-data.
include "config.php";

//Send to login if not logged in.
if(!isset($_SESSION["uname"]) && empty($_SESSION["uname"])){
  header('Location: login.php');
}

if (isset($_GET['add']) && ($_SESSION["role"] == 3)) {
  $product = $_GET['add'];
}
else{
  $product = ($_SESSION["uname"]);
}

$role = $_SESSION["role"];





if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $name = mysqli_real_escape_string($conn,$_POST['name']);
  $stock = mysqli_real_escape_string($conn,$_POST['stock']);
  $active = mysqli_real_escape_string($conn,$_POST['active']);
  $cost = mysqli_real_escape_string($conn,$_POST['cost']);

  $role = $_SESSION["role"];




  $sqlAdd = "INSERT INTO products (name, stock, cost_unit, active)
  VALUES ('$name', $stock, $cost, $active)";

  if(!mysqli_query($conn, $sqlAdd)){
    die("error");
  }
  else{
    header('Location: stock.php');
  }
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add to stock</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
  .wrapper{
    width: 500px;
    margin: 0 auto;
  }
  </style>
  <style>
  .secretmenu {
    position: fixed;
    left: 5px; top: 5px;
    width: 150px;
    height:200px;
    background-color:;
    padding: 5px;
  }
  </style>
  <style>
  .topright {
    position: fixed;
    right: 5px; top: 5px;
    padding: 5px;
  }
  </style>
</head>
<body>

  <div class="secretmenu">
    <?php
    echo "<a href='./orders.php'>Manage orders</a>";
    echo "<br>";
    if($_SESSION["role"] > 1){
      echo "<a href='./stock.php'>Show and edit stock</a>";
      echo "<br>";
    }
    if($_SESSION["role"] == 3){
      echo "<a href='./users.php'>View and edit users</a>";
    }
    ?>
  </div>
  <div class = "topright">
    <a href="logout.php" class="btn btn-default" style="color:white;background-color: red;">Logout</a>
  </div>




  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header">
            <h2>Add to stock</h2>
          </div>
          <p>Fill in the fields for adding a new product.
            Remember to set active status to 0 if product is not yet in stock.</p>
          </br>
          <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" name="name" class="form-control" value="">
              <span class="help-block"></span>
            </div>
            <div class="form-group">
              <label>Left in stock</label>
              <input type="text" name="stock" class="form-control" value="">
              <span class="help-block"></span>
            </div>
            <div class="form-group">
              <label>Active status</label>
              <input type="text" name="active" class="form-control" value="">
              <span class="help-block"></span>
            </div>
            <div class="form-group">
              <label>Cost per unit</label>
              <input type="text" name="cost" class="form-control" value="">
              <span class="help-block"></span>
            </div>

            <input type="submit" class="btn btn-primary" value="Update or add new item to stock">
            <a href="stock.php" class="btn btn-default">Back</a>

          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
