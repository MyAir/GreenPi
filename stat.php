<?php
	$argecho = '$argv=' + $argv[1];
	echo $argecho;
	$command = escapeshellcmd('sudo ./relais_stat.py');
	$output = shell_exec($command);
	echo $output;
?>
