<?php
// Establish database connection
$db_host = 'localhost'; 
$db_username = 'root';
$db_password = ''; 
$db_name = 'employee'; 

// Create database connection
$con = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if ID is set in the POST request
if(isset($_POST['ID'])) {
    $id = $_POST['ID'];

    // Delete query
    $sql = "DELETE FROM leave_applications WHERE ID = $id";
    
    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if the query executed successfully
    if ($result) {
        echo "Leave application deleted successfully!";
    } else {
        echo "Error deleting leave application: " . mysqli_error($con);
    }
} else {
    // If ID is not set, redirect back to the same page
    header("Location: Admin_leaveappPage.php");
    exit();
}

// Close database connection
mysqli_close($con);
?>
