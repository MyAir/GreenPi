<?php
	$command = escapeshellcmd('sudo ./light_on.py');
	$output = shell_exec($command);
	echo $output;
?>
