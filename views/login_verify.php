<?php

session_start();

include('../config/connection.php');

$error = '';
$next_action = '';

sleep(2);

if(isset($_POST["action"])) {
    if($_POST["action"] == 'email') {
        if($_POST["user_email"] != '') {
            $data = array(
                ':user_email' => $_POST["user_email"]
            );

            $query = "
            SELECT * FROM register_user 
            WHERE user_email = :user_email
            ";

            $statement = $connection->prepare($query);
            $statement->execute($data);
            $total_row = $statement->rowCount();

            if($total_row == 0) {
                $error = 'Email Address not found';
                $next_action = 'email';
            } else {
                $result = $statement->fetchAll();
                foreach($result as $row) {
                    if($row["user_email_status"] == 'verified') {
                        $_SESSION['register_user_id'] = $row['register_user_id'];
                        $_SESSION['user_name'] = $row['user_name'];
                        $_SESSION['user_email'] = $row['user_email'];
                        $_SESSION['user_password'] = $row['user_password'];
                        $next_action = 'password';
                    } else {
                        $error = 'Email Address is not verified, first verify your email address';
                        $next_action = 'email';
                    }
                }
            }
        } else {
            $error = 'Email Address is Required';
            $next_action = 'email';
        }
    }

    if($_POST["action"] == 'password') {
        if($_POST["user_password"] != '') {
            if(password_verify($_POST["user_password"], $_SESSION["user_password"])) {
                $login_otp = rand(100000,999999);
                
                $data = array(
                    ':user_id'  => $_SESSION["register_user_id"],
                    ':login_otp' => $login_otp,
                    ':last_activity'=> date('d-m-y h:i:s')
                );

                $query = "
                INSERT INTO login_data 
                (user_id, login_otp, last_activity) 
                VALUES (:user_id, :login_otp, :last_activity)
                ";

                $statement = $connection->prepare($query);
                if($statement->execute($data)) {
                    $_SESSION['login_id'] = $connection->lastInsertId();
                    $_SESSION['login_otp'] = $login_otp;

                    $to = $_SESSION["user_email"];
                    $subject = "One Time Pin";
                    $message = '
                            <p>To verify login, enter this verification code when prompted: <b>'.$login_otp.'</b>.</p>
                            <p>Sincerely,</p>
                            <p>YaQwaQwa</p>
                        ';
                    $headers = "From: lnzimand@student.wethinkcode.co.za" . "\r\n";
                    $headers .= 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


                    if (mail($to, $subject, $message, $headers)) {
                        $next_action = 'otp';
                    } else {
                        $error = '<label class="text-danger">'.$mail->ErrorInfo.'</label>';
                        $next_action = 'password';
                    }
                }
            } else {
                $error = 'Wrong Password';
                $next_action = 'password';
            }
        } else {
            $error = 'Password is Required';
            $next_action = 'password';
        }
    }

    if($_POST["action"] == "otp") {
        if($_POST["user_otp"] != '') {
            if($_SESSION['login_otp'] == $_POST["user_otp"]) {
                $_SESSION['user_id'] = $_SESSION['register_user_id'];
                unset($_SESSION["register_user_id"]);
                unset($_SESSION["user_email"]);
                unset($_SESSION["user_password"]);
                unset($_SESSION["login_otp"]);
            } else {
                $error = 'Wrong OTP Number';
                $next_action = 'otp';
            }
        } else {
            $error = 'OTP Number is required';
            $next_action = 'otp';
        }
    }

    $output = array(
        'error'   => $error,
        'next_action' => $next_action
    );

    echo json_encode($output);
}

?>
