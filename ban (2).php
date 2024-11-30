<?php
// session_start(); // Start session
date_default_timezone_set('Asia/Kolkata');

require_once('Array_filter.php');

function get_ip() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    } else {
        return "";
    }
}

function increment_login_count($id, $con) {
    try {
        // Get current login count, rounds, ban duration, and timestamp
        $query = "SELECT login_count, rounded, banned, ban_duration, last_attempt FROM bannedtable WHERE id = :id LIMIT 1";
        $stm = $con->prepare($query);
        $stm->execute(['id' => $id]);
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        $current_time = date("Y-m-d H:i:s");
        $last_attempt = $row['last_attempt'];
        $time_diff = strtotime($current_time) - strtotime($last_attempt);

        // Reset login count and rounded if 24 hours have passed
        if ($time_diff > 86400) { // 86400 seconds in 24 hours
            $login_count = 0;
            $rounded = 0;
            $ban_duration = 0;
            $ban_end_time = "0000-00-00 00:00:00";
        } else {
            $login_count = $row['login_count']; // Get current login count
            $rounded = $row['rounded']; // Get current round

            if ($login_count >= 4) {
               
                $login_count = 0;
                $rounded += 1;
                $ban_duration = 2; 

                // Update the database immediately for ban and reset login count
                $ban_time = date("Y-m-d H:i:s"); 
                $ban_end_time = date("Y-m-d H:i:s", strtotime("$ban_time + $ban_duration minutes"));
                $query = "UPDATE bannedtable SET login_count = :login_count, banned = :ban_time, rounded = :rounded, ban_duration = :ban_duration, ban_end_time = :ban_end_time, last_attempt = :last_attempt WHERE id = :id";
                $stm_update = $con->prepare($query);
                $stm_update->execute([
                    'login_count' => $login_count,
                    'ban_time' => $ban_time,
                    'rounded' => $rounded,
                    'ban_duration' => $ban_duration,
                    'ban_end_time' => $ban_end_time,
                    'last_attempt' => $current_time,
                    'id' => $id
                ]);
                header("Location: denial.php");
                exit;
            } else {
                // Increment login count for the current round
                $login_count += 1;
            }
        }

        // Update login count, rounds, and last attempt in the database
        $query = "UPDATE bannedtable SET login_count = :login_count, rounded = :rounded, last_attempt = :last_attempt, ban_duration = :ban_duration, ban_end_time = :ban_end_time WHERE id = :id";
        $stm_update = $con->prepare($query);
        $stm_update->execute([
            'login_count' => $login_count,
            'rounded' => $rounded,
            'last_attempt' => $current_time,
            'ban_duration' => $login_count == 0 ? 0 : (isset($row['ban_duration']) ? $row['ban_duration'] : 0),
            'ban_end_time' => $login_count == 0 ? "0000-00-00 00:00:00" : (isset($row['ban_end_time']) ? $row['ban_end_time'] : "0000-00-00 00:00:00"),
            'id' => $id
        ]);

    } catch (PDOException $e) {
        // Handle database errors
        die("Database error: " . $e->getMessage());
    }
}

function check_if_banned($malicious_attempt) {
    $dsn = "mysql:host=localhost;dbname=employee";
    $username = 'root';
    $password = '';

    try {
        $con = new PDO($dsn, $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $ip = get_ip();

        // Check if there's an existing record for the user
        $query = "SELECT * FROM bannedtable WHERE ip_address = :ip LIMIT 1";
        $stm = $con->prepare($query);
        $stm->execute(['ip' => $ip]);
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $current_time = date("Y-m-d H:i:s");
            $ban_end_time = $row['ban_end_time'];
            $time_diff = strtotime($current_time) - strtotime($row['last_attempt']);

            if ($time_diff > 86400) { // 86400 seconds in 24 hours
                // Reset login count and rounded if 24 hours have passed
                $query = "UPDATE bannedtable SET login_count = 0, rounded = 0, ban_duration = 0, ban_end_time = '0000-00-00 00:00:00', last_attempt = :current_time WHERE id = :id";
                $stm_update = $con->prepare($query);
                $stm_update->execute(['current_time' => $current_time, 'id' => $row['id']]);
            }

            if (strtotime($current_time) < strtotime($ban_end_time)) {
                // User is currently banned
                header("Location: denial.php");
                exit;
            } else {
                // Reset ban_duration to 0 if not currently banned
                $query = "UPDATE bannedtable SET ban_duration = 0, ban_end_time = '0000-00-00 00:00:00' WHERE id = :id";
                $stm_update = $con->prepare($query);
                $stm_update->execute(['id' => $row['id']]);
                
                // Increment login count if this is a malicious attempt
                if ($malicious_attempt) {
                    increment_login_count($row['id'], $con);
                }
            }
        } else {
            if ($malicious_attempt) {
                // Insert a new record for the user
                $login_count = 1;
                $rounded = 0; // Initial round
                $ban_time = date("Y-m-d H:i:s");
                $ban_duration = 0;
                $ban_end_time = "0000-00-00 00:00:00";
                $current_time = date("Y-m-d H:i:s");

                $query = "INSERT INTO bannedtable (ip_address, login_count, banned, rounded, ban_duration, ban_end_time, last_attempt) VALUES (:ip, :login_count, :ban_time, :rounded, :ban_duration, :ban_end_time, :last_attempt)";
                $stm_insert = $con->prepare($query);
                $stm_insert->execute([
                    'ip' => $ip,
                    'login_count' => $login_count,
                    'ban_time' => $ban_time,
                    'rounded' => $rounded,
                    'ban_duration' => $ban_duration,
                    'ban_end_time' => $ban_end_time,
                    'last_attempt' => $current_time
                ]);
            }
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Assuming you call check_if_banned with the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $malicious_attempt = isset($_SESSION['login_success']) && $_SESSION['login_success'] === false;
    check_if_banned($malicious_attempt);
    $_SESSION['login_success'] = null; // Reset for next attempt
}
?>
