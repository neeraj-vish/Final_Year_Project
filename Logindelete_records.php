<?php

require_once('config.php');

// Function to delete the first three records from the database
function deleteFirstThreeRecords()
{
    global $conn;
    $sql = "DELETE FROM login_malicious_attempts ORDER BY attempt_time ASC LIMIT 3";
    if ($conn->query($sql) === TRUE) {
        // echo "First three records deleted successfully!";
    } else {
        echo "Error deleting records: " . $conn->error;
    }
}

deleteFirstThreeRecords();
?>
