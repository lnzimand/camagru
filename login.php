<?php
require "header.php";
session_start();
?>
<head>
  <style media="screen">
    h4 {
      color: #cc7a66;
    }
  </style>
</head>
<main>
  <div class="container">
    <div class="first">
      <?php if (isset($_SESSION['loginerror']))
        echo "<h4>".$_SESSION['loginerror']."</h4>"?>
      <form action="includes/checklogin.php" method="post">
        <input class="fname" type="text" name="username" placeholder="Username/Email">
        <input class="fname" type="password" name="passwd" placeholder="Enter Password">
        <button class="submit" type="submit" name="login">login</button>
        <p class="fname" text-align="right">New to this site? <a href="index.php">click here</a> to create an account</p><br>
        <a href="includes/forgot_password.php">forgot passwords?</a>
      </form>
    </div>
  </div>
</main>
<?php session_destroy();?>
<?php require "footer.php" ?>
