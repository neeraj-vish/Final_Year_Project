<?php
require_once('Admin_db.php');

if(isset($_POST['approve'])) {
    $user_id = $_POST['user_id'];
    
    // Update the status to 'approved' in the database
    $query = "UPDATE customers SET status='approve' WHERE ID=$user_id";
    $result = mysqli_query($con, $query);
    
    if($result) {
        header("Location: Admin_Page.php");
        exit;
    } else {
        echo "Failed to approve user.";
    }
}
?>
