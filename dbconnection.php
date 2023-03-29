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
// Create table if it doesn't exist
    $sqlStructure = "CREATE TABLE temperatureDataF (
        id int(11) NOT NULL AUTO_INCREMENT,
        time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        temperature varchar(50) COLLATE utf8_unicode_ci NOT NULL,
        measurement varchar(1) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (id),
        INDEX (time),
        INDEX (temperature)
    ) COLLATE='utf8_unicode_ci'";
    if ($conn->query($sqlStructure) === TRUE) {
        debug("Table structure created successfully");
      } else {
        debug("Table structure exists not creating");
      }
}
?>