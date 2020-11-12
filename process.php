<?php
require_once('connection.php');
session_start();

  if(isset($_POST['login']))
  {
      $username=$_POST['myUsername'];
      $password=$_POST['myPassword'];
      $password = md5($password);
      $query="select * from login where user='$username' and pass='$password'";
      $result=mysqli_query($db,$query);
      
      if(mysqli_fetch_assoc($result))
      {
        $_SESSION['User']=$username;
        header("location:member.php"); //direct to welcome page if logged in successfully
      }
      else
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Please enter correct username and password!");'; 
        echo 'window.location.href = "login.php";';
        echo '</script>';
      }
    
  }
  else
  {
    echo 'Not working...';
  }
