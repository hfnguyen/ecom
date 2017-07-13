
<?php
    if(isset($_GET['id'])){

        $id = escape_string($_GET['id']);
      }

?>


<div id="page-wrapper">

  <div class="container-fluid">

      <div class="col-md-12">

        <div class="row">
          <h1 class="page-header">
             Edit Product
             <?php edit_product();?>

             <!-- Display properties after editing to make sure all the data presented properly, not slower -->

             <?php 

                  $select = query("SELECT * FROM products WHERE product_id = '{$id}' ");
                  confirm($select);
                  while($row = fetch_array($select)):
                      $product_id          = $row['product_id'];
                      $product_title       = $row['product_title'];
                      $product_brand       = $row['product_brand'];
                      $product_category_id = $row['product_category_id'];
                      $product_tags        = $row['product_tags'];
                      $product_quantity    = $row['product_quantity'];
                      $product_price       = $row['product_price'];
                      $short_desc          = $row['short_desc'];
                      $product_description = $row['product_description'];
                      $product_status      = $row['product_status']; 
                      $product_image       = $row['product_image'];

             ?>

          </h1>
        </div>
               
        <form action="" method="post" enctype="multipart/form-data">


        <div class="col-md-8">

          <div class="form-group">
              <label for="product-title">Product Title </label>
                  <input type="text" name="product_title" class="form-control" value="<?php echo $product_title; ?>">
          </div>

          <div class="form-group">
              <label for="product-title">Short Description </label>
                  <input type="text" name="short_desc" class="form-control" value="<?php echo $short_desc; ?>" >
          </div>


            <div class="form-group">
                   <label for="product-title">Product Description</label>
              <textarea name="product_description" id="" cols="30" rows="10" class="form-control tinymce"><?php echo str_replace('\r\n', '<br>', $product_description); ?></textarea>
            </div>



            <div class="form-group row">

              <div class="col-xs-3">
                <label for="product-price">Product Price</label>
                <input type="number" name="product_price" class="form-control" size="60" min="0" step="any"  value="<?php echo $product_price; ?>" >
              </div>
            </div>

      </div><!--Main Content-->


<!-- SIDEBAR-->


      <aside id="admin_sidebar" class="col-md-4">


           <!-- Product Categories-->

          <div class="form-group">
            <div class="row">

              <div class="col-md-8">
                <label for="product-title">Product Category</label>
                  <select name="product_category" class="form-control">
                      <?php
                        $cat = query("SELECT * FROM categories");
                        confirm($cat);
                        while($row = fetch_array($cat)){
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            if($cat_id == $product_category_id){

                                echo "<option value='$cat_id' selected>{$cat_title}</option>";
                            }else{
                                echo "<option value='$cat_id'>{$cat_title}</option>";
                            }
                        }

                      ?> 
                  </select>
              </div>

              <div class="col-md-4">
                  <label for="product-title">Quantity</label>
                  <input type="number" name="product_quantity" class="form-control" min="1" max="100" value="<?php echo $product_quantity; ?>">
              </div>
              </div>

          </div>

          <!-- Product Brands-->


          <div class="form-group">
            <div class="row">
              <div class="col-md-8">
                <label for="product-title">Product Brand</label>
                 <select name="product_brand" id="" class="form-control">

                      <?php
                          $brand = query("SELECT * FROM brand");
                          confirm($brand);
                          while($row = fetch_array($brand)){
                              $brand_title = $row['brand_title'];
                              if($brand_title == $product_brand){

                                  echo "<option value='$brand_title' selected>{$brand_title}</option>";
                              }else{
                                  echo "<option value='$brand_title'>{$brand_title}</option>";
                              }
                          }

                        ?> 
                    
                 </select>
              </div>

               <div class="col-md-4">
                  <label for="product-title">Status</label>
                  <select name="product_status" id="" class="form-control">
                      <option value='<?php echo $product_status; ?>'><?php echo $product_status; ?></option>

                      <?php
                            if($product_status == "Published"){

                                echo "<option value='Draft'>Draft</option>";
                            }else{
                                echo "<option value='Published'>Published</option>";
                            }

                      ?> 
                    
                 </select>
              </div>
            </div>
          </div>



      <!-- Product Tags -->


          <div class="form-group">
              <label for="product-title">Product Keywords</label>
              <input type="text" name="product_tags" class="form-control"  value="<?php echo $product_tags; ?>"  >
          </div>

          <!-- Product Image -->
          <div class="form-group">
              <label for="product-title">Product Image</label>
              <br>
              <img src="../../resources/images/<?php echo $product_image;?>" alt="" width="100" height="50">
              <input type="file" name="file" value="<?php echo $product_image;?>">
            
          </div>

          <div class="form-group">
              <input type="submit" name="update_product" class="btn btn-primary btn-md" value="Update">
          </div>

      </aside><!--SIDEBAR-->


    
      </form>

      </div>
      <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<?php endwhile; ?>

<!-- 

 -->
