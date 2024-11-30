<?php
$servername="localhost";
$username="root";
$password="";
$database="employee";

//Create connection
$connection=new mysqli($servername,$username,$password,$database);

$Email="";
$Password="";
$errorMessage="";
$successMessage="";
if($_SERVER['REQUEST_METHOD']=='POST'){
    $Email=$_POST["username"];
    $Password=$_POST["password"];

    do{
        if(empty($Email)||empty($Password)){
        $errorMessage="All the fields are required";
        break;
        }

        // Check if email or password already exists
        $checkQuery = "SELECT COUNT(*) AS count FROM customer WHERE email = '$Email' OR pass = '$Password'";
        $checkResult = $connection->query($checkQuery);
        $row = $checkResult->fetch_assoc();
        if ($row['count'] > 0) {
            $errorMessage = "This email or password is already used.";
            break;
        }
     
        //add new user to database
        $sql="INSERT INTO Customers(email,pass)"."VALUES('$Email','$Password')";
        $result=$connection->query($sql);

        if(!$result){
            $errorMessage="Invalid query: " .$connection->error;
            break;
        }

        $Email="";
        $Password="";
        $successMessage="User added correctly";
        header("location:Admin_Page.php");

    }while (false);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
    <div class="container my-5">
        <h2 class="text-primary">New Users</h2>
    <?php 
    if(!empty($errorMessage)){
        echo "
        <div class='alert  w-50 fw-bold fs-6 text-danger alert-warning alert-dismissible fade show' role='alert'>
        <strong>$errorMessage</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-lable='Close'></button>
        </div>
        ";
    }
    
    ?>
   <form  method="post" action="">
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold fs-4 text-success">Email</label>
        <div class="col-sm-6">
            <input type="email" class="form-control w-50" name="username" value="<?php echo $Email;?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold fs-4 text-success">Password</label>
        <div class="col-sm-6">
            <input type="password" class="form-control w-50" name="password" value="<?php echo $Password;?>">
        </div>
    </div>
    <?php
    if(!empty($successMessage)){
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