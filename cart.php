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
        // ${"product_src_" .$i} = $row['product_img_path']; //variable varaibles work but online say not reccommended to use it so use array instead
        // ${"product_name_" .$i} = $row['product_name'];
        // ${"product_price_" .$i} = $row['product_price'];
    }
    $db->close();
    ?>
    <h1 align="center">Your Shopping Cart </h1>
    <div class="wrappercart" align="center">

        <table border="1">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                for ($i = 0; $i < count($product_id); $i++) { //only stuff that has been added to cart is defined. So just display everything that is defined
                    echo "<tr>";
                    echo "<td>" . $product_name[$i] . "</td>";
                    echo "<td align='right'>$";
                    echo number_format($product_price[$i], 2) . "</td>";
                }
                foreach ($product_price as $value) {
                    $total += $value;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th align='right'>Total:</th><br>
                    <th align='right'>$<?php echo number_format($total, 2); ?>
                    </th>
                </tr>
            </tfoot>
        </table>
        <p><a href="products.php">Continue Shopping</a> or
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?empty=1">Empty your cart</a></p>

        <p>
            <form method="post" id="checkout" action="checkout.php">
                <input type="submit" name="dollarsales" class="button" value="Checkout" style="display:inline;" />
            </form>
        </p>

    </div>

</body>

<footer>
    <small><i>Copyright &copy; 2014 JavaJam Coffee House<br><a href="mailto:zhengying@ong.com">zhengying@ong.com</a>
        </i></small>
</footer>

</html>