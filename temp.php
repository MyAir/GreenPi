<?php
	$command = escapeshellcmd('sudo ./get_dht11.py 6');
	$output = shell_exec($command);
	echo $output;
?>
