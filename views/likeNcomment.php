<?php
require_once '../config/connection.php';
session_start();
if (!isset($_SESSION['user_id']) && $_SESSION['user_id'] !== true)
{
  header("location:home.php");
  exit();
}

$userid = $_POST['userid'];
$gallerid = $_POST['galleryid'];
$comment = $_POST['comment'];

if (isset($_POST['like']))
{
  try {
    $stmt = $connection->prepare("INSERT INTO likes(userid, galleryid)
        VALUES('$userid', '$gallerid')");
    $stmt->execute();

    header("location:home.php");
    exit();
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
elseif (isset($_POST['comment'])) {
  try {
    $stmt = $connection->prepare("INSERT INTO comment(userid, galleryid, comment)
    VALUES('$userid', '$gallerid', '$comment')");
    $stmt->execute();

    $_SESSION['notifyuser'] = $userid;
    echo $_SESSION['notifyuser'];
    header("location:email.php");
    exit();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

}

?>
