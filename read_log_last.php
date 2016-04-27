<?php 
$vardump = TRUE;
// read_log_last.php BEGIN

// Read last Sensor values from DB:

// Read last $tempHumiExt
debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiExt['port'].': calling...');
$returnVar = logReadLastTempHumi($tempHumiExt['port']);
debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiExt['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($tempHumiExt['last_RC'],$tempHumiExt['last_date_time'], $tempHumiExt['last_temp'], $tempHumiExt['last_humi']) = $returnVar;
if($vardump){
    debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiExt['port'].': list complete '
	    		.'$tempHumiExt='.print_r($tempHumiExt, true) );
}
unset($returnVar);

// Read last $tempHumiInt1
debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiInt1['port'].': calling...');
$returnVar = logReadLastTempHumi($tempHumiInt1['port']);
debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiInt1['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($tempHumiInt1['last_RC'],$tempHumiInt1['last_date_time'], $tempHumiInt1['last_temp'], $tempHumiInt1['last_humi']) = $returnVar;
if($vardump){
    debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiInt1['port'].': list complete '
	    		.'$tempHumiInt1='.print_r($tempHumiInt1, true) );
}
unset($returnVar);

// Read last $tempHumiInt2
debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiInt2['port'].': calling...');
$returnVar = logReadLastTempHumi($tempHumiInt2['port']);
debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiInt2['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($tempHumiInt2['last_RC'],$tempHumiInt2['last_date_time'], $tempHumiInt2['last_temp'], $tempHumiInt2['last_humi']) = $returnVar;
if($vardump){
    debugPrint(	'RLOGL: logReadLastTempHumi: D'.$tempHumiInt2['port'].': list complete '
	    		.'$tempHumiInt2='.print_r($tempHumiInt2, true) );
}
unset($returnVar);

// Read last $soilMoisture
debugPrint(	'RLOGL: logReadLastMoisture: A'.$soilMoisture['port'].': calling...');
$returnVar = logReadLastMoisture($soilMoisture['port']);
debugPrint(	'RLOGL: logReadLastMoisture: A'.$soilMoisture['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($soilMoisture['last_RC'],$soilMoisture['last_date_time'], $soilMoisture['last_moist'] ) = $returnVar;
if($vardump){
    debugPrint(	'RLOGL: logReadLastMoisture: A'.$soilMoisture['port'].': list complete '
	    		.'$soilMoisture='.print_r($soilMoisture, true) );
}
unset($returnVar);

// Read last $airQuality
debugPrint(	'RLOGL: logReadLastAirQuality: A'.$airQuality['port'].': calling...');
$returnVar = logReadLastAirQuality($airQuality['port']);
debugPrint(	'RLOGL: logReadLastAirQuality: A'.$airQuality['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($airQuality['last_RC'],$airQuality['last_date_time'], $airQuality['last_quality'] ) = $returnVar;
if($vardump){
    debugPrint(	'RLOGL: logReadLastAirQuality: A'.$airQuality['port'].': list complete '
	    		.'$airQuality='.print_r($airQuality, true) );
}
unset($returnVar);


// read_log_last.php END
?> 
