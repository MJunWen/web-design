<!DOCTYPE html>
<html lang="en">
<head>
<title>IT Shop</title>
<meta charset="utf-8">
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class = "box">
			<h1>Welcome</h1>
<div class = "welcomeuser">
<?php
    session_start();
    if(isset($_SESSION['User']))
    {
        echo $_SESSION['User'];
    }
?>
</div>
<form method="post" action="adminchange.php">
              <input type="submit" name="home" id="home" value="Admin Page">
</form>
<form method="post" action="index.html">
              <input type="submit" name="home" id="home" value="Main Page">
</form>
<form method="post" action="logout.php">
			  <input name="logout" id="logout" type="submit" value="Logout">
</form>
</div>

</body>
</html>