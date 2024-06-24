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
          ['STATUS', 'BITAMOUNT'],
         <?php
         $sql = "SELECT STATUS, BITAMOUNT FROM ANALYTICS  GROUP BY STATUS";
         $fire = mysqli_query($con,$sql);
          while ($result = mysqli_fetch_assoc($fire)) {
            echo"['".$result['STATUS']."',".$result['BITAMOUNT']."],";
          }

         ?>
        ]);

        var options = {
          title: 'STATUS AND BIT AMOUNT'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart1" style="width: 900px; height: 500px;"></div>
  </body>
</html>