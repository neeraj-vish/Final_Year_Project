<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Function to send approval email
function sendApprovalEmail($recipient_email) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Enable verbose debug output
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Show debug output for troubleshooting
        $mail->isSMTP(); // Send using SMTP
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'nv4866594@gmail.com'; // SMTP username
        $mail->Password   = 'ddmnssuwqrdvatkb'; // SMTP password (ensure it's an App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
        $mail->Port       = 465; // TCP port to connect to (use 587 for STARTTLS)

        // Recipients
        $mail->setFrom('nv4866594@gmail.com', 'IT-MARVELS');
        $mail->addAddress($recipient_email); // Add recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Registration Approved';
        $mail->Body    = 'Dear User,<br><br>Your registration has been approved. You can now log in to your account.<br><br>Best regards,<br>IT-MARVELS';

        // Send email
        $mail->send();
        echo "Email sent successfully to $recipient_email<br>";
    } catch (Exception $e) {
        // Log error and display it for debugging
        error_log("Mailer Error: {$mail->ErrorInfo}");
        echo "Mailer Error: {$mail->ErrorInfo}<br>";
    }
}

// Include your database connection file
require_once('Admin_db.php');

// Change user status if admin action is submitted
if (isset($_POST['change_status'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];

    // Update user status in the database
    $update_query = "UPDATE customers SET status='$new_status' WHERE ID=$user_id";
    
    if (mysqli_query($con, $update_query)) {
        echo "Status updated successfully for user ID: $user_id<br>";

        if ($new_status == "Approved") {
            // Fetch user email from customers table
            $email_query = "SELECT email FROM customers WHERE ID=$user_id";
            $email_result = mysqli_query($con, $email_query);

            if ($email_result && mysqli_num_rows($email_result) > 0) {
                $row = mysqli_fetch_assoc($email_result);
                $user_email = $row['email'];

                if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                    // Send approval email
                    sendApprovalEmail($user_email);
                } else {
                    echo "Invalid email format: $user_email<br>";
                }
            } else {
                echo "Error: Failed to retrieve user email for user ID: $user_id<br>";
                error_log("Failed to retrieve email for user ID: $user_id");
            }
        }

        // Redirect after processing
        header("Location: admin_page.php");
        exit();
    } else {
        // Error occurred while updating status
        echo "Database Error: " . mysqli_error($con) . "<br>";
        error_log("Database Error: " . mysqli_error($con));
    }
}
?>
