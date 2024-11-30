<?php
if(isset($_GET["ID"])){
$ID=$_GET["ID"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "employee";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);
$sql="DELETE FROM Customers WHERE ID=$ID";
$connection->query($sql);
}
header("location:Admin_Page.php");
?>