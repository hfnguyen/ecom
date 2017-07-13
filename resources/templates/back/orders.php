<?php include(".../../../delete-modal.php"); ?>

<div class="col-md-12">
    <div class="row">
    <h2 class="page-header">
       All Orders

    </h2>
    </div>

    <div class="row">
    <table class="table table-hover">
        <thead>

          <tr>
               <th>Id</th>
               <th>Transaction Id</th>
               <th>Title</th>
               <th>Quantity</th>
               <th>Price</th>
               <th>Total Price</th>
               <th>Status</th>
          </tr>
        </thead>

        <?php 
        display_orders(); 
        delete_orders();


        ?>
    
    </table>
    </div>

</div>
