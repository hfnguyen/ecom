<?php include(".../../../delete_item_modal.php"); ?>

<div id="page-wrapper">

    <div class="container-fluid">

         <div class="row">

            <h1 class="page-header">
               All Products

            </h1>
            <table class="table table-hover">


                <thead>

                  <tr>
                       <th>Id</th>
                       <th>Title</th>
                       <th>Category</th>
                       <th>Price</th>
                       <th>Status</th>
                  </tr>
                </thead>
                <?php 
                
                  admin_get_products();  
                  admin_delete_products();

                ?>
            </table>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->





