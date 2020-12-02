<html>
<body>

Welcome <?php
session_start();
echo $_SESSION["uname"];
echo "<br>"."You will be sent to start-page in 5 seconds"
header("Refresh: 5; url=index.php");
?><br>


</body>
</html>
