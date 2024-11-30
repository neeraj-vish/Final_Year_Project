
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select File to Access</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px 0px;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 100px 0px 0px -50px;
        }

        #fileForm {
            width: 50%;
            margin: 20px 0px 0px 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 20%;
            margin-left: 500px;
            
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
    include('Adminheading2.php');
    ?>
    <h2>Select File to Access</h2>
    <form id="fileForm" action="#" method="post">
        <label for="file">Select File:</label><br>
        <select id="file" name="file" required>
            <option value="" disabled selected>Select a file</option>
            <option value="Admin_page.php">User Login Detail</option>
             <option value="Admin_leaveappPage.php">User Leave Application</option>
             <option value="AdminMalciousLogin.php">Login Malicious Code</option>
             <option value="AdminMalciousRegister.php">Register Malicious Code</option>
             <option value="AdminLeave_Application_view.php">Leave Application Malicious log file</option>
             <option value="forgotPasswordlog.php">forgot Password Malicious log file</option>
             <option value="Admin_banpanel.php">Login Malicious Ban</option>
            
        </select><br><br>
        <input type="submit" value="Access">
    </form>

    <script>
        document.getElementById("fileForm").onsubmit = function() {
            var selectedFile = document.getElementById("file").value;
            if (selectedFile !== "") {
                window.location.href = selectedFile;
            }
            return false; 
        };
    </script>
</body>
</html>
