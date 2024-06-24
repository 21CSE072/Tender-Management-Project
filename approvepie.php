<?php
  $con = mysqli_connect("localhost","root","","chart_db");
  if($con){
   
  }
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['CATEGORY', 'BITAMOUNT'],
         <?php
         $sql = "SELECT APPSTATUS, BITAMOUNT FROM ANALYTICS  GROUP BY APPSTATUS";
         $fire = mysqli_query($con,$sql);
          while ($result = mysqli_fetch_assoc($fire)) {
            echo"['".$result['APPSTATUS']."',".$result['BITAMOUNT']."],";
          }

         ?>
        ]);

        var options = {
          title: 'APPROVAL STATUS AND BIT AMOUNT'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart2" style="width: 900px; height: 500px;"></div>
  </body>
</html>