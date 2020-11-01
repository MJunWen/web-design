<?php //catalog.php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_GET['buy'])) {
    $_SESSION['cart'][] = $_GET['buy'];
    header('location: ' . $_SERVER['PHP_SELF'] . '?' . SID);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>IT Shop</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php
    /*Connect to DB */
    require_once('connection.php');

    //If click on category, filter out stuff based on category. Else show default 3 products

    if (isset($_GET['product'])) {
        $query = "SELECT * from products where category= '" . $_GET['product'] . "'";

        $result = $db->query($query);

        $product_src = array();
        $product_name = array();
        $product_price = array();
        $product_quantity = array();

        for ($i = 0; $i < $result->num_rows; $i++) {
            $row = mysqli_fetch_assoc($result);
            $product_id[] = $row['productid'];
            $product_src[] = $row['product_img_path'];
            $product_name[] = $row['product_name'];
            $product_price[] = $row['product_price'];
            $product_quantity[] = $row['quantity'];
            // ${"product_src_" .$i} = $row['product_img_path']; //variable varaibles work but online say not reccommended to use it so use array instead
            // ${"product_name_" .$i} = $row['product_name'];
            // ${"product_price_" .$i} = $row['product_price'];
        }
    } else { //If click on category, filter out stuff based on category. Else show default 3 products

        /*Fetch prices from DB and updates the prices on the website on load/refresh. */
        $query = "SELECT * from products";

        $result = $db->query($query);

        $product_src = array();
        $product_name = array();
        $product_price = array();
        $product_quantity = array();

        for ($i = 0; $i < $result->num_rows; $i++) {
            $row = mysqli_fetch_assoc($result);
            $product_id[] = $row['productid'];
            $product_src[] = $row['product_img_path'];
            $product_name[] = $row['product_name'];
            $product_price[] = $row['product_price'];
            $product_quantity[] = $row['quantity'];
        }
    }
    ?>


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
    <div class="wrapper">
        <div class="leftcolumn">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=keyboard">Keyboard</a></p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=Mouse">Mouse</a></p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=USB">USB</a></p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=Mobile Phone">Mobile Phone</a></p>
        </div>
        <div class="rightcolumn">

            <!--fill from left to right, down 1 row, left to right repeat-->

            <div class="productimg">
                <?php if (isset($product_src[0])) {
                    echo "<img src='" . $product_src[0] . "'>";
                } ?>
            </div>
            <div class="productimg">
                <?php if (isset($product_src[1])) {
                    echo "<img src='" . $product_src[1] . "'>";
                } ?>
            </div>
            <div class="productimg">
                <?php if (isset($product_src[2])) {
                    echo "<img src='" . $product_src[2] . "'>";
                } ?>
            </div>

            <div class="productname">
                <?php if (isset($product_name[0])) {
                    echo "$product_name[0]";
                } ?>
            </div>
            <div class="productname">
                <?php if (isset($product_name[1])) {
                    echo "$product_name[1]";
                } ?>
            </div>
            <div class="productname">
                <?php if (isset($product_name[2])) {
                    echo "$product_name[2]";
                } ?>
            </div>

            <div class="productprice">
                <?php if (isset($product_price[0])) {
                    echo "$$product_price[0]";
                } ?>
            </div>
            <div class="productprice">
                <?php if (isset($product_price[1])) {
                    echo "$$product_price[1]";
                } ?>
            </div>
            <div class="productprice">
                <?php if (isset($product_price[2])) {
                    echo "$$product_price[2]";
                } ?>
            </div>

            <div class="addtocart">
                <?php if (isset($product_id[0])) {
                    if ($product_quantity[0] <= 0) {
                        echo "<a>Sold out</a>";
                    } else {
                        echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[0] . "'>Buy1</a>";
                    }
                } ?>
            </div>

            <div class="addtocart">
            <?php if (isset($product_id[1])) {
                    if ($product_quantity[1] <= 0) {
                        echo "<a>Sold out</a>";
                    } else {
                        echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[1] . "'>Buy</a>";
                    }
                } ?>
            </div>

            <div class="addtocart">
            <?php if (isset($product_id[2])) {
                    if ($product_quantity[2] <= 0) {
                        echo "<a>Sold out</a>";
                    } else {
                        echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[2] . "'>Buy</a>";
                    }
                } ?>
            </div>

        </div>
    </div>
    <footer>
        <small><i>Copyright &copy; 2014 JavaJam Coffee House<br><a href="mailto:zhengying@ong.com">zhengying@ong.com</a>
            </i></small>
    </footer>
</body>

</html>