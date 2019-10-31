<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
  header("location: ../login.php");
  exit;
}

require_once 'setup.php';

if (isset($_POST['submit']))
{
  if (isset($_POST['password']))
  {
    $password = $_POST['password'];
    try {
      $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query = $connection->prepare("SELECT * FROM users WHERE username = :username");
      $query = bindParam(':password', $_SESSION['username']);
      $query->execute();
      $result = $query->rowCount();

      if ($result === 1)
      {
        header("location: newpassword.php");
      }
      else
        header("location: lo")
    } catch (PDOException $e) {

    }

  }
}

?>
