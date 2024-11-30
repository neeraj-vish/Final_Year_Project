<?php
require_once('Admin_db.php');

if(isset($_POST['disapprove'])) {
    $user_id = $_POST['user_id'];
    
    // Update the status to 'disapproved' in the database
    $query = "UPDATE customers SET status='disapprove' WHERE ID=$user_id";
    $result = mysqli_query($con, $query);
    
    if($result) {
        // Redirect back to the admin page
        header("Location: Admin_page.php");
        exit;
    } else {
        echo "Failed to disapprove user.";
    }
}
?>
