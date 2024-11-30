<?php
     include 'config.php';
    if(isset($_POST['submit'])) {

        $email = $_POST['username'];
        $pass = $_POST['pass'];

         $sql = "SELECT * FROM customers WHERE email='$email' and pass = '$pass'";

                $check = mysqli_query($conn,$sql);
        
                if(mysqli_num_rows($check)>0) {

                     header("location:Admin_optionfile.php");
                }
                else {
                    echo "Incorrect details";
                }

        
	    }
        
    
?>