<?php 
echo "Hodor! Starting pulse.php\n";
// Include general functions
require_once './functions_general.php';
// Include grovepi functions
require_once './functions_grove.php';
// Include mysql functions
require_once './functions_mysql.php';

$debug = false;
$debug = true;

// $g_write = FALSE;
$g_write = TRUE;
// $g_write_relay = FALSE;
$g_write_relay = TRUE;
// $g_write_hist = FALSE;
$g_write_hist = TRUE;

// Debug variable for logging
$d = '';

// mysqli parameters
$servername = "localhost";
$username = "datalogger";
$password = "datalogger";
$database = "datalogger";

// Table name of current log
$tb_current = "current_log";
// Table name of current relay activity
$tb_current_relay= "relay_log";
// Table name of history in 60 minutes slices.
$tb_hist_hour= "history_hour";
// Table name of history in 15 minutes slices.
$tb_hist_quart= "history_quart";

// Table base_name for histAMin
$tb_hist= "history_";



$g_humiMin = 40.0;
$g_humiMax = 61.0;
$g_airQualityMax = 300;

// Include dependencies from composer
// require_once './vendor/autoload.php';

// Port|Pin    | Description
// 0   | A0    | Soil Moisture sensor
// 1   | A1    | Air Quality sensor
// 2-4 | D2-D4 | Relays
// 5   | D5    | unused
// 6-8 | D6-D8 | D6=DHT11, D7-8 DHT22, Temperature Humidity sensor
$relayD2      = array(  'port'=>2, 'RC'=>-1, 'state'=>-1, 'desired'=>-1,
                        'last_RC'=>-1, 'last_date_time'=>'', 'last_state'=>-1, 
					    'reason'=>'', 'time'=>'');
$relayD3      = array(  'port'=>3, 'RC'=>-1, 'state'=>-1, 'desired'=>-1,
                        'last_RC'=>-1, 'last_date_time'=>'', 'last_state'=>-1, 
					    'reason'=>'', 'time'=>'');
$relayD4      = array(  'port'=>4, 'RC'=>-1, 'state'=>-1, 'desired'=>-1,
                        'last_RC'=>-1, 'last_date_time'=>'', 'last_state'=>-1, 
					    'reason'=>'', 'time'=>'');
$tempHumiExt  = array(  'port'=>6, 'RC'=>-1,
                        'temp'=>0.00, 'humi'=>0.00,
                        'last_RC'=>-1, 'last_date_time'=>'', 
                        'last_temp'=>0.00, 'last_humi'=>0.00);
$tempHumiInt1 = array(  'port'=>7, 'RC'=>-1,
                        'temp'=>0.00, 'humi'=>0.00,
                        'last_RC'=>-1, 'last_date_time'=>'', 
                        'last_temp'=>0.00, 'last_humi'=>0.00);
$tempHumiInt2 = array(  'port'=>8, 'RC'=>-1,
                        'temp'=>0.00, 'humi'=>0.00,
                        'last_RC'=>-1, 'last_date_time'=>'', 
                        'last_temp'=>0.00, 'last_humi'=>0.00);
$soilMoisture = array(  'port'=>0, 'RC'=>-1, 
                        'moist'=>0, 'DryHumid'=>"", 
                        'last_RC'=>-1, 'last_date_time'=>'', 
                        'last_moist'=>0);
$airQuality   = array(  'port'=>1, 'RC'=>-1, 
                        'quality'=>0, 'rating'=>"",
                        'last_RC'=>-1, 'last_date_time'=>'', 
                        'last_quality'=>0);

// light on/off hours: 0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,
$lightHours  = array( 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 
//                    12,13,14,15,16,17,18,19,20,21,22,23
                      1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

// fan on/off hours: WARNING! Relay is NC so values are inverted!
//                  : 0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,
$fanHours    = array( 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 
//                    12,13,14,15,16,17,18,19,20,21,22,23
                      0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

// humi on/off hours: WARNING! Relay is NC so values are inverted! 
//                    0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,
$humiHours   = array( 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 
//                    12,13,14,15,16,17,18,19,20,21,22,23
                      0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

// Include histAMin functions
require './histAMin.php';

// Read Relay states:
include './read_relay_state.php';

// Read last Sensor values from DB:
include './read_log_last.php';


// Read and log A0, A1 and D6-D8 into current_log:
include './read_log_current.php';

histAMin(0,15,"quart");
histAMin(1,15,"quart");
histAMin(6,15,"quart");
histAMin(7,15,"quart");
histAMin(8,15,"quart");
histAMin(0,60,"hour");
histAMin(1,60,"hour");
histAMin(6,60,"hour");
histAMin(7,60,"hour");
histAMin(8,60,"hour");

$debug=TRUE;
// Get current Hour:
$now = time();
$testDateStr = date("Y-m-d H:i:s");

// !!!!!!!!!!!!!! Test !!!!!!!!!!!!!!!
// // Test date before 06:00
// $testDateStr = date("Y-m-d 04:00:s");

// // Test date at 06:00
// $testDateStr = date("Y-m-d 04:00:s");

// !!!!!!!!!!!!!! Test !!!!!!!!!!!!!!!

$testDate = strtotime($testDateStr);
$currHour = intval(date('H', $testDate));
debugPrint('PULSE: now='.$now.' $testDateStr='.$testDateStr.' $testDate='.$testDate
         .' $currHour='.$currHour);


// Light control:

debugPrint('PULSE: $relayD2: Assert Light state...');
// set desired Relay state.
if ($lightHours[$currHour] == 1){
	$relayD2['desired'] = 1;
}else{
	$relayD2['desired'] = 0;
}
$relayD2['reason'] = ('$lightHours for current hour "'.$currHour
        .'" is "'.$lightHours[$currHour]).'"';
$relayD2['time'] = date("Y-m-d H:i:s");

debugPrint('PULSE: $relayD2: '.print_r($relayD2, true) );
debugPrint('PULSE: $relayD2: Light state asserted.');

// set Relay to desired state.
if($relayD2['state'] != $relayD2['desired']){
    debugPrint('PULSE: $relayD2: Changing from state='
               .$relayD2['state']." to state="
               .$relayD2['desired']);

    $oldState = $relayD2['state'];
    $returnVar = writeRelay($relayD2['port'], $relayD2['state'], $relayD2['desired']);
    list($relayD2['RC'], $relayD2['state']) = $returnVar;
    debugPrint('PULSE: $relayD2: after write '.print_r($relayD2, true));
    unset($returnVar);
    $returnVar =  logWriteRelay($relayD2['port'], $oldState, $relayD2['state'], $relayD2['reason']);
    debugPrint('PULSE: $relayD2: logWriteRelay returncode='.$returnVar);
    unset($returnVar);
}

// Humifyer Control:

// !!!!!!!!!!!!!! Test !!!!!!!!!!!!!!!

// // Test too much humidity
// $tempHumiInt1['humi'] = 64.5;
// $relayD4['state'] = 0;

// // Test not enough humidity
// $tempHumiInt1['humi'] = 38.5;
// $relayD4['state'] = 1;

// !!!!!!!!!!!!!! Test !!!!!!!!!!!!!!!
// $g_write_relay = true;
debugPrint('PULSE: $relayD4: Asserting desired state...');
if($tempHumiInt1['humi'] > $g_humiMax){
    // Humidity too high; Desired State = 1 for OFF (Relay is NC)
	$relayD4['desired'] = 1;
    $relayD4['reason'] = ('$tempHumiInt1 humi="'.$tempHumiInt1['humi']
            .'" is bigger than maximum humidity "'.$g_humiMax).'"';
    $relayD4['time'] = date("Y-m-d H:i:s");
}elseif($tempHumiInt1['humi'] < $g_humiMin){
    // Humidity too low; Desired State = 0 for ON (Relay is NC)
	$relayD4['desired'] = 0;
    $relayD4['reason'] = ('$tempHumiInt1 humi="'.$tempHumiInt1['humi']
            .'" is smaller than minimum humidity "'.$g_humiMin).'"';
    $relayD4['time'] = date("Y-m-d H:i:s");
}

debugPrint('PULSE: $relayD4: Desired state asserted: '.print_r($relayD4, true));

// set Relay to desired state.
if($relayD4['desired'] != -1 and $relayD4['state'] != $relayD4['desired']){
    debugPrint('PULSE: $relayD4: Changing from state='
               .$relayD4['state']." to state="
               .$relayD4['desired']);
    
    $oldState = $relayD4['state'];
    unset($returnVar);
    $returnVar = writeRelay($relayD4['port'], $relayD4['state'], $relayD4['desired']);
    list($relayD4['RC'], $relayD4['state']) = $returnVar;
    debugPrint('PULSE: $relayD4: after write '.print_r($relayD4, true));
    unset($returnVar);
    debugPrint('PULSE: $relayD4: writing log...');
    $returnVar =  logWriteRelay($relayD4['port'], $oldState, $relayD4['state'], $relayD4['reason']);
    debugPrint('PULSE: logWriteRelay: returncode='.$returnVar);
}
    
// Fan control:

debugPrint('PULSE: $relayD3: Setting Fan state according to $fanHours...');
// Assert desired Relay state.
if ($fanHours[$currHour] == 1){
	$relayD3['desired'] = 1;
}else{
	$relayD3['desired'] = 0;
}
$relayD3['reason'] = ('$fanHours for current hour "'.$currHour
        .'" is "'.$fanHours[$currHour]).'"';
$relayD3['time'] = date("Y-m-d H:i:s");

debugPrint('PULSE: $relayD3: Fan state asserted: '.print_r($relayD3, true) );

// Now test if Fan is supposed to be off ($fanHour = 1 = OFF =NC )
if ($fanHours[$currHour] == 0){
    // Fan should be on.
    debugPrint('PULSE: $relayD3: Fan should be on! No alterations allowed!');
}elseif ($fanHours[$currHour] == 1){
    // Fan should be off so it's safe to actually alter it.
    
    debugPrint('PULSE: $relayD3: Asserting alterations due to humidity');
    if($tempHumiInt2['humi'] > $g_humiMax){
        // Humidity too high; Desired State = 0 for ON (Relay is NC)
    	$relayD3['desired'] = 0;
        $relayD3['reason'] = ('$tempHumiInt2 humi="'.$tempHumiInt2['humi']
                .'" is bigger than maximum humidity "'.$g_humiMax).'"';
        $relayD3['time'] = date("Y-m-d H:i:s");
        debugPrint('PULSE: $relayD3: State altered to 0. Turn ON for high Humidity');
    }elseif($relayD3['state'] == 0 and $tempHumiInt2['humi'] > $g_humiMin){
        // Fan is ON during FanOFF Hours  
        //     AND Humidity NOT too low; Keep it on; Desired State = 0 for OFF (Relay is NC)
    	$relayD3['desired'] = 0;
        $relayD3['reason'] = ('Fan was ON and $tempHumiInt2 humi="'.$tempHumiInt2['humi']
                .'" is bigger than minimum humidity "'.$g_humiMin).'"';
        $relayD3['time'] = date("Y-m-d H:i:s");
        debugPrint('PULSE: $relayD3: State altered to 0. Keep ON during Off');
    }else{
        debugPrint('PULSE: $relayD3: No humidity alterations necessary.');
    }
    
    debugPrint('PULSE: $relayD3: Asserting alterations due to air quality');
    if($airQuality['quality'] > $g_airQualityMax){
        // Air Quality too bad; Desired State = 0 for ON (Relay is NC)
    	$relayD3['desired'] = 0;
        $relayD3['reason'] = ('$airQuality humi="'.$airQuality['quality']
                .'" is bigger than maximum humidity "'.$g_airQualityMax).'"';
        $relayD3['time'] = date("Y-m-d H:i:s");
        debugPrint('PULSE: $relayD3: State altered to 0.');
    }else{
        debugPrint('PULSE: $relayD3: No air quality alterations necessary.');
    }
    
}
// set Relay to desired state.
if($relayD3['desired'] != -1 and $relayD3['state'] != $relayD3['desired']){
    debugPrint('PULSE: $relayD3: Changing from state='
               .$relayD3['state']." to state="
               .$relayD3['desired']);
    
    $oldState = $relayD3['state'];
    unset($returnVar);
    $returnVar = writeRelay($relayD3['port'], $relayD3['state'], $relayD3['desired']);
    list($relayD3['RC'], $relayD3['state']) = $returnVar;
    debugPrint('PULSE: $relayD3: after write '.print_r($relayD3, true));
    unset($returnVar);
    debugPrint('PULSE: $relayD3: writing log...');
    $returnVar =  logWriteRelay($relayD3['port'], $oldState, $relayD3['state'], $relayD3['reason']);
    debugPrint('PULSE: logWriteRelay: returncode='.$returnVar);
}



// histAMin(1);

?> 
