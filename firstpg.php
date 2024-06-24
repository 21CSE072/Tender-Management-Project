<!DOCTYPE html>
<html>
<head>
    <title>ITE TENDER-ANALYTICS</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <style>
        body {
            margin: 0;
            font-family: "Lato", sans-serif;
        }

        .sidebar {
            margin: 0;
            padding: 0;
            width: 205px;
            background-color: #f1f1f1;
            position: fixed;
            height: 100%;
            overflow: auto;
            left: 0;
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
        }
        
        .sidebar a.active {
            background-color: #04AA6D;
            color: white;
        }

        .sidebar a:hover:not(.active) {
            background-color: #555;
            color: white;


        }

        div.content {
        margin-left: 250px;
        padding: 0px 380px 0px 0px;
        height: 100%;
        
              
        }

        div.content1{
            margin-left:210px;
            padding: 1px  16px
        }

        .icon
        {
            height:5px;
            width:5px;
        }

        
    </style>
     
</head>
<body>

    <div class="sidebar">
        <P class="active"><span style="color:black; font-weight:bold; font-size:25px;">IET TENDER MANAGEMENT </span></P>
        <a class="active" href="#home"><i class="fas fa-home"></i> Dashboard</a>
        <a href="#ANALYTICS"><i class="fas fa-chart-bar"></i> Analytics</a>
        <a href="#total_tenders"><i class="fas fa-list-alt"></i> Tenders</a>
        <a href="#awarded_tenders"><i class="fas fa-award"></i> Awarded Tenders</a>
        <a href="#pie_Charts"><i class="fas fa-chart-pie"></i> Pie Charts</a>

        
    </div>




    
<div class="content" id="home" >
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel Dashboard</title>
    <style>
        .box {
            display: inline-block;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            margin-right: 10px; 
            margin-top:15px;
            width: 200px;
            text-align: center;
            background-color: #ADD8E6;
        }

        .box-container {
            display: block;
        }

        
    </style>
</head>


  <body>
    <?php
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $database = 'chart_db';
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    ?>

    <div class="box-container">
        <div class="box">
            <?php
                $sql_tenders = "SELECT COUNT(SNO) AS total_tenders FROM ANALYTICS";
                $result_tenders = $conn->query($sql_tenders);
                $row_tenders = $result_tenders->fetch_assoc();
                $total_tenders = $row_tenders['total_tenders'];
                echo "<h3>Total tenders</h3>";
                echo "<p>" . $total_tenders . "</p>";
            ?>
        </div>

        <div class="box">
            <?php
                $sql_successful = "SELECT COUNT(SNO) AS total_successful FROM ANALYTICS WHERE appstatus = 'success'";
                $result_successful = $conn->query($sql_successful);
                $row_successful = $result_successful->fetch_assoc();
                $total_successful = $row_successful['total_successful'];
                echo "<h3>Successful tenders</h3>";
                echo "<p>" . $total_successful . "</p>";
            ?>
        </div>

        <div class="box">
            <?php
                $sql_unsuccessful = "SELECT COUNT(SNO) AS total_unsuccessful FROM ANALYTICS WHERE appstatus = 'unsuccess'";
                $result_unsuccessful = $conn->query($sql_unsuccessful);
                $row_unsuccessful = $result_unsuccessful->fetch_assoc();
                $total_unsuccessful = $row_unsuccessful['total_unsuccessful'];
                echo "<h3>Unsuccessful tenders</h3>";
                echo "<p>" . $total_unsuccessful . "</p>";
            ?>
        </div>
    </div>

    <div class="box-container">
        <div class="box">
            <?php
                $sql_awarded = "SELECT COUNT(SNO) AS awarded FROM ANALYTICS WHERE status = 'awarded'";
                $result_awarded = $conn->query($sql_awarded);
                $row_awarded = $result_awarded->fetch_assoc();
                $awarded = $row_awarded['awarded'];
                echo "<h3>Awarded tenders</h3>";
                echo "<p>" . $awarded . "</p>";
            ?>
        </div>

        <div class="box">
            <?php
                $sql_pending = "SELECT COUNT(SNO) AS pending FROM ANALYTICS WHERE status = 'pending'";
                $result_pending = $conn->query($sql_pending);
                $row_pending = $result_pending->fetch_assoc();
                $pending = $row_pending['pending'];
                echo "<h3>Pending tenders</h3>";
                echo "<p>" . $pending . "</p>";
            ?>
        </div>

        <div class="box">
            <?php
                $sql_closing = "SELECT COUNT(SNO) AS closing FROM ANALYTICS WHERE month(CLOSINGDATE) = month(curdate())";
                $result_closing = $conn->query($sql_closing);
                $row_closing = $result_closing->fetch_assoc();
                $closing = $row_closing['closing'];
                echo "<h3>Month closing tenders</h3>";
                echo "<p>" . $closing . "</p>";
            ?>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>


</div>



<div class="content" id="ANALYTICS">

<?php

    $con = mysqli_connect("localhost","root","","chart_db");
  if($con){
      
  }   
    echo"<div id=total_tenders>";
    
    include('line.php');

    include('max.php');

    echo"</div>";

    echo"<div id=awarded_tenders>";

    include('awardedgraph.php');

    include('baraward.php');

    echo"</div>";

    echo"<div id=pie_Charts>";

    include('pie.php');

    include('piestatus.php');

    include('approvepie.php');

    echo"</div>";

 
    $sql = "SELECT * FROM ANALYTICS WHERE YEAR(DATE) = YEAR(CURDATE()) ORDER BY BITAMOUNT DESC LIMIT 10";
   
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $besttendr = mysqli_fetch_all($result, MYSQLI_ASSOC);

    }else{
        echo "Error : ". mysqli_error($conn);
    }
?>

<html>
<style>
.btcontainer {
    position: fixed;
    top: 0;
    right: 10px;
    width: 350px;
    height: 100%;
    padding: 2px;
    padding-right: 2px;
    padding-left: 20px; /* Adjust this value to increase or decrease left spacing */
    margin: 0;
    margin-left: 10px;
    margin-top:10px;
    content: 10px;
    overflow-y: auto;
    /background-color: rgba(173, 216, 230);/
    color: black;
    font-size:25px;
}
img{
  width:60%;
}


</style>
<div class="btcontainer" >
            
                <div  style="background-color: rgba(255, 255, 255, 0.7); color: black; ">
                    <img src="top_tenders.PNG"  >
                    <?php foreach($besttendr as $ten) : ?>
                        <div style="margin:auto !important; border-bottom:2px solid white;">
                            <p class="text-center pt-2" style="font-family: 'Times New Roman', Times, serif !important; font-size:x-large;"><?php echo $ten['TENDERTITLE'] ?></p>
                            <p>TENDER REFERENCE ID : <?php echo $ten['ITQREF'] ?> </p>
                            <p>TENDER TYPE : <?php echo $ten['CATEGORY'] ?> </p>
                            <p>DURATION : <?php echo $ten['DATE'] ?> - <?php echo $ten['CLOSINGDATE'] ?></p>
                        </div>
                    <?php endforeach; ?>              
                </div>

                    </div>
<div>
<!DOCTYPE html>
<html>
<head>
    <style>
        .pos{
            position:absolute;
            left:1000px;
            top:0px;
            
        }
    </style>



    
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>

    
   