<?php

require_once('Prepared_statement.php');

$redirectPageMalicious = "Leave_Application.php";
$redirectPageNonMalicious = "leave.php";

if (isset($_POST['submit'])) {
    $email = $_POST['username'];
    $password = $_POST['pass'];

    if (empty($email) || empty($password)) {
        $error_message = "Both email and password are required";
    } else {
        if (Arraybased_Filter($email) || Arraybased_Filter($password)) {
            logMaliciousAttempt($email, $password);
            check_if_banned(true);
            header("Location: $redirectPageMalicious");
            exit;
        } else {
            if (!validateEmail($email)) {
                $error_message = "Invalid email format";
            } elseif (!validatePassword($password)) {
                $error_message = "Invalid password format";
            } else {
                $loginStatus = validateLogin($email, $password);

                if ($loginStatus === true) {
                    $_SESSION['user'] = array('email' => $email);
                    logAttempt($email, $password);
                    header("refresh:2;url=$redirectPageNonMalicious");
                    exit;
                } else {
                    $error_message = $loginStatus === false ? "Login Failed. Invalid email or password" : "Account not approved. Please contact admin.";
                    check_if_banned(false);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Login</title>
    <link rel="stylesheet" href="Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <?php include('heading.php'); ?>
    <div class="container" style="height: 500px; margin-top: 50px">
        <div class="inner-container">
            <h1 style="margin: 20px 0px 0px 240px; width:210px; height:60px; font-size:28px; font-weight: bold;">User Login</h1>
            <form class="division" method="POST" action="" id="login-form">
                <label>Email:</label><br>
                <input type="text" name="username" id="email" autocomplete="username" style="padding: 3px;"><br><br>
                <label>Password:</label><br>
                <div class="password-toggle" style="position: relative;">
                    <input type="password" name="pass" id="pass" autocomplete="current-password" style="padding: 3px;">
                    <span class="toggle-password" onclick="togglePassword('pass')" style="position: absolute; right: -25px; top: 70%; transform: translateY(-50%); cursor: pointer;"><i id="pass-icon" class="fa fa-eye"></i></span>
                </div><br><br>
                <button name="submit" type="submit" value="Login" class="btn_dark" style="padding: 3px;">Submit</button>
                <button type="reset" style="padding: 3px;">Reset</button>
                <p>New Member? <a href="registration.php">Register</a></p>
            </form>
            <?php
            if (!empty($error_message)) {
                echo "<p id='error_message' style='color: red;font-size: 20px;margin-left: 30px; margin-top: 15px;'>$error_message</p>";
            }
            ?>
            <p style="margin: 20px 0px 0px 60px;">Forgot Password? <a href="Forgotpassword.php" style="font-size: 18px;">Reset Password</a></p>
        </div>
    </div>
    <script>
        function togglePassword(inputId) {
            var passwordField = document.getElementById(inputId);
            var icon = document.getElementById(inputId + '-icon');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $('#error_message').fadeOut('slow');
            }, 10000);
        });
    </script>
</body>

</html>
