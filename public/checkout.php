<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>



    <!-- Page Content -->
<div class="container">


<!-- /.row --> 

  <div class="row">

        <h1>Checkout</h1>

        <!-- PAYPAL ACCOUNT -->

    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="business" value="huynguyensc-facilitator@gmail.com">
        <table class="table table-striped">
            <thead>
              <tr>
               <th>Product</th>
               <th>Price</th>
               <th>Quantity</th>
               <th>Sub-total</th>
         
              </tr>
            </thead>

            <?php display_item_from_cart();  ?>

        </table>
        <?php paypal_button(); ?>
    </form>

      <?php 

      delete_item_from_cart(); 
      remove_item_from_cart();
      add_more_item(); 

      ?>



  <!--  ***********CART TOTALS*************-->
              
    <div class="col-xs-4 pull-right ">
      <h2>Cart Totals</h2>

      <table class="table table-bordered" cellspacing="0">

        <!-- Display items in cart -->

        <?php display_cart_totals(); ?>

      </table>

    </div><!-- CART TOTALS-->


   </div><!--Main Content-->


           <hr>

    <!-- Footer -->
       <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>


</div>
    <!-- /.container -->

 <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

