<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    <!-- Page Content -->
    <div class="container">

    <header>
        <h1>All Products</h1>
    </header>

        <hr>

         
        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Features</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

        <!-- Function displaying category -->

        <?php display_products_in_shop_page(); ?>

        
        </div>

        <!-- /.row -->

        <hr>

    </div>
    


    <!-- Footer -->

      <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
