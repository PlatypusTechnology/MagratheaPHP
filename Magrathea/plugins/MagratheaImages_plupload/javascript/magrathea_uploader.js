function magrathea_showGallery(div_result, callback){
	var page = "plugins/MagratheaImages_plupload/Control/image_gallery.php";
	$.ajax({
		url: page,
		success: function (data){
			$(div_result).html(data);
			if( callback != null )
				callback.call();
		}
	});
}

function magrathea_showUploader(div_result, callback){
	var page = "plugins/MagratheaImages_plupload/Control/image_uploader.php";
	$.ajax({
		url: page,
		success: function (data){
			$(div_result).html(data);
			startUploader("#file_uploader");
			if( callback != null )
				callback.call();
		}
	});
}


function startUploader(div){
	console.info("starting upload");
	$(div).pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : 'plugins/MagratheaImages_plupload/Control/upload_image.php',
		max_file_size : '10mb',
		unique_names : true,
		filters : [
			{title : "Image files", extensions : "jpg,gif,png,jpeg"},
			{title : "Zip files", extensions : "zip"}
		]
		
		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90},
	});

}