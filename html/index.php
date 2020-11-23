<html>
<body>

<?php
include "config.php";
?>

<div rel="stylesheet" href="index.css">
<?php
if ($_SESSION["uname"] != 0){
  echo $_SESSION["uname"];
};
else{
  echo "test";
};
?>
</div>


</body>
</html>
