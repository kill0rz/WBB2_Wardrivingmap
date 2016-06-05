<?php

$filename = $argv[1];

if (is_file($argv[1])) {
	$time = str_replace('./todo/Kismet-', '', $argv[1]);
	$time = substr($time, 0, strpos($time, "-"));
	$year = substr($time, 0, 4);
	$month = substr($time, 4, 2);
	$day = substr($time, 6, 2);
	$date = $day . "." . $month . "." . $year;
	echo $date;
}