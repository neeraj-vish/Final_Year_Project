<?php
session_start();

// Initialize variables
$successMessage = "";
$error = "";
$count = 0;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate start date and end date
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    if ($end_date < $start_date) {
        $error = "End date must be greater than or equal to start date";
    } else {
        // Set a predefined success message (fake submission)
        $successMessage = "Leave application submitted successfully!";
        // Increment the count
        // $_SESSION['count'] = isset($_SESSION['count']) ? $_SESSION['count'] + 1 : 1;
        // $count = $_SESSION['count'];
        // Clear the success message after 2 seconds
        echo "<script>setTimeout(() => {document.querySelector('.success').innerHTML = '';}, 5000);</script>";
        
        // Log form submission details
        $log_data = "User Details:\n";
        foreach ($_POST as $key => $value) {
            // Skip the "submit" key
            if ($key !== "submit") {
                $log_data .= "$key: $value\n";
            }
        }

        date_default_timezone_set('Asia/Kolkata');
        $dateTime = date('Y-m-d h:i A');
        $log_data .= "Submission Time: $dateTime\n";
        // Include submission attempt count
        // $log_data .= "Submission Attempt: $count\n\n\n";
        
        // Write to log file
        $log_file = "Leave_Application.log";
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }
}

// Clear the error message after 2 seconds
if ($error) {
    echo "<script>setTimeout(() => {document.querySelector('.error').innerHTML = '';}, 5000);</script>";
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
        <h2>Leave Application Form</h2>
        <h2>Welcome User !!!</h2>
        <?php if ($successMessage): ?>
            <!-- <h2 style="color:blue">Total Application Count: <?php echo $count; ?></h2> -->
            <div class="success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div>
                <label for="user_email">Email:</label>
                <input type="email" id="user_email" name="user_email" required>
            </div>
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





