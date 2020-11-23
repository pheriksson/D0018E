<html>
<body>




<?php
include "config.php";

if ($_SESSION["uname"] != NULL){
  //Kompilera iframe i högra hörnet, redan inloggad
} else {
  <a href="./login.php">Login / Create account</a>
  
}


?>


</body>
</html>
