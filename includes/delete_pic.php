<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true)
{
  header("location: ../login.php");
  exit();
}

if ($_SESSION['userid'] && $_POST['delete'])
{
  try {
    $stmt = $connection->prepare("DELETE FROM gallery WHERE img = :img AND userid = :userid");
    $stmt->bindParam(':img', $_POST['delete']);
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $stmt->execute();

    header("location: profile.php");
    exit();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
else {
  echo "Something went wrong";
}

?>
