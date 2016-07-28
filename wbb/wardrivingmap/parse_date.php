<?php

$filename = $argv[1];

if (is_file($argv[1])) {
	$time = str_replace('./todo/Kismet-', '', $argv[1]);
	$time = substr($time, 0, strpos($time, "-"));
	$year = substr($time, 0, 4);
	$month = substr($time, 4, 2);
	$day = substr($time, 6, 2);
	$date = $day . "." . $month . "." . $year;
	if (is_dir("./kml/" . $date)) {
		// Heute wurde schon geparst
		unlink("./kml/" . $date . "/output.kml");
	} else {
		//erstes Parsen an dem Tag
		mkdir("./kml/" . $date);
		file_put_contents("./kml/" . $date . "/index.php", "");
		file_put_contents("./kml/" . $date . "/info", "");
	}
}

echo $date;
