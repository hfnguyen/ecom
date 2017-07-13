<?php include(".../../../delete_cat_modal.php"); ?>

<div id="page-wrapper">

   <div class="container-fluid">
            

        <h1 class="page-header">
          Product Categories
          <?php add_category();  ?>

        </h1>

        <div class="col-md-4">
            
            <form action="" method="post">
            
                <div class="form-group">
                    <label for="category-title">Title</label>
                    <input type="text" class="form-control" name="cat_title" required>
                </div>

                <div class="form-group">
                    
                    <input type="submit" name="submit" class="btn btn-primary" value="Add Category">
                </div>      


            </form>

        </div>


        <div class="col-md-6">

            <table class="table">
                    <thead>

                <tr>
                    <th>Id</th>
                    <th>Title</th>
                </tr>
                    </thead>


            <?php 

            display_categories();

            delete_category();
            ?>

                </table>

        </div>


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
