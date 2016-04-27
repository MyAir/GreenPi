<?php
	$command = escapeshellcmd('sudo ./light_off.py');
	$output = shell_exec($command);
	echo $output;
?>
