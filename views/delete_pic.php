<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user_id']))
{
  header("location:login.php");
  exit();
}

if ($_SESSION['user_id'] && $_POST['delete'])
{
  try {
    $stmt = $connection->prepare("DELETE FROM gallery WHERE img = :img AND userid = :userid");
    $stmt->bindParam(':img', $_POST['delete']);
    $stmt->bindParam(':userid', $_SESSION['user_id']);
    $stmt->execute();

    header("location:userPosts.php");
    exit();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
else {
  echo "Something went wrong";
}

?>
