<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

// Check if the function is already defined to avoid redeclaration
if (!function_exists('sendEmailNotification')) {
    // Function to send email notification
    function sendEmailNotification() {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP(); // Send using SMTP
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = 'nv4866594@gmail.com'; // SMTP username
            $mail->Password   = 'ddmnssuwqrdvatkb'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
            $mail->Port       = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Recipients
            $mail->setFrom('nv4866594@gmail.com', 'IT-MARVELS');
            $mail->addAddress('nvish123456@gmail.com'); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Filtration Limit Exceeded';

            // Read the content of the malicious_attempts.log file
            $logContent = file_get_contents('malicious_attempts.log');

            // Split the log content into individual attempts
            $logLines = explode("\n\n", $logContent);

            // Remove any empty lines and trim whitespace from each line
            $logLines = array_filter(array_map('trim', $logLines));

            // Get the latest three attempts
            $latestAttempts = array_slice(array_reverse($logLines), 0, 3);

            // Construct the email body with details of the latest three attempts
            $body = 'The filtration limit has been exceeded for Admin Login Page. Please check the system.<br><br>';
            foreach ($latestAttempts as $attempt) {
                // Parse the log lines to extract details
                $attemptDetails = explode("\n", $attempt);
                // Check if the attempt details array has the expected keys
                if (count($attemptDetails) >= 4) {
                    $body .=  $attemptDetails[0] . "<br>"; // Attempt count
                    $body .=   $attemptDetails[1] . "<br>"; // Email
                    $body .=  $attemptDetails[2] . "<br>"; // Password
                    $body .=  $attemptDetails[3] . "<br><br>"; // Date and Time
                }
            }

            // If the total number of attempts exceeds three, add a note about the limit being reached
            if (count($logLines) > 3) {
                $body .= 'Note: Only the latest three attempts are shown.';
            }

            // Append the filtration limit exceeded line
            $body .= 'The filtration limit has been exceeded.';

            $mail->Body = $body;
            $mail->AltBody = 'The filtration limit has been exceeded. Please check the system.';

            // Send email
            $mail->send();
        } catch (Exception $e) {
            // Log error or display error message
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>


