<html>
<body>



<?php
include "config.php";

$dbtable= "test_1";
// Check connection

$sql = "SELECT * FROM  $dbtable";
$result = mysqli_query($conn,$sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysqli_error();
    exit;
}

while ($row = mysqli_fetch_row($result)) {
    if($row[0] < 2){
    	continue;
    }
    echo "Table: {$row[0]} {$row[1]}\n";
}

mysqli_free_result($result);


?>


</body>
</html>
