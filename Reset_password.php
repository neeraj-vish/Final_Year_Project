<?php
include('Input_validation.php');

// Initialize variables for messages
$error_message = "";
$success_message = "";

// Function to check if password and confirm password match
function checkPasswordMatch($password, $confirm_password) {
    if ($password !== $confirm_password) {
        return false;
    }
    return true;
}

// Check if email parameter exists in URL
if (!isset($_GET['email'])) {
    // Redirect user back to forgot password page if email parameter is missing
    header("Location: Forgot_Password.php");
    exit();
}

// Get the email from the URL query parameter
$email = $_GET['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "employee";

    try {
        // Create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if passwords match
        if (checkPasswordMatch($password, $confirm_password)) {
            // Hash the password using bcrypt
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Update password in the database
            $stmt = $conn->prepare("UPDATE customers SET pass = :password WHERE email = :email");
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);

            // Execute the update query
            if ($stmt->execute()) {
                // Password updated successfully
                $success_message = "Password reset successfully. You will be redirected to login shortly.";

                // Redirect to login.php after 5 seconds
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "login.php";
                        }, 5000);
                      </script>';
            } else {
                // If the update query fails, set an error message
                $error_message = "Failed to reset password. Please try again.";
            }
        } else {
            // Set error message for password mismatch
            $error_message = "Passwords and confirm Password do not match.";
        }
    } catch(PDOException $e) {
        // Set error message for database connection failure
        $error_message = "Connection failed: " . $e->getMessage();
    } finally {
        $conn = null; // Close connection
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
            margin: 20px 0;
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
        }
        label {
            font-weight: bold;
            margin-bottom: 5px; 
            display: block; 
        }
        input[type="password"], input[type="email"] {
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
            clear: both; /* Clear the float */
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message, .success-message {
            margin-top: 5px;
            clear: both; /* Clear the float */
            text-align: center; /* Center align messages */
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
<form id="reset-form" method="post" action="">
    <h2>Reset Password</h2>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly><br>
    <label for="password">Password:</label>
    <div style="position: relative;"> 
        <input type="password" id="password" name="password" required>
        <span class="password-toggle" onclick="togglePassword('password')" style="position: absolute; top: 25px; right: 5px;"><i class="fa fa-eye" id="pass-icon"></i></span>
    </div>
    <br>
    <label for="confirm_password">Confirm Password:</label>
    <div style="position: relative;"> 
        <input type="password" id="confirm_password" name="confirm_password" required>
        <span class="password-toggle" onclick="togglePassword('confirm_password')" style="position: absolute; top: 25px; right: 5px;"><i class="fa fa-eye" id="confirm-pass-icon"></i></span>
    </div>
    <br><br><br>
    <button type="submit" name="submit">Submit</button>
    <div class="error-message"><?php echo $error_message; ?></div>
</form>
<div class="success-message"><?php echo $success_message; ?></div>

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



