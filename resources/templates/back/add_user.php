
<div id="page-wrapper">

  <div class="container-fluid">

      <div class="col-md-12">

        <div class="row">
          <h1 class="page-header">
             Add User
             <small>Page</small>
          </h1>
        </div>

        <div class="col-md-6 user_image_box">
            <span id="user_admin" class="fa fa-user fa-4x"></span>  

        </div>
               
          <form action="" method="post" enctype="multipart/form-data">
            <aside id="admin_sidebar" class="col-md-6">

              <div class="col-md-8">

               <?php add_users();?>

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
                            <input type="email" name="user_email" class="form-control">
                    </div>

                    <div class="form-group">
                          <label for="user-title">Password </label>
                            <input type="password" name="user_password" class="form-control">
                    </div>

                    <div class="form-group">
                      <div class="row">
                          <div class="col-md-4">
                              <label for="user-role">Role </label>
                              <select name="user_role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="subscribe">Subscriber</option>
                              </select>
                          </div>
                          <!-- User Photo -->
                          <div class="col-md-4">
                              <label for="user-photo">Photo </label>
                              <input type="file" name="file">
                          </div>
                      </div>
                    </div>

                        

                    <input type="submit" name="add_user" class="btn btn-primary btn-md" value="Add User">

              </div><!--Main Content-->

        </aside><!--SIDEBAR-->
    
      </form>

      </div>
      <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

