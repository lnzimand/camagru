<?php
require_once 'connection.php';
session_start();

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

            if (!empty($_POST['email-notification']))
            {
              $to = $email;
              $subject = "Password";
              $message = "Your password was successfully updated";
              $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
              $headers .= 'MIME-Version: 1.0' . "\r\n";
              $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

              mail($to, $subject, $message, $headers);
            }

            foreach ($_SESSION as $value) {
              unset($value);
            }
            session_destroy();
            header("location: ../login.php");
            exit();
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
          New Password <input type="password" name="passwd" placeholder="Enter Password"><br>
          Confirm Password <input type="password" name="cpasswd" placeholder="Confirm Password">
          <input type="hidden" name="email" value="
_END;
    $text2 = <<<_END
    "<button type="submit" name="passup"></button>
    <button type="submit" name="passup">Update Password</button><br>
    Email notification<input type="checkbox" name="email-notification" checked>
        </form>
      </body>
    </html>
_END;
  echo $text1.$email.$text2;
}
?>
