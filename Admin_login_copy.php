<?php
// session_start();
include "config.php";
// include "Prepared_statement.php"; 
// include "Array_filter.php"; 
// include "mail.php"; 
include "Hacking.php/hack.php";

//Function to display error messages
// function displayMessage($message, $color = 'red') {
//     $id = uniqid('message_');
//     echo "<h4 id='$id' class='error-message' style='color:$color; margin:10px 0px 0px 60px; font-size:20px; text-shadow: 1px 1px 0px blue'>$message</h4>";
//     echo "<script>removeMessageAfterDelay('$id', 2000);</script>";
// }

// // Function to display success messages
// function displaySuccessMessage($message, $color = 'green') {
//     $id = uniqid('message_');
//     echo "<h4 id='$id' class='success-message' style='color:$color; margin:10px 0px 0px 60px; font-size:20px; text-shadow: 1px 1px 0px blue'>$message</h4>";
//     echo "<script>removeMessageAfterDelay('$id', 2000);</script>";
// }

// // Function to handle admin login
// function handleAdminLogin($email, $password) {
//     if (loginAdmin($email, $password)) {
//         $_SESSION['login_success'] = true;
//         header("location: Admin_optionfile.php");
//         exit;
//     } else {
//         $_SESSION['message'] = 'Invalid Email and Password';
//         header("location: {$_SERVER['PHP_SELF']}");
//         exit;
//     }
// }

// // Function to log malicious login attempts
// function logMaliciousAttempts($email, $password, $attemptCount) {
//     // Check if attempt was made with syntax defined in array_filter.php
//     $isMaliciousAttempt = Arraybased_Filter($email) || Arraybased_Filter($password);

//     if ($isMaliciousAttempt) {
//         date_default_timezone_set('Asia/Kolkata');
//         $logMessage = "Malicious Login Attempt: $attemptCount\n";
//         $logMessage .= "Email: $email\n";
//         $logMessage .= "Password: $password\n";
//         $logMessage .= "Date and Time: " . date("Y-m-d h:i A") . "\n\n";
//         file_put_contents('malicious_attempts.log', $logMessage, FILE_APPEND);
//     }
// }

// // Check if form is submitted
// if (isset($_POST['submit'])) {
//     if (!isset($_SESSION['failed_attempts'])) {
//         $_SESSION['failed_attempts'] = 0;
//     }

//     $_SESSION['failed_attempts']++;

//     if ($_SESSION['failed_attempts'] > 3 && isset($_SESSION['array_filtration'])) {
//         sendEmailNotification();
//         $_SESSION['message'] = 'Time Over';
//         unset($_SESSION['failed_attempts']);
//         unset($_SESSION['array_filtration']);
//         header("location: {$_SERVER['PHP_SELF']}");
//         exit;
//     }

//     $email = $_POST['username'];
//     $pass = $_POST['pass'];

//     $emailFilterResult = Arraybased_Filter($email);
//     $passwordFilterResult = Arraybased_Filter($pass);

//     if ($emailFilterResult || $passwordFilterResult) {
//         $_SESSION['array_filtration'] = true;
//         $_SESSION['message'] = 'Invalid Syntax';
//         logMaliciousAttempts($email, $pass, $_SESSION['failed_attempts']);
//         header("location: {$_SERVER['PHP_SELF']}");
//         exit;
//     }

//     handleAdminLogin($email, $pass);
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-login</title>
    <link rel="stylesheet" href="Login.css">
    <link rel="stylesheet" href="heading.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php 
        include('Adminheading.php');
    ?>
    <div id="container" class="container" style="height: 390px;">
        <div class="inner-container">
            <h1 style="margin: 20px 0px 0px 240px; width:210px; height:60px; font-size:28px ;font-weight: bold;">Admin_Login</h1>
            <form class="division" method="POST" action="" id="login-form">
                <label>Email:</label><br>
                <input type="text" name="username" id="email" autocomplete="username" style="padding:3px"><br><br>
                <div id="error"></div>
                <label>Password:</label><br>
                <div class="password-toggle" style="position: relative;">
                    <input type="password" name="pass" id="pass" autocomplete="current-password" style="padding:3px">
                    <span class="toggle-password" onclick="togglePassword('pass')" style="position: absolute; right: -25px; top: 70%; transform: translateY(-50%); cursor: pointer;"><i id="pass-icon" class="fa fa-eye"></i></span>
                </div><br><br>

                <button name="submit" type="submit" value="Login" class="btn_dark" style="padding:5px">Submit</button>
                <button name="Reset" style="padding:2px">Reset</button><br>
            </form>

            <?php
                // if (isset($_SESSION['message'])) {
                //     displayMessage($_SESSION['message']);
                //     unset($_SESSION['message']);
                // }
            ?>
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

        // Function to remove messages after delay
        function removeMessageAfterDelay(id, delay) {
            setTimeout(function() {
                var element = document.getElementById(id);
                if (element) {
                    element.remove();
                }
            }, delay);
        }

        // Call removeMessageAfterDelay for any existing messages
        document.addEventListener('DOMContentLoaded', function() {
            var messages = document.querySelectorAll('.error-message, .success-message');
            messages.forEach(function(message) {
                var id = message.id;
                if (id) {
                    removeMessageAfterDelay(id, 5000);
                }
            });
        });
    </script>
</body>
</html>

