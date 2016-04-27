<?php 
// histAMin.php BEGIN

function histAMin($sensor, $agrmins, $suffix){
	$output = array(); 
	$return_var = 0; 
	global $g_write, $g_write_hist, $g_quality, $g_rating;
	global $g_write, $servername, $username, $password, $database, $tb_current, $tb_hist;

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$q ="CREATE TABLE IF NOT EXISTS `$tb_hist$suffix` (";
	$q.="  `date_time` datetime NOT NULL,";
	$q.="  `temp_avg` float DEFAULT NULL COMMENT 'Average Temperature',";
	$q.="  `temp_min` float DEFAULT NULL COMMENT 'Minimum Temperature',";
	$q.="  `temp_max` float DEFAULT NULL COMMENT 'Maximum Temperature',";
	$q.="  `humi_avg` float DEFAULT NULL COMMENT 'Average Humidity',";
	$q.="  `humi_min` float DEFAULT NULL COMMENT 'Minimum Humidity',";
	$q.="  `humi_max` float DEFAULT NULL COMMENT 'Maximum Humidity',";
	$q.="  `moist_avg` float DEFAULT NULL COMMENT 'Average Moisture',";
	$q.="  `moist_min` float DEFAULT NULL COMMENT 'Minimum Moisture',";
	$q.="  `moist_max` float DEFAULT NULL COMMENT 'Maximum Moisture',";
	$q.="  `qual_avg` float DEFAULT NULL COMMENT 'Average Air Quality',";
	$q.="  `qual_min` float DEFAULT NULL COMMENT 'Minimum (best) Air Quality',";
	$q.="  `qual_max` float DEFAULT NULL COMMENT 'Maximum (worst) Air Quality',";
	$q.="  `sensor` varchar(32) NOT NULL,";
	$q.="  PRIMARY KEY (`date_time`,`sensor`),";
	$q.="  KEY `sensor` (`sensor`)";
	$q.=") ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='History in $agrmins Minutes slots' ";
	if ($g_write_hist) {
		// debugPrint('MYSQL: histAMin: Creating Table $q=' . $q);
		if(mysqli_query($conn,$q)) {
			// debugPrint('MYSQL: histAMin: Create successful.' . $q);
		    $sqlRC = 0;
		} else {
		    debugPrint('MYSQL: histAMin: Create Error: q='.$q."\n".' error= '.mysqli_error($conn) );
		    $sqlRC = 12;
		}
	} else {
		debugPrint('MYSQL: histAMin: Simulating Create $q=' . $q);
		$sqlRC = 4;
	}

	if($sqlRC <= 4){
		// Table created or already there. Update History
		$q ="";	
		$q.="	replace into $tb_hist$suffix (";
		$q.="	    date_time, sensor, ";
		if($sensor == 6 or
		   $sensor == 7 or
		   $sensor == 8){
			$q.="	    temp_avg,temp_min,temp_max, ";
			$q.="	    humi_avg,humi_min,humi_max ";
		}else if($sensor == 0){
			$q.="	    moist_avg,moist_min,moist_max ";
		}else{
			$q.="	    qual_avg,qual_min,qual_max ";
		}
		$q.="	  ) ";
		$q.="	SELECT "; 
		$q.="	  CONCAT_WS( ";
		$q.="	    ' ', date(date_time), ";
		$q.="	    ( ";
		$q.="	      sec_to_time( ";
		$q.="	        time_to_sec(date_time) - ";
		$q.="	        time_to_sec(date_time)%($agrmins*60) ";
		$q.="	      ) "; 
		$q.="	    ) "; 
		$q.="	  ) as date_time_agr, ";
		$q.="	  sensor, ";
		if($sensor == 6 or
		   $sensor == 7 or
		   $sensor == 8){
			$q.="	  round(avg(temperature),2) as temp_avg, ";
			$q.="	  min(temperature) as temp_min, ";
			$q.="	  max(temperature) as temp_max, ";
			$q.="	  round(avg(humidity),2) as humi_avg, ";
			$q.="	  min(humidity) as humi_min, ";
			$q.="	  max(humidity) as humi_max ";
		}else if($sensor == 0){
			$q.="	  round(avg(moisture),2) as moist_avg, ";
			$q.="	  min(moisture) as moist_min, ";
			$q.="	  max(moisture) as moist_max ";
		}else{
			$q.="	  round(avg(quality),2) as qual_avg, ";
			$q.="	  min(quality) as qual_min, ";
			$q.="	  max(quality) as qual_max ";
		}
		$q.="	from current_log ";
		$q.="	where ";
		$q.="	  sensor = $sensor ";
		$q.="	  and date_time >=date_sub(CURRENT_TIMESTAMP(), interval $agrmins minute) ";
		$q.="	  and date_time < CURRENT_TIMESTAMP() ";
		$q.="	group by date_time_agr, sensor ";
		// Execute Query
		if ($g_write) {
			debugPrint('MYSQL: histAMin: Querying $q=' . $q);
			if(mysqli_query($conn,$q)) {
				debugPrint('MYSQL: histAMin: Query successful.' . $q);
			    $sqlRC = 0;
			} else {
			    debugPrint('MYSQL: histAMin: Query Error: q='.$q."\n".' error= '.mysqli_error($conn) );
			    $sqlRC = 12;
			}
		} else {
			debugPrint('MYSQL: histAMin: Simulating $q=' . $q);
			$sqlRC = 4;
		}
	}
	
	mysqli_close($conn); 
	return $sqlRC; 
}

// histAMin.php END
?> 
