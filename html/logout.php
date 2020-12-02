<html>
<body>
You have been logged out.
<?php
include "config.php";
$_SESSION["uname"] = "";
header('Location: index.php');
?>

</body>
</html>
