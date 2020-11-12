<?php
$to      = 'f37ee@localhost';
$subject = $_POST['subject'];
$message = $_POST['description'];
$headers = 'From:' . $_POST['email'] . "\r\n" .
    'Reply-To: f37ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers,'-ff37ee@localhost');

?> 

<html>
<link rel="stylesheet" href="styles.css">
<script type = "text/javascript" src = "checkSubmission.js"></script>
<script type = "text/javascript" src = "textarea.js"></script>
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
    <form method="post" action="email.php">
    <div class="wrapperindex" align="center" justify="center">
			<div class="formstyle">
                <h2>Your enquiry has been submitted.</h2> 
			</div>
    </div>
    </form>
	

</body>

<footer>
    <small><i>Copyright &copy; 2020 SHOPIT<br><a href="mailto:zhengying@ong.com">zhengying@ong.com</a>
        </i></small>
</footer>
<script type = "text/javascript" src = "checkSubmission2.js"></script>
</html>
