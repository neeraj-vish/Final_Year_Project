
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9; /* Light Gray */
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Darker Green */
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Login Form</h2>
    <form id="loginForm" action="#" method="GET">
        <label for="loginType">Select Login Type:</label>
        <select name="loginType" id="loginType">
            <option value="userlogin">User Login</option>
            <option value="admin">Admin Login</option>
        </select>
        <input type="submit" value="Login">
    </form>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the selected value of the dropdown
        var selectedValue = document.getElementById('loginType').value;

        // Open new window based on the selected value
        if (selectedValue === 'userlogin') {
            window.open('Login.php', '_self'); // Open login.php in a same window for user login
        } else if (selectedValue === 'admin') {
            window.open('Admin_login.php', '_self'); // Open admin.php in a same window for admin login
        }
    });
</script>

</body>
</html>
