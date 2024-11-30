<?php
require_once('Admin_db.php');

$result = null; // Initialize $result variable
$message = ""; // Initialize message variable

// Check if a search query is submitted
if (isset($_POST['search'])) {
    $filterValue = $_POST['search'];
    $filterValue = mysqli_real_escape_string($con, $filterValue); // Prevent SQL injection
    
    // Modify the SQL query to fetch data from the leave_applications table
    $sql = "SELECT * FROM leave_applications WHERE EmployeeName LIKE '%$filterValue%'";
    
    
    
    $result = mysqli_query($con, $sql);
    
    // Check if the query executed successfully
    if (!$result) {
        die("Error executing the search query: " . mysqli_error($con));
    }
    
    // Check if any rows were returned
    if (mysqli_num_rows($result) == 0) {
        $message = "No data found.";
    }
} else {
    // If no search query is submitted, fetch all data
    $sql = "SELECT * FROM leave_applications";
    $result = mysqli_query($con, $sql);
    
    
    
    if (!$result) {
        die("Error executing the query: " . mysqli_error($con));
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
    <style>
        .search-container {
            text-align: right;
            margin-bottom: 10px;
            margin-right: 300px;
            margin-top: 15px;
        }
        .search-container input[type=text] {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 5px;
        }
        .search-container input[type=submit] {
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="heading">
            <h1>Welcome to Admin Page</h1>
        </div>
        <div class="body">
            <img src="https://thumbs.dreamstime.com/b/admin-computer-mouse-concept-hand-drawing-under-word-black-marker-transparent-wipe-board-database-system-network-web-140517127.jpg" alt="Error">
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="info-header">
                        <h2>Tables: Leave Applications Data from Database</h2>
                        <!-- Search container -->
                        <div class="search-container">
                            <form method="POST" action="">
                                <input type="text" name="search" class="search" placeholder="Search Here" value="<?php if (isset($_POST['search'])) echo $_POST['search']; ?>">
                                <input type="submit" class="searchbtn" value="Search"> 
                            </form>
                            <?php if (!empty($message)) { ?><p class="error-message"><?php echo $message; ?></p> <?php } ?> 
                        </div>

                        <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>Employee Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th>Delete</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['ID']; ?></td>
                                        <td><?php echo $row['EmployeeName']; ?></td>
                                        <td><?php echo $row['StartDate']; ?></td>
                                        <td><?php echo $row['EndDate']; ?></td>
                                        <td><?php echo $row['Reason']; ?></td>
                                        <td>
                                            <form method="POST" action="Admin_leaveappPagedel.php">
                                                <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                                                <input type="submit" class="del" style="background-color:red;" value="DELETE">
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } else {
                            echo "No data found.";
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>






