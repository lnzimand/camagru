<?php
require_once "connection.php";
session_start();

if (isset($_POST['email']) && $_SESSION['loggedin'] && $_SESSION['loggedin'] === true)
{
  try {
    $stmt = $connection->prepare("SELECT email FROM users");
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
  if (!isset($error))
  {
    try {
      $stmt = $connection->prepare("UPDATE users SET email = :email WHERE username = :username");
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':username', $_SESSION['username']);
      $user = $stmt->execute();

      header("location: login_success.php");
  }
  catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
  else {
    echo $error;
    if ($_SESSION['loggedin'] === true)
    {
      header("location: update_email.php");
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
      <form action="update_email.php" method="post">
        Enter valid email address:
        <input type="text" name="email" placeholder="Enter new email Address">
        <input type="submit" value="Submit">
      </form>
      <a href="login_success.php">home</a>
    </body>
  </html>
_END;
}
?>
