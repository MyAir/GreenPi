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
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<head>
<title>GreenPi - Relay Log</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <!-- JQuery Core JavaScript -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- ENV HISTORY MOIST GRAPH -->

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["table"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [{label: 'Timestamp', id: 'date_time', type: 'datetime'}, 
           {label: 'Relay', id: 'sensor', type: 'string'},
           {label: 'Old state', id: 'state_old', type: 'string'},
           {label: 'New state', id: 'state_new', type: 'string'},
           {label: 'Reason', id: 'reason', type: 'string'}],
<?php 
  $result = getValuesAll($tb_current_relay, ['date_time','sensor', 'state_old', 'state_new', 'reason'],200);
  for($r=0;$r<count($result);$r++){
    // echo "['Date(".date(DATE_W3C,strtotime($result[$r][0])).")', "; 
    echo "['Date(".(strtotime($result[$r][0])*1000).")', ";
    if($result[$r][1] == 2){
      echo " 'Light', ";
      if($result[$r][2] == 0){echo " 'Off', ";}else{echo " 'On', ";}
      if($result[$r][3] == 0){echo " 'Off', ";}else{echo " 'On', ";}
    }elseif($result[$r][1] == 3){
      echo " 'Fan', ";
      if($result[$r][2] == 1){echo " 'Off', ";}else{echo " 'On', ";}
      if($result[$r][3] == 1){echo " 'Off', ";}else{echo " 'On', ";}
    }elseif($result[$r][1] == 4){
      echo " 'Humifier', ";
      if($result[$r][2] == 1){echo " 'Off', ";}else{echo " 'On', ";}
      if($result[$r][3] == 1){echo " 'Off', ";}else{echo " 'On', ";}
    }else{
      echo " ".$result[$r][1].", ";
      echo " ".$result[$r][2].", "; 
      echo " ".$result[$r][3].", "; 
    }
    echo " '".$result[$r][4]."' ],"; 
  }
  unset($result);
?> 
        ]);

	var options = {
	   allowHtml:true,
  	title: 'Las 100 relay switch activities',
  	width: '100%', height: '100%'
  };

        var chart = new google.visualization.Table(document.getElementById('relay_log_div'));

        chart.draw(data, options);
  };
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
<div class="container">
    <div class="col-md-12">
      <h3>Last 200 relay switch actions</h3>
      <div id="relay_log_div" style="width: auto; height: 500px;"></div>
    </div>
</div>
<div class="container"><hr>
<?php include 'footer.php';?></div>
</BODY> 
</HTML>

