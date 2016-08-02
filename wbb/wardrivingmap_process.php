<?php

$pid = pcntl_fork();
if ($pid == -1) {
	die('Konnte nicht verzweigen');
} elseif ($pid) {
	// Wir sind der Vater
	die();
} else {
	// Wir sind das Kind
	//
	// fangen wir an, zu rendern

	// Zuerst die Variablen
	$uploadfilename = base64_decode($argv[1]);

	//Backups
	$current_time = time();
	chmod("./wardrivingmap/todo/{$uploadfilename}", 0755);
	copy("./wardrivingmap/wireless.dbl", "./wardrivingmap/backups/db/wireless.dbl.$current_time");
	copy("./wardrivingmap/todo/{$uploadfilename}", "./wardrivingmap/backups/netxml/{$uploadfilename}.{$current_time}");
	rename("./wardrivingmap/output.kml", "./wardrivingmap/backups/kml/output.kml.{$current_time}");

	#Launch Kismet for global
	@shell_exec("cd ./wardrivingmap/ && giskismet -x ./todo/{$uploadfilename} > giskismet_output.txt");
	@shell_exec("cd ./wardrivingmap/ && php notify.php 1");
	@shell_exec("cd ./wardrivingmap/ && giskismet -q \"select * from wireless\" -o output.kml");
	unlink("./wardrivingmap/giskismet_output.txt");

	#Launch Kismet for local
	// ToDo: Rewrite with RegEx
	$time = str_replace('Kismet-', '', $uploadfilename);
	$time = substr($time, 0, strpos($time, "-"));
	$year = substr($time, 0, 4);
	$month = substr($time, 4, 2);
	$day = substr($time, 6, 2);
	$var_date = $day . "." . $month . "." . $year;
	if (is_dir("./wardrivingmap/kml/" . $var_date)) {
		// Heute wurde schon geparst
		unlink("./wardrivingmap/kml/" . $var_date . "/output.kml");
	} else {
		//erstes Parsen an dem Tag
		mkdir("./wardrivingmap/kml/" . $var_date);
		file_put_contents("./wardrivingmap/kml/" . $var_date . "/index.php", "");
		file_put_contents("./wardrivingmap/kml/" . $var_date . "/info", "");
	}
	@shell_exec("cd ./wardrivingmap/kml/{$var_date}/ && giskismet -x .../../todo/{$uploadfilename}");
	@shell_exec("cd ./wardrivingmap/kml/{$var_date}/ && giskismet -q \"select * from wireless\" -o output.kml");

	// delete processed file
	unlink("./wardrivingmap/todo/" . $uploadfilename);
	die();
}
