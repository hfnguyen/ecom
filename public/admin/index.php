<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK . DS . "header.php"); ?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <?php

                if(!isset($_SESSION['username'])){
                    header("Location: ../../public/index.php");
                }

                display_admin();
                    
                ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include(TEMPLATE_BACK . DS . "footer.php"); ?>


