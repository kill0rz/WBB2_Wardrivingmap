<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
	<title>Vorschau</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15" />
	<meta name="robots" content="noindex, nofollow" />
	<link rel="stylesheet" media="screen" type="text/css" href="template/layout.css" />
	<script src="https://maps.google.com/maps?file=api&amp;v=2&amp;key=YOURAPIKEY" type="text/javascript"></script>
	<script type="text/javascript">
	/* <![CDATA[ */
	function initialize() {
		if (GBrowserIsCompatible()) {
			var map = new GMap2(document.getElementById("map"));
			var mapcenter = new GLatLng(LONG, LAT);
			map.setCenter(mapcenter, 14);
			map.addControl(new GSmallZoomControl());
			map.addMapType(G_PHYSICAL_MAP);
			map.removeMapType(G_HYBRID_MAP);
			map.addControl(new GMapTypeControl());
			map.setMapType(G_SATELLITE_MAP);
			var geoXml = new GGeoXml("https://forum/wbb2/wardrivingmap/tmp/<?php echo $_GET['timestamp']; ?>/output.kml");
			map.addOverlay(geoXml);
		}
	}
	/* ]]> */
	</script>
</head>

<body onload="initialize()" onunload="GUnload()">
	<div id="body"></div>
	<div id="map" style="width: 100%; height: 500px;"></div>
</body>
