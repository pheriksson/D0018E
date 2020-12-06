<html>
<body>
You have been logged out.
<?php
include "config.php";
$_SESSION["uname"] = ""; 
$_SESSION['state'] = ""; //Reset state.
header('Location: index.php');
?>

</body>
</html>
