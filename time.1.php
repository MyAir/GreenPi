<?php
$servername = "localhost";
$username = "datalogger";
$password = "datalogger";
$dbname = "datalogger";
// Table name of current log
$tb_current = "current_log";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// $mysqldate = date( 'Y-m-d H:i:s', $phpdate );
$mysqldate = date( 'Y-m-d H:i:s' );
$phpdate = strtotime( $mysqldate );

$sql = "SELECT date_time, sensor, temperature, humidity FROM $tb_current ORDER BY date_time DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<b>". "LAST UPDATE: " . $row["date_time"]. "</b>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?> 
