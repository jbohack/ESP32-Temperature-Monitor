<meta http-equiv="refresh" content="5" >
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
 
<?php
include_once 'dbconnection.php';

function debug($data) {
    $debugOutput = $data;

    if (is_array($output))
        $output = implode(',', $debugOutput);

    echo "<script>console.log('Debug: " . $debugOutput . "' );</script>";
}

// Minimum temperature log
$minTemp = "SELECT MIN(temperature) AS minimum FROM temperatureDataF";
$resultMin = $conn->query($minTemp);
if( $resultMin->num_rows > 0 )
{
     $row = $resultMin->fetch_assoc();
     $minimumTemperature = $row['minimum'];
}

// Maximum temperature log
$maxTemp = "SELECT MAX(temperature) AS maximum FROM temperatureDataF";
$resultMax = $conn->query($maxTemp);
if( $resultMax->num_rows > 0 )
{
     $row = $resultMax->fetch_assoc();
     $maximumTemperature = $row['maximum'];
}

// Select current temperature, time, and id
$currentTemp = "SELECT * FROM temperatureDataF ORDER BY id DESC LIMIT 1";
$resultCurrentTemp = $conn->query($currentTemp);
if( $resultCurrentTemp->num_rows > 0 )
{
     $row = $resultCurrentTemp->fetch_assoc();
     $currentTemperature = $row['temperature'];
     $currentTime = $row['time'];
     $currentID = $row['id'];
}

// Select average temperature
$averageTemp = "SELECT AVG(temperature) AS averageTemp FROM temperatureDataF";
$resultAverageTemp = $conn->query($averageTemp);
if( $resultAverageTemp->num_rows > 0 )
{
     $row = $resultAverageTemp->fetch_assoc();
     $averageTemperature = $row['averageTemp'];
}

// display to the interface
echo "<b>Maximum temperature:</b> ".number_format((float)$maximumTemperature, 2, '.', ''); echo " F";
echo "<br><b>Minimum temperature:</b> ".number_format((float)$minimumTemperature, 2, '.', ''); echo " F";
echo "<br><b>Average temperature:</b> ".number_format((float)$averageTemperature, 2, '.', ''); echo " F";
echo "<br><b>Current temperature:</b> ".number_format((float)$currentTemperature, 2, '.', ''); echo " F";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Latest log time:</b> ".$currentTime. " UTC";
echo "<br><b>Data size:</b> ".$currentID. " IDs";

// close the db connection
$conn->close();
debug("DB Connection Closed.");
?>
