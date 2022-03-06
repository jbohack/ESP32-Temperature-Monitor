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

    // filter for numbers & decimal only
    if (preg_match('/^[0-9]+(\\.[0-9]+)?$/', $temperature)){
        debug($temperature. " is a temperature");
        $stmt = $conn->prepare("INSERT INTO temperatureDataF (temperature, measurement) VALUES (?, ?)");
        $stmt->bind_param("ss", $temperature, $measurement);
        $stmt->execute(); 
    } else {
        debug($temperature. " is not a temperature");
    }

    // close the connection
    $stmt->close();
    $conn->close();
    debug("DB connection closed.");
}
?>