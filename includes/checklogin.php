<?php
session_start();

//check whether the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
    }
    elseif ($user && password_verify($password, $user['password']) && !$user['verified'])
    {
      echo "User not yet verified<br>";
      exit;
    }
    else
    {
      echo "username/password incorrect<br>";
      exit;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
else {
  if (!empty($password_err))
    echo $password_err;
  else if (!empty($username_err))
    echo $username_err;
  elseif ($user['vkey'] === 0) {
    echo "Account not verified yet";
  }
  else
    echo "Oops something went wrong. Please try again later.";
}
?>
