<?php
require_once('Admin_db.php');

if(isset($_POST['pending'])) {
    $user_id = $_POST['user_id'];
    
    // Update the status to 'disapproved' in the database
    $query = "UPDATE customers SET status='pending' WHERE ID=$user_id";
    $result = mysqli_query($con, $query);
    
    if($result) {
        // Redirect back to the admin page
        header("Location: Admin_page.php");
        exit;
    } else {
        echo "Failed to pending user.";
    }
}
?>