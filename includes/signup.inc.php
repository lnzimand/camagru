<?php
require_once 'setup.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['passwd'];
$cpassword = $_POST['cpasswd'];
$hash = password_hash($password, PASSWORD_DEFAULT);
//Verifcation
if (empty($username) || empty($email) || empty($password) || empty($cpassword)){
    $error = "Complete all fields";
}

// Password match
if ($password !== $cpassword){
    $error = "<p>Passwords don't match</p>";
}

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = "<p>Enter a  valid email</p>";
}

// Password length
if (strlen($password) < 4){
    $error = "<p>Choose a password that equals or is longer than 4 character</p>";
}

if (!empty($password))
{
  $upper = preg_match('/[A-Z]/', $password);
  $lower = preg_match('/[a-z]/', $password);
  $spchar = preg_match('/[!@#$%^&*()-_+=[\]\\;\',.?":{}|<>~]/', $password);
  if (!$upper || !$lower || !$spchar)
  {
    $error = "<p>At least one upper case, a lower case, and a special character must be present</p>";
  }
}

//username length
if (strlen($username) < 4){
    $error = "<p>Choose a username that equals or is longer than 4 character</p>";
}

if (!isset($error)) {

    $vkey = md5(time().$username);
		try {
	    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    	$stmt = $connection->prepare("INSERT INTO users (email, password, username, vkey)
	    	VALUES (:email, :password, :username, :vkey)");
	    	$stmt->bindParam(':email', $email);
	    	$stmt->bindParam(':password', $hash);
	    	$stmt->bindParam(':username', $username);
        $stmt->bindParam(':vkey', $vkey);
	    	$user = $stmt->execute();

        if ($user)
        {
          //verification email
          $to = $email;
          $subject = "Email verification";
          $message = "<a href='verify.php?vkey=$vkey'>Click here to verify your account</a>";
          $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
          $headers .= 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


          if (mail($to, $subject, $message, $headers))
          {
           header("location: thankyou.php");
          }
          else
          {
            echo "Message delivery failed...";
          }
        }
		}
	catch(PDOException $e)
	    {
				if (strpos($e->getMessage(), "email"))
					echo "Email: $email is already taken";
				elseif (strpos($e->getMessage(), "username"))
					echo "Username: $username is alreay taken";
				else
	    		echo "Error: " . $e->getMessage();
	    }
	$connection = null;
}
else {
    echo "error occured: ".$error;
    exit();
}
?>
