<?php
require_once '../config/connection.php';
session_start();

if (!isset($_SESSION['user_id']))
{
  header("location:home.php");
  exit();
}

$stmt = $connection->prepare("SELECT * FROM register_user WHERE register_user_id = :userid");
$stmt->bindParam(':userid', $_SESSION['notifyuser']);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($results)) {
  if ($results[0]['email_notification'] === YES) {
    $to = $results[0]['user_email'];
    $subject = "Activity";
    $message = "Someone commented on your picture";
    $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($to, $subject, $message, $headers);
    unset($_SESSION['notifyuser']);
    header("location:home.php");
    exit();
  }
  else {
    unset($_SESSION['notifyuser']);
    header("location:home.php");
    exit();
  }
}
?>
