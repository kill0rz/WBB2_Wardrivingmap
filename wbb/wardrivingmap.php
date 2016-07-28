<?php

// require './acp/lib/class_parse.php';
// require './acp/lib/class_parsecode.php';
// require './acp/lib/options.inc.php';
require './global.php';
require './wardrivingmap/wdm_config.php';

$map_upload = '';
$successmessage = '';
$linkscollection = "<table border='1'><tr><th>Datum</th><th>Info</th></tr>";

#netxml - fuer alle freigeben
if ($wbbuserdata['userid'] == "1") {
	eval("\$map_upload .= \"" . $tpl->get("wardrivingmap_upload") . "\";");
	# todo: check for valid file name

	if (isset($_FILES['newmap_netxml']) && $_FILES['newmap_netxml']['size'] > 0) {
		move_uploaded_file($_FILES['newmap_netxml']['tmp_name'], "./wardrivingmap/todo/" . str_replace(".netxml", "", $_FILES['newmap_netxml']['name']) . ".netxml");
		move_uploaded_file($_FILES['newmap_netxml']['tmp_name'], "./wardrivingmap/todo/" . $uploadfilename);
		mail($wdm_mailto, "Neue NETXML von " . $wbbuserdata['username'] . " hochgeladen", "");
		$pid = pcntl_fork();
		if ($pid == -1) {
			die('Konnte nicht verzweigen');
		} elseif ($pid) {
			// Wir sind der Vater
			eval("\$successmessage .= \"" . $tpl->get("wardrivingmap_upload_success") . "\";");
		} else {
			// Wir sind das Kind
			//
			// fangen wir an, zu rendern

			//Backups
			$current_time = time();
			chmod("./wardrivingmap/todo/{$uploadfilename}", 0755);
			copy("./wardrivingmap/wireless.dbl", "./wardrivingmap/backups/db/wireless.dbl.$current_time");
			copy("./wardrivingmap/todo/{$uploadfilename}", "./wardrivingmap/backups/netxml/{$uploadfilename}.{$current_time}");
			rename("./wardrivingmap/output.kml", "./wardrivingmap/backups/kml/output.kml.{$current_time}");

			#Launch Kismet for global
			@shell_exec("cd ./wardrivingmap/ && giskismet -x ./todo/$1 > giskismet_output.txt");
			@shell_exec("cd ./wardrivingmap/ && php notify.php 1");
			@shell_exec("cd ./wardrivingmap/ && giskismet -q \"select * from wireless\" -o output.kml");
			unlink("./wardrivingmap/giskismet_output.txt");

			#Launch Kismet for local
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
	}
}

#einzelmaps
#karte anzeigen
$showkarte = false;

if (isset($_GET['map']) && is_dir("./wardrivingmap/kml/" . trim($_GET['map']) . "/")) {
	//valid map requested
	$showkarte = true;
	$link_to_map = $url2board . "/wardrivingmap/kml/" . trim($_GET['map']) . "/output.kml";
}

if ($showkarte) {
	$showmap = "<div id='map' style='width: 100%; height: 500px;'></div>";
} else {
	$showmap = '';
}

#linksammlung
$allmaps = scandir("./wardrivingmap/kml/");
foreach ($allmaps as $map) {
	if (is_dir("./wardrivingmap/kml/" . $map) && $map != '.' && $map != '..') {
		$linkscollection .= "<tr><td><a href='./wardrivingmap.php?map={$map}'>{$map}</a></td>";
		if (file_exists("./wardrivingmap/kml/" . $map . "/info")) {
			$linkscollection .= "<td>" . file_get_contents("./wardrivingmap/kml/" . $map . "/info") . "</td>";
		}
		$linkscollection .= "</tr>\n";
	}
}
$linkscollection .= "</table>";
eval("\$tpl->output(\"" . $tpl->get("wardrivingmap") . "\");");
