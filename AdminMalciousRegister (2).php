<?php
include_once 'config.php';

// Check if a delete request is submitted
if(isset($_POST['delete'])) {
    $idToDelete = $_POST['delete'];
    $deleteQuery = "DELETE FROM registermalcious_attempts WHERE id = '$idToDelete'";
    if(mysqli_query($conn, $deleteQuery)) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error deleting record: " . mysqli_error($conn);
    }
}

// Fetch all login attempts initially
$query = "SELECT * FROM registermalcious_attempts";
$result = mysqli_query($conn, $query);

// Check if a search query is submitted
if(isset($_POST['search'])) {
    $filterValue = $_POST['search'];
    $filterData = "SELECT * FROM registermalcious_attempts WHERE CONCAT(id, full name,username, password,Confirm_Password,date_time) LIKE '%$filterValue%'";
    $result = mysqli_query($conn, $filterData);
    
    // Data is found on search-bar
    if(mysqli_num_rows($result) > 0) {
        $message = "Records found.";
    } 
    // Data is not found on search-bar
    else {
        $message = "Records not found.";
    }
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="Admin_Page.css">
    
</head>

<body>
    <div class="main">
        <div class="heading">
            <h1>Welcome to Admin Page</h1>
        </div>
        <div class="body">
          
        </div>
        <div class="container">
            <div class="row">
                <div class="col ">
                    <div class="info-header">
                        <h2>Tables: Register Malicious Attempts Data</h2>
                       
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>FullName</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>ConfirmPassword</th>
                                <th>DateAndTime</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['password']; ?></td>
                                    <td><?php echo $row['Confirm_Password']; ?></td>
                                    <td><?php echo $row['date_time']; ?></td>
                                    <td>
                                        <form method="POST">
                                            <button type="submit" name="delete" value="<?php echo $row['id']; ?>">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='7'>No records found.</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


