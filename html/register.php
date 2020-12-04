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
              <select name="dropdown" id="dropdown">
                <?php
                $res = mysqli_query($conn, "SELECT * FROM sex");
                  while($row = mysqli_fetch_array($res)) {
                    echo("<option value='".$row['gender']."'></option>");
                  }
                  ?>
                  <label for="dropdown">Select</label>
                </select>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_pnumb" name="txt_pnumb"
                 placeholder="Swedish social security equivalent (YYYY-MM-DD-XXXX)"/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_ctr" name="txt_ctr" placeholder="Country"/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_adr" name="txt_adr" placeholder="Address"/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_city" name="txt_city" placeholder="City"/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_zip" name="txt_zip" placeholder="Postal code"/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_cc" name="txt_cc" placeholder="Credit card number"/>
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
