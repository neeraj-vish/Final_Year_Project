<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="heading.css">
    <style>
        /* Additional inline styles if needed */
        
    </style>
</head>
<body>
    <div class="top-container">
        <div class="logo">
            <img src="http://it-marvels.com/css/images/it-marvels.png" alt="">
        </div>
        <div class="heading">
            <table cellspacing="30">
                <tr>
                    <td><a href="index.php">Home</a></td>
                    <td><a href="About.html" target="_self">About</a></td>
                    <td><a href="Contract.html" target="_self">Contract</a></td>
                    <td><a href="index.php" target="_self" onclick="confirmLogout('neeraj2002@gmail.com', event)">Logout</a></td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        function confirmLogout(adminEmail, event) {
            if (confirm("Are you sure you want to logout ?")) {
                alert("Email " + adminEmail + " has logged out.");
                
            } else {
               
                
                event.preventDefault();
            }
        }
    </script>
</body>
</html>