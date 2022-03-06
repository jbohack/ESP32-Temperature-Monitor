<meta http-equiv="refresh" content="5" > 
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

// next select maximum ID with SELECT MAX(ID) FROM temperatureDataF; & store it as a variable. afterwords SELECT * FROM temperatureDataF WHERE id = $variable;
// Select maximum ID
$maxID = "SELECT MAX(id) AS maxID FROM temperatureDataF";
$resultMaxID = $conn->query($maxID);
if( $resultMaxID->num_rows > 0 )
{
     $row = $resultMaxID->fetch_assoc();
     $maximumID = $row['maxID'];
}

// Select current temperature
$currentTemp = "SELECT * FROM temperatureDataF WHERE id = $maximumID";
$resultCurrentTemp = $conn->query($currentTemp);
if( $resultCurrentTemp->num_rows > 0 )
{
     $row = $resultCurrentTemp->fetch_assoc();
     $currentTemperature = $row['temperature'];
}

// Select average temperature
$averageTemp = "SELECT AVG(temperature) AS averageTemp FROM temperatureDataF";
$resultAverageTemp = $conn->query($averageTemp);
if( $resultAverageTemp->num_rows > 0 )
{
     $row = $resultAverageTemp->fetch_assoc();
     $averageTemperature = $row['averageTemp'];
}

// Select latest log time
$curTime = "SELECT * FROM temperatureDataF WHERE id = $maximumID";
$resultCurrentTime = $conn->query($curTime);
if( $resultCurrentTime->num_rows > 0 )
{
     $row = $resultCurrentTime->fetch_assoc();
     $currentTime = $row['time'];
}

// display to the interface
echo "<b>Maximum temperature:</b> ".number_format((float)$maximumTemperature, 2, '.', ''); echo " F";
echo "<br><b>Minimum temperature:</b> ".number_format((float)$minimumTemperature, 2, '.', ''); echo " F";
echo "<br><b>Average temperature:</b> ".number_format((float)$averageTemperature, 2, '.', ''); echo " F";
echo "<br><b>Current temperature:</b> ".number_format((float)$currentTemperature, 2, '.', ''); echo " F";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Latest log time:</b> ".$currentTime. " UTC";
echo "<br><b>Data size:</b> ".$maximumID. " IDs";

// close the db connection
$conn->close();
debug("DB Connection Closed.");
?>
