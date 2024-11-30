<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "employee";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$ID = "";
$Email = "";
$Password = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET Method: Show the data of users
    if (!isset($_GET["ID"])) {
        header("location: Admin_Page.php");
        exit;
    }
    $ID =intval($_GET["ID"]);
    // Read the row of the selected user from database table
    $sql = "SELECT * FROM Customers WHERE ID=$ID";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Email = $row["email"];
        $Password = $row["pass"];
    } else {
        header("location: Admin_Page.php");
        exit;
    }
} else {
    // POST method: Update the data of users
    $ID = $_POST["id"];
    $Email = $_POST["email"];
    $Password = $_POST["pass"];

    if (empty($Email) || empty($Password)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "UPDATE Customers SET email='$Email', pass='$Password' WHERE ID=$ID";
        $result = $connection->query($sql);

        if ($result) {
            $successMessage = "User updated correctly";
            header("location: Admin_Page.php");
            exit;
        } else {
            $errorMessage = "Error updating user: " . $connection->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2 class="text-primary">Edit User</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert  w-50 fw-bold fs-6 text-danger alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-lable='Close'></button>
            </div>
            ";
        }

        ?>
        <form method="post" name="ID" action="">
            <input type="hidden" name="id" value="<?php echo $ID; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label fw-bold fs-4 text-success">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control w-50" name="email" value="<?php echo $Email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label fw-bold fs-4 text-success">Password</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control w-50" name="pass" value="<?php echo $Password; ?>">
                </div>
            </div>
            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='alert  w-50 fw-bold fs-6 text-success alert-warning alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-lable='Close'></button>
                </div>
                ";
            }

            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 d-grid w-25">
                    <button type="submit" class="btn btn-primary w-50">Submit</button>
                </div>
                <div class="col-sm-3 d-grid ">
                    <a class="btn btn-outline-primary w-50" href="Admin_Page.php" role="button" style="margin-left: -150px;">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</body>

</html>