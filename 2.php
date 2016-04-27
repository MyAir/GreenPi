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
    <script type="text/javascript">
      google.charts.load('current', {'packages':[
                                      'corechart', 
                                      'controls', 
                                      'gauge',
                                      // 'charteditor',
                                      ],
                                    'language': 'de_CH'
      });
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
              $result = getValues($tb_current, 8, ['temperature'],1);
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
              $result = getValues($tb_current, 8, ['humidity'],1);
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
  
    <!-- Temperature/Humidity Chart 12H by Minute -->
    <script type="text/javascript">
      google.charts.setOnLoadCallback(drawDashboard);
    
      function drawDashboard() {

        // Create a dashboard instance
        var dashboard = new google.visualization.Dashboard(
          document.getElementById('dashboard_min_div'));

        // We omit "var" so that chart_min_slider is visible to changeRange.
        chart_min_slider = new google.visualization.ControlWrapper({
          'controlType': 'ChartRangeFilter',
          'containerId': 'filter_min_div',
          'options': {
            'filterColumnLabel': 'TIME',
            'ui': {'chartOptions':{
              'chartArea': {'width': '912'},
            }},
          },
        });

        // Prepare TEMP chart.
        chart_temp_min  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_temp_min_div',
          'view': {'columns': [0, 1]},
          'options': {
            colors: ['red', '#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Temperature (C)'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        // Prepare HUM chart.
        chart_hum_min  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_hum_min_div',
          'view': {'columns': [0, 2]},
          'options': {
          // 	colors:['red','#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Humidity (%)'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        chart_light_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_light_min_div',
          'view': {
            'columns': [0, 3]
          },
      
          'options': {
            title: 'Light',
            colors: ['Yellow'],
            'height': 30,
            'bar': {
              'groupWidth': '100%',
            },
            'hAxis'       : {
            'textPosition': 'none',
            },
            'vAxis': {
              'textPosition': 'none',
            },
            'chartArea': {
              'top': 20,
              'bottom': 0,
              'width': '912',
            },
            legend: {
              position: 'none'
            },
          },
        });

        chart_fan_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_fan_min_div',
          'view': {
            'columns': [0, 4]
          },
      
          'options': {
            title: 'Fan',
            colors: ['Green'],
            'height': 30,
            'bar': {
              'groupWidth': '100%',
            },
            'hAxis': {
              'textPosition': 'none',
            },
            'vAxis': {
              'textPosition': 'none',
            },
            'chartArea': {
              'top': 20,
              'bottom': 0,
              'width': '912',
            },
            legend: {
              position: 'none'
            },
          },
        });

        chart_humifier_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_humifier_min_div',
          'view': {
            'columns': [0, 5]
          },
      
          'options': {
            title: 'Humifier',
            colors: ['Blue'],
            'height': 30,
            'bar': {
              'groupWidth': '100%',
            },
            'hAxis': {
              'textPosition': 'none',
            },
            'vAxis': {
              'textPosition': 'none',
            },
            'chartArea': {
              'top': 20,
              'bottom': 0,
              'width': '912',
            },
            legend: {
              position: 'none'
            },
          },
        });

        // Prepare data
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'TIME');
        data.addColumn('number', 'TEMP');
        data.addColumn('number', 'HUM');
        data.addColumn('number', 'LIGHT');
        data.addColumn('number', 'FAN');
        data.addColumn('number', 'HUMIFIER');
        data.addRows([
            <?php 
              $result = getValues($tb_current, 8, ['date_time','temperature', 'humidity',
                                                   'stat_d2','stat_d3','stat_d4'],720);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                echo " ".$result[$r][2].", ";
                if($result[$r][3] == 1){echo "1,";}else{echo "0,";}
                if($result[$r][4] == 0){echo "1,";}else{echo "0,";}
                if($result[$r][5] == 0){echo "1,";}else{echo "0,";}
                echo " ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        dashboard.bind(chart_min_slider, chart_temp_min);
        dashboard.bind(chart_min_slider, chart_hum_min);
        dashboard.bind(chart_min_slider, chart_light_min);
        dashboard.bind(chart_min_slider, chart_fan_min);
        dashboard.bind(chart_min_slider, chart_humifier_min);
        dashboard.draw(data);
      }
    </script>
    
    <!-- Temperature/Humidity Chart 7 Days by 15 Minute -->
    <script type="text/javascript">
      google.charts.setOnLoadCallback(drawDashboard);
    
      function drawDashboard() {

        // Create a dashboard instance
        var dashboard = new google.visualization.Dashboard(
          document.getElementById('dashboard_quart_div'));

        // We omit "var" so that chart_min_slider is visible to changeRange.
        chart_quart_slider = new google.visualization.ControlWrapper({
          'controlType': 'ChartRangeFilter',
          'containerId': 'filter_quart_div',
          'options': {
            'filterColumnLabel': 'TIME',
            'ui': {'chartOptions':{
              'chartArea': {'width': '912'},
            }},
          },
        });

        // Prepare TEMP chart.
        chart_temp_quart  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_temp_quart_div',
          'view': {'columns': [0, 1]},
          'options': {
            colors: ['red', '#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Temperature (C)'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        // Prepare HUM chart.
        chart_hum_quart  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_hum_quart_div',
          'view': {'columns': [0, 2]},
          'options': {
          // 	colors:['red','#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Humidity (%)'},
            },
            'hAxis.gridlines.count': -1,
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
              $result = getValues($tb_hist_quart, 8, ['date_time','temp_avg', 'humi_avg'],672);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                echo " ".$result[$r][2].", ";
                echo " ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        dashboard.bind(chart_quart_slider, chart_temp_quart);
        dashboard.bind(chart_quart_slider, chart_hum_quart);
        dashboard.draw(data);
      }
    </script>
    
    <!-- Temperature/Humidity Chart 30 Days by Hour -->
    <script type="text/javascript">
      google.charts.setOnLoadCallback(drawDashboard);
    
      function drawDashboard() {

        // Create a dashboard instance
        var dashboard = new google.visualization.Dashboard(
          document.getElementById('dashboard_hour_div'));

        // We omit "var" so that chart_min_slider is visible to changeRange.
        chart_hour_slider = new google.visualization.ControlWrapper({
          'controlType': 'ChartRangeFilter',
          'containerId': 'filter_hour_div',
          'options': {
            'filterColumnLabel': 'TIME',
            'ui': {'chartOptions':{
              'chartArea': {'width': '912'},
            }},
          },
        });

        // Prepare TEMP chart.
        chart_temp_hour  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_temp_hour_div',
          'view': {'columns': [0, 1]},
          'options': {
            colors: ['red', '#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Temperature (C)'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        // Prepare HUM chart.
        chart_hum_hour  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_hum_hour_div',
          'view': {'columns': [0, 2]},
          'options': {
          // 	colors:['red','#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Humidity (%)'},
            },
            'hAxis.gridlines.count': -1,
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
              $result = getValues($tb_hist_hour, 8, ['date_time','temp_avg', 'humi_avg'],720);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                echo " ".$result[$r][2].", ";
                echo " ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        dashboard.bind(chart_hour_slider, chart_temp_hour);
        dashboard.bind(chart_hour_slider, chart_hum_hour);
        dashboard.draw(data);
      }
    </script>
    
  </head>
  <body>
    <div class="jumbotron">
      <div class="container">
        <?php include 'menu.php';?>
        <h2>Temperature and Humidity Sensor Top</h2>
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
        <tbody>
        <tr>
          <h3>Temperature/Humidity last 12 hours by minute</h3>
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
            <div style="border: 1px solid #ccc;">
              <div id="chart_light_min_div" style="width: auto; height: 50px; "></div>
              <div id="chart_fan_min_div" style="width: auto; height: 50px; "></div>
              <div id="chart_humifier_min_div" style="width: auto; height: 50px; "></div>
            </div>
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
      </div>
    </div>

    <div class="container">
      <!--Div that will hold the dashboard-->
      <!--<div id="dashboard_min_div" style="border: 1px solid #ccc">-->
      <div id="dashboard_quart_div">
        <tbody>
        <tr>
          <h3>Temperature/Humidity last 7 days by 15 minutes</h3>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_temp_min_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_temp_quart_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_temp_min_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_hum_quart_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="filter_min_div" style="width: 915px; height: 50px;"></div>-->
            <div id="filter_quart_div" style="width: auto; height: 50px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        </tbody>
      </div>
    </div>

    <div class="container">
      <!--Div that will hold the dashboard-->
      <!--<div id="dashboard_min_div" style="border: 1px solid #ccc">-->
      <div id="dashboard_quart_div">
        <tbody>
        <tr>
          <h3>Temperature/Humidity last 30 days by hours</h3>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_temp_min_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_temp_hour_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_temp_min_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_hum_hour_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="filter_min_div" style="width: 915px; height: 50px;"></div>-->
            <div id="filter_hour_div" style="width: auto; height: 50px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        </tbody>
      </div>
    </div>

    <div class="container"><hr>
    <?php include 'footer.php';?></div>
  </body>
</html>
