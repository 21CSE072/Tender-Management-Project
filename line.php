<!DOCTYPE html>
<html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<body>
<div id="Chart" style="width:100%; max-width:600px; height:500px;"></div>

<script>

google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  <?php
    
    $con = mysqli_connect("localhost","root","","chart_db");

    if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }

    $sql = "SELECT date AS MONTH, SUM(bitamount) AS TOTAL_AMOUNT FROM analytics GROUP BY MONTH";
    $result = $con->query($sql);

    $data = array(['MONTH', 'TOTAL_AMOUNT']);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $month = $row['MONTH']; 
        $totalAmount = (int)$row['TOTAL_AMOUNT']; 
        $data[] = [$month, $totalAmount];
      }
    }

    $jsonData = json_encode($data);
    echo "var jsonData = " . $jsonData . ";";

    $con->close();
  ?>

  // Set Data
  const data = google.visualization.arrayToDataTable(jsonData);

  // Set Options
  const options = {
    title: 'TENDER STATISTICS (Monthly)',
    hAxis: {title: 'MONTH'},
    vAxis: {title: 'BIT AMOUNT'},
    legend: 'none'
  };

  // Draw
  const chart = new google.visualization.LineChart(document.getElementById('Chart'));
  chart.draw(data, options);
}
</script>

</body>
</html>