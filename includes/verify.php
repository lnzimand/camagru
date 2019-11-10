<?php
require_once 'connection.php';

if (isset($_GET['vkey']))
{
  $vkey = $_GET['vkey'];
  $stmt = $connection->prepare("SELECT * FROM users WHERE verified = 0 AND vkey = :vkey");
  $stmt->bindParam(':vkey', $vkey);
  $stmt->execute();

  $count = $stmt->rowCount();
  if ($count === 1)
  {
    $query = $connection->prepare("UPDATE users SET verified = 1 WHERE vkey = :vkey");
    $query->bindParam(':vkey', $vkey);
    $user = $query->execute();
    if ($user)
    {
      header("location: verified.php");
      exit();
    }
    else
      echo "This account is invalid or already verified";
  }
  else
    die("Something went wrong");
}
?>
