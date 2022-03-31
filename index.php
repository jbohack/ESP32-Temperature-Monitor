<html>
<head>
     <title>Temperature Monitor</title>
     <meta http-equiv="refresh" content="5" >
     <meta name="keywords" content="esp32 temperature, temperature monitor php, esp32 php temperature, esp32 monitor temperature, micropython temperature monitor">
     <meta name="description" content="ESP32 temperature monitoring site https://github.com/jbohack/ESP32-Temperature-Monitor">
     <meta name="author" content="jbohack">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>
</html>

<?php
include_once 'dbconnection.php';

function debug($data) {
    $debugOutput = $data;

    if (is_array($output))
        $output = implode(',', $debugOutput);

    echo "<script>console.log('Debug: " . $debugOutput . "' );</script>";
}

// Minimum temperature log
$minTemp = "SELECT temperature AS temperatureMin, time AS timeMin FROM temperatureDataF ORDER BY temperature ASC LIMIT 1";
$resultMin = $conn->query($minTemp);
if( $resultMin->num_rows > 0 )
{
     $row = $resultMin->fetch_assoc();
     $minimumTemperature = $row['temperatureMin'];
     $minimumTemperatureTime = $row['timeMin'];
}

// Maximum temperature log
$maxTemp = "SELECT temperature AS temperatureMax, time AS timeMax FROM temperatureDataF ORDER BY temperature DESC LIMIT 1";
$resultMax = $conn->query($maxTemp);
if( $resultMax->num_rows > 0 )
{
     $row = $resultMax->fetch_assoc();
     $maximumTemperature = $row['temperatureMax'];
     $maximumTemperatureTime = $row['timeMax'];
}

// Select current temperature, time, and id
$currentTemp = "SELECT * FROM temperatureDataF ORDER BY id DESC LIMIT 1";
$resultCurrentTemp = $conn->query($currentTemp);
if( $resultCurrentTemp->num_rows > 0 )
{
     $row = $resultCurrentTemp->fetch_assoc();
     $currentTemperature = $row['temperature'];
     $currentTime = $row['time'];
}

// Select data size
$dataSize = "SELECT COUNT(temperature) AS dataSize FROM temperatureDataF";
$resultDataSize = $conn->query($dataSize);
if( $resultDataSize->num_rows > 0 )
{
     $row = $resultDataSize->fetch_assoc();
     $numDataSize = $row['dataSize'];
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
echo "<b>Current temperature:</b> ".number_format((float)$currentTemperature, 2, '.', ''); echo " F";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Highest temperature:</b> ".number_format((float)$maximumTemperature, 2, '.', ''); echo " F";
echo "<br><b>Lowest temperature:</b> ".number_format((float)$minimumTemperature, 2, '.', ''); echo " F";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Time of highest temperature:</b> ".$maximumTemperatureTime. " UTC";
echo "<br><b>Time of lowest temperature:</b> ".$minimumTemperatureTime. " UTC";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Hourly average:</b> ".number_format((float)$averageHourlyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Daily average:</b> ".number_format((float)$averageDailyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Weekly average:</b> ".number_format((float)$averageWeeklyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Monthly average:</b> ".number_format((float)$averageMonthlyTemperature, 2, '.', ''); echo " F";
echo "<br><b>Yearly average:</b> ".number_format((float)$averageYearlyTemperature, 2, '.', ''); echo " F";
echo "<br><b>All time average:</b> ".number_format((float)$averageTotalTemperature, 2, '.', ''); echo " F";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><b>Latest log time:</b> ".$currentTime. " UTC";
echo "<br><b>Data size:</b> ".$numDataSize. " IDs";
echo "<br><b>~~~~~~~~~~~~~~~~~~~~~~~~~~~~</b>";
echo "<br><br><br>";

// temperature line chart creation using quickchart
require_once('QuickChart.php');
debug("Graphing data");

// Select the current hour
$currentHourQuery = "SELECT HOUR(NOW()) AS currentHour";
$resultCurrentHour = $conn->query($currentHourQuery);
if( $resultCurrentHour->num_rows > 0 )
{
     $row = $resultCurrentHour->fetch_assoc();
     $resultCurrentHour = $row['currentHour'] + 1;
}

// 24h graph
$temperatureArray24H= array();
$timeArray24H = array();
$temperatureDailyQuery = "SELECT HOUR(time) AS hour, AVG(temperature) AS temperature FROM temperatureDataF GROUP BY HOUR(time) ASC LIMIT $resultCurrentHour";
$resultTemperatureDailyQuery = $conn->query($temperatureDailyQuery);
if( $resultTemperatureDailyQuery->num_rows > 0 )
{
     foreach ($resultTemperatureDailyQuery as $row) {
          array_push($temperatureArray24H, $row["temperature"]);
          array_push($timeArray24H, $row["hour"]);
     }
}
$temperatureDayJsonData = json_encode($temperatureArray24H);
$timeDayJsonData = json_encode($timeArray24H);
$chartDaily = new QuickChart(array(
     'width' => 500,
     'height' => 300,
     'backgroundColor' => transparent,
     'devicePixelRatio' => 0.8,
   ));
   
   $chartDaily->setConfig("{
     type: 'line',
     options:
	{
          elements:
               {
                    point:
                    {
                         radius: 0,
                    },
               },
          },

     data: {
       labels: $timeDayJsonData,
       datasets: [{
         label: '24 Hour Temperature Graph | Fahrenheit |',
         fill: false,
         data: $temperatureDayJsonData
       }]
     }
   }");
$chartURLDaily = $chartDaily->getUrl();

// 7 day graph
$temperatureArray7D= array();
$timeArray7D = array();
$temperatureWeeklyQuery = "SELECT DAY(time) AS day, AVG(temperature) AS temperature FROM temperatureDataF GROUP BY DAY(time) DESC LIMIT 7";
$resultTemperatureWeeklyQuery = $conn->query($temperatureWeeklyQuery);
if( $resultTemperatureWeeklyQuery->num_rows > 0 )
{
     foreach ($resultTemperatureWeeklyQuery as $row) {
          array_push($temperatureArray7D, $row["temperature"]);
          array_push($timeArray7D, $row["day"]);
     }
}
$reversedArrayTemperature7D = array_reverse($temperatureArray7D);
$reversedArrayTime7D = array_reverse($timeArray7D);
$temperatureWeekJsonData = json_encode($reversedArrayTemperature7D);
$timeWeekJsonData = json_encode($reversedArrayTime7D);
$chartWeekly = new QuickChart(array(
     'width' => 500,
     'height' => 300,
     'backgroundColor' => transparent,
     'devicePixelRatio' => 0.8,
   ));
   
   $chartWeekly->setConfig("{
     type: 'line',
     options:
	{
          elements:
               {
                    point:
                    {
                         radius: 0,
                    },
               },
          },

     data: {
       labels: $timeWeekJsonData,
       datasets: [{
         label: '7 Day Temperature Graph | Fahrenheit |',
         fill: false,
         data: $temperatureWeekJsonData
       }]
     }
   }");
$chartURLWeekly = $chartWeekly->getUrl();

// 30 day graph
$temperatureArray30D= array();
$timeArray30D = array();
$temperatureMonthlyQuery = "SELECT DAY(time) AS day, AVG(temperature) AS temperature FROM temperatureDataF GROUP BY DAY(time) DESC LIMIT 30";
$resultTemperatureMonthlyQuery = $conn->query($temperatureMonthlyQuery);
if( $resultTemperatureMonthlyQuery->num_rows > 0 )
{
     foreach ($resultTemperatureMonthlyQuery as $row) {
          array_push($temperatureArray30D, $row["temperature"]);
          array_push($timeArray30D, $row["day"]);
     }
}
$reversedArrayTemperature30D = array_reverse($temperatureArray30D);
$reversedArrayTime30D = array_reverse($timeArray30D);
$temperatureMonthJsonData = json_encode($reversedArrayTemperature30D);
$timeMonthJsonData = json_encode($reversedArrayTime30D);
$chartMonthly = new QuickChart(array(
     'width' => 500,
     'height' => 300,
     'backgroundColor' => transparent,
     'devicePixelRatio' => 0.8,
   ));
   
   $chartMonthly->setConfig("{
     type: 'line',
     options:
	{
          elements:
               {
                    point:
                    {
                         radius: 0,
                    },
               },
          },

     data: {
       labels: $timeMonthJsonData,
       datasets: [{
         label: '30 Day Temperature Graph | Fahrenheit |',
         fill: false,
         data: $temperatureMonthJsonData
       }]
     }
   }");
$chartURLMonthly = $chartMonthly->getUrl();

// close the db connection
$conn->close();
debug("DB Connection Closed.");
?>

<body>
     <img src="<?php echo $chartURLDaily;?>">
     <img src="<?php echo $chartURLWeekly;?>">
     <img src="<?php echo $chartURLMonthly;?>">
</body>