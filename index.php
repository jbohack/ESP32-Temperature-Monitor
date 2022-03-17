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

// Select hourly average temperature
$averageHourlyTemp = "SELECT AVG(hourlyAVG.temperature) AS hourlyAVG FROM (SELECT temperature FROM temperatureDataF ORDER BY id DESC LIMIT 12) hourlyAVG";
$resultAverageHourlyTemp = $conn->query($averageHourlyTemp);
if( $resultAverageHourlyTemp->num_rows > 0 )
{
     $row = $resultAverageHourlyTemp->fetch_assoc();
     $averageHourlyTemperature = $row['hourlyAVG'];
}

// Select daily average temperature
$averageDailyTemp = "SELECT AVG(dailyAVG.temperature) AS dailyAVG FROM (SELECT temperature FROM temperatureDataF ORDER BY id DESC LIMIT 288) dailyAVG";
$resultAverageDailyTemp = $conn->query($averageDailyTemp);
if( $resultAverageDailyTemp->num_rows > 0 )
{
     $row = $resultAverageDailyTemp->fetch_assoc();
     $averageDailyTemperature = $row['dailyAVG'];
}

// Select weekly average temperature
$averageWeeklyTemp = "SELECT AVG(weeklyAVG.temperature) AS weeklyAVG FROM (SELECT temperature FROM temperatureDataF ORDER BY id DESC LIMIT 2016) weeklyAVG";
$resultAverageWeeklyTemp = $conn->query($averageWeeklyTemp);
if( $resultAverageWeeklyTemp->num_rows > 0 )
{
     $row = $resultAverageWeeklyTemp->fetch_assoc();
     $averageWeeklyTemperature = $row['weeklyAVG'];
}

// Select monthly average temperature
$averageMonthlyTemp = "SELECT AVG(monthlyAVG.temperature) AS monthlyAVG FROM (SELECT temperature FROM temperatureDataF ORDER BY id DESC LIMIT 8640) monthlyAVG";
$resultAverageMonthlyTemp = $conn->query($averageMonthlyTemp);
if( $resultAverageMonthlyTemp->num_rows > 0 )
{
     $row = $resultAverageMonthlyTemp->fetch_assoc();
     $averageMonthlyTemperature = $row['monthlyAVG'];
}

// Select yearly average temperature
$averageYearlyTemp = "SELECT AVG(yearlyAVG.temperature) AS yearlyAVG FROM (SELECT temperature FROM temperatureDataF ORDER BY id DESC LIMIT 105120) yearlyAVG";
$resultAverageYearlyTemp = $conn->query($averageYearlyTemp);
if( $resultAverageYearlyTemp->num_rows > 0 )
{
     $row = $resultAverageYearlyTemp->fetch_assoc();
     $averageYearlyTemperature = $row['yearlyAVG'];
}

// Select total average temperature
$averageTotalTemp = "SELECT AVG(temperature) AS totalAVG FROM temperatureDataF";
$resultAverageTotalTemp = $conn->query($averageTotalTemp);
if( $resultAverageTotalTemp->num_rows > 0 )
{
     $row = $resultAverageTotalTemp->fetch_assoc();
     $averageTotalTemperature = $row['totalAVG'];
}

// display to the interface
echo "<b>Maximum temperature:</b> ".number_format((float)$maximumTemperature, 2, '.', ''); echo " F";
echo "<br><b>Minimum temperature:</b> ".number_format((float)$minimumTemperature, 2, '.', ''); echo " F";
echo "<br><b>Current temperature:</b> ".number_format((float)$currentTemperature, 2, '.', ''); echo " F";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Hourly average:</b> ".number_format((float)$averageHourlyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Daily average:</b> ".number_format((float)$averageDailyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Weekly average:</b> ".number_format((float)$averageWeeklyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Monthly average:</b> ".number_format((float)$averageMonthlyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Yearly average:</b> ".number_format((float)$averageYearlyTemperature, 2, '.', ''); echo " F";
echo "<br><b>All time average:</b> ".number_format((float)$averageTotalTemperature, 2, '.', ''); echo " F";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Latest log time:</b> ".$currentTime. " UTC";
echo "<br><b>Data size:</b> ".$currentID. " IDs";

// close the db connection
$conn->close();
debug("DB Connection Closed.");
?>
