<html>
<body>

<div class="container">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div id="div_createuser">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
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
                <input type="text" class="textbox" id="txt_email" name="txt_email" placeholder="Email"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
        </div>
    </form>
</div>

<a href="./register.php">Create account</a>


<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $uname = mysqli_real_escape_string($conn,$_POST['txt_uname']);
    $password = mysqli_real_escape_string($conn,$_POST['txt_pwd']);
    $fname = mysqli_real_escape_string($conn,$_POST['txt_fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['txt_lname']);
    $email = mysqli_real_escape_string($conn,$_POST['txt_email']);
    if ($uname != "" && $password !="" && $fname != "" && $uname !="" && $email !=""){

        $sql = "SELECT * FROM users WHERE attr1='$email';
		$result = mysqli_query($conn,$sql);

        $row = mysqli_fetch_row($result);
        $count = $row[0];
        if($count > 0){

            $_SESSION["uname"] = $uname;
            echo $uname;
            header('Location: welcome.php');
        }else{
            echo "Invalid username and password";
        }

    }
    else{
    	echo "Fill in the fields retard";
    }

}
?>


</body>
</html>
