<?php //catalog.php

/*Connect to DB */
require_once('connection.php');
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
    //If click on category, filter out stuff based on category. Else show default 3 products
    $query = "SELECT products.productid,products.product_img_path,products.product_name,products.product_price,products.quantity, orders.productid,count(orders.productid) as total_sold  from orders, products where orders.productid=products.productid group by orders.productid order by total_sold desc";
    session_start();




    $result = $db->query($query);
    //need to define all these arrays so that will have no errors if its empty
    $product_id = array();
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

    ?>

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
                                if (isset($_SESSION['cart'])) {
                                    echo count($_SESSION['cart']);
                                } else{
                                    echo 0;
                                }
                                 ?> items</a>
            </li>
            <li>
                <a href="login.php">Login</a>
            </li>
        </ul>
    </nav>
    <div class="wrapperadmin">
        <?php
        $query = "SELECT products.productid,products.product_img_path,products.product_name,products.product_price,products.quantity, orders.productid,count(orders.productid) as total_sold  from orders, products where orders.productid=products.productid group by orders.productid order by total_sold desc";
        $result = $db->query($query);
        //need to define all these arrays so that will have no errors if its empty
        $product_id = array();
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
            $product_total_sold[] = $row['total_sold'];
        }
        ?>

<div class="wrappercart" align="center">

<table id="contentcolor" border="1">
    <thead>
        <tr>
            <th colspan="3">Sales report</th>
        </tr>
        <tr>
            <th>Item Description</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        for ($i = 0; $i < count($product_id); $i++) { //Display based on product_id_sold
            echo "<tr>";
            echo "<td>" . $product_name[$i] . "</td>"; // need to display name based on product id
            echo "<td>" . $product_total_sold[$i] . "</td>";
            echo "<td align='right'>$";
            echo number_format($product_total_sold[$i] * $product_price[$i], 2) . "</td>"; // need to display price based on product id
        }
        foreach ($product_price as $value) {
            $total += $value;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th align='right'>Total:</th><br>
            <th align='right'>$<?php echo number_format($total, 2); ?>
            </th>
        </tr>
    </tfoot>
</table>
<div class="checkout">

</div>

    </div>
    </div>
    <footer>
        <small><i>Copyright &copy; 2020 SHOPIT<br><a href="mailto:zhengying@ong.com">zhengying@ong.com</a>
            </i></small>
    </footer>
</body>

</html>