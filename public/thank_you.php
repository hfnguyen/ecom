<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<?php

if(isset($_GET['tx'])){

    echo "connected";
    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];

    $query = query("INSERT INTO orders(order_amount, order_transaction, order_status, order_currency) VALUES('{$amount}', '{$transaction}', '{$status}', '{$currency}') ");
    confirm($query);
    session_destroy();

}

?>

    <!-- Page Content -->
    <div class="container">
        <h1 class="tex-center">Thank You</h1>

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_BACK . DS . "footer.php"); ?>