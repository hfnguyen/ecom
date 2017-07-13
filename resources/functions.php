<?php
function confirm($confirm_variable){
	global $connection;
	if(!$confirm_variable){
		die("QUERY FAILED" . mysqli_error($connection));
	}
}

function redirect($location){
	header("Location: $location");
    exit();
}


// function performing a query
function query($sql){
	global $connection;

	return mysqli_query($connection, $sql);
}

function escape_string($string){
	global $connection;
	return mysqli_real_escape_string($connection, $string);

}

function fetch_array($result){
	return mysqli_fetch_array($result);
}


/*---------------------------------------------FRONT END FUNCTIONS---------------------------------------------*/

function get_products(){
	global $connection;
	$query = "SELECT * FROM products";
    $send_query = mysqli_query($connection, $query);
    confirm($send_query);
    while($row = fetch_array($send_query)):

    	$product_image = image_directory($row['product_image']);

        $product = <<<INFO
        <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <a target="_blank" href="item.php?id={$row['product_id']}"><img src="../resources/$product_image" alt="" width="350" height="150" ></a>
                    <div class="caption">
                        <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                        <h4><a href="product.php?{$row['product_id']}">{$row['product_title']}</a>
                        </h4>
                        <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <a class="btn btn-primary" href="index.php?id_x={$row['product_id']}">Add to cart</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>        
                    </div>
                </div>
            </div>
INFO;

echo $product;

    endwhile;
}


function get_categories(){
	global $connection;
	$query = "SELECT * FROM categories";
	$send_query = mysqli_query($connection, $query);
	confirm($send_query);
	while($row = fetch_array($send_query)){
		$category_links = <<<CAT_INF
			<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
CAT_INF;
echo $category_links;
	}
}



function display_category(){
	global $connection; 
    $query = "SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ";
    $result = query($query);
    confirm($result);
    while($row = fetch_array($result)){

        $category_data = <<<DATA
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="{$row['product_image']}" alt="">
            <div class="caption">
                <h4><a href="product.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
                <p>{$row['product_intro']}</p>
                <p>
                    <a class="btn btn-primary" target="_blank" href="item.php?id={$row['product_id']}">Buy Now</a> <a href="#" class="btn btn-default">More Info</a>
                </p>
            </div>
        </div>
    </div>
DATA;
echo $category_data;
	}
}

function display_products_in_shop_page(){
        global $connection; 
        $query = "SELECT * FROM products";
        $result = query($query);
        confirm($result);
        while($row = fetch_array($result)){
            $product_image = image_directory($row['product_image']);

            $product_data = <<<DATA
            <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail">
                <img src="../resources/$product_image" alt="" width="100" height="50">
                <div class="caption">
                    <h4>{$row['product_title']}</h4>
                    <p>
                        <a class="btn btn-primary" target="_blank" href="item.php?id={$row['product_id']}">Buy Now</a> <a class="btn btn-default" href="#">More Info</a>
                    </p>
                </div>
            </div>
        </div>
DATA;
echo $product_data;
        }
}

function isadmin($username){
    $check = query("SELECT user_role FROM users WHERE username = '{$username}' ");
    confirm($check);
    $row = fetch_array($check);
    if($row['user_role'] == 'admin'){
        return true;
    }else{
        return false;
    }
}


function login($username, $password){
    global $connection;

        $username = trim($_POST['username']);
        $username = trim($_POST['password']);
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = "SELECT * FROM users WHERE username = '{$username}' ";
        $result = query($query);
        confirm($result);
        $num = mysqli_num_rows($result);

        if($num != 0){

            while($row = fetch_array($result)){
            $db_username  = $row['username'];
            $db_password  = $row['user_password'];
            $db_role      = $row['user_role'];
            $db_firstname = $row['user_firstname'];
            $db_lastname  = $row['user_lastname'];
            }

            if(password_verify($password, $db_password)){

                if($db_role == 'admin'){

                    $_SESSION['username']       = $db_username;
                    $_SESSION['password']       = $db_password;
                    $_SESSION['user_firstname'] = $db_firstname;
                    $_SESSION['user_lastname']  = $db_lastname;
                    $_SESSION['user_role']      = $db_role;
                
                    header("Location: admin/index.php");
                    }else{
                        $_SESSION['username']       = $db_username;
                        $_SESSION['password']       = $db_password;
                        $_SESSION['user_firstname'] = $db_firstname;
                        $_SESSION['user_lastname']  = $db_lastname;
                        $_SESSION['user_role']      = $db_role;

                        echo "<h4>You have logged in as subscriber</h4>" . " " . "<a href='index.php'>Go to homepage</a>";
                    }

                }else{
                    echo "<h4>Password is incorrect!</h4>";
                }


        }else{
            echo "<h4>Username is incorrect!</h4>";
        }

}

/*DEALING WITH REGISTRATION*/

function username_exists($username){
    $check = query("SELECT username FROM users WHERE username = '{$username}' ");
    confirm($check);
    if(mysqli_num_rows($check) > 0){
        return true;
    }else{
        return false;
    }

}

function email_exists($email){
    $check = query("SELECT user_email FROM users WHERE user_email = '{$email}' ");
    confirm($check);
    if(mysqli_num_rows($check) > 0){
        return true;
    }else{
        return false;
    }
}

function register($username, $firstname, $lastname, $password, $email, $role){
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost',12));
    $register = query("INSERT INTO users(username, user_firstname, user_lastname, user_password, user_email, user_role) VALUES ('{$username}', '{$firstname}', '{$lastname}', '{$password}', '{$email}', '{$role}') ");
    confirm($register);

    $_SESSION['username']       = $username;
    $_SESSION['password']       = $password;
    $_SESSION['user_firstname'] = $firstname;
    $_SESSION['user_lastname']  = $lastname;
    $_SESSION['user_role']      = 'subcriber';

    echo "<p style='text-align:center'><b>Registered as subscriber</b> <a href= 'index.php'>Back to homepage</a></p>";
}

function registration(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username       = $_POST['username'];
        $firstname      = $_POST['firstname'];
        $lastname       = $_POST['lastname'];
        $password       = $_POST['password'];
        $email          = $_POST['email'];
        $role           = 'subscriber';

        /*Checking username*/

        if(username_exists($username)){
            echo "The username is registered. Do you already have an account? <a href='login.php'>Log in</a>";
            return;
        }

        if(strlen($username)<4){
            echo "Username needs to be at least 5 characters!";
            return;
        }

        if(username_exists($username)){
            echo "This username is already registered. Please choose another one!";
            return;
        }

        if($username == ''){
            echo "Username cannot be emptied!";
            return;
        }


        if(preg_match('#\s#', $username)){
            echo "Username cannot contain white spaces. Please choose another one!";
            return;
        }

        if(!preg_match('#^[0-9A-Za-z_.]+$#', $username)){
            echo "Username cannot contain special characters!";
            return;
        }


        /*Checking password*/

        if($password == ''){
            echo "Password cannot be emptied!";
            return;
        }
            
        if(preg_match('#\s#', $password)){
            echo "Password cannot contain white spaces.";
            return;
        }

        /*Checking email */

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            echo "Incorrect email!";
            return;
        }

        if(email_exists($email)){
           echo "The email is registered. Do you already have an account? <a href='login.php'>Log in</a>";
           return;
        }

        register($username, $firstname, $lastname, $password, $email, $role);
    }
}

function send_message(){
    if(isset($_POST['submit'])){
        $to = "huynguyensc@gmail.com";
        $sender = $_POST['email'];
        $subject = $_POST['name'];
        $message = $_POST['message'];
        $header = "From: {$sender}" . "\n";

        $result = mail($to, $subject, $message, $header);// this mail function will return a boolean value

        echo "Your message has been sent!";
    }
}




/*----------------FUNCTION DEALING WITH CART-------------------*/

function add_to_cart($product_title, $product_price){

    if(isset($_POST['submit']) || isset($_GET['id_x'])){

        //check to see if this is the new products or not

        $check = "SELECT ck_id, ck_product_name, ck_product_quantity FROM checkout WHERE ck_product_name = '{$product_title}' ";
        $check_result = query($check);
        confirm($check_result);
        
        $count = mysqli_num_rows($check_result);

        if($count == 0){

            $new_id = mt_rand();
            $quantity = isset($_POST['submit'])? $_POST['quantity']: 1;
            $total = $quantity * $product_price;
            $status = "Not Completed";

            //Insert items
            $query = "INSERT INTO checkout(ck_id, ck_product_name, ck_product_price, ck_product_quantity, ck_product_total, ck_product_status) ";
            $query .= "VALUES('{$new_id}', '{$product_title}', '{$product_price}', '{$quantity}', '{$total}', '{$status}') ";
            $result = query($query);
            confirm($result);

            return true;

        }else{

            $row = fetch_array($check_result);
            $db_quantity = $row['ck_product_quantity'];
            $db_id = $row['ck_id'];
            $act_quantity = isset($_POST['submit'])? $_POST['quantity']: 1;

            $quantity = $act_quantity + $db_quantity;

            if($quantity < 6){
                $total = $quantity * $product_price;
                 // Update items

                $query  = "UPDATE checkout SET ";
                $query .= "ck_product_quantity = {$quantity}, ";
                $query .= "ck_product_price = {$product_price}, ";
                $query .= "ck_product_total = {$total} WHERE ck_id = {$db_id} ";
                $result = query($query);
                confirm($result);

                return true;

            }else{

                return false;
            }

        }
        
    }

}

function get_photo($photo){
    $get_photo = query("SELECT product_image FROM products WHERE product_title = '$photo' ");
    confirm($get_photo);
    $row = fetch_array($get_photo);
    return $row['product_image'];
}

function display_item_from_cart(){

    $item_name      = 1;
    $item_number    = 1;
    $amount         = 1;
    $quantity       = 1;

    $query = "SELECT * FROM checkout ";
        $result = query($query);
        confirm($result);
        $count = mysqli_num_rows($result);

        if($count != 0){
            while($row = fetch_array($result)):
            $get_photo = get_photo($row['ck_product_name']);
            $product_image =  image_directory($get_photo);   
            $display = <<<DISPLAY

                <tbody>
                    <tr>
                        <td>{$row['ck_product_name']}<br>
                        <img src="../resources/$product_image" alt="" width="100" height="50"></td>
                        <td>&#36;{$row['ck_product_price']}</td>
                        <td>{$row['ck_product_quantity']}</td>
                        <td>&#36;{$row['ck_product_total']}</td>
                        <td><a id='remove' class='btn btn-warning' href="checkout.php?remove={$row['ck_product_id']}"><span class='glyphicon glyphicon-minus'></span></a> <a class='btn btn-info' href="checkout.php?add={$row['ck_product_id']}"><span class='glyphicon glyphicon-plus'></span></a> <a class='btn btn-danger' href='checkout.php?delete={$row['ck_product_id']}'><span class='glyphicon glyphicon-remove'></span></a></td>
                    </tr>

                        <input type="hidden" name="item_name_{$item_name}" value="{$row['ck_product_name']}">
                        <input type="hidden" name="item_number_{$item_number}" value="{$row['ck_product_id']}">
                        <input type="hidden" name="amount_{$amount}" value="{$row['ck_product_price']}">
                        <input type="hidden" name="quantity_{$quantity}" value="{$row['ck_product_quantity']}">

                </tbody>
DISPLAY;

            $item_name++;
            $item_number++;
            $amount++;
            $quantity++;

        echo $display;

            endwhile;

        }
        
}

    // DISPLAY PAYPAL BUTTON

function paypal_button(){
    $query = query("SELECT * FROM checkout ");
    confirm($query);
    $count = mysqli_num_rows($query);
    $paypal = "";
    if($count != 0){
        $paypal = <<<PP
            <input type="image" name="upload" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
PP;

    echo $paypal;
    }else{
        return;
    }
}



function display_cart_totals(){
    $query = "SELECT ck_product_quantity, ck_product_total FROM checkout ";
    $result = query($query);
    confirm($result);
    $quantity_total = 0;
    $price_total = 0;
    while($row = fetch_array($result)){
        $quantity_total = $quantity_total + $row['ck_product_quantity'];
        $price_total = $price_total + $row['ck_product_total'];
    }
    $display_total = <<<DISPLAY
    <tbody>

      <tr class="cart-subtotal">
        <th>Items:</th>
        <td><span class="amount">{$quantity_total}</span></td>
      </tr>

      <tr class="shipping">
        <th>Shipping and Handling</th>
        <td>Free Shipping</td>
      </tr>

      <tr class="order-total">
        <th>Order Total</th>
        <td><strong><span class="amount">&#36;{$price_total}</span></strong></td>
      </tr>

    </tbody>
DISPLAY;

echo $display_total;

}

function delete_item_from_cart(){

    if(isset($_GET['delete'])){

        $id = $_GET['delete'];

        $delete = query("DELETE FROM checkout WHERE ck_product_id = " . escape_string($id) . " ");
        confirm($delete);
        header("Location: checkout.php");
        exit();//Terminates execution of the script.
    }
}

function remove_item_from_cart(){

    if(isset($_GET['remove'])){
        $id = escape_string($_GET['remove']);

        $select_quantity = query("SELECT * FROM checkout WHERE ck_product_id = '{$id}' ");
        confirm($select_quantity);
        $row = fetch_array($select_quantity);
        $quantity_count = $row['ck_product_quantity'];
        $sub_price = $row['ck_product_price'];

        if($quantity_count > 1 ){
            $quantity_count--;
            $price = $quantity_count * $sub_price;
            $remove = query("UPDATE checkout SET ck_product_quantity = '{$quantity_count}', ck_product_total = '{$price}' WHERE ck_product_id = '{$id}' ");
            confirm($remove);
        }else{
            $remove = query("DELETE FROM checkout WHERE ck_product_id = '{$id}' ");
            confirm($remove);
        }
        header("Location: checkout.php");
        exit();
    }
}

function add_more_item(){
    if(isset($_GET['add'])){
        $id = escape_string($_GET['add']);

        $select_quantity = query("SELECT * FROM checkout WHERE ck_product_id = '{$id}' ");
        confirm($select_quantity);
        $row = fetch_array($select_quantity);
        $quantity_count = $row['ck_product_quantity'];
        $sub_price = $row['ck_product_price'];

        if($quantity_count < 5){
            $quantity_count++;
            $price = $quantity_count * $sub_price;
            $add = query("UPDATE checkout SET ck_product_quantity = '{$quantity_count}', ck_product_total = '{$price}' WHERE ck_product_id = '{$id}' ");
            confirm($add);
            header("Location: checkout.php");
            exit();
        }
    }
}




/*---------------------------------------------BACK END FUNCTIONS---------------------------------------------*/

function display_admin(){

    if(isset($_GET['page'])){
        $page = $_GET['page'];
        }else{
            $page = " ";
        }

        switch ($page) {
            case 'orders':
                include(TEMPLATE_BACK . DS . "orders.php");
                break;

            case 'view_products':
                include(TEMPLATE_BACK . DS . "products.php");
                break;

            case 'add_product':
                include(TEMPLATE_BACK . DS . "add_product.php");
                break;

            case 'edit_product':
                include(TEMPLATE_BACK . DS . "edit_product.php");
                break;

            case 'view_cat':
                include(TEMPLATE_BACK . DS . "categories.php");
                break;

            case 'view_users':
                include(TEMPLATE_BACK . DS . "users.php");
                break;

            case 'add_user':
                include(TEMPLATE_BACK . DS . "add_user.php");
                break;

            case 'edit_user':
                include(TEMPLATE_BACK . DS . "edit_user.php");
                break;

            case 'logout':
                include(TEMPLATE_BACK . DS . "logout.php");
                break;

            default:
                include(TEMPLATE_BACK . DS . "admin_content.php");
                break;
        }
}


function display_orders(){

    $display = query("SELECT * FROM checkout ");
    confirm($display);
    while($row = fetch_array($display)):
        $product_id = $row['ck_product_id'];
        $display_items = <<<DISPLAY
        <tbody>
            <tr>
                <td>{$row['ck_product_id']}</td>
                <td>{$row['ck_id']}</td>
                <td>{$row['ck_product_name']}</td>
                <td>{$row['ck_product_quantity']}</td>
                <td>{$row['ck_product_price']}</td>
                <td>{$row['ck_product_total']}</td>
                <td>{$row['ck_product_status']}</td>
                <td><a rel='$product_id' href='javascript:void(0)' class= 'btn btn-danger delete_link'><span class="glyphicon glyphicon-remove"></span></a></td>            
            </tr>
        </tbody>
DISPLAY;

echo $display_items;

endwhile;
}

function delete_orders(){
    if(isset($_GET['delete'])){
        $delete = query("DELETE FROM checkout WHERE ck_product_id = " . escape_string($_GET['delete']) . " ");
        confirm($delete);
        header("Location: index.php?page=orders");
    }
}

// ---------------------------------------------ADMIN PRODUCTS FUNCTIONS----------------------------------------------

/*Get the right directory of the photo for later uses*/
function image_directory($photo){
    return "images" . DS .$photo;
}

/*Function helps display all products in Admin page*/
function admin_get_products(){
    
    $get_products = query("SELECT * FROM products INNER JOIN categories ON products.product_category_id = categories.cat_id");
    confirm($get_products);
    while($row = fetch_array($get_products)):
        $id = $row['product_id'];
        $product_image = image_directory($row['product_image']);

        //Using heredoc syntax to asign a string to a variable

        $product = <<<INFO
        <tbody>

          <tr>
                <td>{$row['product_id']}</td>
                <td>{$row['product_title']}<br>
                  <img src="../../resources/$product_image" alt="" width="100" height="50">
                </td>
                <td>{$row['cat_title']}</td>
                <td>{$row['product_price']}</td>
                <td>{$row['product_status']}</td>
                <td><a class='btn btn-primary' href='index.php?page=edit_product&id={$id}'><span class='glyphicon glyphicon-edit'></span></a> <a rel='$id' href='javascript:void(0)' class='btn btn-danger delete_product'><span class='glyphicon glyphicon-remove'></span></a></td>
            </tr>
                  
        </tbody>
INFO;

echo $product;

    endwhile;
}

function admin_delete_products(){
    if(isset($_GET['delete'])){
        $delete = query("DELETE FROM products WHERE product_id = " . escape_string($_GET['delete']) . " ");
        confirm($delete);
        header("Location: index.php?page=view_products");
    }
}

/*Function helps display a list of categories when adding product*/

function display_product_categories(){
    $select = query("SELECT * FROM categories");
    confirm($select);
    while($row = fetch_array($select)):
        $display = <<<DISPLAY
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DISPLAY;
echo $display;
endwhile;
}

/*Function helps display a list of brands when adding product*/

function display_product_brands(){
    $select = query("SELECT * FROM brand");
    confirm($select);
    while($row = fetch_array($select)):
        $display = <<<DISPLAY
        <option value="{$row['brand_title']}">{$row['brand_title']}</option>
DISPLAY;
echo $display;
endwhile;
}


/*Function dealing with editting or adding product*/

function admin_add_product(){
    if(isset($_POST['publish']) || isset($_POST['draft'])){

        $product_title       = escape_string($_POST['product_title']);
        $product_description = escape_string($_POST['product_description']);
        $short_desc          = escape_string($_POST['short_desc']);
        $product_quantity    = escape_string($_POST['product_quantity']);
        $product_price       = escape_string($_POST['product_price']);
        $product_category_id = escape_string($_POST['product_category']);
        $product_brand       = escape_string($_POST['product_brand']);
        $product_tags        = escape_string($_POST['product_tags']);
        $product_status      = isset($_POST['publish'])? $product_status = "Published" : $product_status = "Draft";
        $product_image       = $_FILES['file']['name'];
        $tmp_product_image   = $_FILES['file']['tmp_name'];

        // Work out the file extension
        $file_error = $_FILES['file']['error'];
        $file_ext = explode('.', $product_image);
        $file_ext = strtolower(end($file_ext));
        $allowed  = array('jpg','jpeg','png');
        if(in_array($file_ext, $allowed)){
            if($file_error === 0){

                /*Generate unique file name in case user uploads files with the same name*/
                $file_name_new = uniqid('',true) . '.' . $file_ext;

                $path = '../../resources/images/' . $file_name_new;
                move_uploaded_file($tmp_product_image, $path);
            }
        }else{
            echo "<h3>The uploaded image is not supported. Please choose the right one!</h3>";
            return;
        }

            $add  = "INSERT INTO products(product_title, product_brand, product_category_id, product_tags, product_quantity, product_price, short_desc, product_description, product_image, product_status) ";
            $add .= "VALUES('{$product_title}', '{$product_brand}', '{$product_category_id}', '{$product_tags}', '{$product_quantity}', '{$product_price}', '{$short_desc}', '{$product_description}', '{$file_name_new}', '{$product_status}') ";
            $result = query($add);
            confirm($result);
    }
}



function edit_product(){

    if(isset($_POST['update_product'])){
        $product_title       = escape_string($_POST['product_title']);
        $product_description = escape_string($_POST['product_description']);
        $short_desc          = escape_string($_POST['short_desc']);
        $product_quantity    = escape_string($_POST['product_quantity']);
        $product_price       = escape_string($_POST['product_price']);
        $product_category_id = escape_string($_POST['product_category']);
        $product_brand       = escape_string($_POST['product_brand']);
        $product_tags        = escape_string($_POST['product_tags']);
        $product_status      = escape_string($_POST['product_status']);
        $product_image       = $_FILES['file']['name'];
        $tmp_product_image   = $_FILES['file']['tmp_name'];

        /*Check to see if file is uploaded*/

        if(!is_uploaded_file($_FILES['file']['tmp_name'])){
            $get_image = query("SELECT product_image FROM products WHERE product_id = " . escape_string($_GET['id']) . " ");
            confirm($get_image);
            $row = fetch_array($get_image);
            $product_image = $row['product_image'];
        }else{

            // Work out the file extension
            $file_error = $_FILES['file']['error'];
            $file_ext = explode('.', $product_image);
            $file_ext = strtolower(end($file_ext));
            $allowed  = array('jpg','jpeg','png');

            if(in_array($file_ext, $allowed)){
                if($file_error === 0){

                    /*Generate unique file name in case user uploads files with the same name*/
                    $product_image = uniqid('',true) . '.' . $file_ext;

                    $path = '../../resources/images/' . $product_image;
                    move_uploaded_file($tmp_product_image, $path);
                }

            }else{
                echo "<h3>The uploaded image is not supported. Please choose the right one!</h3>";
                return;
        }

        }

        $update   = "UPDATE products SET ";
        $update  .= "product_title       = '{$product_title}', ";
        $update  .= "product_brand       = '{$product_brand}', ";
        $update  .= "product_category_id = '{$product_category_id}', ";
        $update  .= "product_tags        = '{$product_tags}', ";
        $update  .= "product_quantity    = '{$product_quantity}', ";
        $update  .= "product_price       = '{$product_price}', ";
        $update  .= "short_desc          = '{$short_desc}', ";
        $update  .= "product_description = '{$product_description}', ";
        $update  .= "product_image       = '{$product_image}', ";
        $update  .= "product_status      = '{$product_status}' ";
        $update  .= "WHERE product_id    = " . escape_string($_GET['id']) . " ";
        
        $result = query($update);
        confirm($result);
}
}

/*DEALING WITH CATEGORIES*/

function display_categories(){
    $display = query("SELECT * FROM categories");
    confirm($display);
    while($row = fetch_array($display)):

        $cat_id    = $row['cat_id'];
        $cat_title = $row['cat_title'];

        $dp = <<<DISPLAY
            <tbody>
                <tr>
                    <td>{$cat_id}</td>
                    <td>{$cat_title}</td>
                    <td><a rel='$cat_id' href='javascript:void(0)' class='btn btn-danger delete_categories'><span class='glyphicon glyphicon-remove'></span></a></td>
                </tr>
            </tbody>
DISPLAY;

echo $dp;
endwhile;
}


function add_category(){
    if(isset($_POST['submit'])){
        $cat_title = escape_string($_POST['cat_title']);
        echo $cat_title;
        $add = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}')");
        confirm($add);
    }
}

function delete_category(){
    if(isset($_GET['delete'])){
        $delete = query("DELETE FROM categories WHERE cat_id = " . escape_string($_GET['delete']) . " ");
        confirm($delete);
        header("Location: index.php?page=view_cat");
    }
}


/*DEALING WITH USERS*/

function display_users(){
    $display = query("SELECT * FROM users");
    confirm($display);
    while($row = fetch_array($display)):

        $user_id        = $row['user_id'];
        $username       = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname  = $row['user_lastname'];
        $user_role      = $row['user_role'];

        $dp = <<<DISPLAY
                <tr>
                    <td>{$user_id}</td>
                    <td>{$username}</td>
                    <td>{$user_firstname}</td>
                    <td>{$user_lastname}</td>
                    <td><a rel='$user_id' href='javascript:void(0)' class='btn btn-danger delete_users'><span class='glyphicon glyphicon-remove'></span></a></td>
                </tr>
DISPLAY;

echo $dp;
endwhile;
}

function delete_users(){
    if(isset($_GET['delete'])){
        $delete = query("DELETE FROM users WHERE user_id = " . escape_string($_GET['delete']) . " ");
        confirm($delete);
        header("Location: index.php?page=view_users");
    }
}


function add_users(){
    if(isset($_POST['add_user'])){
        $username       = escape_string($_POST['username']);
        $firstname      = escape_string($_POST['firstname']);
        $lastname       = escape_string($_POST['lastname']);
        $user_email     = escape_string($_POST['user_email']);
        $user_password  = escape_string($_POST['user_password']);
        $user_role      = escape_string($_POST['user_role']);

        /*Check to see if username is already registered*/
        $check = query("SELECT username FROM users WHERE username = '{$username}' ");
        confirm($check);
        $count = mysqli_num_rows($check);
        if($count != 0){
            echo "This username is already taken. Please choose another one!";
            return;
        }

        /*Processing password*/

        $user_password  = password_hash($user_password, PASSWORD_BCRYPT, array('cost',12));

        $user_image     = $_FILES['file']['name'];
        $tmp_user_image = $_FILES['file']['tmp_name'];

        $file_error = $_FILES['file']['error'];
        $file_ext = explode('.', $user_image);
        $file_ext = strtolower(end($file_ext));
        $allowed  = array('jpg','jpeg','png');

        if(in_array($file_ext, $allowed)){
            if($file_error === 0){
                $file_name_new = uniqid('',true) . '.' . $file_ext;

                $path = '../../resources/images/' . $file_name_new;
                move_uploaded_file($tmp_user_image, $path);
            }
        }else{
            echo "<h3>The uploaded image is not supported. Please choose the right one!</h3>";
            return;
        }

            $add  = "INSERT INTO users(username, user_firstname, user_lastname, user_password, user_email, user_role, user_avatar) ";
            $add .= "VALUES('{$username}', '{$firstname}', '{$lastname}', '{$user_password}', '{$user_email}', '{$user_role}', '{$file_name_new}') ";
            $result = query($add);
            confirm($result);

    }
}
?>
