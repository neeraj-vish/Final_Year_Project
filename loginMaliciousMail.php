<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require_once('config.php');
require_once('Prepared_statement.php');
require_once('Input_validation.php');
require_once('Array_filter.php');

$error_message = '';
$redirectPageMalicious = "Leave_Application.php";
$redirectPageNonMalicious = "leave.php";

// Function to send email notification
function sendEmailNotification($latestAttempts)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nv4866594@gmail.com';
        $mail->Password = 'ddmnssuwqrdvatkb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('nv4866594@gmail.com', 'IT-MARVELS');
        $mail->addAddress('nvish123456@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Filtration Limit Exceeded';

        $body = 'The filtration limit has been exceeded for Login Page. Please check the system.<br><br>';
        foreach ($latestAttempts as $attempt) {
            $body .= 'Email: ' . $attempt['email'] . "<br>";
            $body .= 'Password: ' . $attempt['password'] . "<br>";
            $body .= 'Date and Time: ' . $attempt['attempt_time'] . "<br><br>";
        }
        $body .= 'Note:- Three detail is automatically deleted after multiple four attempts.';

        $mail->Body = $body;
        $mail->AltBody = 'The filtration limit has been exceeded. Please check the system.';

        if (!$mail->send()) {
            throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
        } else {
            include 'Logindelete_records.php';
        }
    } catch (Exception $e) {
        error_log('Error sending email: ' . $e->getMessage());
    }
}

// Function to get total count of malicious attempts from the database
function getTotalMaliciousAttempts()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM login_malicious_attempts";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = Arraybased_Filter($_POST["username"]);
    $password = Arraybased_Filter($_POST["pass"]);
    $date_time = date("Y-m-d H:i:s");

    logAttempt($email, $password);

    $totalCount = getTotalMaliciousAttempts();
    if ($totalCount > 0 && $totalCount % 4== 0) {
        $latestAttempts = array();
        $sql = "SELECT email, password, attempt_time FROM login_malicious_attempts ORDER BY attempt_time DESC LIMIT 2";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $latestAttempts[] = $row;
            }
            sendEmailNotification($latestAttempts);
        }
    }
}
?>


