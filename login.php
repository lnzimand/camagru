<?php require "header.php" ?>

<main>
  <div class="container">
    <div class="first">
      <form action="includes/checklogin.php" method="post">
        <input class="fname" type="text" name="username" placeholder="Username/Email">
        <input class="fname" type="password" name="passwd" placeholder="Enter Password">
        <button class="submit" type="submit" name="login">login</button>
        <p class="fname" text-align="right">New to this site? <a href="index.php">click here</a> to create an account</p><br>
        <a href="includes/forgot_password.php">forgot passwords?</a>
        <a href="includes/gallery.php">gallery</a>
      </form>
    </div>
  </div>
</main>

<?php require "footer.php" ?>
