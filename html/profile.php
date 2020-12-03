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
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
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

                    <p>Fill in the fields you like to update.</p>
                    </br>
                    If you would like to change your password, fill in the
                    password fields. Otherwise leave them blank.
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
      header('Location: login.php');
    }
  }
  else{
    if($_POST['pw1'] == $_POST['pw2']){
    $sqltable = "UPDATE users SET first_name= '$fnametable', last_name = '$lnametable', adress = '$adresstable', city = '$citytable', country = '$countrytable', zip_code = '$ziptable', credit_card = '$cardtable', password = '$pw1table' WHERE email= '$uname'";

      if(!mysqli_query($conn,$sqltable)){
        die("error");
      }
      else{
        header('Location: login.php');
      }
    }
    else{
      echo "<b style='color:red'>Passwords do not match.</b>";
    }
  }
}



 ?>

</body>
</html>
