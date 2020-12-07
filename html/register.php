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
          Sex :
          <select name = "dropdown" id = "dropdown">
            <option value = "">--- Select --- </option>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM sex");
            while($rows = $result->fetch_assoc()){
              $genders = $rows['gender'];
              echo "<option value = '.$genders.' type= "Submit" name ='sex'>
            '.$genders.'</option>";
            }
            ?>
          </div>

            <div>
              <input type="text" class="textbox" id="txt_pnumb" name="txt_pnumb"
              placeholder="Swedish social security equivalent (YYYY-MM-DD-XXXX)" size = 50/>
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
        $sex =  mysqli_real_escape_string($conn,$_POST['sex']);
        $email = mysqli_real_escape_string($conn,$_POST['txt_email']);
        $password = mysqli_real_escape_string($conn,$_POST['txt_pwd']);
        $fname = mysqli_real_escape_string($conn,$_POST['txt_fname']);
        $lname = mysqli_real_escape_string($conn,$_POST['txt_lname']);
        $pnumb = mysqli_real_escape_string($conn,$_POST['txt_pnumb']);
        $country = mysqli_real_escape_string($conn,$_POST['txt_ctr']);
        $address = mysqli_real_escape_string($conn,$_POST['txt_adr']);
        $city = mysqli_real_escape_string($conn,$_POST['txt_city']);
        $zip = mysqli_real_escape_string($conn,$_POST['txt_zip']);
        $cc = mysqli_real_escape_string($conn,$_POST['txt_cc']);
      //  $sex = mysqli_real_escape_string($conn,$_POST['submit']);

        $userInfo = array($email, $password, $fname, $lname, $pnumb, $country,
        $address, $city, $zip, $cc, $sex);
        $empty = false;
        for ($i = 0; $i < count($userInfo); $i++){
          if (empty($userInfo[$i])){
            $empty = true;
            echo "Vafan?";
          }
        }
        if($empty){
          echo "Fill in all the fields.";
        }
        //  if ($lname != "" && $password !="" && $fname != "" && $email !=""){
        if(!$empty){
          $sql = "SELECT * FROM users WHERE email='$email'";
          $result = mysqli_query($conn,$sql);

          $row = mysqli_fetch_row($result);
          $count = $row[0];
          if($count > 0){
            echo $email + ' email already exists';
          }
        }
        else{

          $sql = "INSERT INTO users (email, first_name, last_name,  sex,
            p_nmb, password, adress, city, zip_code, country, role, credit_card)
            Values ('$email', '$fname', '$lname', '$sex', '$pnumb', '$password',
              '$address', '$city', '$zip', '$country', '$cc')";
              if (mysqli_query($conn, $sql)) {
                header('Location: login.php');
              } else {
                echo "Funka inte.. noob";
              }
            }


            /*  else{
            echo "Fill in the fields retard";
          }*/

        }
        ?>


      </body>
      </html>
