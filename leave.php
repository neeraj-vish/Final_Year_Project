<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['email'])) {
    header("location: login.php");
    exit;
}

// Check if logout is requested
if (isset($_GET['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("location: login.php");
    exit;
}

// Database configuration
$db_host = 'localhost'; 
$db_username = 'root';
$db_password = ''; 
$db_name = 'employee'; 

// Create database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$successMessage = "";
$error = "";
$count = 0;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['user']['email'];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $reason = $_POST["reason"];

    // Calculate leave duration
    $leaveDuration = floor((strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24)) + 1;

    // Get the current year and month
    $currentYear = date('Y');
    $currentMonth = date('m');

    // Check if the email exists in the customers table
    $emailCheckQuery = "SELECT 1 FROM customers WHERE email = ?";
    $stmtEmailCheck = $conn->prepare($emailCheckQuery);
    $stmtEmailCheck->bind_param("s", $email);
    $stmtEmailCheck->execute();
    $stmtEmailCheck->store_result();

    if ($stmtEmailCheck->num_rows == 0) {
        $error = 'Entered email does not exist.';
    } else {
        $stmtEmailCheck->close();

        // Count the number of leave applications for the current user in the current month
        $leaveApplicationsQuery = "SELECT COUNT(*) AS TotalApplications FROM leave_applications WHERE employeeName = ? AND YEAR(startDate) = ? AND MONTH(startDate) = ?";
        $stmtLeaveApplications = $conn->prepare($leaveApplicationsQuery);
        $stmtLeaveApplications->bind_param("sii", $email, $currentYear, $currentMonth);
        $stmtLeaveApplications->execute();
        $stmtLeaveApplications->bind_result($totalApplications);
        $stmtLeaveApplications->fetch();
        $stmtLeaveApplications->close();

        // Perform validations based on business rules
        if ($totalApplications > 0) {
            $error = 'You can only submit one leave application per month.';
        } elseif ($end_date < $start_date) {
            $error = 'End date must be greater than start date.';
        } elseif ($leaveDuration > 4) {
            $error = 'Leave duration exceeds the maximum allowed limit (4 days).';
        } elseif (date('m', strtotime($start_date)) != date('m', strtotime($end_date)) || date('Y', strtotime($start_date)) != $currentYear || date('Y', strtotime($end_date)) != $currentYear) {
            $error = 'Start and end dates must be within the same month and the current year.';
        } else {
            // Submit leave application
            $submitLeaveQuery = "INSERT INTO leave_applications (employeeName, startDate, endDate, reason) VALUES (?, ?, ?, ?)";
            $stmtSubmitLeave = $conn->prepare($submitLeaveQuery);
            $stmtSubmitLeave->bind_param("ssss", $email, $start_date, $end_date, $reason);
            if ($stmtSubmitLeave->execute()) {
                $successMessage = 'Leave application submitted successfully!';
                $count = $totalApplications + 1; // Increment TotalApplications count after successful submission
                
            } else {
                $error = 'Error submitting leave application: ' . $conn->error;
            }
            $stmtSubmitLeave->close();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 550px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        textarea,
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: blue;
            margin-bottom: 10px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        .btn-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-container button:hover {
            background-color: #45a049;
        }

        .logout-btn {
            background-color: #f44336;
            margin-left: auto;
        }

        .logout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome <?php echo $_SESSION['user']['email']; ?></h2>
        <h2>Leave Application Form</h2>
        <?php if ($successMessage): ?>
            <h2 style="color:blue" id="countMessage">Total Application Count: <?php echo $count; ?></h2>
            <script>
        setTimeout(function() {
            var successMessage = document.querySelector('.success');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            document.getElementById('countMessage').style.display = 'none';
        }, 2000); // Hide after 2 seconds
    </script>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <div>
                <label for="reason">Reason:</label>
                <textarea id="reason" name="reason" required></textarea>
            </div>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="success"><?php echo $successMessage; ?></div>
            <div class="btn-container">
                <button type="submit" name="submit">Submit</button>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </form>
    </div>

    <script>
        function logout() {
            var confirmLogout = confirm("Are you sure you want to logout?");
            if (confirmLogout) {
                window.location.href = "leave.php?logout=1";
            }
        }
    </script>
</body>
</html>


