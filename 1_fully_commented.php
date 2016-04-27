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
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <head>
    <title>GreenPi - Temperature Humidity bottom</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
    <!-- Temperature Chart 24H by Minute -->
    <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
    <script type="text/javascript">
      // Load the Visualization API and the controls package.
      // Packages for all the other charts you need will be loaded
      // automatically by the system.
      google.charts.load('current', {'packages':[
                                      'corechart', 
                                      'controls', 
                                      'gauge',
                                      // 'charteditor',
                                      ],
                                    'language': 'de_CH'
      });
   
      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawDashboard);
    
      function drawDashboard() {
        // Everything is loaded. Assemble your dashboard...

        // Create a dashboard instance
        var dashboard = new google.visualization.Dashboard(
          document.getElementById('dashboard_min_div'));

        // We omit "var" so that programmaticSlider is visible to changeRange.
        programmaticSlider = new google.visualization.ControlWrapper({
          'controlType': 'ChartRangeFilter',
          // 'controlType': 'NumberRangeFilter',
          'containerId': 'filter_min_div',
          'options': {
            'filterColumnLabel': 'TIME',
            // 'filterColumnIndex': 0,
            // 'ui': {
            //   // 'labelStacking': 'vertical',
            //   'chartType': 'LineChart',
            'ui': {'chartOptions':{
              // 'chartArea': {'width': '76%'},
              'chartArea': {'width': '912'},
              // 'chartArea': {'left': 150, 'top': 15, 'right': 0, 'bottom': 0},
            }},
          },
        });

        // Prepare TEMP chart.
        chart_temp  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_temp_min_div',
          'view': {'columns': [0, 1]},
          'options': {
          // 	title: 'Temperature/Humidity last 24 hours by minute',
          	curveType: 'function',
            // // Gives each series an axis that matches the vAxes number below.
            // series: {
            //   0: {targetAxisIndex: 0},
            //   1: {targetAxisIndex: 1}
            // },
            // vAxes: {
            //   // Adds titles to each axis.
            //   0: {title: 'Temps (Celsius)'},
            //   1: {title: 'Humidity'}
            // },
            vAxes: {
              // Adds titles to each axis.
              0: {title: 'Temperature (C)'},
              // 1: {title: 'Humidity'}
            },
            'hAxis.gridlines.count': -1,
            // width: auto; height: 500px;
            // 'width': 300,
            // 'height': 300,
            // 'height': 500,
            // 'legend': 'none',
            // 'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        // Prepare HUM chart.
        chart_hum  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_hum_min_div',
          'view': {'columns': [0, 2]},
          'options': {
          // 	title: 'HUM (%) LAST 24 HR',
          	colors:['red','#004411'],
          	curveType: 'function',
            // Gives each series an axis that matches the vAxes number below.
            // series: {
            //   0: {targetAxisIndex: 0},
            //   1: {targetAxisIndex: 1}
            // },
            vAxes: {
              // Adds titles to each axis.
              0: {title: 'Humidity (%)'},
              // 1: {title: 'Humidity'}
            },
            'hAxis.gridlines.count': -1,
            // width: auto; height: 500px;
            // 'width': 300,
            // 'height': 300,
            // 'height': 500,
            // 'legend': 'none',
            // 'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        // Prepare data
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'TIME');
        data.addColumn('number', 'TEMP');
        data.addColumn('number', 'HUM');
        data.addRows([
            <?php 
              $result = getValues($tb_current, 7, ['date_time','temperature', 'humidity'],1440);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                echo " ".$result[$r][2]." ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        // chart.setDataTable(data);
        // chart.draw();
        dashboard.bind(programmaticSlider, chart_temp);
        dashboard.bind(programmaticSlider, chart_hum);
        dashboard.draw(data);
      }
    </script>
    
    <!-- VIV 1 TEMP GAUGE -->
    <script type="text/javascript">
      // google.load("visualization", "1", {packages:["gauge"]});
      // google.charts.load('current', {'packages':['gauge']});
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
    
        var chart = new google.visualization.Gauge(document.getElementById('gaugetemp_div'));
        chart.draw(data, options);
      }
    </script>
    
    <!-- VIV 1 HUM GAUGE -->
    <script type="text/javascript">
      // google.load("visualization", "1", {packages:["gauge"]});
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
  
        var chart = new google.visualization.Gauge(document.getElementById('gaugehum_div'));
        chart.draw(data, options);
      }
    </script>
  
    <!-- VIV 1 HUM GRAPH -->
    <script type="text/javascript">
      // google.load("visualization", "1", {packages:["corechart"]});
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
      // google.load("visualization", "1", {packages:["corechart"]});
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
          <div id="gaugetemp_div" style="width: 200px; height: 200px;"></div>
        </div>
        <div class="col-sm-3">
          <div id="gaugehum_div" style="width: 200px; height: 200px;"></div>
        </div>
      </div>
      <hr>
    </div>
    <div class="container">
      <!--Div that will hold the dashboard-->
      <!--<div id="dashboard_min_div" style="border: 1px solid #ccc">-->
      <div id="dashboard_min_div">
        <!--<table class="columns" >-->
          <tbody>
          <tr>
            <h3>Temperature/Humidity last 24 hours by minute</h3>
          </tr>
          <tr>
            <td>
              <!--Divs that will hold each control and chart-->
              <!--<div id="chart_temp_min_div" style="width: 915px; height: 300px;"></div>-->
              <div id="chart_temp_min_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
            </td>
          </tr>
          <tr>
            <td>
              <!--Divs that will hold each control and chart-->
              <!--<div id="chart_temp_min_div" style="width: 915px; height: 300px;"></div>-->
              <div id="chart_hum_min_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
            </td>
          </tr>
          <tr>
            <td>
              <!--Divs that will hold each control and chart-->
              <!--<div id="filter_min_div" style="width: 915px; height: 50px;"></div>-->
              <div id="filter_min_div" style="width: auto; height: 50px; border: 1px solid #ccc;"></div>
            </td>
          </tr>
          </tbody>
        <!--</table>-->
      </div>

      <div id="chart2_div" style="width: auto; height: 500px;"></div>
      <div id="chart_div" style="width: auot; height: 500px;"></div>
      <hr>
        <?php include 'footer.php';?>
    </div>
  </body>
</html>
