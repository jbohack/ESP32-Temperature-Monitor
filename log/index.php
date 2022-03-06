<?php

function debug($data) {
    $debugOutput = $data;

    if (is_array($output))
        $output = implode(',', $debugOutput);

    echo "<script>console.log('Debug: " . $debugOutput . "' );</script>";
}

if(isset($_GET['temperature'])){
    include_once '../dbconnection.php';
    date_default_timezone_set('America/New_York');

    $temperature = $_GET['temperature'];
    $measurement = 'F';

    $stmt = $conn->prepare("INSERT INTO temperatureDataF (temperature, measurement) VALUES (?, ?)");
    $stmt->bind_param("ss", $temperature, $measurement);
    $stmt->execute(); 

    // close the connection
    $stmt->close();
    $conn->close();
    debug("DB connection closed.");
}
?>