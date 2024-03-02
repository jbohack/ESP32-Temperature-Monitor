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
} else {
    debug("DB Connection Successful");

    // Check if the table exists
    $checkTableQuery = "SHOW TABLES LIKE 'temperatureDataF'";
    $result = $conn->query($checkTableQuery);

    if ($result->num_rows == 0) {
        // Create table if it doesn't exist
        $sqlStructure = "CREATE TABLE temperatureDataF (
            id int(11) NOT NULL AUTO_INCREMENT,
            time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            temperature varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            measurement varchar(1) COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (id)) COLLATE='utf8_unicode_ci'";

        if ($conn->query($sqlStructure) === TRUE) {
            debug("Table structure created successfully");
        } else {
            debug("Error creating table structure: " . $conn->error);
        }
    } else {
        debug("Table 'temperatureDataF' already exists, not creating");
    }
}
?>