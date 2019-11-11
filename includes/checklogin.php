<?php
session_start();

//check whether the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
{
  header("location: login_success.php");
  exit;
}

require_once 'connection.php';

$username = trim($_POST['username']);
$password = trim($_POST['passwd']);

if (empty($username))
  $username_err = "Please enter username";
if (empty($password))
  $password_err = "Please enter password";

if (isset($_POST['login']) && empty($username_err) && empty($password_err))
{
  try {
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    $userid = $user['id'];
    $email = $user['email'];

    if ($user && password_verify($password, $user['password']) && $user['verified'])
    {
      $_SESSION['username'] = $username;
      $_SESSION['userid'] = $userid;
      $_SESSION['loggedin'] = true;
      $_SESSION['email'] = $email;
      header("location: login_success.php");
      exit();
    }
    elseif ($user && password_verify($password, $user['password']) && !$user['verified'])
    {
      $_SESSION['loginerror'] = "User not yet verified<br>";
      header("location: ../login.php");
      exit;
    }
    else
    {
      $_SESSION['loginerror'] = "username/password incorrect<br>";
      header("location: ../login.php");
      exit;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
else {
  if (!empty($password_err))
  {
    $_SESSION['loginerror'] = $password_err;
    header("location: ../login.php");
    exit;
  }
  else if (!empty($username_err))
  {
    $_SESSION['loginerror'] = $username_err;
    header("location: ../login.php");
    exit;
  }
  elseif ($user['vkey'] === 0) {
    $_SESSION['loginerror'] = "Account not verified yet";
    header("location: ../login.php");
    exit;
  }
  else
    echo "Oops something went wrong. Please try again later.";
}
?>
