
function WriteData()
	{
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotfswrite, fail);
	}

function ReadData()
	{
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotfsread, fail);
	}
function gotfswrite(fileSystem) 
	{
	fileSystem.root.getFile("mytaxi/locdata.txt", {create: true, exclusive: false}, gotFileEntry, fail);
	}

function gotfsread(fileSystem)
	{
	fileSystem.root.getFile("mytaxi/locdata.txt", null, gotFileEntry2, fail2);
	}

function gotFileEntry(fileEntry) 
	{
	fileEntry.createWriter(gotFileWriter, fail);
	}

function gotFileWriter(writer) 
	{
	writer.write(MyUser+";"+MyPass+";"+MyZoom+";"+wlon+";"+wlat);

	}

function fail(error)
	{
	alert("error: "+error.code);
	}



function gotFileEntry2(fileEntry) 
	{
	fileEntry.file(gotFile, fail);
	}

function gotFile(file)
	{
	readAsText(file);
	}

function readAsText(file) 
	{
	var reader = new FileReader();
	reader.onloadend = function(evt) 
		{
		var myData =evt.target.result;
		a=myData.split(";");
		MyUser=a[0];
		MyPass=a[1];
		MyZoom=Math.floor(a[2]);
		if (a.length>3)
			{
			wlon=a[3];
			wlat=a[4];
			setmypos();
			}

		document.getElementById("myname").value=MyUser;
		document.getElementById("mypass").value=MyPass;
		};
	reader.readAsText(file);
	}

function fail2(evt) 
	{
	alert(evt.target.error.code);
	}

function checkIfFileExists(path)
	{
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/1", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/2", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/3", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/4", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/5", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/6", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/7", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/8", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/9", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/10", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getDirectory("mytaxi/maps/dummy.html", {create: true, exclusive: false}, fileExists, fileDoesNotExist); } , getFSFail); 
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getFile("mytaxi/"+path, { create: false }, fileExists, fileDoesNotExist);}, getFSFail); 
	}


function checktile(fileName)
	{
	console.log("checking file: "+fileName);
	fileName="file:///storage/emulated/0/mytaxi/maps/"+fileName;
    var http = new XMLHttpRequest();
    http.open('HEAD', fileName, false);
    http.send(null);
	console.log("file: "+fileName+" status: "+http.status );
    return (http.status != 404);
	}

function checktile2(path)
	{
	var reader = new FileReader();
	reader.onloadend = function(evt) 
		{
		if(evt.target.result == null) 
			{
			tilef=0;
			return false;
		   // If you receive a null value the file doesn't exists
			} 
		else 
			{
			tilef=1;
			return true;
	// Otherwise the file exists
			}         
		};

	reader.readAsDataURL("mytaxi/maps/"+path); 
	}

function checktile3(path)
	{

    window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getFile("mytaxi/maps/"+path, { create: false }, tilefound, notile);}, getFSFail); 
//	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fileSystem){fileSystem.root.getFile("mytaxi/maps/"+path, { create: false }, function(){console.log("loading image: "+path); document.getElementById("img_"+i+"-"+ii).src="file:///storage/emulated/0/mytaxi/maps/"+path;}, function(){console.log("downloading tile: "+smap+"/"+szoom+"_"+A+"_"+B+" : "+i+" | "+ii);downtile(smap, szoom, A, B, i, ii,1);});}, getFSFail); 

	}

function tilefound(fileEntry)
	{
	tilef=1;
	check_complete=1;
	}
function notile()
	{
	tilef=0;
	check_complete=1;
	}

function fileExists(fileEntry)
	{
    dataex=1;
	}
function fileDoesNotExist()
	{
    dataex=0;
	}
function getFSFail(evt)
	{
    console.log("shit error");
	}



