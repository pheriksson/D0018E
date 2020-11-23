<html>
<body>

<?php
include "config.php";
?>

<div class="topright.css">
<?php
if ($_SESSION["uname"] != 0){
  echo $_SESSION["uname"];
}
else(
  echo "test";
  )
?>
</div>



</body>
</html>
