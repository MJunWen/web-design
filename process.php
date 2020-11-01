<?php
require_once('connection.php');
session_start();
  if(isset($_POST['login']))
  {
    if(empty($_POST['myUsername']) || empty($_POST['myPassword']))
    {
      header("location:login.php?Empty= Please fill in the blanks");
    }
    else
    {
      $query="select * from login where username='".$_POST['myUsername']."' and password='".$_POST['myPassword']."'";
      $result=mysqli_query($db,$query);
      
      if(mysqli_fetch_assoc($result))
      {
        $_SESSION['User']=$_POST['myUsername'];
        header("location:login.php");
      }
      else
      {
        header("location:login.php?Invalid= Please enter correct username and passward");
      }
    }
  }
  else
  {
    echo 'Not working...';
  }
