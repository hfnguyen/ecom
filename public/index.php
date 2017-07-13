<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Side categories are here -->

            <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

            <div class="col-md-9">

                <!-- Slider is here -->

            <?php include(TEMPLATE_FRONT . DS . "slider.php"); ?>

            <?php

                if(isset($_GET['id_x'])){
                    $check = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['id_x']) . " ");
                    confirm($check);

                    $row = fetch_array($check);

                    if(add_to_cart($row['product_title'], $row['product_price'])){

                        echo "<div class='center-text'><b>Your items have been added</b>" . " " . "<a href= 'checkout.php' target='_blank'>View your cart</a></div>"; 
                    }else{
                        echo "<div class='center-text'><b>Your cart is full. You can only add up to 5 items</b>" . " " . "<a href= 'index.php'>Back to homepage</a>" . "<br></div>";
                    }
                }  
                ?>

            </div>

                <!--Displaying products-->

                <div class="row">

                <!-- Get products from DB -->

                <?php get_products();  ?>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>