<html>
<head>
<style>
  .topright {
    position: fixed;
    right: 5px; top: 5px;
    width: 200px;
    height:40px;
    background-color:lightblue;
    padding: 5px;
}
  .large {
    width: 2000px; height: 500px;
    background-color: lightgray;
}
</style>
</head>
<body>

<?php
include "config.php";
?>

<div class="topright">
<?php
session_start();
if ($_SESSION["uname"] != 0){
  echo $_SESSION["uname"];
}
else{
  echo "test";
}
?>
</div>


</body>
</html>
