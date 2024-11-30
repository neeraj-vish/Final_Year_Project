<?php
include_once 'config.php';

// Fetch all login attempts initially
$query = "SELECT * FROM login_malicious_attempts";
$result = mysqli_query($conn, $query);

// Check if a search query is submitted
if(isset($_POST['search'])) {
    $filterValue = $_POST['search'];
    $filterData = "SELECT * FROM login_malicious_attempts WHERE CONCAT(id, email, password,attempt_time) LIKE '%$filterValue%'";
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
                        <h2>Tables: Login Malicious Attempts Data</h2>
                       
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>DateAndTime</th>
                                
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['password']; ?></td>
                                    <td><?php echo $row['attempt_time']; ?></td>
                                   
                                </tr>
                            <?php
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
