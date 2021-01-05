<?php
// Include config file and get user-data.
include "config.php";

//Send to login if not logged in.
if(!isset($_SESSION["uname"]) && empty($_SESSION["uname"])){
  header('Location: login.php');
}

if (isset($_GET['edit']) && ($_SESSION["role"] > 1)) {
  $product = $_GET['edit'];
}
else{
  $product = ($_SESSION["uname"]);
}

$sql = "SELECT * FROM products WHERE name='$product'";
$result = mysqli_query($conn,$sql);
$ArrayUser = mysqli_fetch_array($result);


$name = $ArrayUser["name"];
$stock = $ArrayUser["stock"];
$active = $ArrayUser["active"];
$cost = $ArrayUser["cost_unit"];
$role = $_SESSION["role"];





if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $name = mysqli_real_escape_string($conn,$_POST['name']);
  $stock = mysqli_real_escape_string($conn,$_POST['stock']);
  $active = mysqli_real_escape_string($conn,$_POST['active']);
  $cost = mysqli_real_escape_string($conn,$_POST['cost']);

  $sql = "SELECT * FROM products WHERE name='$product'";
  $result = mysqli_query($conn,$sql);

  $role = $_SESSION["role"];




  $sqlUpdate = "UPDATE products SET name = '$name', stock = $stock, cost_unit = $cost, active = $active WHERE name= '$name'";

  if(!mysqli_query($conn,$sqlUpdate)){
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
  <title>Update stock</title>
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
            <h2>Update stock</h2>
          </div>
          <p>Fill in the fields you like to update.
            If you set stock to 0, remember to set active status to 0
          </p>
          </br>
          <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
              <span class="help-block"></span>
            </div>
            <div class="form-group">
              <label>Left in stock</label>
              <input type="text" name="stock" class="form-control" value="<?php echo $stock; ?>">
              <span class="help-block"></span>
            </div>
            <div class="form-group">
              <label>Active status</label>
              <input type="text" name="active" class="form-control" value="<?php echo $active; ?>">
              <span class="help-block"></span>
            </div>
            <div class="form-group">
              <label>Cost per unit</label>
              <input type="text" name="cost" class="form-control" value="<?php echo $cost; ?>">
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
