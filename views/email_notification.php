<?php

session_start();
require_once '../config/connection.php';
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}
  

if (isset($_POST['email_notification']) && $_SESSION['user_id']) {
  $stmt = $connection->prepare("UPDATE register_user SET email_notification = :email WHERE register_user_id = :register_user_id");
  $stmt->bindParam(':email', $_POST['email_notification']);
  $stmt->bindParam(':register_user_id', $_SESSION['user_id']);
  $results = $stmt->execute();

  if (!empty($results))
  {
    $to = $_SESSION['email'];
    $subject = "Email notification";
    $message = ($_POST['email_notification'] === YES) ? "Email notification has been activated": "Email notification has been deactivated";
    $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    mail($to, $subject, $message, $headers);
    header("location:home.php");
  }
}
$connection = NULL;
?>

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