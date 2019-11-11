<?php
session_start();
require_once "connection.php";

if (isset($_POST['email_notification']) && $_SESSION['loggedin'] === true)
{
  $stmt = $connection->prepare("UPDATE users SET email_notification = :email WHERE username = :username");
  $stmt->bindParam(':email', $_POST['email_notification']);
  $stmt->bindParam(':username', $_SESSION['username']);
  $results = $stmt->execute();
  echo $_POST['email_notification'];

  if (!empty($results))
  {
    $to = $_SESSION['email'];
    $subject = "Email notification";
    $message = ($_POST['email_notification'] === YES) ? "Email notification has been activated": "Email notification has been deactivated";
    $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    mail($to, $subject, $message, $headers);
    header("location: login_success.php");
    exit();
  }
}
$connection = NULL;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Notification</title>
  </head>
  <body>
    <form action="email_notification.php" method="post">
      Enable email notification<br>
      <input type="radio" name="email_notification" <?php if (isset($email_notification) && $email_notification === "yes")
      echo 'checked'; ?> value="YES">Yes<br>
      <input type="radio" name="email_notification" <?php if (isset($email_notification) && $email_notification === "no")
      echo 'checked';?> value="NO">No<br>
      <input type="submit" name="submit">
    </form>
  </body>
</html>
