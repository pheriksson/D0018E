<?php
// Include config file and get user-data.
include "config.php";

//Send to login if not logged in.
if(!isset($_SESSION["uname"]) && empty($_SESSION["uname"])){
  header('Location: login.php');
}

$uname = ($_SESSION["uname"]);

$sql = "SELECT * FROM users WHERE email='$uname'";
$result = mysqli_query($conn,$sql);
$ArrayUser = mysqli_fetch_array($result);


$fname = $ArrayUser["first_name"];
$lname = $ArrayUser["last_name"];
$adress = $ArrayUser["adress"];
$city = $ArrayUser["city"];
$zip_code = $ArrayUser["zip_code"];
$country = $ArrayUser["country"];
$card = $ArrayUser["credit_card"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
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
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Profile</h2>
                    </div>
                    <p>Fill in the fields you like to update.
                    If you would like to change your password, fill in the
                    password fields. Otherwise leave them blank.</p>
                    </br>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Last name</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="adress" class="form-control" value="<?php echo $adress; ?>">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Zip code</label>
                            <input type="text" name="zip" class="form-control" value="<?php echo $zip_code; ?>">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" name="card" class="form-control" value="<?php echo $card; ?>">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="pw1" class="form-control">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input type="password" name="pw2" class="form-control">
                            <span class="help-block"></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Update">
                        <a href="index.php" class="btn btn-default">Back</a>
                        <div class="form-group">
                        <?php
                          if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['pw2'] != $_POST['pw1'])){
                            echo "<b style='color:red' , class='form-group'>Passwords do not match.</b>";
                          }
                         ?>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $pw1table = mysqli_real_escape_string($conn,$_POST['pw1']);
  $fnametable = mysqli_real_escape_string($conn,$_POST['fname']);
  $lnametable = mysqli_real_escape_string($conn,$_POST['lname']);
  $adresstable = mysqli_real_escape_string($conn,$_POST['adress']);
  $citytable = mysqli_real_escape_string($conn,$_POST['city']);
  $countrytable = mysqli_real_escape_string($conn,$_POST['country']);
  $ziptable = mysqli_real_escape_string($conn,$_POST['zip']);
  $cardtable = mysqli_real_escape_string($conn,$_POST['card']);




  if($_POST['pw1'] == "" && $_POST['pw2'] == ""){
    $sqltable = "UPDATE users SET first_name= '$fnametable', last_name = '$lnametable', adress = '$adresstable', city = '$citytable', country = '$countrytable', zip_code = '$ziptable', credit_card = '$cardtable' WHERE email= '$uname'";

    if(!mysqli_query($conn,$sqltable)){
      die("error");
    }
    else{
      header('Location: index.php');
    }
  }
  else{
    if($_POST['pw1'] == $_POST['pw2']){
    $sqltable = "UPDATE users SET first_name= '$fnametable', last_name = '$lnametable', adress = '$adresstable', city = '$citytable', country = '$countrytable', zip_code = '$ziptable', credit_card = '$cardtable', password = '$pw1table' WHERE email= '$uname'";

      if(!mysqli_query($conn,$sqltable)){
        die("error");
      }
      else{
        header('Location: index.php');
      }
    }
  }
}



 ?>



<div class="secretmenu">
  <?php
    if($ArrayUser["role"] > 1){
      echo "<a href='./orders.php'>Manage orders</a>";
      echo "<br>";
      echo "<a href='./stock.php'>Show and edit stock</a>";
      echo "<br>";
    }
    if($ArrayUser["role"] == 3){
      echo "<a href='./users.php'>View and edit users</a>";
    }
   ?>
 </div>
   <a href="Logout.php" class="btn btn-default" style= "position: fixed",
   "Right: 5px", "top: 5px">Logout</a>




</body>
</html>
