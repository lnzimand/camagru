<?php
require_once 'connection.php';

if (isset($_POST['passwd']) && isset($_POST['email']))
{
    $password = $_POST['passwd'];
    $cpassword = $_POST['cpasswd'];
    $email = $_POST['email'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    //Verifcation
    if (empty($password) || empty($cpassword)){
        $error = "Complete all fields";
    }

    // Password match
    if ($password !== $cpassword){
        $error = "<p>Passwords don't match</p>";
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
    if (!isset($error)) {

      	try {
          	$stmt = $connection->prepare("UPDATE users SET password = :password WHERE email = :email");
      	   	$stmt->bindParam(':password', $hash);
            $stmt->bindParam(':email', $email);
      	   	$user = $stmt->execute();

            header("location: login_success.php");
      	}
      	catch(PDOException $e) {
      	    		echo "Error: " . $e->getMessage();
      	    }
      }
      else {
          echo "error occured: ".$error;
          exit();
      }
}
else
{
  $email = $_GET['email'];
  $text1 = <<<_END
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
      <head>
        <meta charset="utf-8">
      </head>
      <body>
        <form action="check_fpasswd.php" method="post">
          <input type="password" name="passwd" placeholder="Enter Password">
          <input type="password" name="cpasswd" placeholder="Confirm Password">
          <input type="hidden" name="email" value="
_END;
    $text2 = <<<_END
    "<button type="submit" name="passup"></button>
    <button type="submit" name="passup">Update Password</button>
        </form>
      </body>
    </html>
_END;
  echo $text1.$email.$text2;
}
?>
