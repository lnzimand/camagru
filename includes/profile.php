<?php
//login_success.php
session_start();

if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true)
{
  header("location: ../login.php");
  exit;
}

if(isset($_SESSION['loggedin']))
{
  require_once "../header.php";
  require_once "uploadfile.php";
  require_once "showpics.php";
}
else
{
     header("location:../login.php");
}
?>
