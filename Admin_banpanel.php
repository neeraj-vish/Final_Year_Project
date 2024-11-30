<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            margin: 0 auto;
            max-width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        form {
            margin-top: 10px;
            text-align: center;
        }

        select, input[type="text"], input[type="submit"] {
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        h2 {
            color: red;
            margin-top: 20px;
        }

        h1 {
            margin-top: 40px;
        }

        .update {
            margin-top: 20px;
        }

        h3 {
            background-color: black;
            color: red;
            width: 100%;
            height: 30px;
            margin: 0px;
            padding: 12px;
        }
        #error {
            color: red;
            display: none; 
        }
        #banRemovedMessage,#userDeletedMessage{
            color:red
        }
    </style>
</head>
<body>
<h3>Welcome to Admin Page</h3>
    <div class="container">
        <h1>User Login Ban Records</h1>
        <h2>Ban User by IP Address</h2>
        <form id="banForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
            <label for="ip_address">IP Address:</label>
            <input type="text" id="ip_address" name="ip_address">
            <label for="ban_duration">Ban Duration:</label>
            <select id="ban_duration" name="ban_duration">
                <option value="15">15 minutes</option>
                <option value="30">30 minutes</option>
                <option value="60">1 hour</option>
                <option value="1440">1 day</option>
            </select>
            <input type="submit" value="Ban User" class="update">
        </form>
         <!-- Error message for IP address validation -->
    <p id="error" style="color: red; display: none;">Please enter the IP address.</p>
    <!-- Ban success message -->
    <p id="success" style="color: green; display: none;">User banned successfully!</p>
    


        <?php
        date_default_timezone_set('Asia/Kolkata');

        // Database connection details
        $dsn = "mysql:host=localhost;dbname=employee";
        $username = 'root';
        $password = '';

        // Function to mark expired bans
        function markExpiredBans($con) {
            try {
                // Fetch current time
                $current_time = date('Y-m-d H:i:s');
                
                // Mark expired bans
                $query = "UPDATE bannedtable SET expired = 1 WHERE TIMESTAMPADD(MINUTE, ban_duration, banned) <= :current_time";
                $stm = $con->prepare($query);
                $stm->execute(['current_time' => $current_time]);
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }

        // Function to remove a ban
        function removeBan($id, $con) {
            try {
                $query = "UPDATE bannedtable SET expired = 1, ban_end_time = NULL, ban_duration = NULL WHERE id = :id";
                $stm = $con->prepare($query);
                $stm->execute(['id' => $id]);
                echo "<p id='banRemovedMessage'>User ban removed successfully!</p>";
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }

        // Function to delete a user record
        function deleteUser($id, $con) {
            try {
                $query = "DELETE FROM bannedtable WHERE id = :id";
                $stm = $con->prepare($query);
                $stm->execute(['id' => $id]);
                echo "<p id='userDeletedMessage'>User deleted successfully!</p>";

            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }

        // Handle form submission to ban user by IP Address
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['ip_address'])) {
                try {
                    // Establish database connection
                    $con = new PDO($dsn, $username, $password);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Get data from form
                    $ip_address = $_POST['ip_address'];
                    $ban_duration = $_POST['ban_duration'];

         // Calculate ban end time
                    $ban_time = date("Y-m-d H:i:s");
                    $ban_end_time = date("Y-m-d H:i:s", strtotime("$ban_time + $ban_duration minutes"));

                    // Check if IP address already exists
                    $query = "SELECT COUNT(*) FROM bannedtable WHERE ip_address = :ip_address";
                    $stm = $con->prepare($query);
                    $stm->execute(['ip_address' => $ip_address]);
                    $ip_exists = $stm->fetchColumn();

                    if ($ip_exists) {
                        // Update existing record
                        $query = "UPDATE bannedtable SET banned = :ban_time, ban_duration = :ban_duration, ban_end_time = :ban_end_time, expired = 0 WHERE ip_address = :ip_address";
                        $stm = $con->prepare($query);
                        $stm->execute(['ban_time' => $ban_time, 'ban_duration' => $ban_duration, 'ban_end_time' => $ban_end_time, 'ip_address' => $ip_address]);
                        // echo "<p>User ban updated successfully!</p>";
                    } else {
                        // Insert new record
                        $query = "INSERT INTO bannedtable (ip_address, banned, ban_duration, ban_end_time, expired) VALUES (:ip_address, :ban_time, :ban_duration, :ban_end_time, 0)";
                        $stm = $con->prepare($query);
                        $stm->execute(['ip_address' => $ip_address, 'ban_time' => $ban_time, 'ban_duration' => $ban_duration, 'ban_end_time' => $ban_end_time]);
                        // echo "<p>User banned successfully!</p>";
                    }
                } catch (PDOException $e) {
                    // Handle database connection errors
                    echo "Database error: " . $e->getMessage();
                }
            } elseif (isset($_POST['remove_ban'])) {
                try {
                    // Establish database connection
                    $con = new PDO($dsn, $username, $password);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Remove the ban for the user
                    removeBan($_POST['remove_ban'], $con);
                } catch (PDOException $e) {
                    // Handle database connection errors
                    echo "Database error: " . $e->getMessage();
                }
            } elseif (isset($_POST['delete_user'])) {
                try {
                    // Establish database connection
                    $con = new PDO($dsn, $username, $password);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Delete the user record
                    deleteUser($_POST['delete_user'], $con);
                } catch (PDOException $e) {
                    // Handle database connection errors
                    echo "Database error: " . $e->getMessage();
                }
            }
        }

        // Display banned users
        try {
            // Establish database connection
            $con = new PDO($dsn, $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Mark expired bans before displaying
            markExpiredBans($con);

            // Fetch banned users including expired ones
            $query = "SELECT id, ip_address, banned, login_count, rounded, ban_end_time, ban_duration, expired FROM bannedtable";
            $stm = $con->prepare($query);
            $stm->execute();
            $bannedUsers = $stm->fetchAll(PDO::FETCH_ASSOC);

            echo "<table>";
            echo "<tr><th>ID</th><th>IP Address</th><th>Banned</th><th>Login Count</th><th>Rounded</th><th>Ban End Time</th><th>Status</th><th>Actions</th></tr>";
            foreach ($bannedUsers as $user) {
                echo "<tr>";
                echo "<td>".$user['id']."</td>";
                echo "<td>".$user['ip_address']."</td>";
                echo "<td>".$user['banned']."</td>";
                echo "<td>".$user['login_count']."</td>";
                echo "<td>".$user['rounded']."</td>";
                echo "<td>".$user['ban_end_time']."</td>";
                // Determine status based on ban_end_time and banned columns
                $status = (strtotime($user['ban_end_time']) > time()) ? '<span style="color: green;">Active</span>' : '<span style="color: red;">Expired</span>';
                echo "<td>".$status."</td>";
                echo "<td>
                        <form action='".$_SERVER['PHP_SELF']."' method='post' style='display:inline;'>
                            <input type='hidden' name='remove_ban' value='".$user['id']."'>
                            <input type='submit' value='Remove Ban'>
                        </form>
                        <form action='".$_SERVER['PHP_SELF']."' method='post' style='display:inline;'>
                            <input type='hidden' name='delete_user' value='".$user['id']."'>
                            <input type='submit' value='Delete User'>
                        </form>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } catch (PDOException $e) {
            // Handle database connection errors
            echo "Database error: " . $e->getMessage();
        }
        ?>
    </div>
    
    <script>
    // Function to validate form before submission
    function validateForm() {
        var ipAddress = document.getElementById("ip_address").value;
        if (ipAddress.trim() === "") {
            document.getElementById("error").style.display = "block";
            setTimeout(function() {
                document.getElementById("error").style.display = "none";
            }, 2000);
            return false;
        }
        return true;
    }

    // Function to delay display and hide elements after 2 seconds
    setTimeout(function() {
        document.getElementById("banForm").style.display = "block";
    }, 2000);

    // Function to show and hide ban success message and other PHP messages
    <?php
    // Check if form submitted and ban successful
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ip_address'])) {
        echo "document.getElementById('success').style.display = 'block';";
    }
    // Hide success message after 2 seconds
    echo "setTimeout(function() {
            document.getElementById('success').style.display = 'none';
        }, 2000);";
    ?>

    // Function to hide other PHP messages after 2 seconds
    setTimeout(function() {
        var banRemovedMessage = document.getElementById('banRemovedMessage');
        var userDeletedMessage = document.getElementById('userDeletedMessage');
        if (banRemovedMessage) {
            banRemovedMessage.style.display = 'none';
        }
        if (userDeletedMessage) {
            userDeletedMessage.style.display = 'none';
        }
    }, 2000);
    
</script>
</body>
</html>



