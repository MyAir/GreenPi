<?php 
// functions_general.php BEGIN

function debugPrint($d){
    global $debug;
    $now = date("Y-m-d H:i:s");
    if($debug) echo "$now DEBUG: ".$d."\n";
}

// StopWatch function to measure time between calls
function stopWatch($total = false,$reset = true){
    global $first_called;
    global $last_called;
    $now_time = microtime(true);
    if ($last_called === null) {
        $last_called = $now_time;
        $first_called = $now_time;
    }
    if ($total) {
        $time_diff = $now_time - $first_called;
    } else {
        $time_diff = $now_time - $last_called;
    }
    if ($reset)
        $last_called = $now_time;
    return $time_diff;
}

// Check plausibility of sensor reading comapred to last reading
function sensorPlausible($sensor){
    $plausi = true;
    if($sensor['last_RC'] == 0){
        debugPrint('GENER: Plausi: Sensor '.$sensor['port'].': Last reading present' );
        $diffsec = (time()-strtotime($sensor['last_date_time']));
        if ($diffsec < 90){
            debugPrint( 'GENER: Plausi: Sensor '.$sensor['port']
                        .': Time difference within range for plausi. $diffsec='.$diffsec );
            if($sensor['port'] == 0){
                // $soilMoisture:
                $diffval = abs($sensor['moist'] - $sensor['last_moist']);
                debugPrint( 'GENER: Plausi: Sensor '.$sensor['port']
                            .': moist='.$sensor['moist'].'last_moist='.$sensor['last_moist'] 
                            .' $diffval='.$diffval);
                // DEBUG: Exit with plausible
                $plausi = true;
            }elseif($sensor['port'] == 1){
                // $airQuality:
                $diffval = abs($sensor['quality'] - $sensor['last_quality']);
                debugPrint( 'GENER: Plausi: Sensor '.$sensor['port']
                            .': quality='.$sensor['quality'].'last_quality='.$sensor['last_quality'] 
                            .' $diffval='.$diffval);
                // DEBUG: Exit with plausible
                $plausi = true;
            }elseif($sensor['port'] == 6
                    or $sensor['port'] == 7
                    or $sensor['port'] == 8){
                // $tempHumi:
                $diffval = abs($sensor['temp'] - $sensor['last_temp']);
                debugPrint( 'GENER: Plausi: Sensor '.$sensor['port']
                            .': temp='.$sensor['temp'].'last_temp='.$sensor['last_temp'] 
                            .' $diffval='.$diffval);
                $diffval = abs($sensor['humi'] - $sensor['last_humi']);
                debugPrint( 'GENER: Plausi: Sensor '.$sensor['port']
                            .': humi='.$sensor['humi'].'last_humi='.$sensor['last_humi'] 
                            .' $diffval='.$diffval);
                // DEBUG: Exit with plausible
                $plausi = true;
            }else{
                debugPrint('GENER: Plausi: Sensor '.$sensor['port'].': Unknown Sensor. Plausi=true' );
                $plausi = true;
            }
        }else{
            debugPrint( 'GENER: Plausi: Sensor '.$sensor['port']
                        .': Time difference too big for plausi. $diffsec='.$diffsec
                        .' Plausi=true');
            $plausi = true;
        }
            }else{
        debugPrint('GENER: Plausi: Sensor '.$sensor['port'].': Last reading not present. Plausi=true' );
        // Reading can only be palausible.
        $plausi = true;
    }
    return $plausi;
}

// functions_general.php END
?> 
