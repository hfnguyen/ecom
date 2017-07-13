<?php require_once("../resources/config.php"); ?>

<?php
    
    if(isset($_GET['add'])){

        $result = query("SELECT product_quantity FROM products WHERE product_id = " . escape_string($_GET['add']) . " ");
        confirm($result);

        $row = fetch_array($result);

        if($_SESSION['product_' . $_GET['add']] < $row['product_quantity']){
            $_SESSION['product_' . $_GET['add']] += 1;
            echo $_SESSION['product_' . $_GET['add']];
            header("Location: checkout.php");

        }else{
            echo "NOT AVAILABLE";
        }

    }



    if(isset($_GET['remove']) && $_SESSION['product_' . $_GET['remove']] != 0){
        $_SESSION['product_' . $_GET['remove']]--;
    }

    if(isset($_GET['delete'])){
        $_SESSION['product_' . $_GET['delete']] = 0;

    }


    function cart(){

        foreach($_SESSION as $name => $value){
            if($value > 0){

                if(substr($name, 0, 8) == "product_"){

                    $length = strlen($name - 8);
                    $id = substr($name, 8, $length);
                    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
                    confirm($query);
                    while($row = fetch_array($query)){

                        $product = <<<DISPLAY
                        <tr>
                            <td>{$row['product_title']}</td>
                            <td>{$row['product_price']}</td>
                            <td>{$row['product_quantity']}</td>
                            <td>{$row['product_total']}</td>
                            <td><a id='remove' class='btn btn-warning' href="cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a> <a class='btn btn-info' href="cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a> <a class='btn btn-danger' href='cart.php?delete={$row['ck_product_id']}'><span class='glyphicon glyphicon-remove'></span></a></td>
                        </tr>

DISPLAY;
                    }
                }
            }
        }
    }

 ?>