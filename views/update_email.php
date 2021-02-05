<?php
require_once '../config/connection.php';
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}

require_once "header.php";

if (isset($_POST['email'])) {
  try {
    $stmt = $connection->prepare("SELECT user_email FROM register_user");
    $stmt->execute();
    $user = $stmt->fetch();

    if (in_array($_POST['email'], $user))
    {
      $error = "<p>email already taken</p>";
    }
  }
  catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }


  $email = $_POST['email'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error = "<p>Enter a  valid email</p>";
  }
  if (!isset($error)) {
    try {
      $stmt = $connection->prepare("UPDATE register_user SET user_email = :email WHERE register_user_id = :user_id");
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':user_id', $_SESSION['user_id']);
      $user = $stmt->execute();
  }
  catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
  else {
    echo $error;
    if ($_SESSION['user_id']) {
      header("location: update_email.php");
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
    <form action="update_email.php" method="post">
        <input type="text" name="email" placeholder="Enter new email Address">
        <input type="submit" value="Submit"><br>
    </form>
</body>
</html>
