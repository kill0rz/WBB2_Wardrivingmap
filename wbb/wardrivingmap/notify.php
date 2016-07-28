<?php

if (!isset($argv[1]) || trim($argv[1]) != "1") {
	die("nein.\n");
}

require '../acp/lib/config.inc.php';
require '../acp/lib/class_db_mysql.php';
require '../acp/lib/class_parse.php';
require '../acp/lib/class_parsecode.php';
require '../acp/lib/options.inc.php';
require 'wdm_config.php';
$phpversion = phpversion();
$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);

function getgentime() {

}

// -------

$filenameofinread = "./giskismet_output.txt";
$newcount = 0;

if (!file_exists($filenameofinread) || !$wdm_use_shoutbox) {
	die();
}

$output = file($filenameofinread);

foreach ($output as $line) {
	if (str_replace("AP added", "", $line) != $line) {
		$newcount++;
	}
}

unlink($filenameofinread);

if ($newcount > 0) {
	$message = "Die Wardriving-Map wurde aktualisiert. Es wurden [b]" . $newcount . "[/b] neue Access Points hinzugefügt.";
	$result = $db->query("INSERT INTO bb" . $n . "_xy_shoutbox SET `name`='WLAN-Map',`comment`='" . addslashes($message) . "',`date`='" . time() . "'");
}
