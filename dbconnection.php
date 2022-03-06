<?php 
$servername = "xxxx"; // IP address to your server
$username = "xxxx"; // Username to your database
$password = "xxxx"; // Password to your database
$dbname = "xxxx"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}else{
    debug("DB Connection Successful");
}
?>