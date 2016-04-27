<?php 
// functions_frontend.php BEGIN
require_once("./db_config.php");

function getValues($table, $sensor, $values, $limit){
  // Read $limit $values from $table from $sensor.
	global $debug;
	$return_var = 0;
	$ret_values = array();
	global $servername, $username, $password, $database;

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	
	$valcount = count($values);	
	$q = "SELECT $values[0]";
	for ($i=1;$i<$valcount;$i++) {
	  $q.= " ,$values[$i]";
	}
	$q.= " FROM $table";
	$q.= " WHERE sensor=$sensor ORDER BY date_time DESC";
	$q.= " LIMIT $limit";
	$result = mysqli_query($conn,$q);

	$o=0;
	while($row = mysqli_fetch_assoc($result)){
	  for($v=0;$v < $valcount;$v++){
  	  $ret_values[$o][$v] = $row[$values[$v]];
	  }
	  $o++;
	}
  	mysqli_close($conn); 
	return $ret_values; 
}

function drawButton($sensor, $button){
	global $tb_current_relay;
	$result = getValues($tb_current_relay, $sensor, ['state_new','date_time','reason'],1);
	
	if ($result[0][0] == 0 ) {
	  echo ("<img id='button_".$button."' src='data/img/red/red_".$button.".png' alt='off'");
	  echo (" title='".$result[0][1].":\n".$result[0][2]."'/>");
	}
	//if on
	if ($result[0][0] == 1 ) {
	  echo ("<img id='button_".$button."' src='data/img/green/green_".$button.".png' alt='on'");
	  echo (" title='".$result[0][1].":\n".$result[0][2]."'/>");
	}	 
	unset($result);
}
// functions_frontend.php END
?> 
