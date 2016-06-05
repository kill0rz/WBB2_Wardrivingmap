<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
  <title>$master_board_name | Wardrivingmap</title>
  $headinclude
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-15" />
  <meta name="robots" content="noindex, nofollow" />
  <link rel="stylesheet" media="screen" type="text/css" href="template/layout.css" />
  <script src='https://maps.google.com/maps?file=api&amp;v=2&amp;key=YOURAPIKEY'></script>
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
      var geoXml = new GGeoXml("$link_to_map");
      map.addOverlay(geoXml);
    }
  }
  /* ]]> */
  </script>
</head>

<body onload="initialize()" onunload="GUnload()">
  $header
  <div id="body"></div>
  <table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
    <tr>
      <td class="tablea">
        <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
          <tr class="tablea_fc">
            <td align="left">
              <span class="smallfont">
                <b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; Wardrivingmap</b>
              </span>
            </td>
            <td align="right">
              <span class="smallfont">
                <b>$usercbar</b>
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <br />
    <tr>
      <td align="left">
        <table cellpadding="4" cellspacing="1" border="0" style="width:100%" class="tableinborder">
          <tr>
            <td align="left" colspan="4" nowrap="nowrap" class="tabletitle">
              <span class="normalfont">
                <b></b>
              </span>
            </td>
          </tr>
          <tr align="left">
            <td colspan="2" class="tablea" align="center">
              <span class="smallfont">
                <!-- <div id="body"></div> -->Alle Fahrten als Download zum &Ouml;ffnen in Google Earth: <a href="./wardrivingmap/output.kml">&rarr; DOWNLOAD &larr;</a>
                <br />
                <br /> $map_upload $successmessage
                <if($link_to_map !='' )>
                  <then>Lade die aktuelle Map herunter: <a href="$link_to_map">DOWNLOAD</a></then>
                  </if>
                  $showmap $linkscollection
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  $footer
