<?php

require './global.php';
require './acp/lib/class_parse.php';
require './acp/lib/class_parsecode.php';
require './acp/lib/options.inc.php';

$map_upload = '';
$successmessage = '';
$linkscollection = "<table border='0'><tr><th>Datum</th><th>Info</th></tr>";

#netxml - fuer alle freigeben
if ($wbbuserdata['userid'] == "1") {
	eval("\$map_upload .= \"" . $tpl->get("wardrivingmap_upload") . "\";");
	if (isset($_FILES['newmap_netxml']) && $_FILES['newmap_netxml']['size'] > 0) {
		move_uploaded_file($_FILES['newmap_netxml']['tmp_name'], "./wardrivingmap/todo/" . str_replace(".netxml", "", $_FILES['newmap_netxml']['name']) . ".netxml");
		mail("mail@example.com", "Neue NETXML von " . $wbbuserdata['username'] . " hochgeladen", "");
		eval("\$successmessage .= \"" . $tpl->get("wardrivingmap_upload_success") . "\";");
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
