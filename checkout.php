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
<header>
    <h1 align="center" ;>IT Shop</h1>
</header>
<nav>
    <a href="index.html">ShopIT</a>
    <a href="products.php">Products</a>
    <a href="aboutus.html">About Us</a>
    <a href="contactus.html">Contact Us</a>
    <a href="cart.php">Cart <?php
                            echo count($_SESSION['cart']); ?> items.</a>
    <a href="login.php">Login</a>
</nav>

<body>
    <?php

    if (!isset($_SESSION['User'])) {
        echo "Please login before ordering"; //if no session login then dont allow ordering
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

    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        for ($j = 0; $j < count($_SESSION['cart']); $j++) { // check every element in cart if it matches Product ID.
            if ($row['productid'] == $_SESSION['cart'][$j]) { // Define variables only if PID is contained in cart
                $product_id[] = $row['productid'];
                $product_src[] = $row['product_img_path'];
                $product_name[] = $row['product_name'];
                $product_price[] = $row['product_price'];
            }
        }
    }


    // Update database. Need to get loginid. Only have username based on session id so query DB for loginid. Or just yolo use username????

    //select userid based on username from session
    $query = "SELECT * from login";
    $result = $db->query($query);
    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($_SESSION['User'] == $row['username']) {
            $login_id = $row['loginid'];
        }
    }


    //select login.username, orders.orderid,orders.amount from login,orders where login.loginid=orders.loginid

    for ($i = 0; $i < count($_SESSION['cart']); $i++) { //need loginid from session but session only has username
        $query = "INSERT into orders values 
        ('','" . $login_id . "','" . $product_id[$i] . "','" . $product_price[$i] . "') ";
        $db->query($query);
    }





    $db->close();
    ?>
    <div>The following items have been ordered: </div> <!--send email????-->

    <?php for ($i = 0; $i < count($product_id); $i++) { //only stuff that has been added to cart is defined. So just display everything that is defined
                    echo "<p>" . $product_name[$i] . "</p>";
                }
    unset($_SESSION['cart']); //clear cart after buying
    ?>
<?php
}
?>

</body>

<footer>
    <small><i>Copyright &copy; 2014 JavaJam Coffee House<br><a href="mailto:zhengying@ong.com">zhengying@ong.com</a>
        </i></small>
</footer>

</html>