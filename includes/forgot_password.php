<?php
require_once 'connection.php';

if ($_POST['email'])
{
  $email = $_POST['email'];
  try {
    $stmt = $connection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetchAll();
    if (!empty($user))
    {
      $to = $email;
      $subject = "Password reset";
      $message = "<a href='http://".$_SERVER['HTTP_HOST']."/camagru/".basename(dirname(__FILE__))."/check_fpasswd.php?&email=$email'>Click here to reset password</a>";
      $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers = "Content-type: text/html; charset=iso-8859-1" . "\r\n";

      if (mail($to, $subject, $message, $headers)) {
        header("location: passwd.php");
        exit();
        }
      else {
        echo "Something went wrong. Try again later";
        }
      }
      else
        $response = "Email does not exist";
      if ($response)
      {
        echo "Email does not exist <a href='../index.php'>Click here to register</a>";
      }
    }
    catch(PDOException $e)
    {
      echo "Error: " . $e->getMessage();
    }
  }
else
{
  echo <<<_END
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
    </head>
    <body>
      <form action="forgot_password.php" method="post">
        <p>Forgot Password?</p><br>
        Enter Email Address:
        <input type="text" name="email" placeholder="Enter Email Address">
        <br><br>
        <input type="submit" value="Submit">
      </form>

    </form>
    </body>
  </html>
_END;
}
$connection = NULL;
?>
