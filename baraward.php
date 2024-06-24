<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chart_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "AWARDED GRAPH";
// Fetch data from the database
$sql = "SELECT date, bitamount FROM analytics WHERE STATUS='Awarded'";
$result = $conn->query($sql);

$data = array();

while ($row = $result->fetch_assoc()) {
    $xValue = $row["date"];
    $yValue = $row["bitamount"];

    // Check if X-axis value already exists in the data array
    if (!isset($data[$xValue])) {
        // Calculate the point based on your requirements
        // For simplicity, assume the point is the sum of Y-axis values
        $data[$xValue] = $yValue;
    } else {
        // Perform any necessary calculations for duplicate X-axis values
        // For example, you can choose to sum the Y-axis values or take the average
        $data[$xValue] += $yValue;
    }
}
// Prepare data for Chart.js
$labels = array_keys($data);
$dataPoints = array_values($data);

// Encode data to JSON format
$labelsJSON = json_encode($labels);
$dataPointsJSON = json_encode($dataPoints);

// Echo the JavaScript code to generate the bar graph using Chart.js
echo "
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<canvas id='barChart2' width='500' height='400'></canvas>
<script>
    var ctx = document.getElementById('barChart2').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: $labelsJSON,
            datasets: [{
                label: 'salesamount',
                data: $dataPointsJSON,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>";
?>
