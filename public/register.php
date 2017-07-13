<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

  <div class="container">
    <header>
        <h1 class="text-center">
             Register
        </h1>
        <div class="col-xs-6 col-xs-offset-3">
          <form action="" method="post" enctype="multipart/form-data">
                <?php registration();  ?>
                  <div class="form-group">
                       <label for="user-title">Username </label>
                          <input type="text" name="username" class="form-control">
                  </div>

                    <div class="form-group">
                          <label for="user-title">First Name </label>
                            <input type="text" name="firstname" class="form-control">
                    </div>

                    <div class="form-group">
                          <label for="user-title">Last Name </label>
                            <input type="text" name="lastname" class="form-control">
                    </div>

                    <div class="form-group">
                          <label for="user-title">Email </label>
                            <input type="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                          <label for="user-title">Password </label>
                            <input type="password" name="password" class="form-control">
                    </div>                        

                    <input type="submit" name="add_user" class="btn btn-custom btn-block" value="Register">    
            </form>
       </div><!--Main Content-->
  </header>
  </div>
<!-- /#wrapper -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>
