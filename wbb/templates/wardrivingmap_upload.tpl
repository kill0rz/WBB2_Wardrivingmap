NETXML-Datei hochladen:
<form action="" method="post" enctype="multipart/form-data">
	<input name="newmap_netxml" id="newmap_netxml" type="file" size="50" maxlength="100000" onchange="uploadnetxml_fileChange();">
	<progress style='visibility:hidden;' id="progress" style="margin-top:10px"></progress>
	<span style='visibility:hidden;' id="prozent"></span>
	<br />
	<input type="submit" onclick="uploadnetxml();" />
</form>
