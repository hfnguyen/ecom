<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li class="active">
            <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
        <li class="">
            <a href="index.php?page=orders"><i class="fa fa-fw fa-dashboard"></i>Orders</a>
        </li>

        <li>
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Products <i class="fa fa-fw fa-caret-down"></i></a>

            <ul id="posts_dropdown" class="collapse">

                <li>
                    <a href="index.php?page=view_products"><i class="fa fa-fw fa-bar-chart-o"></i> View Products</a>
                </li>

                <li>
                    <a href="index.php?page=add_product"><i class="fa fa-fw fa-table"></i> Add Product</a>
                </li>
                
            </ul>

        </li>

        <li>
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#cat"><i class="fa fa-fw fa-arrows-v"></i>Categories <i class="fa fa-fw fa-caret-down"></i></a>

            <ul id="cat" class="collapse">

                <li>
                    <a href="index.php?page=view_cat">View Categories</a>
                </li>
                
            </ul>

        </li>


        <li>
            <a href="javascript:void(0)" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i>Users <i class="fa fa-fw fa-caret-down"></i></a>

            <ul id="demo" class="collapse">

                <li>
                    <a href="index.php?page=view_users">View Users</a>
                </li>
                
            </ul>

        </li>
    
    </ul>
</div>
<!-- /.navbar-collapse -->