<HTML>
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
<title>GreenPi - Home</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- ROOM TEMP GAUGE -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['BASE TMP', 
<?php
  $result = getValues($tb_current, 6, ['temperature'],1);
  echo $result[0][0];
  unset($result);
?> 
],

        ]);

        var options = {
          width: 200, height: 200,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('roomtemp_div'));

        chart.draw(data, options);


      }
    </script>

<!-- ROOM HUM GAUGE -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['BASE HUM', <?php
  $result = getValues($tb_current, 6, ['humidity'],1);
  echo $result[0][0];
  unset($result);
?> ],

        ]);

        var options = {
          width: 200, height: 200,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('roomhum_div'));

        chart.draw(data, options);


      }
    </script>

<!-- ENV MOIST GAUGE -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
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

        var chart = new google.visualization.Gauge(document.getElementById('envmoist_div'));

        chart.draw(data, options);


      }
    </script>

<!-- ENV QUAL GAUGE -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Quality', <?php
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

        var chart = new google.visualization.Gauge(document.getElementById('envqual_div'));

        chart.draw(data, options);


      }
    </script>

<!-- VIV 1 TEMP GAUGE -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['1 TMP', <?php
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

        var chart = new google.visualization.Gauge(document.getElementById('viv1temp_div'));

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
          ['1 HUM', <?php
  $result = getValues($tb_current, 7, ['humidity'],1);
  echo $result[0][0];
  unset($result);
?> ],

        ]);

        var options = {
          width: 200, height: 200,
          redFrom: 60, redTo: 100,
          yellowFrom:00, yellowTo: 40,
          greenFrom:40, greenTo: 60,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('viv1hum_div'));

        chart.draw(data, options);


      }
    </script>
<!-- VIV 2 TEMP GAUGE -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['2 TMP', <?php
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

        var chart = new google.visualization.Gauge(document.getElementById('viv2temp_div'));

        chart.draw(data, options);


      }
    </script>

<!-- VIV 2 HUM GAUGE -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['2 HUM', <?php
  $result = getValues($tb_current, 8, ['humidity'],1);
  echo $result[0][0];
  unset($result);
?> ],

        ]);

        var options = {
          width: 200, height: 200,
          redFrom: 60, redTo: 100,
          yellowFrom:00, yellowTo: 40,
          greenFrom:40, greenTo: 60,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('viv2hum_div'));

        chart.draw(data, options);


      }
    </script>


<!-- ENV HISTORY MOIST GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [{label: 'TIME', id: 'TIME', type: 'datetime'}, 
           {label: 'MOISTURE', id: 'MOISTURE', type: 'number'}],
<?php 
  $result = getValues($tb_hist_hour, 0, ['date_time','moist_avg'],24);
  for($r=0;$r<count($result);$r++){
    // echo "['Date(".date(DATE_W3C,strtotime($result[$r][0])).")', "; 
    echo "['Date(".(strtotime($result[$r][0])*1000).")', "; 
    echo " ".$result[$r][1]." ],"; 
  }
  unset($result);
?> 
        ]);

	var options = {
  	title: 'MOISTURE LAST 24 HR',
  	curveType: 'function',
  	legend: { position: 'none' },
    trendlines: { 0: {} },
    // 	hAxis: {direction: '-1' },
    // hAxis: { 
    //   gridlines: {
    //     count: -1,
    //     units: {
    //       days: {format: ['dd HH', 'dd.MM.yyyy']},
    //       hours: {format: ['HH:mm']}
    //     }
    //   }
    // }
  };

        var chart = new google.visualization.LineChart(document.getElementById('envmoistgraph_div'));

        chart.draw(data, options);
options['pagingSymbols'] = {prev: 'prev', next: 'next'}; options['pagingButtonsConfiguration'] = 'auto';
      }
    </script>

<!-- ENV HISTORY QUAL GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          // ['TIME', 'QUALITY', ],
          [{label: 'TIME', id: 'TIME', type: 'datetime'}, 
           {label: 'QUALITY', id: 'QUALITY', type: 'number'}],
<?php 
  $result = getValues($tb_hist_hour, 1, ['date_time','qual_avg'],24);
  for($r=0;$r<count($result);$r++){
    // echo "['".$result[$r][0]."', "; 
    echo "['Date(".(strtotime($result[$r][0])*1000).")', "; 
    echo " ".$result[$r][1]." ],"; 
  }
  unset($result);
?> 
        ]);

	var options = {
	title: 'QUALITY LAST 24 HR',
	curveType: 'function',
	legend: { position: 'none' },
    trendlines: { 0: {} },
// 	hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('envqualgraph_div'));

        chart.draw(data, options);
options['pagingSymbols'] = {prev: 'prev', next: 'next'}; options['pagingButtonsConfiguration'] = 'auto';
      }
    </script>

<!-- TANK 1 HISTORY HUM GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          // ['TIME', 'HUMIDITY', ],
          [{label: 'TIME', id: 'TIME', type: 'datetime'}, 
           {label: 'HUMIDITY', id: 'HUMIDITY', type: 'number'}],
<?php 
  $result = getValues($tb_hist_hour, 7, ['date_time','humi_avg'],24);
  for($r=0;$r<count($result);$r++){
    echo "['Date(".(strtotime($result[$r][0])*1000).")', "; 
    echo " ".$result[$r][1]." ],"; 
  }
  unset($result);
?> 
        ]);

	var options = {
	title: 'HUMIDITY (%) LAST 24 HR',
	curveType: 'function',
	legend: { position: 'none' },
    trendlines: { 0: {} },
// 	hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('tank1humgraph_div'));

        chart.draw(data, options);
options['pagingSymbols'] = {prev: 'prev', next: 'next'}; options['pagingButtonsConfiguration'] = 'auto';
      }
    </script>

<!-- TANK 1 HISTORY TEMP GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          // ['TIME', 'TEMP', ],
          [{label: 'TIME', id: 'TIME', type: 'datetime'}, 
           {label: 'TEMP', id: 'TEMP', type: 'number'}],
            <?php 
              $result = getValues($tb_hist_hour, 7, ['date_time','temp_avg'],24);
              for($r=0;$r<count($result);$r++){
                echo "['Date(".(strtotime($result[$r][0])*1000).")', "; 
                echo " ".$result[$r][1]." ],"; 
              }
              unset($result);
            ?> 
        ]);

	var options = {
	title: 'TEMP (C) LAST 24 HR',
	curveType: 'function',
	legend: { position: 'none' },
    trendlines: { 0: {} },
// 	hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('tank1tempgraph_div'));

        chart.draw(data, options);
      }
    </script>

<!-- TANK 2 HISTORY HUM GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          // ['TIME', 'HUMIDITY', ],
          [{label: 'TIME', id: 'TIME', type: 'datetime'}, 
           {label: 'HUMIDITY', id: 'HUMIDITY', type: 'number'}
          ],
          <?php 
            $result = getValues($tb_hist_hour, 8, ['date_time','humi_avg'],24);
            for($r=0;$r<count($result);$r++){
              // echo "['".$result[$r][0]."', "; 
              echo "['Date(".(strtotime($result[$r][0])*1000).")', "; 
              echo " ".$result[$r][1]." ],"; 
            }
            unset($result);
          ?> 
        ]);

	var options = {
	title: 'HUMIDITY (%) LAST 24 HR',
	curveType: 'function',
	legend: { position: 'none' },
	  trendlines: { 0: {} },
//hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('tank2humgraph_div'));

        chart.draw(data, options);
      }
    </script>

<!-- TANK 2 HISTORY TEMP GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          // ['TIME', 'TEMP', ],
          [{label: 'TIME', id: 'TIME', type: 'datetime'}, 
           {label: 'TEMP', id: 'TEMP', type: 'number'}],
<?php 
  $result = getValues($tb_hist_hour, 8, ['date_time','temp_avg'],24);
  for($r=0;$r<count($result);$r++){
    // echo "['".$result[$r][0]."', "; 
    echo "['Date(".(strtotime($result[$r][0])*1000).")', "; 
    echo " ".$result[$r][1]." ],"; 
  }
  unset($result);
?> 
        ]);

	var options = {
	title: 'TEMP (C) LAST 24 HR',
	curveType: 'function',
	legend: { position: 'none' },
	  trendlines: { 0: {} },
//hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('tank2tempgraph_div'));

        chart.draw(data, options);
      }
    </script>

</head>
<body>
<div class="jumbotron">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php include 'menu.php';?>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <h3>Light</h3>
      <!-- On/Off button's picture -->
      <?php
        // Draw Button 0 from Sensor 2
        drawButton(2,0);
    ?>
    </div>
    <div class="col-md-4">
      <h3>Ventilation</h3>
      <!-- On/Off button's picture -->
      <?php
        // Draw Button 5 from Sensor 3
        drawButton(3,5);
        $button = 5;
    ?>
    </div>
    <div class="col-md-4">
      <h3>Humifier</h3>
      <!-- On/Off button's picture -->
      <?php
        // Draw Button 2 from Sensor 4
        drawButton(4,2);
    ?>
    </div>
  </div>
</div>
<div class="container">
<h3>CURRENT CONDITIONS</h3>
<?php include 'time.php';?>
<hr>
  <div class="row">
    <div class="col-sm-3">
      <a href="/b.php" title="BASE" alt="BASE">
        <span class="fa-stack fa-3x">
          <i class="fa fa-circle fa-stack-2x text-success"></i>
          <strong class="fa-stack-1x fa-stack-text fa-inverse">B</strong>
        </span>
      </a>
      <div id="roomtemp_div"></div>
      <div id="roomhum_div"></div>
    </div>
    
    <div class="col-sm-3">
      <a href="/0.php" title="ENV" alt="ENV">
        <span class="fa-stack fa-3x">
          <i class="fa fa-circle fa-stack-2x text-success"></i>
          <strong class="fa-stack-1x fa-stack-text fa-inverse">E</strong>
        </span>
      </a>
      <div id="envmoist_div"></div>
      <div id="envqual_div"></div>
    </div>
    
    <div class="col-sm-3">
      <a href="/1.php" title="VIV 1" alt="VIV 1">
        <span class="fa-stack fa-3x">
          <i class="fa fa-circle fa-stack-2x text-success"></i>
          <strong class="fa-stack-1x fa-stack-text fa-inverse">1</strong>
        </span>
      </a>
      <div id="viv1temp_div"></div>
      <div id="viv1hum_div"></div>
    </div>
    
    <div class="col-sm-3">
      <a href="/2.php" title="VIV 2" alt="VIV 2">
        <span class="fa-stack fa-3x">
          <i class="fa fa-circle fa-stack-2x text-success"></i>
          <strong class="fa-stack-1x fa-stack-text fa-inverse">2</strong>
        </span>
      </a>
      <div id="viv2temp_div"></div>
      <div id="viv2hum_div"></div>
    </div>
  </div>
<hr>

<div class="container">
<a href="/0.php" title="ENV" alt="ENV">
<span class="fa-stack fa-3x">
  <i class="fa fa-circle fa-stack-2x text-success"></i>
  <strong class="fa-stack-1x fa-stack-text fa-inverse">E</strong>
</span>
</a>
    <div id="envmoistgraph_div" style="width: auto; height: 500px;"></div>
    <div id="envqualgraph_div" style="width: auto; height: 500px;"></div>
</div>
<div class="container">
<a href="/1.php" title="VIV 1" alt="VIV 1">
<span class="fa-stack fa-3x">
  <i class="fa fa-circle fa-stack-2x text-success"></i>
  <strong class="fa-stack-1x fa-stack-text fa-inverse">1</strong>
</span>
</a>
    <div id="tank1tempgraph_div" style="width: auto; height: 500px;"></div>
    <div id="tank1humgraph_div" style="width: auto; height: 500px;"></div>
</div>
<div class="container">
<a href="/2.php" title="VIV 2" alt="VIV 2">
<span class="fa-stack fa-3x">
  <i class="fa fa-circle fa-stack-2x text-success"></i>
  <strong class="fa-stack-1x fa-stack-text fa-inverse">2</strong>
</span>
</a>
    <div id="tank2tempgraph_div" style="width: auto; height: 500px;"></div>
    <div id="tank2humgraph_div" style="width: auto; height: 500px;"></div>
</div>
<div class="container"><hr>
<?php include 'footer.php';?></div>
</BODY> 
</HTML>

