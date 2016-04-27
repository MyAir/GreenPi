<?php
	$command = escapeshellcmd('sudo ./get_moisture.py');
	$output = shell_exec($command);
	echo $output;
?>
