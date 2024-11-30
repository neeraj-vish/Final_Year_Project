<?php

// Check if the user has submitted the login form
if (isset($_POST['login'])) {
    // Perform login authentication
    // Assuming successful authentication, set the email in session
    $_SESSION['user']['email'] = $_POST['email'];
    // Redirect to leave.php
    header("Location: leave.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="heading.css">
    <style>
        /* Add CSS style for the welcome message */
        .welcome-message {
            color: blue;
        }

        .heading {
            margin: 0px 0px 0px -40px;
        }
    </style>
</head>
<body>
    <div class="top-container <?php echo isset($_SESSION['user']['email']) ? '' : 'blur'; ?>">
        <div class="logo">
            <img src="http://it-marvels.com/css/images/it-marvels.png" alt="">
        </div>
        <div class="heading">
            <table cellspacing="30">
                <tr>
                    <td><a href="index.php">Home</a></td>
                    <td><a href="About.html" target="_self">About</a></td>
                    <td><a href="Contact.html" target="_self">Contact</a></td>
                    <td><?php echo isset($_GET['loginType']) && $_GET['loginType'] === 'admin' ? '<a href="Admin_login.php" target="_self">Admin Login</a>' : '<a href="Login.php" target="_self">UserLogin</a>'; ?></td>
                    <?php
                    // Check if the user is logged in
                    // if (isset($_SESSION['user']['email'])) {
                      
                    //     echo '<td id="logout"><a href="logout.php">Logout</a></td>';
                    // }
                    ?>
                </tr>
            </table>
        </div>
    </div>

    <script>
  
    window.addEventListener('beforeunload', function (e) {
        <?php if (isset($_SESSION['user']['email'])): ?>
            // Send AJAX request to logout.php to log the user out
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "logout.php", true);
            xhr.send();
        <?php endif; ?>
    });


</script>
</body>
</html>
