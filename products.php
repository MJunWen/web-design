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
        if ($_SESSION['category'] == "hot sales") {
            $query = "SELECT products.productid,products.product_img_path,products.product_name,products.product_price,products.quantity, orders.productid,count(orders.productid) as total_sold  from orders, products where orders.productid=products.productid group by orders.productid order by total_sold desc";
        } else {
            $query = "SELECT * from products where category= '" . $_SESSION['category'] . "'";
        }
    } else { //If click on category, filter out stuff based on category. Default just load everything
        /*Fetch prices from DB and updates the prices on the website on load/refresh. */
        $query = "SELECT * from products";
    }

    $result = $db->query($query);
    //need to define all these arrays so that will have no errors if its empty
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
        $product_quantity_assoc[$product_id[$i]] = $row['quantity']; //make an associative array of key = productid, value = quantity so can get quantity based on product id 
    }

    //change page = change the index of array to display
    $firstproductindex = 0;
    $secondproductindex = 1;
    $thirdproductindex = 2;

    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 1:
                $firstproductindex = 0;
                $secondproductindex = 1;
                $thirdproductindex = 2;
                break;
            case 2:
                $firstproductindex = 3;
                $secondproductindex = 4;
                $thirdproductindex = 5;
                break;
            case 3:
                $firstproductindex = 6;
                $secondproductindex = 7;
                $thirdproductindex = 8;
                break;
            default:
        }
    }
    
    //cumulative quantity of items in cart eg productid 4 has 5 quantity sold,  4 => '5' ,productid 1 has 3 quantity sold, 1 => '3'
    $quantityarray = array_count_values($_SESSION['cart']); //store in assoc array with key=productid value=count(productid)
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
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=hot sales">Hot sales</a></p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=keyboard">Keyboard</a></p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=Mouse">Mouse</a></p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=USB">USB</a></p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?product=Mobile Phone">Mobile Phone</a></p>
        </div>
        <div class="rightcolumn">

            <!--fill from left to right, down 1 row, left to right repeat-->

            <div class="productimg">
                <?php if (isset($product_src[$firstproductindex])) {
                    echo "<img src='" . $product_src[$firstproductindex] . "'>";
                } ?>
            </div>
            <div class="productimg">
                <?php if (isset($product_src[$secondproductindex])) {
                    echo "<img src='" . $product_src[$secondproductindex] . "'>";
                } ?>
            </div>
            <div class="productimg">
                <?php if (isset($product_src[$thirdproductindex])) {
                    echo "<img src='" . $product_src[$thirdproductindex] . "'>";
                } ?>
            </div>

            <div class="productname">
                <?php if (isset($product_name[$firstproductindex])) {
                    echo "$product_name[$firstproductindex]";
                } ?>
            </div>
            <div class="productname">
                <?php if (isset($product_name[$secondproductindex])) {
                    echo "$product_name[$secondproductindex]";
                } ?>
            </div>
            <div class="productname">
                <?php if (isset($product_name[$thirdproductindex])) {
                    echo "$product_name[$thirdproductindex]";
                } ?>
            </div>

            <div class="productprice">
                <?php if (isset($product_price[$firstproductindex])) {
                    echo "$$product_price[$firstproductindex]";
                } ?>
            </div>
            <div class="productprice">
                <?php if (isset($product_price[$secondproductindex])) {
                    echo "$$product_price[$secondproductindex]";
                } ?>
            </div>
            <div class="productprice">
                <?php if (isset($product_price[$thirdproductindex])) {
                    echo "$$product_price[$thirdproductindex]";
                } ?>
            </div>

            <div class="addtocart">
            <?php if (isset($product_id[$firstproductindex])) { //check if theres a product to show, else do nothing
                    if ((isset($product_quantity_assoc[$product_id[$firstproductindex]]) && isset($quantityarray[$product_id[$firstproductindex]]))) { //check if the 2 arrays are set. If not set, will have error
                        if (($product_quantity_assoc[$product_id[$firstproductindex]] - $quantityarray[$product_id[$firstproductindex]]) <= 0) { //if 2 arrays are set, check if quantity(db) - quantity(cart) <=0
                            echo "<a>Sold out</a>";
                        } else { //if 2 arrays set but quantity >0, show buy
                            echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$firstproductindex] . "'>Buy</a><br>";
                            echo "$product_quantity[$firstproductindex] remaining";
                        }
                    } else { //if 2 arrays not set, check quantity(db) if <=0)
                        if (($product_quantity[$firstproductindex] <= 0)) {
                            echo "<a>Sold out</a>";
                        } else { //if 2 arrays not set, and quantity(db)>0, show buy
                            echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$firstproductindex] . "'>Buy</a><br>";
                            echo "$product_quantity[$firstproductindex] remaining";
                        }
                    }
                } ?>
            </div>

            <div class="addtocart">
            <?php if (isset($product_id[$secondproductindex])) {
                    if ((isset($product_quantity_assoc[$product_id[$secondproductindex]]) && isset($quantityarray[$product_id[$secondproductindex]]))) {
                        if (($product_quantity_assoc[$product_id[$secondproductindex]] - $quantityarray[$product_id[$secondproductindex]]) <= 0) {
                            echo "<a>Sold out</a>";
                        } else {
                            echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$secondproductindex] . "'>Buy</a><br>";
                            echo "$product_quantity[$secondproductindex] remaining";
                        }
                    } else {
                        if (($product_quantity[$secondproductindex] <= 0)) {
                            echo "<a>Sold out</a>";
                        } else {
                            echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$secondproductindex] . "'>Buy</a><br>";
                            echo "$product_quantity[$secondproductindex] remaining";
                        }
                    }
                } ?>
            </div>

            <div class="addtocart">
                <?php if (isset($product_id[$thirdproductindex])) {
                    if ((isset($product_quantity_assoc[$product_id[$thirdproductindex]]) && isset($quantityarray[$product_id[$thirdproductindex]]))) {
                        if (($product_quantity_assoc[$product_id[$thirdproductindex]] - $quantityarray[$product_id[$thirdproductindex]]) <= 0) {
                            echo "<a>Sold out</a>";
                        } else {
                            echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$thirdproductindex] . "'>Buy</a><br>";
                            echo "$product_quantity[$thirdproductindex] remaining";
                        }
                    } else {
                        if (($product_quantity[$thirdproductindex] <= 0)) {
                            echo "<a>Sold out</a>";
                        } else {
                            echo " <a href='" . $_SERVER['PHP_SELF'] . '?buy=' . $product_id[$thirdproductindex] . "'>Buy</a><br>";
                            echo "$product_quantity[$thirdproductindex] remaining";
                        }
                    }
                } ?>
            </div>

            <div class="pagenumber">
                <?php
                $pagecount = count($product_id);
                $i=1;
                while ($pagecount % 3 != 0) {
                    echo " <a href='" . $_SERVER['PHP_SELF'] . '?page=' . $i . "'>$i</a>";
                    $pagecount /= 3;
                    $i++;
                }
<<<<<<< HEAD
=======
                // for (;$pagecount>=0;$pagecount/=3) {
                //     echo " <a href='" . $_SERVER['PHP_SELF'] . '?page=' . $i . "'>1</a>";
                // }
>>>>>>> 5afddac5a72a19c729e3e4f31bfcdc6156c7a55d
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