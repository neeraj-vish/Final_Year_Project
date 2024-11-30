<?php
session_start();
require_once('Admin_db.php');
require_once('RegisterApprove_mail.php');

// Fetch all users initially
$query = "SELECT * FROM customers";
$result = mysqli_query($con, $query);

// Check if a search query is submitted
if(isset($_POST['search'])) {
    $filterValue = $_POST['search'];
    $filterData = "SELECT * FROM customers WHERE CONCAT(ID, email, pass) LIKE '%$filterValue%'";
    $result = mysqli_query($con, $filterData);
    
    if(mysqli_num_rows($result) > 0) {
        $message = "Records found.";
    } else {
        $message = "Records not found.";
    }
}

// Change user status if admin action is submitted

if (isset($_POST['change_status'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];
    $update_query = "UPDATE customers SET status='$new_status' WHERE ID=$user_id";
    if (mysqli_query($con, $update_query)) {
        header("Location: admin_page.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
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
        .main {
            width: 98.7vw;
        }
        .info-header .btn {
            margin: 10px 0px 0px 300px;
            width: 110px;
            height: 40px;
            border-radius: 10px;
            background-color: blue;
        }
        .info-header .btn a {
            color: white;
            font-size: 15px;
            text-decoration: none;
        }
        .info-header .search {
            width: 300px;
            height: 20px;
            margin-left: 400px;
            border: 2px solid red;
            border-radius: 5px;
            font-size: 15px;
            padding: 5px;
        }
        .info-header .searchbtn {
            width: 80px;
            height: 35px;
            border-radius: 10px;
            background-color: blue;
            color: white;
            font-size: 15px;
        }
        .error-message {
            text-transform: uppercase;
            font-weight: 300;
            font-size: 25px;
            margin: 10px 0px 0px 820px;
            color: red;
        }
        form {
            margin-top: 10px;
        }
        select {
            width: 150px;
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
                        <h2>Tables: Users Data from Database</h2>
                        <form method="POST" action="">
                            <button class="btn"><a href="create.php" target="_blank">Add New User</a></button>
                            <input type="text" name="search" class="search" placeholder="Search Here" value="<?php if (isset($_POST['search'])) echo $_POST['search']; ?>">
                            <input type="submit" class="searchbtn" value="Search">
                            <?php if (!empty($message)) { ?><p class="error-message"><?php echo $message; ?></p><?php } ?>
                        </form>
                        <table class="table" style="margin: 30px 0px 0px 200px;">
                            <tr>
                                <th>ID</th>
                                <th>EMAIL</th>
                                <th>PASSWORD</th>
                                <th>STATUS</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                                <th>ACTION</th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['ID']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['pass']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><button class="edit"><a href="edit.php?ID=<?php echo $row['ID']; ?>" class="editbtn" target="_blank">EDIT</a></button></td>
                                    <td><button class="del" style="background-color:red;"><a href="delete.php?ID=<?php echo $row['ID']; ?>" class="deletebtn">DELETE</a></button></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo $row['ID']; ?>">
                                            <select name="new_status">
                                                <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Approved" <?php echo ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                                <option value="Disapproved" <?php echo ($row['status'] == 'Disapproved') ? 'selected' : ''; ?>>Disapproved</option>
                                            </select>
                                            <input type="submit" name="change_status" value="Change Status">
                                        </form>
                                    </td>
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

    <script>
        const dropdowns = document.querySelectorAll('.action-dropdown');

        dropdowns.forEach(dropdown => {
            const statusBtn = dropdown.querySelector('.status-btn');
            const actionButtons = dropdown.querySelector('.action-buttons');

            statusBtn.addEventListener('click', () => {
                actionButtons.classList.toggle('show');
            });

            const statusOptions = dropdown.querySelectorAll('.status-option');
            statusOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const newStatus = option.dataset.status;
                    statusBtn.textContent = newStatus;
                    actionButtons.classList.remove('show');
                });
            });
        });
    </script>
</body>

</html>
