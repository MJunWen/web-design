<!DOCTYPE html>
<html lang="en">
<head>

<?php  //cart.php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>
<title>IT Shop</title>
<meta charset="utf-8">
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
	<h1>IT Shop</h1>
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



<?php
	if(@$_GET['Empty']==true)
	{
?>
<div class="alert-light text-danger"><?php echo $_GET['Empty'] ?></div>
<?php
	}
?>

<?php
	if(@$_GET['Invalid']==true)
	{
?>
<div class="alert-light text-danger"><?php echo $_GET['Invalid'] ?></div>
<?php
	}
?>

<?php
if(isset($_SESSION['User']))
{
	echo 'Welcome ' . $_SESSION['User'].'<br/>';
	echo '<a href="logout.php?logout">Logout</a>';
} else {
?>
<div>
<form method="post" action="process.php">
			  <label for="myUsername">Username:</label>
			  <input type="text" name="myUsername" id="myUsername">
			  <br>
			  <label for="myPassword">Password:</label>
			  <input type="text" name="myPassword" id="myPassword">
			  <br>
			  <input name="login" id="login" type="submit" value="Login">
</form>
</div>
<?php
}
?>
<br>
<br>
<footer>
	<small><i>Copyright &copy; 2014 JavaJam Coffee House<br><a href=
		"mailto:zhengying@ong.com">zhengying@ong.com</a>
	</i></small>
</footer>
</body>
</html>