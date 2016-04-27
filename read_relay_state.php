<?php 
$vardump = TRUE;
// read_relay_state.php BEGIN

// Read current relay state from D2-D4:

// Read $relayD2
debugPrint('RRELS: calling readRelay with $relayD2[\'port\']='.$relayD2['port']);
$returnVar = readRelay($relayD2['port']);
// unstring return array into RC and state attribute of $relayD2
list($relayD2['RC'], $relayD2['state']) = $returnVar;
debugPrint('RRELS: $returnVar='.$returnVar.' RC='.$relayD2['RC'].'  '.' state='.$relayD2['state']);
unset($returnVar);

// Read $relayD3
debugPrint('RRELS: calling readRelay with $relayD3[\'port\']='.$relayD3['port']);
$returnVar = readRelay($relayD3['port']);
list($relayD3['RC'], $relayD3['state']) = $returnVar;
debugPrint('RRELS: $returnVar='.$returnVar.' RC='.$relayD3['RC'].'  '.' state='.$relayD3['state']);
unset($returnVar);

// Read $relayD4
debugPrint('RRELS: calling readRelay with $relayD4[\'port\']='.$relayD4['port']);
$returnVar = readRelay($relayD4['port']);
list($relayD4['RC'], $relayD4['state']) = $returnVar;
debugPrint('RRELS: $returnVar='.$returnVar.' RC='.$relayD4['RC'].'  '.' state='.$relayD4['state']);
unset($returnVar);

// read_relay_state.php END
?> 
