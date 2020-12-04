<html>
<body>
<?php
include "config.php";
?>
<div class="container">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div id="div_createuser">
            <h1>Login</h1>

            <div>
                <input type="text" class="textbox" id="txt_email" name="txt_email" placeholder="Email"/>
            </div>
            <div>
                <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password"/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_fname" name="txt_fname" placeholder="First Name"/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_lname" name="txt_lname" placeholder="Last Name"/>
            </div>
            <div>
        <form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF; ?>">
            Sex :
            <select Sex = 'NEW'>
            <option value="">--- Select ---</option>
            <?php
            $genders = mysql_query($conn, "SELECT * from sex");
              while ($rows = $genders.fetch_assoc()){
                  $gender_val = $rows['sex'];
                  echo "<option value = '$gender_val'> $gender_val </option>";
                }
            ?>



          </select>

            </div>

            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>

        </div>
    </form>
</div>



<?php


if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = mysqli_real_escape_string($conn,$_POST['txt_email']);
    $password = mysqli_real_escape_string($conn,$_POST['txt_pwd']);
    $fname = mysqli_real_escape_string($conn,$_POST['txt_fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['txt_lname']);

    if ($lname != "" && $password !="" && $fname != "" && $email !=""){

        $sql = "SELECT * FROM users WHERE email='$email'";
		    $result = mysqli_query($conn,$sql);

        $row = mysqli_fetch_row($result);
        $count = $row[0];
        if($count > 0){
          echo $email + ' email already exists';
        }
        else{

        $sql = "INSERT INTO users (email, first_name, last_name, password)
        Values ('$email', '$fname', '$lname', '$password')";
        if (mysqli_query($conn, $sql)) {
            header('Location: login.php');
        } else {
          echo "Funka inte.. noob";
        }
        }

    }
    else{
    	echo "Fill in the fields retard";
    }

}
?>


</body>
</html>
