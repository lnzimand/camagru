<?php
require_once "connection.php";
session_start();

if (isset($_POST['username']) && $_SESSION['loggedin'] && $_SESSION['loggedin'] === true)
{
  try {
    $stmt = $connection->prepare("SELECT username FROM users");
    $stmt->execute();
    $user = $stmt->fetch();

    if (in_array($_POST['username'], $user))
    {
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
    try {
      $stmt = $connection->prepare("UPDATE users SET username = :username WHERE email = :email");
      $stmt->bindParam(':username', $_POST['username']);
      $stmt->bindParam(':email', $_SESSION['email']);
      $user = $stmt->execute();

      $_SESSION['username'] = $_POST['username'];
      header("location: login_success.php");
      exit();
  }
  catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
  else {
    echo $error;
    if ($_SESSION['loggedin'] === true)
    {
      header("location: update_username.php");
    }
  }
}
else
{
  echo <<<_END
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
    </head>
    <body>
      <form action="update_username.php" method="post">
        Enter new username:
        <input type="text" name="username" placeholder="Enter new username">
        <input type="submit" value="Submit">
      </form>
      <a href="login_success.php">home</a>
    </body>
  </html>
_END;
}
?>
