<?php
// Include the function for filtering malicious input
require_once('Array_filter.php');

$error_message = "";
$success_message = ""; // Initialize success message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the password and confirm_password fields are empty
    if (empty($_POST['password']) || empty($_POST['confirm_password'])) {
        $error_message = "Both password fields are required.";
    } else {
        // Get the submitted password and confirm_password
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check for malicious input
        if (Arraybased_Filter($password) || Arraybased_Filter($confirm_password)) {
            // If malicious input is detected, set the success message
            $success_message = "Successfully set the password.";
        } 
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h2 {
            color: blue;
            font-size: 20px;
            margin: 70px 0px 0px 570px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 320px;
            margin: 20px auto;
            overflow: hidden;
            margin-top: 120px;
            height: 300px;
        }

        #form-container {
            margin-top: -100px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="password"],
        input[type="email"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: width 0.3s;
        }

        .password-toggle {
            width: 24px;
            padding: 10px;
            border: none;
            background: none;
            cursor: pointer;
            float: left;
            margin-top: 10px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            clear: both;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message,
        .success-message {
            margin-top: 5px;
            clear: both;
            text-align: center;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: -70px;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-top: -70px;
        }

        .message {
            margin: -15px 0px 0px 620px;
            color: blue;
        }
    </style>
</head>

<body>
    <h2>Reset Password</h2>
    <div id="form-container">
        <form id="reset-form" method="post" action="">
            <label for="password">Password:</label>
            <div style="position: relative;">
                <input type="password" id="password" name="password">
                <span class="password-toggle" onclick="togglePassword('password')" style="position: absolute; top: 25px; right: 5px;"><i class="fa fa-eye" id="pass-icon"></i></span>
            </div>
            <br>
            <label for="confirm_password">Confirm Password:</label>
            <div style="position: relative;">
                <input type="password" id="confirm_password" name="confirm_password" >
                <span class="password-toggle" onclick="togglePassword('confirm_password')" style="position: absolute; top: 25px; right: 5px;"><i class="fa fa-eye" id="confirm-pass-icon"></i></span>
            </div>
            <br><br><br>
            <button type="submit" name="submit">Submit</button>
        </form>
        <?php if ($error_message) : ?>
            <p class='error-message'><?php echo $error_message; ?></p>
            <script>
                setTimeout(function() {
                    document.querySelector('.error-message').style.display = 'none';
                }, 2000);
            </script>
        <?php endif; ?>
    </div>
    <?php if ($success_message) : ?>
        <p class='success-message'><?php echo $success_message; ?></p>
        <p class="message">You will be redirected to login page</p>
        <script>
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 5000);
        </script>
    <?php endif; ?>


    <script>
        // Function to toggle password visibility
        function togglePassword(id) {
            var x = document.getElementById(id);
            var icon = document.getElementById(id + "-icon");
            if (x.type === "password") {
                x.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                x.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>
