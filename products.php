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
if (isset($_GET['product'])) { //put category into session so can change page while keeping the same category
    $_SESSION['category'] = $_GET['product'];
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

    if (isset($_SESSION['category'])) {
        $query = "SELECT * from products where category= '" . $_SESSION['category'] . "'";

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
                $firstproductnumber = 0;
                $secondproductnumber = 1;
                $thirdproductnumber = 2;

    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 1:
                $firstproductnumber = 0;
                $secondproductnumber = 1;
                $thirdproductnumber = 2;
                break;
            case 2:
                $firstproductnumber = 3;
                $secondproductnumber = 4;
                $thirdproductnumber = 5;
                break;
            case 3:
                $firstproductnumber = 6;
                $secondproductnumber = 7;
                $thirdproductnumber = 8;
                break;
            default:
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
                <?php if (isset($product_src[$firstproductnumber])) {
                    echo "<img src='" . $product_src[$firstproductnumber] . "'>";
                } ?>
            </div>
            <div class="productimg">
                <?php if (isset($product_src[$secondproductnumber])) {
                    echo "<img src='" . $product_src[$secondproductnumber] . "'>";
                } ?>
            </div>
            <div class="productimg">
                <?php if (isset($product_src[$thirdproductnumber])) {
                    echo "<img src='" . $product_src[$thirdproductnumber] . "'>";
                } ?>
            </div>

            <div class="productname">
                <?php if (isset($product_name[$firstproductnumber])) {
                    echo "$product_name[$firstproductnumber]";
                } ?>
            </div>
            <div class="productname">
                <?php if (isset($product_name[$secondproductnumber])) {
                    echo "$product_name[$secondproductnumber]";
                } ?>
            </div>
            <div class="productname">
                <?php if (isset($product_name[$thirdproductnumber])) {
                    echo "$product_name[$thirdproductnumber]";
                } ?>
            </div>

            <div class="productprice">
                <?php if (isset($product_price[$firstproductnumber])) {
                    echo "$$product_price[$firstproductnumber]";
                } ?>
            </div>
            <div class="productprice">
                <?php if (isset($product_price[$secondproductnumber])) {
                    echo "$$product_price[$secondproductnumber]";
                } ?>
            </div>
            <div class="productprice">
                <?php if (isset($product_price[$thirdproductnumber])) {
                    echo "$$product_price[$thirdproductnumber]";
                } ?>
            </div>

            <div class="addtocart">
                <?php if (isset($product_id[$firstproductnumber])) {
                    if ($product_quantity[$firstproductnumber] <= 0) {
                        echo "<a>Sold out</a>";
                    } else {
                        echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$firstproductnumber] . "'>Buy</a>";
                    }
                } ?>
            </div>

            <div class="addtocart">
                <?php if (isset($product_id[$secondproductnumber])) {
                    if ($product_quantity[$secondproductnumber] <= 0) {
                        echo "<a>Sold out</a>";
                    } else {
                        echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$secondproductnumber] . "'>Buy</a>";
                    }
                } ?>
            </div>

            <div class="addtocart">
                <?php if (isset($product_id[$thirdproductnumber])) {
                    if ($product_quantity[$thirdproductnumber] <= 0) {
                        echo "<a>Sold out</a>";
                    } else {
                        echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$thirdproductnumber] . "'>Buy</a>";
                    }
                } ?>
            </div>

            <div class="pagenumber">
                <?php
                 echo " <a href='" . $_SERVER['PHP_SELF'] . '?page=' . 1 . "'>1</a>"; 
                 echo " <a href='" . $_SERVER['PHP_SELF'] . '?page=' . 2 . "'>2</a>";
                 echo " <a href='" . $_SERVER['PHP_SELF'] . '?page=' . 3 . "'>3</a>"; 
                ?>
            </div>

        </div>
    </div>
    <footer>
        <small><i>Copyright &copy; 2014 JavaJam Coffee House<br><a href="mailto:zhengying@ong.com">zhengying@ong.com</a>
            </i></small>
    </footer>
</body>

</html>