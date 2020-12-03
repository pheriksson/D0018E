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
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Update">
                        <a href="index.php" class="btn btn-default">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>



</body>
</html>
