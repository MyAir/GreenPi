<?php
require_once("./functions_frontend.php");
$result = getValues($tb_current, 0, ['date_time'],1);
echo "<b>". "LAST UPDATE: " . $result[0][0]. "</b>";
unset($result);
?> 
