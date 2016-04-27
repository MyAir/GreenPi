<?php 
// functions_grove.php BEGIN

function readRelay($sensor) 
{ 
	// get relay state from D2-D4:
	
	global $debug;
	$output = array(); 
	$return_var = 0; 
	$retry = true;
	$retry_wait = 2000000;
	$retry_count = 0;

	stopWatch();
	while($retry and $retry_count < 5){
		if($retry_count > 0){
			$diff = stopWatch(true);
			if($diff < $retry_wait){
				$wait = $retry_wait - $diff;
				usleep($wait);
				debugPrint('GROVE: readRelay: D'.$sensor.': Waiting for '.$wait.' Microseconds...');
			}

		}
		debugPrint('GROVE: readRelay: D'.$sensor.': Reading Relay state. '
					.'$retry_count='.$retry_count);
		exec('sudo ./get_relay_stat.py '.$sensor, $output, $return_var); 
		// Parse the second output string directly into the variables
		parse_str($output[1]);
		$retry_count++;		
		// Retry if output is not plausible
		if($return_var == 0 
		   and ($state == 0 or $state == 1) ){
		   	// Value plausible; stop retrying.
		   	$retry = false;
		}elseif($return_var == 0){
			debugPrint('GROVE: readRelay: D'.$sensor.': Reading failed! Retry as RC='.$return_var);
			unset($output);
		}else{
			debugPrint('GROVE: readRelay: D'.$sensor.': Reading failed! Retry as state='.$state);
			unset($output);
		}
	}
	debugPrint('GROVE: readRelay: D'.$sensor.': Read ended RC='.$return_var
				.' $retry_count='.$retry_count.' Output='.print_r($output, true) );

	// Return 
	return array ($return_var, $state); 
} 

function writeRelay($sensor, $old_state, $new_state) 
{ 
	// write new state to relay D2-D4

	global $debug, $g_write_relay;
	$output = array(); 
	$return_var = 0; 
	$retry = true;
	$retry_wait = 2000000;
	$retry_count = 0;

	stopWatch();
	while($retry and $retry_count < 5){
		if($retry_count > 0){
			$diff = stopWatch(true);
			if($diff < $retry_wait){
				$wait = $retry_wait - $diff;
				usleep($wait);
				debugPrint('GROVE: writeRelay: D'.$sensor.': Waiting for '.$wait.' Microseconds...');
			}

		}
		$request = $sensor.' '.$new_state;
		debugPrint('GROVE: writeRelay: D'.$sensor.': Writing... $request='.$request
		           .' $retry_count='.$retry_count);
		if ($g_write_relay){
			exec('sudo ./set_relay.py '.$request, $output, $return_var); 
			// Parse the second output string directly into the variables
			parse_str($output[1]);
			$retry_count++;		
			if($return_var == 0 
			   and ($new_state == 0 or $new_state == 1) ){
			   	// Value plausible; stop retrying.
			   	$retry = false;
			}elseif($return_var == 0){
				debugPrint('GROVE: writeRelay: D'.$sensor.': Writing failed! Retry as RC='.$return_var);
				unset($output);
			}else{
				debugPrint('GROVE: writeRelay: D'.$sensor.': Writing failed! Retry as new_state='.$new_state);
				unset($output);
			}
		}else{
			debugPrint('GROVE: writeRelay: D'.$sensor.': Simulating set_relay.py '.$request);
			$return_var = 4;
			$output[0] = 'script=simulation&port='.$sensor.'&state='.$new_state;
			$output[1] = 'new_state='.$new_state;
			$retry=false;
		}
		
	}

	debugPrint('GROVE: writeRelay: D'.$sensor.': Write ended RC='.$return_var
				.' $retry_count='.$retry_count.' Output='.print_r($output, true) );

	// Return the Returncode and the new state.
	return array ($return_var, $new_state); 
} 

function readTempHumi($sensor) 
{ 
	// get Temperate and Humidity from D6-D8:

	global $debug;
	$output = array(); 
	$return_var = 0; 
	$retry = true;
	$retry_wait = 2000000;
	$retry_count = 0;

	stopWatch();
	while($retry and $retry_count < 5){
		if($retry_count > 0){
			$diff = stopWatch(true);
			if($diff < $retry_wait){
				$wait = $retry_wait - $diff;
				usleep($wait);
				debugPrint('GROVE: readTempHumi: D'.$sensor.': Waiting for '.$wait.' Microseconds...');
			}

		}
		debugPrint('GROVE: readTempHumi: D'.$sensor.': Reading TempHumi. '
					.'$retry_count='.$retry_count);
		exec('sudo ./get_dht.py '.$sensor, $output, $return_var); 
		// Parse the second output string directly into the variables
		parse_str($output[1]);
		$retry_count++;		
		// Retry if output is not plausible
		if($return_var == 0 
		   and ($temp > -10 and $temp < 81) 
   		   and ($humid > 4 and $humid < 100) ){
		   	// Value plausible; stop retrying.
		   	$retry = false;
		}elseif($return_var == 0){
			debugPrint('GROVE: readTempHumi: D'.$sensor.': Reading failed! Retry as RC='.$return_var);
			unset($output);
		}else{
			debugPrint('GROVE: readTempHumi: D'.$sensor.': Reading failed! '
						.'Retry as $temp='.$temp.' $humid='.$humid);
			unset($output);
		}
	}
	debugPrint('GROVE: readTempHumi: D'.$sensor.': Read ended RC='.$return_var
				.' $retry_count='.$retry_count.' Output='.print_r($output, true) );

	// Return 
	return array($return_var,$temp,$humid); 
} 

function readMoisture($sensor){
	// get Moisture from A0-A3

	global $debug;
	$output = array(); 
	$return_var = 0; 
	$retry = true;
	$retry_wait = 2000000;
	$retry_count = 0;

	stopWatch();
	while($retry and $retry_count < 5){
		if($retry_count > 0){
			$diff = stopWatch(true);
			if($diff < $retry_wait){
				$wait = $retry_wait - $diff;
				usleep($wait);
				debugPrint('GROVE: readMoisture: A'.$sensor.': Waiting for '.$wait.' Microseconds...');
			}

		}
		debugPrint('GROVE: readMoisture: A'.$sensor.': Reading Moisture. '
					.'$retry_count='.$retry_count);
		exec('sudo ./get_moisture.py '.$sensor, $output, $return_var); 
		// Parse the second output string directly into the variables
		parse_str($output[1]);
		$retry_count++;		
		// Retry if output is not plausible
		if($return_var == 0 
   		   and ($moist > -1 and $moist < 951) ){
		   	// Value plausible; stop retrying.
		   	$retry = false;
		}elseif($return_var == 0){
			debugPrint('GROVE: readMoisture: A'.$sensor.': Reading failed! Retry as RC='.$return_var);
			unset($output);
		}else{
			debugPrint('GROVE: readMoisture: A'.$sensor.': Reading failed! '
						.'Retry as $moist='.$moist);
			unset($output);
		}
	}
	debugPrint('GROVE: readMoisture: A'.$sensor.': Read ended RC='.$return_var
				.' $retry_count='.$retry_count.' Output='.print_r($output, true) );

	// Return 
	return array($return_var,$moist,$DryHumid); 
}
    
function readQuality($sensor){
	// get Air Quality from A0-A3

	global $debug;
	$output = array(); 
	$return_var = 0; 
	$retry = true;
	$retry_wait = 2000000;
	$retry_count = 0;

	stopWatch();
	while($retry and $retry_count < 5){
		if($retry_count > 0){
			$diff = stopWatch(true);
			if($diff < $retry_wait){
				$wait = $retry_wait - $diff;
				usleep($wait);
				debugPrint('GROVE: readQuality: A'.$sensor.': Waiting for '.$wait.' Microseconds...');
			}

		}
		debugPrint('GROVE: readQuality: A'.$sensor.': Reading Air Quality. '
					.'$retry_count='.$retry_count);
		exec('sudo ./get_airquality.py '.$sensor, $output, $return_var); 
		// Parse the second output string directly into the variables
		parse_str($output[1]);
		$retry_count++;		
		// Retry if output is not plausible
		if($return_var == 0 
   		   and ($quality > -1 and $quality < 1000) ){
		   	// Value plausible; stop retrying.
		   	$retry = false;
		}elseif($return_var == 0){
			debugPrint('GROVE: readQuality: A'.$sensor.': Reading failed! Retry as RC='.$return_var);
			unset($output);
		}else{
			debugPrint('GROVE: readQuality: A'.$sensor.': Reading failed! '
						.'Retry as $quality='.$quality);
			unset($output);
		}
	}
	if ($retry_count >= 5 and $quality >= 1000){
		debugPrint('GROVE: readQuality: A'.$sensor.': Patching $quality >=1000');
		$quality = 1000;
	}
	debugPrint('GROVE: readQuality: A'.$sensor.': Read ended RC='.$return_var
				.' $retry_count='.$retry_count.' Output='.print_r($output, true) );

	// Return 
	return array($return_var,$quality,$rating); 
}
    

// functions_grove.php END
?> 
