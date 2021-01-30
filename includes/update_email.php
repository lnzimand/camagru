<?php
require_once "connection.php";
session_start();
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true)
{
  header("location: ../login.php");
  exit();
}

require_once "../header.php";

if (isset($_POST['email']) && $_SESSION['loggedin'] && $_SESSION['loggedin'] === true)
{
  try {
    $stmt = $connection->prepare("SELECT email FROM users");
    $stmt->execute();
    $user = $stmt->fetch();

    if (in_array($_POST['email'], $user))
    {
      $error = "<p>email already taken</p>";
    }
  }
  catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }


  $email = $_POST['email'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error = "<p>Enter a  valid email</p>";
  }
  if (!isset($error))
  {
    try {
      $stmt = $connection->prepare("UPDATE users SET email = :email WHERE username = :username");
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':username', $_SESSION['username']);
      $user = $stmt->execute();

      if (!empty($_POST['email-notification']))
      {
        $to = $email;
        $subject = "Email";
        $message = "You've chosen to use " . $email . " as your new email";
        $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);
      }

      foreach ($_SESSION as $value) {
        unset($value);
      }
      session_destroy();
      header("location: ../login.php");
      exit();
  }
  catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
  else {
    echo $error;
    if ($_SESSION['loggedin'] === true)
    {
      header("location: update_email.php");
      exit();
    }
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
      <form action="update_email.php" method="post">
        Enter valid email address:
        <input type="text" name="email" placeholder="Enter new email Address">
        <input type="submit" value="Submit"><br>
        Email notification <input type="checkbox" name="email-notification" checked><br>
      </form>
      <a href="login_success.php">home</a>
    </body>
  </html>
_END;
}
?>
