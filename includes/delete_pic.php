<?php
session_start();
require_once 'connection.php';

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
