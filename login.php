<!DOCTYPE html>
<html lang="en">
<head>
<title>IT Shop</title>
<meta charset="utf-8">
<link rel="stylesheet" href="login.css">
</head>
<body>

<?php
	if(@$_GET['Invalid']==true)
	{
?>
<div class="alert-light text-danger"><?php echo $_GET['Invalid'] ?></div>
<?php
	}
?>

<?php
//If user is already logged in, direct to welcome page
session_start();
if(isset($_SESSION['User']))
{
	header("location:member.php");
} else {
?>
<div class = "box">
<form method="post" action="process.php">
			<h1>Login</h1>
			  <input type="text" name="myUsername" id="myUsername" placeholder="Username" required>
			  
			  <input type="password" name="myPassword" id="myPassword" placeholder="Password" required>
			  <br>
			  <input name="login" id="login" type="submit" value="Login">
</form>			  
<form method="post" action="signup.php">
			  <input name="signup" id="signup" type="submit" value="Register">
</form>
</div>
<?php
}
?>

</body>
</html>