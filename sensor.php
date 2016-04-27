<?php 
function readTempHumi($sensor) 
{ 
	$output = array(); 
	$return_var = 0; 

	// get Temperate and Humidity from D6-D8
	exec('sudo ./get_dht.py '.$sensor, $output, $return_var); 
	// On error retry, as first readings are sometimes errorrous.
  	if($return_var != 0){
		exec('sudo ./get_dht.py '.$sensor, $output, $return_var);
  	}
  	// echo "Returnvar:" . $return_var . ' ';
  	// echo 'Output0:' . $output[0] . ' ';
  	// echo 'Output1:' . $output[1] . ' ';

	// // Parse the first output the ID string directly into the variables
	// parse_str($output[0]);
	// echo "script=" . $script . '&';
	// echo "port=" .   $port . '&';
	// echo "typ=" .    $typ  . '&';
	
	// Parse the second output string directly into the variables
	parse_str($output[1]);
	// echo "temp=" . $temp . '&';
	// echo "humid=" . $humid . ' ';

	// insert into database
	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
	mysql_select_db("datalogger"); 
	// $q = "INSERT INTO datalogger( VALUES (now(), $sensor, '$temp', '$humid')"; 
	$q = "INSERT INTO datalogger(date_time, sensor, temperature, humidity) VALUES (now(), $sensor, $temp, $humid)";
	mysql_query($q); 
	mysql_close($db); 

	return 0; 
} 
function readMoisture($sensor){
	$output = array(); 
	$return_var = 0; 

	// get Moisture from A0-A3
	exec('sudo ./get_moisture.py '.$sensor, $output, $return_var); 
	if($return_var != 0){
		exec('sudo ./get_moisture.py '.$sensor, $output, $return_var); 
	}
  	// echo "Returnvar:" . $return_var . ' ';
  	// echo 'Output0:' . $output[0] . ' ';
  	// echo 'Output1:' . $output[1] . ' ';

	// // Parse the first output string directly into the variables
	// parse_str($output[0]);
	// echo "script=" . $script . '&';
	// echo "port=" .   $port . ' ';

	// Parse the second output string directly into the variables
	parse_str($output[1]);
	// echo "moist=" . $moist . '&';
	// echo "DryHumid=" . $DryHumid . ' ';
    
	// insert into database
	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
	mysql_select_db("datalogger"); 
	$q = "INSERT INTO datalogger (date_time, sensor, moisture, DryHumid) VALUES (now(), $sensor, $moist, $DryHumid)"; 
	mysql_query($q); 
	mysql_close($db); 

	return 0; 
}

function readQuality($sensor){
	$output = array(); 
	$return_var = 0; 

	// get Air Quality from A0-A3
	exec('sudo ./get_airquality.py '.$sensor, $output, $return_var); 
	if($return_var != 0){
		exec('sudo ./get_airquality.py '.$sensor, $output, $return_var); 
	}
  	// echo "Returnvar:" . $return_var . ' ';
  	// echo 'Output0:' . $output[0] . ' ';
  	// echo 'Output1:' . $output[1] . ' ';

	// // Parse the first output string directly into the variables
	// parse_str($output[0]);
	// echo "script=" . $script . '&';
	// echo "port=" .   $port . ' ';

	// Parse the second output string directly into the variables
	parse_str($output[1]);
	// echo "quality=" . $quality . '&';
	// echo "rating=" . $rating . ' ';
    
	// insert into database
	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
	mysql_select_db("datalogger"); 
	$q = "INSERT INTO datalogger (date_time, sensor, quality, rating) VALUES (now(), $sensor, $quality, $rating)"; 
	echo $q;
	mysql_query($q); 
	// $res = mysql_query($q); 
	// echo "res=".$res." err=". mysql_error();
	mysql_close($db); 

	return 0; 
}
readMoisture(0);
readQuality(1);
readTempHumi(8); 
readTempHumi(7); 
readTempHumi(6); 

?> 
