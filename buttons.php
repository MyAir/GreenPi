<?PHP
// require_once("./include/membersite_config.php");

// if(!$fgmembersite->CheckLogin())
// {
//     $fgmembersite->RedirectToURL("login.php");
//     exit;
// }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<html>
  <head>
<html>
<head>
<title>RasPiViv.com - Buttons</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>

<body>
<body>
<div class="jumbotron">
<div class="container">
<?php include 'menu.php';?>
</div>
</div>
<div class="container">
     <!-- On/Off button's picture -->
	 <?php
	 //this php script generate the first page in function of the gpio's status
	 $status = array(0, 0, 0);

	 for ($i = 0; $i < count($status); $i++) {
		// Translate index to pin number:
		// Relays are connected to D2-D4 (2-4)
		$pin = $i + 2;
		$button = $pin;
		// get relay status
		// set the pinmode to output and digitalRead pin.
        exec('sudo ./relais_stat.py '.$pin, $status[$i], $return); 

		if ($pin == 2){
			$button = 0;
		} 
		if ($pin == 3){
			$button = 5;
		}
		if ($pin == 4){
			$button = 2;
		}

		// Images for green/red_4-6.png are inverted!
		// // Switch status to correct this
		// if($button >= 4){
		// 	if($status[$i][0] == 0){
		// 		$status[$i][0] = 1;
		// 	}else if ($status[$i][0] == 1) {
		// 		$status[$i][0] = 0;
		// 	}
	 //	}

		//if off
		if ($status[$i][0] == 0 ) {
		echo ("<img id='button_".$button."' src='data/img/red/red_".$button.".png' alt='off'/><br>");
		}
		//if on
		if ($status[$i][0] == 1 ) {
		echo ("<img id='button_".$button."' src='data/img/green/green_".$button.".png' alt='on'/><br>");
		}	 
	 }
	 ?>
	 </div>
	 <!-- javascript -->
	 <script src="script.js"></script>
<div class="container">
	 <hr><?php include 'footer.php';?>
</div>
</body>
</html>
