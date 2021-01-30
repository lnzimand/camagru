<?php
session_start();

 if (empty($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true)
{
  header("location: ../login.php");
}

if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
{
  require_once "../header.php";
  $email = $_SESSION['email'];
  $text1 = <<<_END
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
      <head>
        <meta charset="utf-8">
      </head>
      <body>
        <form action="check_fpasswd.php" method="post">
          <p>Enter a new password <input type="password" name="passwd" placeholder="New Password"></p>
          <p>Confirm Password <input type="password" name="cpasswd" placeholder="Confirm Password"></p>
          <input type="hidden" name="email" value="
_END;
    $text2 = <<<_END
    "<button type="submit" name="passup"></button>
    <button type="submit" name="passup">Update Password</button><br>
      Email notification<input type="checkbox" name="email-notification" checked>
        </form>
      </body>
    </html>
_END;
  echo $text1.$email.$text2;
}
?>
