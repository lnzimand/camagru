<?php

//resend_email_otp.php

include('../config/connection.php');

$message = '';

session_start();

if(isset($_SESSION["user_id"])) {
    header("location:home.php");
}

if(isset($_POST["resend"])) {
    if(empty($_POST["user_email"])) {
        $message = '<div class="alert alert-danger">Email Address is required</div>';
    } else {
        $data = array(
        ':user_email' => trim($_POST["user_email"])
        );

        $query = "
        SELECT * FROM register_user 
        WHERE user_email = :user_email
        ";

        $statement = $connection->prepare($query);
        $statement->execute($data);

        if($statement->rowCount() > 0) {
            $result = $statement->fetchAll();
            foreach($result as $row) {
                if($row["user_email_status"] == 'verified') {
                    $message = '<div class="alert alert-info">Email Address already verified, you can login into system</div>';
                } else {

                    $to = $row["user_email"];
                    $subject = "Verification code for Verify Your Email Address";
                    $message_body = '
                        <p>For verify your email address, enter this verification code when prompted: <b>'.$row["user_otp"].'</b>.</p>
                        <p>Sincerely,</p>
                        <p>YaQwaQwa</p>
                    ';
                    $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
                    $headers .= 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    
                    if(mail($to, $subject, $message, $headers)) {
                        echo '<script>alert("Please Check Your Email for Verification Code")</script>';
                        echo '<script>window.location.replace("email_verify.php?code='.$row["user_activation_code"].'");</script>';
                    } else {

                    }
                }
            }
        } else {
            $message = '<div class="alert alert-danger">Email Address not found in our record</div>';
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Camagru | Resend Email Verification OTP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://code.jquery.com/jquery.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <br />
        <div class="container">
            <h3 align="center">Camagru</h3>
            <br />
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Resend Email Verification OTP</h3>
                            </div>
                            <div class="panel-body">
                                <?php echo $message; ?>
                                <form method="post">
                                    <div class="form-group">
                                        <label>Enter Your Email</label>
                                        <input type="email" name="user_email" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="resend" class="btn btn-success" value="Send" />
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
