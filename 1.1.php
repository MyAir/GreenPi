<?PHP
// require_once("./include/membersite_config.php");

// if(!$fgmembersite->CheckLogin())
// {
//     $fgmembersite->RedirectToURL("login.php");
//     exit;
// }
require_once("./functions_frontend.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
  <head>
    <title>RasPiViv.com - Vivarium 1</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
    <!-- VIV 1 TEMP GAUGE -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['TEMP C', 
            <?php
              $result = getValues($tb_current, 7, ['temperature'],1);
              echo $result[0][0];
              unset($result);
            ?> 
          ],
    
        ]);
    
        var options = {
          width: 400, height: 200,
          yellowFrom:0, yellowTo: 20,
          greenFrom:20, greenTo: 35,
          redFrom: 35, redTo: 100,
          minorTicks: 5
        };
    
        var chart = new google.visualization.Gauge(document.getElementById('charttemp_div'));
        chart.draw(data, options);
      }
    </script>
    
    <!-- VIV 1 HUM GAUGE -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
  
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['HUM %', 
            <?php
              $result = getValues($tb_current, 7, ['humidity'],1);
              echo $result[0][0];
              unset($result);
            ?> 
          ],
        ]);
  
        var options = {
          width: 200, height: 200,
          redFrom: 60, redTo: 100,
          yellowFrom:00, yellowTo: 40,
          greenFrom:40, greenTo: 60,
          minorTicks: 5
        };
  
        var chart = new google.visualization.Gauge(document.getElementById('charthum_div'));
        chart.draw(data, options);
      }
    </script>
  
    <!-- VIV 1 HUM GRAPH -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['TIME', 'HUMIDITY', ],
            <?php 
              $result = getValues($tb_current, 7, ['date_time','humidity'],60);
              for($r=0;$r<count($result);$r++){
                echo "['".$result[$r][0]."', "; 
                echo " ".$result[$r][1]." ],"; 
              }
              unset($result);
            ?> 
          ]);
    
    	  var options = {
        	title: 'HUMIDITY LAST HOUR',
        	curveType: 'function',
        	legend: { position: 'none' },
        	hAxis: { textPosition: 'none', direction: '-1' },
        };
    
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <!-- VIV 1 TEMP GRAPH -->
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['TIME', 'TEMP', ],
            <?php 
              $result = getValues($tb_current, 7, ['date_time','temperature'],60);
              for($r=0;$r<count($result);$r++){
                echo "['".$result[$r][0]."', "; 
                echo " ".$result[$r][1]." ],"; 
              }
              unset($result);
            ?> 
        ]);
    
      	var options = {
        	title: 'TEMP LAST HOUR',
        	curveType: 'function',
        	legend: { position: 'none' },
        	hAxis: { textPosition: 'none', direction: '-1' },
        };
    
        var chart = new google.visualization.LineChart(document.getElementById('chart2_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div class="jumbotron">
      <div class="container">
        <?php include 'menu.php';?>
        <h2>Temperature and Humidity Sensor 1</h2>
        <?php include 'time.php';?>
      </div>
    </div>
    <div class="container">
      <h3>CURRENT CONDITIONS</h3>
      <div class="row">
        <div class="col-sm-3">
          <div id="charttemp_div" style="width: 200px; height: 200px;"></div>
        </div>
        <div class="col-sm-3">
          <div id="charthum_div" style="width: 200px; height: 200px;"></div>
        </div>
      </div>
      <hr>
    </div>
    <div class="container">
      <div id="chart2_div" style="width: auto; height: 500px;"></div>
      <div id="chart_div" style="width: auot; height: 500px;"></div>
      <hr>
        <?php include 'footer.php';?>
    </div>
  </body>
</html>
