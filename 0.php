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
<title>RasPiViv.com - Environment</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- Environment Moisture GAUGE -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Moisture', <?php
  $result = getValues($tb_current, 0, ['moisture'],1);
  echo $result[0][0];
  unset($result);
?> 

],

        ]);

        var options = {
          min: 0, max: 1000,
          width: 400, height: 200,
          redFrom: 0, redTo: 300,
          greenFrom: 300, greenTo: 700,
          yellowFrom:700, yellowTo: 1000,
          minorTicks: 10
        };

        var chart = new google.visualization.Gauge(document.getElementById('chartmoist_div'));

        chart.draw(data, options);


      }
    </script>

<!-- Environment AirQuality GAUGE -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Air Quality', <?php
  $result = getValues($tb_current, 1, ['quality'],1);
  echo $result[0][0];
  unset($result);
?> ],

        ]);

        var options = {
          min: 0, max: 1000,
          width: 400, height: 200,
          greenFrom: 0, greenTo: 300,
          yellowFrom:300, yellowTo: 700,
          redFrom: 700, redTo: 1000,
          minorTicks: 10
        };

        var chart = new google.visualization.Gauge(document.getElementById('chartqual_div'));

        chart.draw(data, options);


      }
    </script>
<!-- Environment Moisture GRAPH -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['TIME', 'MOISTURE', ],
<?php 
  $result = getValues($tb_current, 0, ['date_time','moisture'],60);
  for($r=0;$r<count($result);$r++){
    echo "['".$result[$r][0]."', "; 
    echo " ".$result[$r][1]." ],"; 
  }
  unset($result);
?> 
        ]);

	var options = {
	title: 'MOISTURE LAST HOUR',
	curveType: 'function',
	legend: { position: 'none' },
	hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>

<!-- Environment AirQuality GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['TIME', 'QUALITY', ],
<?php 
  $result = getValues($tb_current, 1, ['date_time','quality'],60);
  for($r=0;$r<count($result);$r++){
    echo "['".$result[$r][0]."', "; 
    echo " ".$result[$r][1]." ],"; 
  }
  unset($result);
?> 
        ]);

	var options = {
	title: 'QUALITY LAST HOUR',
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
<h2>Environment</h2>
<?php include 'time.php';?>
</div>
</div>
<div class="container">
<h3>CURRENT CONDITIONS</h3>
  <div class="row">
    <div class="col-sm-3">
    <div id="chartmoist_div" style="width: 200px; height: 200px;"></div>
    </div>
    <div class="col-sm-3">
    <div id="chartqual_div" style="width: 200px; height: 200px;"></div>
    </div>
    </div>
<hr>
    </div>
<div class="container">
    <div id="chart_div" style="width: auot; height: 500px;"></div><hr>
    <div id="chart2_div" style="width: auto; height: 500px;"></div>
    <?php include 'footer.php';?>
</div>
</body>
</html>
