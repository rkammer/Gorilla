// Avoid jQuery conflict
var $j = jQuery.noConflict();

$j(document).ready(function() {
	
	var _getParams = function() {
		return JSON.parse($j("#dropzone-params").val());
	}
	
	var _setParams = function(params) {
		$j("#dropzone-params").val(JSON.stringify(params));
	}
	
	var _getFileList = function() {
		var params = _getParams();

		var jsonText = $j(params.fileListSelector).val();
		if (typeof jsonText === "undefined" || jsonText == '') {
			jsonText = '{"files": []}';
		}
		
		return JSON.parse(jsonText);
	}
	
	var _setFileList = function(newSetOfFileList) {
		var params = _getParams();		
		$j(params.fileListSelector).val(JSON.stringify(newSetOfFileList))
	}	

	var _fileStruct = function (originalName, clientName,size,serverName) {
		this.originalName = originalName;
		this.clientName   = clientName;
		this.size         = size;
		this.serverName   = serverName;
	}

	var _getUniqueClientFileName = function (fileName) {
		var randomNumber = Math.floor((Math.random() * 9999) + 1);
		return fileName.concat(randomNumber.toString());
	}	
	
	var _createFileData = function(file) {
		var clientFileName = _getUniqueClientFileName(file.name);
		var fileRegistered = new _fileStruct(file.name, clientFileName, file.upload.total, '');
		return fileRegistered;
	}
	
	var _addFileList = function(fileData) {
		var files = _getFileList();
		files.files.push(fileData);
		_setFileList(files);
	}
	
	var _getIndexByClientName = function(clientName) {
		var files = _getFileList();
		
		for (index = 0; index < files.files.length; ++index) {
			if (files.files[index].clientName == clientName) {
				return index;
			}
		}
		return -1;
	}
	
	var _getIndexByServerName = function(name) {
		var files = _getFileList();
		
		for (index = 0; index < files.files.length; ++index) {
			if (files.files[index].serverName == name) {
				return index;
			}
		}
		return -1;
	}	
	
	var _removeFromFileListByIndex = function(index) {
		var files = _getFileList();
		files.files.splice(index,1);
		_setFileList(files);
	}
	
	var $params = _getParams();
	
	var $myDropzone = new Dropzone("div#dropzone-div", {
		url: $params.addFileUrl,
		paramName: "file", 
		maxFilesize: $params.maxFilesize,
		clickable: true, 
		uploadMultiple: $params.uploadMultiple,
		maxFiles: $params.maxFiles,
		addRemoveLinks: true, 
		autoProcessQueue: true 
	}); 

	$myDropzone.on("maxfilesexceeded", function(file) { 
		this.removeFile(file); 
	});
	
	$myDropzone.on("sending", function(file, xhr, formData) {
		var params = _getParams();
		
	    var fileData = _createFileData(file);	
	    _addFileList(fileData);	
	   
		// Will send the token along with the file as POST data. 
		formData.append("clientname", fileData.clientName);
		formData.append(params.token, "1");
	});
	
	$myDropzone.on("addedfile", function(file) { 
	});
	
	$myDropzone.on("error", function(file, msg) { 
		// Nothing to do. 
		// Dropzone show progress bar in red and 
		// on mouse over user can see error message. 
	});
	
	$myDropzone.on("canceled", function(file) { 
		var serverName = $j(file.previewTemplate).children('.dropzone-servername').val();
		var index = _getIndexByServerName(serverName);
		_removeFromFileListByIndex(index);		
	});	

	$myDropzone.on("success", function(file, responseText) {
		var response = JSON.parse(responseText);
		var files = _getFileList();
		files.files[_getIndexByClientName(response.clientName)].serverName = response.serverName;
		_setFileList(files);
		
		$j(file.previewTemplate).append('<input type="hidden" class="dropzone-servername" value="'+response.serverName+'" />');
	});
	
	$myDropzone.on("removedfile", function(file) {
		var serverName = $j(file.previewTemplate).children('.dropzone-servername').val();
		var files = _getFileList();
		var index = _getIndexByServerName(serverName);
		_removeFromFileListByIndex(index);
		
		var params = _getParams();
		
		var postData = '"servername": "' + serverName + '", "' + params.token + '": "1"';
		var plainObject = JSON.parse("{"+postData+"}");

		$j.post(params.cancelFileUrl, plainObject)
			.done(function( data ) {
			})
		 	.fail(function( data ) {
			})
			.always(function() {
			});
		
	});	

}); 