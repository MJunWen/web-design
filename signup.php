<!DOCTYPE html>
<html lang="en">
<head>
<title>IT Shop</title>
<meta charset="utf-8">
<link rel="stylesheet" href="login.css">
<script type = "text/javascript" src = "checkSubmission.js"></script>
</head>
<body>

<?php
include "connection.php";
if (isset($_POST['signup'])){
    if(empty($_POST['newUser']) || empty($_POST['newPass']) || empty($_POST['newPass2'])){
            echo 'All records need to be filled up!';
        } else {
        $username = $_POST['newUser'];
        $password = $_POST['newPass'];
        $password2 = $_POST['newPass2'];
        $email = $_POST['myEmail'];
        //Check if passwords match
        if ($password != $password2){
            echo '<script type="text/javascript">'; 
            echo 'alert("Passwords do not match!");'; 
            echo 'window.location.href = "login.php";';
            echo '</script>';
            exit();
        }
        //Check if user already exists
        $user_check_query = "SELECT * FROM login WHERE user='$username'";
        $resultt = mysqli_query($db,$user_check_query);
        $userr = mysqli_fetch_assoc($resultt);
        if ($userr) {
            if($userr['user'] === $username){
                echo '<script type="text/javascript">'; 
                echo 'alert("Username already exists!");'; 
                echo 'window.location.href = "signup.php";';
                echo '</script>';
                exit();
            }
        }

        //Calculate the MD5 hash of password
        $password = md5($password);
        $query = "INSERT INTO login (user, pass, email) VALUES ('$username', '$password','$email')";
        $result = mysqli_query($db,$query);
        
        if(!$result){
            echo '<script type="text/javascript">'; 
            echo 'alert("Your query failed! Please try again.");'; 
            echo 'window.location.href = "login.php";';
            echo '</script>';
        }
        else{
            echo '<script type="text/javascript">'; 
            echo 'alert("You are now registered!");'; 
            echo 'window.location.href = "login.php";';
            echo '</script>';
        }
    }
}
?>

<div class = "box">
<form method="post" action="signup.php">
			<h1>Register</h1>
			  <input type="text" name="newUser" id="newUser" placeholder="Username">
			  
			  <input type="password" name="newPass" id="newPass" placeholder="Password">
              
              <input type="password" name="newPass2" id="newPass2" placeholder="Re-enter Password">
<<<<<<< HEAD

              <input type="email" name="myEmail" id="myEmail" placeholder="Email" required>
=======
>>>>>>> e88572dbed14185309dbb5535d25c8c3bf152bea
              
			  <br>
			  <input name="signup" id="signup" type="submit" value="Register">
</form>
</div>

</body>
<<<<<<< HEAD
<script type = "text/javascript" src = "checkSubmission2.js"></script>
=======
>>>>>>> e88572dbed14185309dbb5535d25c8c3bf152bea
</html>