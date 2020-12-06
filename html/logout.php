<html>
<body>
You have been logged out.
<?php
include "config.php";
session_destroy();
header('Location: index.php');
?>

</body>
</html>
