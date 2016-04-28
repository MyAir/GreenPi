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
    <title>GreenPi - Soil and Air</title>
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

    <!-- Environment Moisture GAUGE -->

    <script type="text/javascript">
      // google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Moisture', 
            <?php
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
      // google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Air Quality', 
            <?php
              $result = getValues($tb_current, 1, ['quality'],1);
              echo $result[0][0];
              unset($result);
            ?> 
          ],
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

    <!-- Moisture Chart 12H by Minute -->
    <script type="text/javascript">
      google.charts.setOnLoadCallback(drawDashboard);
    
      function drawDashboard() {

        // Create a dashboard instance
        var dashboard = new google.visualization.Dashboard(
          document.getElementById('dashboard_moist_min_div'));

        // We omit "var" so that chart_min_slider is visible to changeRange.
        chart_min_moist_slider = new google.visualization.ControlWrapper({
          'controlType': 'ChartRangeFilter',
          'containerId': 'filter_moist_min_div',
          'options': {
            'filterColumnLabel': 'TIME',
            'ui': {'chartOptions':{
              'chartArea': {'width': '912'},
            }},
          },
        });

        // Prepare Moisture chart.
        chart_moist_min  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_moist_min_div',
          'view': {'columns': [0, 1]},
          'options': {
            colors: ['red', '#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Moisture'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        chart_light_moist_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_light_moist_min_div',
          'view': {
            'columns': [0, 2]
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

        chart_fan_moist_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_fan_moist_min_div',
          'view': {
            'columns': [0, 3]
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

        chart_humifier_moist_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_humifier_moist_min_div',
          'view': {
            'columns': [0, 4]
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
        data.addColumn('number', 'MOIST');
        data.addColumn('number', 'LIGHT');
        data.addColumn('number', 'FAN');
        data.addColumn('number', 'HUMIFIER');
        data.addRows([
            <?php 
              $result = getValues($tb_current, 0, ['date_time', 'moisture','stat_d2','stat_d3','stat_d4'],720);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                if($result[$r][2] == 1){echo "1,";}else{echo "0,";}
                if($result[$r][3] == 0){echo "1,";}else{echo "0,";}
                if($result[$r][4] == 0){echo "1,";}else{echo "0,";}
                echo " ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        dashboard.bind(chart_min_moist_slider, chart_moist_min);
        dashboard.bind(chart_min_moist_slider, chart_light_moist_min);
        dashboard.bind(chart_min_moist_slider, chart_fan_moist_min);
        dashboard.bind(chart_min_moist_slider, chart_humifier_moist_min);
        dashboard.draw(data);
      }
    </script>
    
    <!-- Air Quality Chart 12H by Minute -->
    <script type="text/javascript">
      google.charts.setOnLoadCallback(drawDashboard);
    
      function drawDashboard() {

        // Create a dashboard instance
        var dashboard = new google.visualization.Dashboard(
          document.getElementById('dashboard_qual_min_div'));

        // We omit "var" so that chart_min_slider is visible to changeRange.
        chart_min_qual_slider = new google.visualization.ControlWrapper({
          'controlType': 'ChartRangeFilter',
          'containerId': 'filter_qual_min_div',
          'options': {
            'filterColumnLabel': 'TIME',
            'ui': {'chartOptions':{
              'chartArea': {'width': '912'},
            }},
          },
        });

        // Prepare Quality chart.
        chart_qual_min  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_qual_min_div',
          'view': {'columns': [0, 1]},
          'options': {
            // colors: ['red', '#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Air Quality'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        chart_light_qual_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_light_qual_min_div',
          'view': {
            'columns': [0, 2]
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

        chart_fan_qual_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_fan_qual_min_div',
          'view': {
            'columns': [0, 3]
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

        chart_humifier_qual_min = new google.visualization.ChartWrapper({
          'chartType': 'ColumnChart',
          'containerId': 'chart_humifier_qual_min_div',
          'view': {
            'columns': [0, 4]
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
        data.addColumn('number', 'QUAL');
        data.addColumn('number', 'LIGHT');
        data.addColumn('number', 'FAN');
        data.addColumn('number', 'HUMIFIER');
        data.addRows([
            <?php 
              $result = getValues($tb_current, 1, ['date_time', 'quality','stat_d2','stat_d3','stat_d4'],720);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                if($result[$r][2] == 1){echo "1,";}else{echo "0,";}
                if($result[$r][3] == 0){echo "1,";}else{echo "0,";}
                if($result[$r][4] == 0){echo "1,";}else{echo "0,";}
                echo " ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        dashboard.bind(chart_min_qual_slider, chart_qual_min);
        dashboard.bind(chart_min_qual_slider, chart_light_qual_min);
        dashboard.bind(chart_min_qual_slider, chart_fan_qual_min);
        dashboard.bind(chart_min_qual_slider, chart_humifier_qual_min);
        dashboard.draw(data);
      }
    </script>
    
    <!-- Moisture/Air Quality Chart 7 Days by 15 Minute -->
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

        // Prepare MOIST chart.
        chart_moist_quart  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_moist_quart_div',
          'view': {'columns': [0, 1]},
          'options': {
            colors: ['red', '#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Moisture'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        // Prepare QUAL chart.
        chart_qual_quart  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_qual_quart_div',
          'view': {'columns': [0, 2]},
          'options': {
          // 	colors:['red','#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Air Quality'},
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
        data.addColumn('number', 'MOIST');
        data.addColumn('number', 'QUAL');
        data.addRows([
            <?php 
              $result = getValuesMQHist($tb_hist_quart, 672);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                echo " ".$result[$r][2].", ";
                echo " ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        dashboard.bind(chart_quart_slider, chart_moist_quart);
        dashboard.bind(chart_quart_slider, chart_qual_quart);
        dashboard.draw(data);
      }
    </script>
    
    <!-- Moisture/Air Quality Chart 30 Days by Hour -->
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

        // Prepare MOIST chart.
        chart_moist_hour  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_moist_hour_div',
          'view': {'columns': [0, 1]},
          'options': {
            colors: ['red', '#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Moisture'},
            },
            'hAxis.gridlines.count': -1,
            'chartArea': {'top': 10, 'bottom': 20},
          	legend: { position: 'none' },
          	trendlines: { 0: {} },
          },
        });
  
        // Prepare QUAL chart.
        chart_qual_hour  = new google.visualization.ChartWrapper({
          'chartType': 'LineChart',
          'containerId': 'chart_qual_hour_div',
          'view': {'columns': [0, 2]},
          'options': {
          // 	colors:['red','#004411'],
          	curveType: 'function',
            vAxes: {
              0: {title: 'Air Quality'},
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
        data.addColumn('number', 'MOIST');
        data.addColumn('number', 'QUAL');
        data.addRows([
            <?php 
              $result = getValuesMQHist($tb_hist_hour,720);
              for($r=0;$r<count($result);$r++){
                echo "[new Date(".(strtotime($result[$r][0])*1000)."), "; 
                echo " ".$result[$r][1].", "; 
                echo " ".$result[$r][2].", ";
                echo " ],".PHP_EOL; 
              }
              unset($result);
            ?> 
          ]);

        dashboard.bind(chart_hour_slider, chart_moist_hour);
        dashboard.bind(chart_hour_slider, chart_qual_hour);
        dashboard.draw(data);
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
      <!--Div that will hold the dashboard-->
      <!--<div id="dashboard_min_div" style="border: 1px solid #ccc">-->
      <div id="dashboard_moist_min_div">
        <tbody>
        <tr>
          <h3>Moisture last 12 hours by minute</h3>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_moist_min_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_moist_min_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="filter_min_div" style="width: 915px; height: 50px;"></div>-->
            <div style="border: 1px solid #ccc;">
              <div id="chart_light_moist_min_div" style="width: auto; height: 50px; "></div>
              <div id="chart_fan_moist_min_div" style="width: auto; height: 50px; "></div>
              <div id="chart_humifier_moist_min_div" style="width: auto; height: 50px; "></div>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="filter_min_div" style="width: 915px; height: 50px;"></div>-->
            <div id="filter_moist_min_div" style="width: auto; height: 50px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        </tbody>
      </div>
    </div>

    <div class="container">
      <!--Div that will hold the dashboard-->
      <!--<div id="dashboard_min_div" style="border: 1px solid #ccc">-->
      <div id="dashboard_qual_min_div">
        <tbody>
        <tr>
          <h3>Air Quality last 12 hours by minute</h3>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_qual_min_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_qual_min_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="filter_min_div" style="width: 915px; height: 50px;"></div>-->
            <div style="border: 1px solid #ccc;">
              <div id="chart_light_qual_min_div" style="width: auto; height: 50px; "></div>
              <div id="chart_fan_qual_min_div" style="width: auto; height: 50px; "></div>
              <div id="chart_humifier_qual_min_div" style="width: auto; height: 50px; "></div>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="filter_min_div" style="width: 915px; height: 50px;"></div>-->
            <div id="filter_qual_min_div" style="width: auto; height: 50px; border: 1px solid #ccc;"></div>
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
          <h3>Moisture/Air Quality last 7 days by 15 minutes</h3>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_moist_quart_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_moist_quart_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_qual_quart_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_qual_quart_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
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
          <h3>Moisture/Air Quality last 30 days by hours</h3>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_moist_hour_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_moist_hour_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
          </td>
        </tr>
        <tr>
          <td>
            <!--Divs that will hold each control and chart-->
            <!--<div id="chart_qual_hour_div" style="width: 915px; height: 300px;"></div>-->
            <div id="chart_qual_hour_div" style="width: auto; height: 200px; border: 1px solid #ccc;"></div>
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
