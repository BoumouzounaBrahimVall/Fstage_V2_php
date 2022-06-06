<?php
 session_start();
 if(!isset($_SESSION['auth']))
 {
    $_SESSION['vers']=$_SERVER['REQUEST_URI'];
    header('location:../pages/login.php');
 }
 ?>