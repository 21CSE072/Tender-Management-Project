<?php 
 $con = mysqli_connect("localhost","root","","chart_db");

    if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }
$result =mysqli_query($con, "SELECT  MAX(bitamount) as max, MIN(bitamount) as min FROM analytics");

      while($res = mysqli_fetch_array($result)) { 

           $max = $res['max']; 

           echo 'HIGHEST TENDER SALE AMOUNT :'.$max.'<br><br>'; 

 $min=$res['min'].'<br>'; 
        echo 'LOWEST TENDER SALE AMOUNT :'.$min.'<br><br>'; 
 }
?> 


<!DOCTYPE html>
<html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<body>
<div id="myChart" style="width:100%; max-width:600px; height:500px;"></div>

<script>
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  <?php
    
    $sql = "SELECT DATE AS MONTH, SUM(BITAMOUNT) AS TOTAL_AMOUNT FROM analytics where status='awarded' GROUP BY DATE";
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
    title: 'TENDER STATISTICS (AWARDED)',
    hAxis: {title: 'MONTH'},
    vAxis: {title: 'BIT AMOUNT'},
    legend: 'none'
  };

  // Draw
  const chart = new google.visualization.LineChart(document.getElementById('myChart'));
  chart.draw(data, options);
}
</script>

</body>
</html>