<?php

session_start();
require_once '../config/connection.php';
include('header.php');

if (!isset($_SESSION['user_id'])) {
  header("location: login.php");
  exit();
}

if (isset($_POST['passwd']))
{
    $password = $_POST['passwd'];
    $cpassword = $_POST['cpasswd'];
    $user_id = $_SESSION['user_id'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    //Verifcation
    if (empty($password) || empty($cpassword)){
        $error = '<label class="text-danger">Complete all fields</label>';
    }

    // Password match
    if ($password !== $cpassword){
        $error = '<label class="text-danger">Passwords don\'t match</label>';
    }

    // Password length
    if (strlen($password) < 4){
        $error = '<label class="text-danger">Choose a password that equals or is longer than 4 character</label>';
    }

    if (!empty($password))
    {
      $upper = preg_match('/[A-Z]/', $password);
      $lower = preg_match('/[a-z]/', $password);
      $spchar = preg_match('/[!@#$%^&*()-_+=[\]\\;\',.?":{}|<>~]/', $password);
      if (!$upper || !$lower || !$spchar)
      {
        $error = '<label class="text-danger">At least one upper case, a lower case, and a special character must be present</label>';
      }
    }
    if (!isset($error)) {
        $error = $_SESSION['user_id'];
      	try {
          	$stmt = $connection->prepare("UPDATE register_user SET user_password = :password WHERE register_user_id = :userid");
      	   	$stmt->bindParam(':password', $hash);
            $stmt->bindParam(':userid', $user_id);
      	   	$user = $stmt->execute();

            foreach ($_SESSION as $value) {
              unset($value);
            }
            session_destroy();
            header("location:login.php");
            exit();
      	}
      	catch(PDOException $e) {
      	    		$error = '<label class="text-danger">Error: ' . $e->getMessage().'</label>';
      	    }
      }
      else {
          $error = '<label class="text-danger">Error occured: '.$error.'</label>';
      }
}

?>
<body>
    <form action="changing_passwd.php" method="post">
        <?php echo $error; ?>
        <div>
            <input type="password" name="passwd" placeholder="New Password">
        </div>
        <div>
            <input type="password" name="cpasswd" placeholder="Confirm Password"></p>
        </div>
        <button type="submit" name="passup">Update Password</button><br>
    </form>
</body>
</html>