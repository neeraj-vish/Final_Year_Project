<?php
include("config.php");

//  check if email already exists
if (!function_exists('emailExists')) {
    function emailExists($email) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM customers WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}

//  check email and password already exist
if (!function_exists('emailAndPasswordExist')){
function emailAndPasswordExist($email, $password) {
    global $conn;
    
    $hashedPass = md5($password);

    $stmt = $conn->prepare("SELECT * FROM customers WHERE email=? AND pass=?");
    $stmt->bind_param("ss", $email, $hashedPass);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}
}


// User Registration

function registerUser($email, $password, $fullname, $confirmPassword) {
    global $conn;

    // Check if the email already exists
    if (emailExists($email)) {
        return "The email is already in use";
    } else {
        // Hash the passwords using bcrypt
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $hashedConfPass = password_hash($confirmPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO customers (Name, email, pass, Confirm_Password, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param("ssss", $fullname, $email, $hashedPass, $hashedConfPass);

        if ($stmt->execute()) {
            return "Pending registration. Email coming soon."; 
        } else {
            return "Failed to create account"; 
        }
    }
}

// Function to check if the password already exists
function passwordExists($hashedPass) {
    global $conn;

    $stmt = $conn->prepare("SELECT COUNT(*) FROM customers WHERE pass = ?");
    $stmt->bind_param("s", $hashedPass);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}


// User login

session_start();

require_once('checksumEncryption.php');
require_once('config.php');
require_once('ban.php');
require_once('Prepared_statement.php');
require_once('Input_validation.php');
require_once('Array_filter.php');
require_once('loginMaliciousMail.php');

function logAttempt($email, $password)
{
    if (empty($email) || empty($password)) {
        return false;
    }

    $encrypted_email = encrypt_data($email);
    $encrypted_password = encrypt_data($password);

    $conn = new mysqli("localhost", "root", "", "employee");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM customers WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) {
            $stmt = $conn->prepare("INSERT INTO customers (email, pass) VALUES (?, ?)");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ss", $encrypted_email, $encrypted_password);
            if (!$stmt->execute()) {
                die("Execute failed: " . $stmt->error);
            }
            $stmt->close();
        }
    }

    $conn->close();
    save_encrypted_data($email, $password);

    return true;
}

if (!function_exists('logMaliciousAttempt')) {
function logMaliciousAttempt($email, $password)
{
    $conn = new mysqli("localhost", "root", "", "employee");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO login_malicious_attempts (email, password) VALUES (?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $email, $password);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
}

function validateLogin($email, $password)
{
    $conn = new mysqli("localhost", "root", "", "employee");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT pass, status FROM customers WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($db_password, $status);
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        if ($status === 'approved' && password_verify($password, $db_password)) {
            return true;
        } else {
            return $status === 'approved' ? false : $status;
        }
    }

    return false;
}







//Admin Login Page

if (!function_exists('loginAdmin')){
    // session_start();
    include("config.php");
    
    // Function to check admin login
    function loginAdmin($email, $password) {
        global $conn;
    
        $qry = "SELECT * FROM adminlogin WHERE email_id=? AND pass=?";
        $stmt = $conn->prepare($qry);
    
        if (!$stmt) {
            $errorMessage = "<h4 style='color:red; margin:10px 0px 0px 60px; font-size:20px; text-shadow: 1px 1px 0px red'>Database Error</h4>";
            return false;
        }
        
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>










