<?php  //cart.php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_GET['empty'])) {
    unset($_SESSION['cart']);
    header('location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>
<html>
<link rel="stylesheet" href="styles.css">

<nav>
    <div class="logo">
        <a href="index.html">ShopIT</a>
    </div>
    <ul class="nav-links">
        <li>
            <a href="products.php">Products</a>
        </li>
        <li>
            <a href="aboutus.html">About Us</a>
        </li>
        <li>
            <a href="contactus.php">Contact Us</a>
        </li>
        <li>
            <a href="cart.php">Cart <?php
                                echo count($_SESSION['cart']); ?> items</a>
        </li>
        <li>
            <a href="login.php">Login</a>
        </li>
    </ul>
</nav>

<body>
    <?php

    if (!isset($_SESSION['User'])) {
        //if no session login then dont allow ordering
        echo '<script type="text/javascript">'; 
        echo 'alert("Please login before ordering!");'; 
        echo 'window.location.href = "login.php";';
        echo '</script>';
    } else {

   
    /*Connect to DB */
    require_once('connection.php');

    /*Fetch items stored in session */
    $query = "SELECT * from products";

    $result = $db->query($query);

    $product_src = array();
    $product_name = array();
    $product_price = array();
    $product_id = array();
    $product_quantity = array();

    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        for ($j = 0; $j < count($_SESSION['cart']); $j++) { // check every element in cart if it matches Product ID.
            if ($row['productid'] == $_SESSION['cart'][$j]) { // Define variables only if PID is contained in cart
                $product_id[] = $row['productid'];
                $product_src[] = $row['product_img_path'];
                $product_name[] = $row['product_name'];
                $product_price[] = $row['product_price'];
                $product_quantity[] = $row['quantity'];
                $product_quantity_assoc[$product_id[$i]] = $row['quantity'];
                $product_name_assoc[$product_id[$i]] = $row['product_name'];
            }
        }
    }


    // Update database. Need to get loginid. Only have username based on session id so query DB for loginid. Or just yolo use username????

    //select userid based on username from session
    $query = "SELECT * from login";
    $result = $db->query($query);
    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($_SESSION['User'] == $row['user']) {
            $login_id = $row['loginid'];
        }
    }

    $quantityarray = array_count_values($product_id); //cumulative quantity of item sold eg 4 => '5' , 1 => '3'
    foreach($quantityarray as $x=>$x_value) {
        $product_id_sold[] = $x; // Stores product id of all items sold in this array in ascending order
        $product_id_quantity_sold[] = $x_value; // quantity of items sold based on product id
    }

    //insert order into orders table
    for ($i = 0; $i < count($_SESSION['cart']); $i++) { //need loginid from session but session only has username
        $query = "INSERT into orders values 
        ('','" . $login_id . "','" . $product_id[$i] . "','" . $product_price[$i] . "') ";
        $db->query($query); 
    }

    //update quantity sold
    for ($i = 0; $i < count($product_id_quantity_sold); $i++) { //need loginid from session but session only has username
        $query = "UPDATE products set quantity = quantity - '".$product_id_quantity_sold[$i]."' where productid='".$product_id_sold[$i]."'"; //update quantity
        $db->query($query); //update quantity from products table //cant do this way because each element in the array is the original value.
    }







    ?>
    <div class="aboutus">A confirmation email has been sent to the following email address:  <!--send email????-->

    <?php       $query = "SELECT * from login";
    $result = $db->query($query);
    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($_SESSION['User'] == $row['user']) {
            $email = $row['email'];
        }
    }
    echo $email;
    
    unset($_SESSION['cart']); //clear cart after buying
    ?>
    </div>
    <?php
$to      = 'f37ee@localhost';
$subject = 'Confirmation Email';
$hi = 'The following items have been ordered:';
for ($i = 0; $i < count($product_id); $i++) {
    $hi .= $product_name_assoc[$product_id[$i]];
    $hi .= $product_quantity_assoc[$product_id[$i]];
};
$message = $hi;
$headers = 'From:' . $email . "\r\n" .
    'Reply-To: f37ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers,'-ff37ee@localhost');

?> 
<?php
}
$db->close();
?>

</body>

<footer>
    <small><i>Copyright &copy; 2020 SHOPIT<br><a href="mailto:zhengying@ong.com">zhengying@ong.com</a>
        </i></small>
</footer>

</html>