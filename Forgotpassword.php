<?php
// Define log file path
$logFilePath = 'forgotPassword.log';

// Function to log password reset attempts
function logPasswordResetAttempt($email) {
    global $logFilePath;
    // Create a DateTime object with current time in UTC
    $dateTimeUTC = new DateTime('now', new DateTimeZone('UTC'));
    $dateTimeKolkata = $dateTimeUTC->setTimezone(new DateTimeZone('Asia/Kolkata'));
    $formattedDateTime = $dateTimeKolkata->format('Y-m-d h:i A');
    // Format log message
    $logMessage = "Password reset attempt for email: $email at $formattedDateTime\n ";
    file_put_contents($logFilePath, $logMessage, FILE_APPEND | LOCK_EX);
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include the function for filtering malicious input
require_once('Array_filter.php');

// Initialize error message
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the email field is empty
    if (empty($_POST['email'])) {
        $error_message = "Email is required.";
    } else {
        // Get the submitted email
        $email = $_POST['email'];

        // Check for malicious input
        if (Arraybased_Filter($email)) {
            // Log malicious attempt
            logPasswordResetAttempt($email);
            // Redirect to a fake password recovery page for malicious input
            header("Location: Reset_Pass.php");
            exit();
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Invalid email format
            $error_message = "Please enter a valid email.";
        } else {
            // Check if email exists in the database
            $sql = "SELECT * FROM customers WHERE email='$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            
                logPasswordResetAttempt($email);
                // Redirect to Reset_password.php with email as query parameter
                header("Location: Reset_password.php?email=" . urlencode($email));
                exit();
            } else {
                // Email not found in the database
                $error_message = "Email not found in the database.";
            }
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        #form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 320px;
            margin: 20px auto;
            overflow: hidden;
            margin-top: 120px;
        }

        h2 {
            color: blue;
            font-size: 20px;
            margin: 20px 0;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: width 0.3s;
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

        .error-message {
            margin-top: 5px;
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="form-container">
        <h2>Forgot Password</h2>
        <form id="reset-form" method="post" action="">
            <label>Email:</label><br>
            <input type="text" name="email"  id="email"><br>
            <br>
            <button type="submit" name="send-reset-link">Submit</button>
        </form>
        <?php if ($error_message): ?>
            <p class='error-message'><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>

    <script>
        // Function to hide error message after 2 seconds
        function hideErrorMessage() {
            var errorMessage = document.querySelector('.error-message');
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 2000);
            }
        }

        // Call the function when the page loads
        window.onload = function() {
            hideErrorMessage();
        };
    </script>
</body>
</html>
