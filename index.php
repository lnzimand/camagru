<?php

session_start();

if(isset($_SESSION["user_id"])) {
    header("location:home.php");
}

include('config/connection.php');
include('helpers/function.php');

$message = '';
$error_user_name = '';
$error_user_email = '';
$error_user_password = '';
$error_confirm_password = '';
$user_name = '';
$user_email = '';
$user_password = '';
$user_confirm_password = '';

if(isset($_POST["register"])) {
    if(empty($_POST["user_name"])) {
        $error_user_name = "<label class='text-danger'>Enter Name</label>";
    } else {
        if (strlen($_POST["user_name"]) < 4){
            $error = '<label class="text-danger">Choose a username that equals or is longer than 4 character</label>';
        } else {
            $user_name = trim($_POST["user_name"]);
            $user_name = htmlentities($user_name);
        }
    }
    
    if(empty($_POST["user_email"])) {
        $error_user_email = '<label class="text-danger">Enter Email Address</label>';
    } else {
        $user_email = trim($_POST["user_email"]);
        if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $error_user_email = '<label class="text-danger">Enter Valid Email Address</label>';
        }
    }
    
    if(empty($_POST["user_password"])) {
        $error_user_password = '<label class="text-danger">Enter Password</label>';
    } else {
        if($_POST["user_password"] !== $_POST["user_confirm_password"]) {
            $error_confirm_password = '<label class="text-danger">Passwords don\'t match</label>';
        } else {
            if(strlen($_POST["user_password"]) < 4){
                $error_user_password = '<label class="text-danger">Choose a password that equals or is longer than 4 character</label>';
            } else {
                $upper = preg_match('/[A-Z]/', $_POST["user_password"]);
                $lower = preg_match('/[a-z]/', $_POST["user_password"]);
                $spchar = preg_match('/[!@#$%^&*()-_+=[\]\\;\',.?":{}|<>~]/', $_POST["user_password"]);
                if (!$upper || !$lower || !$spchar) {
                    $error_user_password = '<label class="text-danger">At least one upper case, a lower case, and a special character must be present</label>';
                } else {
                    $user_password = trim($_POST["user_password"]);
                    $user_password = password_hash($user_password, PASSWORD_DEFAULT);
                }
            }
        }
    }

    if($error_user_name == '' && $error_user_email == '' && $error_user_password == '' && $error_confirm_password == '') {

        $user_activation_code = md5(rand()).$user_name;
        $user_otp = rand(100000, 999999);

        // $user_avatar = make_avatar(strtoupper($user_name[0]));

        $data = array(
            ':user_name'  => $user_name,
            ':user_email'  => $user_email,
            ':user_password' => $user_password,
            ':user_activation_code' => $user_activation_code,
            ':user_email_status'=> 'not verified',
            ':user_otp'   => $user_otp,
        );

        $query = "
        INSERT INTO register_user 
        (user_name, user_email, user_password, user_activation_code, user_email_status, user_otp)
        SELECT * FROM (SELECT :user_name, :user_email, :user_password, :user_activation_code, :user_email_status, :user_otp) AS tmp
        WHERE NOT EXISTS (
            SELECT user_email FROM register_user WHERE user_email = :user_email
        ) LIMIT 1
        ";

        $statement = $connection->prepare($query);
        $statement->execute($data);
        if($connection->lastInsertId() == 0) {
            $message = '<label class="text-danger">Email Already Registered</label>';
        } else {
            $to = $_POST["user_email"];
            $subject = "Verification code For Verifying Your Email Address";
            $message = "<p>To verify your email address, enter this verification code when prompted: <b>$user_otp</b>.</p>
                    <br />
                    <p>Kind Regards,</p>
                    <br />
                    <p>lnzimand</p>";
            $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


            $boolean = mail($to, $subject, $message, $headers);
            if($boolean == 1) {
                echo '<script>alert("Please Check Your Email for Verification Code")</script>';
                header('location:views/email_verify.php?code='.$user_activation_code);
            } else {
                header("location:views/login.php");
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Camagru | Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://code.jquery.com/jquery.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
		  	<div class="container-fluid">
			    <div class="navbar-header">
			      	<a class="navbar-brand" href="#">Camagru</a>
			    </div>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="views/gallery.php"><b>Gallery</b></a></li>
			    </ul>
		  	</div>
		</nav>
        <br />
        <div class="container">
            <h3 align="center">Camagru</h3>
            <br />
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Register</h3>
                            </div>
                            <div class="panel-body">
                                <?php echo $message; ?>
                                <form method="post">
                                    <div class="form-group">
                                        <label>Enter Your Name</label>
                                        <input type="text" name="user_name" class="form-control" />
                                        <?php echo $error_user_name; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Your Email</label>
                                        <input type="text" name="user_email" class="form-control" />
                                        <?php echo $error_user_email; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Your Password</label>
                                        <input type="password" name="user_password" class="form-control" />
                                        <?php echo $error_user_password; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Your Password</label>
                                        <input type="password" name="user_confirm_password" class="form-control" />
                                        <?php echo $error_confirm_password; ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="register" class="btn btn-success" value="Click to Register" />&nbsp;&nbsp;&nbsp;
                                        <a href="views/resend_email_otp.php" class="btn btn-default">Resend OTP</a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="views/login.php">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <br />
    </body>
</html>
