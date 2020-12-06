<html>
<body>

<div class="container">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div id="div_login">
            <h1>Login1</h1>
            <div>
                <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Email" />
            </div>
            <div>
                <input type="password" class="textbox" id="txt_uname" name="txt_pwd" placeholder="Password"/>
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

if(isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
  header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $uname = mysqli_real_escape_string($conn,$_POST['txt_uname']);

    $password = mysqli_real_escape_string($conn,$_POST['txt_pwd']);
    if ($uname != "" && $password !=""){

        $sql = "SELECT * FROM users WHERE email='$uname' and password='$password'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($result);
        $count = $row[0];
        if($count > 0){
	    $result2= mysqli_query($conn,$sql);
            $_SESSION["uname"] = $uname;
            mysql_data_seek($result, 0);
            $row = mysqli_fetch_array($result);
            $_SESSION["role"] = $row["role"];
            $_SESSION["user_id"] = $row["id"];
	          header('Location: index.php');
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
