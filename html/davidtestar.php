

Contract|Select|Wrap|Line Numbers

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    </head>
    <h1> ADDITION AND SUBRACTION</h1>
    <body>
         <table>
                <form name="nestle" method="post" action="mod_code.php"/>
                      <tr>
                          <td>
                          <label>NAME</label>&nbsp;<th colspan="col"><input name="name" type="text"/></th>
                          </td>
                       </tr>
                       <tr>
                           <td>
                           <label>AUTH CODE</label>&nbsp;<th colspan="col"><input name="auth_code" type="text"/></th>
                           </td>
                        </tr>
                         <tr>
                           <td>
                           <label>PRODUCT NAME</label>&nbsp;<th colspan="col"><input name="prod_name" type="text"/></th>
                           </td>
                        </tr>
                        <tr>
                        <td>
                        <label>NUMBER</label>&nbsp;<th colspan="col"><input name="number" type="text"/></th>
                        </td>
                      </tr>
                      <tr>
                         <td>
                         <input name="add" type="submit" value="ADD"/>




                          <input name="subract" type="submit" value="SUBRACT"/>
                          </td>
                      </tr>

                  </form>
                </table>






    </body>
    </html>
    <?php
include "config.php";

    //Try not to use direct user input, if you do, ensure you validate the data.
    ((empty($_POST['prod_name'])) ? die('Product Name is required.') : null); //Verify that $_POST['prod_name'] is not empty.

    $prod_name=add_slashes(preg_replace("/[^a-zA-Z0-9\'\"\.\&\s]/","",$_POST['prod_name'])); //Only allow alpha numeric with ' " & and . punctuation. This adds resistance to MySQL Injection Attacks (" or 1=1 -- would be output as \" or 11 which doesn't really alter the query as the " or ' are escaped for MySQL)


    if(isset($_post['add'])){
        $add = $_POST['number'];

        if(!is_numeric((int)$add)){ //This locks the $_POST['number] to being a whole integer (ie 1 2 3 10 so on.)
            exit("Sorry, the amount to add must be a valid number.");
        }

        $query = "update products SET prod_qty = prod_qty + $add WHERE prod_name = $prod_name";
        $result = mysqli_query($conn,$query);

        if(!$result)
        {
            exit("quantity not updated ".mysqli_error($conn)); //Need to use $conn here.
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

        $result = mysqli_query($conn,$query);

        if(!$result) //If it is false.
        {
                exit("quantity not updated ".mysqli_error($conn));
        }else{
                echo "$prod_name has been updated";
        }

    }
    ?>
