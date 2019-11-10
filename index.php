<?php
require "header.php";
session_start();
?>

<main>
  <div class="container">
    <div class="first">
      <form action="includes/signup.inc.php" method="post" autocomplete="on">
        <?php if (isset($_SESSION['loginerror']))
          echo "<h4 style='color:red;'>".$_SESSION['loginerror']."</h4>"?>
        <h1>Register</h1>
        <label>Username</label>
        <input class="fname" type="text" name="username" placeholder="Preferred Username">
        <label>Email :</label>
        <input id="email" placeholder="Email" type="text" name="email">
        <label>Password :</label>
        <input class="fname" type="password" name="passwd" placeholder="Enter Password" autocomplete="off">
        <label>Confirm Password :</label>
        <input class="fname" type="password" name="cpasswd" placeholder="Confirm Password" autocomplete="off">
        <button class="submit" type="submit" name="signup">submit</button>
        <p class="fname">Already a user? <a href="login.php">Login</a></p>
      </form>
    </div>
  </div>
</main>
<?php session_destroy();?>
<?php require "footer.php"; ?>
