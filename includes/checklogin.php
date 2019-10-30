<?php
session_start();

//check whether the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{
  header("location: login_success.php");
  exit;
}

require_once 'setup.php';

$username = trim($_POST['username']);
$password = trim($_POST['passwd']);

if (empty($username))
  $username_err = "Please enter username";
if (empty($password))
  $password_err = "Please enter password";

if (isset($_POST['login']) && empty($username_err) && empty($password_err))
{
  try {
    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password']))
    {
      $_SESSION['username'] = $username;
      header("location: login_success.php");
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
  else
    echo "Oops something went wrong. Please try again later.";
}
?>
