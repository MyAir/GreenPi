<?php 
// functions_mysql.php BEGIN

function logReadLastTempHumi($sensor){
	// Read latest temperature and humidity from tb_current
	global $debug;
	$return_var = 0; 
	global $servername, $username, $password, $database, $tb_current;

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$q = "SELECT date_time, temperature, humidity FROM $tb_current";
	$q.= " WHERE sensor=$sensor ORDER BY date_time DESC LIMIT 1";
	debugPrint('MYSQL: logReadLastTempHumi: Querying $q=' . $q);
	$result = mysqli_query($conn,$q);
	debugPrint('MYSQL: logReadLastTempHumi: Query complete.');
	if (mysqli_num_rows($result) > 0) {
		// Fetch fields
		if($row = mysqli_fetch_assoc($result)){
			debugPrint(	'MYSQL: logReadLastTempHumi: fetch_assoc successful.' 
						.' date_time='.$row['date_time']
						.' temperature='.$row['temperature']
						.' humidity='.$row['humidity']);
			$sqlRC = 0;
		}else{
			debugPrint('MYSQL: logReadLastTempHumi: fetch_assoc failed! $result='.print_r($result, true) );
		    $sqlRC = 12;
		}
	} else {
	    debugPrint('MYSQL: logReadLastTempHumi: Query failed!: '
	    			.'mysqli_num_rows <= 0! q='.$q."\n".'$result='.print_r($result, true).' error= '.mysqli_error($conn) );
	    $sqlRC = 12;
	}
	mysqli_close($conn); 
	return array ($sqlRC, $row['date_time'], $row['temperature'], $row['humidity']); 
} 

function logReadLastMoisture($sensor){
	// Read latest temperature and humidity from tb_current
	global $debug;
	$return_var = 0; 
	global $servername, $username, $password, $database, $tb_current;

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$q = "SELECT date_time, moisture FROM $tb_current";
	$q.= " WHERE sensor=$sensor ORDER BY date_time DESC LIMIT 1";
	debugPrint('MYSQL: logReadLastMoisture: Querying $q=' . $q);
	$result = mysqli_query($conn,$q);
	debugPrint('MYSQL: logReadLastMoisture: Query complete.');
	if (mysqli_num_rows($result) > 0) {
		// Fetch fields
		if($row = mysqli_fetch_assoc($result)){
			debugPrint(	'MYSQL: logReadLastMoisture: fetch_assoc successful.' 
						.' date_time='.$row['date_time']
						.' moisture='.$row['moisture']);
			$sqlRC = 0;
		}else{
			debugPrint('MYSQL: logReadLastMoisture: fetch_assoc failed! $result='.print_r($result, true) );
		    $sqlRC = 12;
		}
	} else {
	    debugPrint('MYSQL: logReadLastMoisture: Query failed!: '
	    			.'mysqli_num_rows <= 0! q='.$q."\n".'$result='.print_r($result, true).' error= '.mysqli_error($conn) );
	    $sqlRC = 12;
	}
	mysqli_close($conn); 
	return array ($sqlRC, $row['date_time'], $row['moisture']); 
} 

function logReadLastAirQuality($sensor){
	// Read latest temperature and humidity from tb_current
	global $debug;
	$return_var = 0; 
	global $servername, $username, $password, $database, $tb_current;

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$q = "SELECT date_time, quality FROM $tb_current";
	$q.= " WHERE sensor=$sensor ORDER BY date_time DESC LIMIT 1";
	debugPrint('MYSQL: logReadLastAirQuality: Querying $q=' . $q);
	$result = mysqli_query($conn,$q);
	debugPrint('MYSQL: logReadLastAirQuality: Query complete.');
	if (mysqli_num_rows($result) > 0) {
		// Fetch fields
		if($row = mysqli_fetch_assoc($result)){
			debugPrint(	'MYSQL: logReadLastAirQuality: fetch_assoc successful.' 
						.' date_time='.$row['date_time']
						.' quality='.$row['quality']);
			$sqlRC = 0;
		}else{
			debugPrint('MYSQL: logReadLastAirQuality: fetch_assoc failed! $result='.print_r($result, true) );
		    $sqlRC = 12;
		}
	} else {
	    debugPrint('MYSQL: logReadLastAirQuality: Query failed!: '
	    			.'mysqli_num_rows <= 0! q='.$q."\n".'$result='.print_r($result, true).' error= '.mysqli_error($conn) );
	    $sqlRC = 12;
	}
	mysqli_close($conn); 
	return array ($sqlRC, $row['date_time'], $row['quality']); 
} 

function logWriteTempHumi($sensor, $temperature, $humidity, $stateD2, $stateD3, $stateD4){
	global $debug;
	$return_var = 0; 
	global $g_write, $servername, $username, $password, $database, $tb_current;

	// insert into database
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$q = "INSERT INTO $tb_current(date_time, sensor, temperature, humidity, stat_D2, stat_D3, stat_D4) ";
	$q.= "VALUES (now(), $sensor, $temperature, $humidity, $stateD2, $stateD3, $stateD4)";
	if ($g_write) {
		debugPrint('MYSQL: logWriteTempHumi: Querying $q=' . $q);
		if(mysqli_query($conn,$q)) {
			debugPrint('MYSQL: logWriteTempHumi: Query successful.' . $q);
		    $sqlRC = 0;
		} else {
		    debugPrint('MYSQL: logWriteTempHumi: Query Error: q='.$q."\n".' error= '.mysqli_error($conn) );
		    $sqlRC = 12;
		}
	} else {
		debugPrint('MYSQL: logWriteTempHumi: Simulating $q=' . $q);
		$sqlRC = 4;
	}
	mysqli_close($conn); 
	return $sqlRC; 
} 

function logWriteMoisture($sensor, $moisture, $DryHumid, $stateD2, $stateD3, $stateD4){
	global $debug;
	$return_var = 0; 
	global $g_write, $servername, $username, $password, $database, $tb_current;

	// insert into database
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$q = "INSERT INTO $tb_current(date_time, sensor, moisture, DryHumid, stat_D2, stat_D3, stat_D4) ";
	$q.= "VALUES (now(), $sensor, $moisture, $DryHumid, $stateD2, $stateD3, $stateD4)";
	if ($g_write) {
		debugPrint('MYSQL: logWriteMoisture: Querying $q=' . $q);
		if(mysqli_query($conn,$q)) {
			debugPrint('MYSQL: logWriteMoisture: Query successful.' . $q);
		    $sqlRC = 0;
		} else {
		    debugPrint('MYSQL: logWriteMoisture: Query Error: q='.$q."\n".' error= '.mysqli_error($conn) );
		    $sqlRC = 12;
		}
	} else {
		debugPrint('MYSQL: logWriteMoisture: Simulating $q=' . $q);
		$sqlRC = 4;
	}
	mysqli_close($conn); 
	return $sqlRC; 
} 

function logWriteQuality($sensor, $quality, $rating, $stateD2, $stateD3, $stateD4){
	global $debug;
	$return_var = 0; 
	global $g_write, $servername, $username, $password, $database, $tb_current;

	// insert into database
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$q = "INSERT INTO $tb_current(date_time, sensor, quality, rating, stat_D2, stat_D3, stat_D4) ";
	$q.= "VALUES (now(), $sensor, $quality, $rating, $stateD2, $stateD3, $stateD4)";
	if ($g_write) {
		debugPrint('MYSQL: logWriteQuality: Querying $q=' . $q);
		if(mysqli_query($conn,$q)) {
			debugPrint('MYSQL: logWriteQuality: Query successful.' . $q);
		    $sqlRC = 0;
		} else {
		    debugPrint('MYSQL: logWriteQuality: Query Error: q='.$q."\n".' error= '.mysqli_error($conn) );
		    $sqlRC = 12;
		}
	} else {
		debugPrint('MYSQL: logWriteQuality: Simulating $q=' . $q);
		$sqlRC = 4;
	}
	mysqli_close($conn); 
	return $sqlRC; 
} 

function logWriteRelay($sensor, $oldState, $newState, $reason){
	global $debug;
	$return_var = 0; 
	global $g_write, $servername, $username, $password, $database, $tb_current_relay;

	// insert into database
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$q = "INSERT INTO $tb_current_relay(date_time, sensor, state_old, state_new, reason) ";
	$q.= "VALUES (now(), $sensor, $oldState, $newState, '$reason')";
	
	if ($g_write) {
		debugPrint('MYSQL: logWriteRelay: Querying $q=' . $q);
		if(mysqli_query($conn,$q)) {
			debugPrint('MYSQL: logWriteRelay: Query successful.' . $q);
		    $sqlRC = 0;
		} else {
		    debugPrint('MYSQL: logWriteRelay: Query Error: q='.$q."\n".' error= '.mysqli_error($conn) );
		    $sqlRC = 12;
		}
	} else {
		debugPrint('MYSQL: logWriteRelay: Simulating $q=' . $q);
		$sqlRC = 4;
	}
	mysqli_close($conn); 
	return $sqlRC; 
} 


// functions_mysql.php END
?> 
