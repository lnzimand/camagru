<?php
require_once '../config/connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}

require_once "header.php";
if (isset($_POST['username'])) {
  try {
    $stmt = $connection->prepare("SELECT user_name FROM register_user");
    $stmt->execute();
    $user = $stmt->fetch();

    if (in_array($_POST['username'], $user)) {
      $error = "<p>username already taken</p>";
    }
  }
  catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }

  if (strlen($_POST['username']) < 4){
      $error = "<p>Choose a username that equals or is longer than 4 character</p>";
  }

  if (empty($_POST['username']))
  {
    $error = "Field empty";
  }

  if (!isset($error))
  {
    $email = $_SESSION['email'];
    try {
      $stmt = $connection->prepare("UPDATE register_user SET user_name = :username WHERE register_user_id = :user_id");
      $stmt->bindParam(':username', $_POST['username']);
      $stmt->bindParam(':user_id', $_SESSION['user_id']);
      $user = $stmt->execute();

      header("location:home.php");
      exit();
  }
  catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
  else {
    if ($_SESSION['user_id']) {
      $_SESSION['error'] = $error;
      header("location:update_username.php");
      exit();
    }
  }
}

?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
    </head>
    <body>
      <form action="update_username.php" method="post">
        Enter new username:
        <input type="text" name="username" placeholder="Enter new username">
        <input type="submit" value="Submit"><br>
      </form>
    </body>
  </html>
