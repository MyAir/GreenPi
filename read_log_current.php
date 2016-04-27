<?php 
$vardump = TRUE;
// read_log_current.php BEGIN
// Read $soilMoisture
// Write $soilMoisture
// Read $airQuality
// Write $airQuality
// Read $tempHumiInt2
// Write $tempHumiInt2
// Read $tempHumiInt1
// Write $tempHumiInt1
// Read $tempHumiExt
// Write $tempHumiExt

// Read Sensors and write to DB:

// Read $soilMoisture
$retry_count = 0;
do{
	debugPrint(	'RLOGC: readMoisture: A'.$soilMoisture['port'].': calling...');
	$returnVar = readMoisture($soilMoisture['port']);
	debugPrint(	'RLOGC: readMoisture: A'.$soilMoisture['port'].': Call complete '
				.'RC='.$returnVar[0] );
	list($soilMoisture['RC'], $soilMoisture['moist'], $soilMoisture['DryHumid']) = $returnVar;
	unset($returnVar);
	$retry_count++;
}while(!sensorPlausible($soilMoisture) and $retry_count < 5);

// Write $soilMoisture
debugPrint(	'RLOGC: logWriteMoisture: A'.$soilMoisture['port'].': calling...');
$soilMoisture['RC'] = logWriteMoisture($soilMoisture['port'], $soilMoisture['moist'], $soilMoisture['DryHumid'], $relayD2['state'], $relayD3['state'], $relayD4['state']);
debugPrint(	'RLOGC: logWriteMoisture: A'.$soilMoisture['port'].': Call complete '
			.'RC='.$soilMoisture['RC'] );

// Read $airQuality
debugPrint(	'RLOGC: readQuality: A'.$airQuality['port'].': calling...');
$returnVar = readQuality($airQuality['port']);
debugPrint(	'RLOGC: readQuality: A'.$airQuality['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($airQuality['RC'], $airQuality['quality'], $airQuality['rating']) = $returnVar;
unset($returnVar);

// Write $airQuality
debugPrint(	'RLOGC: logWriteQuality: A'.$airQuality['port'].': calling...');
$airQuality['RC'] = logWriteQuality($airQuality['port'], $airQuality['quality'], $airQuality['rating'], $relayD2['state'], $relayD3['state'], $relayD4['state']);
debugPrint(	'RLOGC: logWriteQuality: A'.$airQuality['port'].': Call complete '
			.'RC='.$airQuality['RC'] );

// Read $tempHumiInt2
debugPrint(	'RLOGC: readTempHumi: D'.$tempHumiInt2['port'].': calling...');
$returnVar = readTempHumi($tempHumiInt2['port']);
debugPrint(	'RLOGC: readTempHumi: D'.$tempHumiInt2['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($tempHumiInt2['RC'], $tempHumiInt2['temp'], $tempHumiInt2['humi']) = $returnVar;
unset($returnVar);

// Write $tempHumiInt2
debugPrint(	'RLOGC: logWriteTempHumi: D'.$tempHumiInt2['port'].': calling...');
$tempHumiInt2['RC'] = logWriteTempHumi($tempHumiInt2['port'], $tempHumiInt2['temp'], $tempHumiInt2['humi'], $relayD2['state'], $relayD3['state'], $relayD4['state']);
debugPrint(	'RLOGC: logWriteTempHumi: D'.$tempHumiInt2['port'].': Call complete '
			.'RC='.$tempHumiInt2['RC'] );

// Read $tempHumiInt1
debugPrint(	'RLOGC: readTempHumi: D'.$tempHumiInt1['port'].': calling...');
$returnVar = readTempHumi($tempHumiInt1['port']);
debugPrint(	'RLOGC: readTempHumi: D'.$tempHumiInt1['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($tempHumiInt1['RC'], $tempHumiInt1['temp'], $tempHumiInt1['humi']) = $returnVar;
unset($returnVar);

// Write $tempHumiInt1
debugPrint(	'RLOGC: logWriteTempHumi: A'.$tempHumiInt1['port'].': calling...');
$tempHumiInt1['RC'] = logWriteTempHumi($tempHumiInt1['port'], $tempHumiInt1['temp'], $tempHumiInt1['humi'], $relayD2['state'], $relayD3['state'], $relayD4['state']);
debugPrint(	'RLOGC: logWriteTempHumi: A'.$tempHumiInt1['port'].': Call complete '
			.'RC='.$tempHumiInt1['RC'] );


// Read $tempHumiExt
debugPrint(	'RLOGC: readTempHumi: D'.$tempHumiExt['port'].': calling...');
$returnVar = readTempHumi($tempHumiExt['port']);
debugPrint(	'RLOGC: readTempHumi: D'.$tempHumiExt['port'].': Call complete '
			.'RC='.$returnVar[0] );
list($tempHumiExt['RC'], $tempHumiExt['temp'], $tempHumiExt['humi']) = $returnVar;
unset($returnVar);

// Write $tempHumiExt
debugPrint(	'RLOGC: logWriteTempHumi: A'.$tempHumiExt['port'].': calling...');
$tempHumiExt['RC'] = logWriteTempHumi($tempHumiExt['port'], $tempHumiExt['temp'], $tempHumiExt['humi'], $relayD2['state'], $relayD3['state'], $relayD4['state']);
debugPrint(	'RLOGC: logWriteTempHumi: D'.$tempHumiExt['port'].': Call complete '
			.'RC='.$airQuality['RC'] );

// read_log_current.php END
?> 
