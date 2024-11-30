<?php
require_once('config.php');
require_once('Prepared_statement.php');
require_once('Input_validation.php');
require_once('Array_filter.php');


$error_message = '';
$success_message = '';

if (isset($_POST['submit'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['Confirm_Password'];

    // Check if any field is empty
    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error_message = "All fields are required";
    } else {
        // Check if the input is not considered malicious
        if (!Arraybased_Filter($fullname) && !Arraybased_Filter($email) && !Arraybased_Filter($password) && !Arraybased_Filter($confirmPassword)) {
            // Validate the inputs
            if (!validateName($fullname)) {
                $error_message = "Invalid name format";
            } elseif (!validateEmail($email)) {
                $error_message = "Invalid email format";
            } elseif (!validatePassword($password)) {
                $error_message = "Invalid password format";
            } elseif ($password !== $confirmPassword) {
                $error_message = "Password and confirmation password do not match";
            } else {
                // Insert user with pending status
                $status = 'pending'; // Default status
                $result = registerUser($email, $password, $fullname, $status);

                if ($result === true) {
                    $success_message = "Your registration is pending approval.";
                } else {
                    $error_message = $result;
                }
            }
        } else {
            // Log malicious attempt
            logMaliciousAttempt($fullname, $email, $password, $confirmPassword, $conn);
            // $error_message = "Malicious input detected";
        }
    }
}

function logMaliciousAttempt($fullname, $email, $password, $confirmPassword, $conn)
{
    // Prepare and execute SQL statement to insert into the registermalcious_attempts table
    $stmt = $conn->prepare("INSERT INTO registermalcious_attempts (fullname, username, password, confirm_password) VALUES (?, ?, ?, ?)");

    // Check for errors in preparing the statement
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssss", $fullname, $email, $password, $confirmPassword);

    // Execute the statement
    $success = $stmt->execute();

    // Check for errors in executing the statement
    if (!$success) {
        die("Error executing statement: " . $stmt->error);
    }

    function passwordExists($hashedPass)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT COUNT(*) FROM customers WHERE pass = ?");
        $stmt->bind_param("s", $hashedPass);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }

    // Close the statement
    $stmt->close();
}
?>



<html>

<head>
    <title>Signup</title>
    <link rel="stylesheet" href="Registration.css">

    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <?php
    include('heading.php');
    ?>

    <div class="main">
        <div class="container" style="height: 540px;margin-top: 50px;">
            <div class="inner-container">
                <h1> Register Here </h1>
                <form class="division" action="" method="post" onsubmit="return validateForm()">
                    <label>Name:</label><br>
                    <input type="text" name="fullname" style="padding:3px"><br><br>
                    <label>Email:</label><br>
                    <input type="email" name="username" id="email" style="padding:3px"><br><br>
                    <label>Password:</label><br>
                    <input type="password" name="password" id="pass" style="padding:3px">
                    <!-- Eye icon for showing/hiding password -->
                    <span class="password-toggle" onclick="togglePassword('pass')"><i id="pass-icon" class="fa fa-eye"></i></span>
                    <br><br>
                    <label>Confirm Password:</label><br>
                    <input type="password" name="Confirm_Password" id="confirm_pass" style="padding:3px">
                    <!-- Eye icon for showing/hiding confirmation password -->
                    <span class="password-toggle" onclick="togglePassword('confirm_pass')"><i id="confirm-pass-icon" class="fa fa-eye"></i></span>
                    <br><br>
                    <!-- Honeypot field -->
                    <input type="text" name="honeypot" style="display: none;">
                    <button type="submit" name="submit" class="btn_dark" style="padding:3px;">Submit</button>
                    <button type="reset" name="Reset" style="padding:3px;">Reset</button>
                    <a href="login.php">Back to login page</a>
                </form>
                <!-- Error message display -->
                <div id="error-msg" style="color: red; margin: 10px 0px 0px 45px; font-size:22px ">
                    <?php echo $error_message; ?>
                </div>
                <!-- Success message display -->
                <div id="success-msg" style="color: green;  margin: 10px 0px 0px 5px;  font-size:20px">
                    <div id="success_message" style="color: blue; margin: 10px 0px 0px 45px; font-size:22px ">

                        <?php echo $success_message; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

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

        // Function to validate form before submission
        function validateForm() {
            var password = document.getElementById("pass").value;
            var Confirm_Password = document.getElementById("confirm_pass").value;

            if (password !== Confirm_Password) {
                document.getElementById("error-msg").innerHTML = "Password and confirmation password do not match";
                return false;
            }

            return true;
        }

        // Function to hide messages of error and success after 2 seconds
        setTimeout(function() {
            document.getElementById("error-msg").style.display = "none";
            document.getElementById("success-msg").style.display = "none";
        }, 5000);
    </script>

</body>

</html>