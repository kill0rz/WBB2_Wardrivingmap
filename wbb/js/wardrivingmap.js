'use strict';

function uploadnetxml_fileChange() {
	var fileList = document.getElementById("newmap_netxml").files;
	var file = fileList[0];
	if (!file) return;
	document.getElementById("progress").value = 0;
	document.getElementById("prozent").innerHTML = "0%";
	document.getElementById("progress").style.visibility = 'visible';
	document.getElementById("prozent").style.visibility = 'visible';
}


function uploadnetxml() {
	var file = document.getElementById("newmap_netxml").files[0];
	var formData = new FormData();
	var client = new XMLHttpRequest();
	var prog = document.getElementById("progress");

	if (!file) return;
	prog.value = 0;
	prog.max = 100;

	formData.append("datei", file);

	client.onload = function() {
		document.getElementById("prozent").innerHTML = "100%";
		prog.value = prog.max;
	};

	client.upload.onprogress = function(e) {
		var p = Math.round(100 / e.total * e.loaded);
		document.getElementById("progress").value = p;
		document.getElementById("prozent").innerHTML = p + "%";
	};

	client.open("POST", "picupload.php");
	client.send(formData);
}
