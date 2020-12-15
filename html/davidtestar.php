

    <?php

    require_once("db_connect.php");
    $db = mysqli_connect($host,$user,$password,$db);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error()); //Verify that we connected.
        exit();
    }

    //Try not to use direct user input, if you do, ensure you validate the data.
    ((empty($_POST['prod_name'])) ? die('Product Name is required.') : null); //Verify that $_POST['prod_name'] is not empty.

    $prod_name=add_slashes(preg_replace("/[^a-zA-Z0-9\'\"\.\&\s]/","",$_POST['prod_name'])); //Only allow alpha numeric with ' " & and . punctuation. This adds resistance to MySQL Injection Attacks (" or 1=1 -- would be output as \" or 11 which doesn't really alter the query as the " or ' are escaped for MySQL)


    if(isset($_post['add'])){
        $add = $_POST['number'];

        if(!is_numeric((int)$add)){ //This locks the $_POST['number] to being a whole integer (ie 1 2 3 10 so on.)
            exit("Sorry, the amount to add must be a valid number.");
        }

        $query = "update products SET prod_qty = prod_qty + $add WHERE prod_name = $prod_name";
        $result = mysqli_query($db,$query);

        if(!$result)
        {
            exit("quantity not updated ".mysqli_error($db)); //Need to use $db here.
        }else{
            echo "$prod_name has been updated";
        }
    }


    if(isset($_POST['subract'])){
        $subract = $_POST['number'];

        if(!is_numeric((int)$subtract)){ //This locks the $_POST['number] to being a whole integer (ie 1 2 3 10 so on.)
            exit("Sorry, the amount to subtract must be a valid number.");
        }

        $query = "update products SET prod_qty = prod_qty - $subract WHERE prod_name= $prod_name";

        $result = mysqli_query($db,$query);

        if(!$result) //If it is false.
        {
                exit("quantity not updated ".mysqli_error($db));
        }else{
                echo "$prod_name has been updated";
        }

    }
    ?>
