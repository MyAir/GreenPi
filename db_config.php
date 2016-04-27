<?php 
// db_config.php BEGIN
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


// db_config.php END
?> 
