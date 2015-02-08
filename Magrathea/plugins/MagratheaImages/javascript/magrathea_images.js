function magrathea_showGallery(div_result, callback){
	var page = magrathea_images_external_url+"/plugins/MagratheaImages/Control/image_gallery.php";
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
	var page = magrathea_images_external_url+"/plugins/MagratheaImages/Control/image_uploader.php";
	$.ajax({
		url: page,
		success: function (data){
			$(div_result).html(data);
			$(".dropzone").dropzone({ 
				url: magrathea_images_external_url+"/plugins/MagratheaImages/Control/upload_image.php" 
			});
			if( callback != null )
				callback.call();
		}
	});
}

function magratheaDeleteImage(image_id){
	if( confirm("Are you sure you want to delete this image? \n (what is done cannot be undone!)") ){
		var page = magrathea_images_external_url+"/plugins/MagratheaImages/Control/image_delete.php?id="+image_id;
		$.ajax({
			url: page,
			success: function(data){
				$("#magratheaImageTb_"+image_id).html("Image deleted");
			}
		});
	}
}

function magratheaLoadImagesSelect(){
	var page = $("#image_pageNumber").val();
	var button = $("#image_loadButton").html("Loading...").attr("readonly", "readonly");
	var urlCall = magrathea_images_external_url+"/plugins/MagratheaImages/Control/image_gallery_select_load.php?page="+page;
	$.ajax({
		url: urlCall,
		success: function (data){
			$("#image_gallery").append(data);
			$.colorbox.resize();
			var button = $("#image_loadButton").html("Load more!").removeAttr("readonly");
		}
	});
	page = parseInt(page) + 1;
	$("#image_pageNumber").val(page);
}

function magratheaLoadImages(){
	var page = $("#image_pageNumber").val();
	var button = $("#image_loadButton").html("Loading...").attr("readonly", "readonly");
	var urlCall = magrathea_images_external_url+"/plugins/MagratheaImages/Control/image_gallery_load.php?page="+page;
	$.ajax({
		url: urlCall,
		success: function (data){
			$("#image_gallery").append(data);
			var button = $("#image_loadButton").html("Load more!").removeAttr("readonly");
		}
	});
	page = parseInt(page) + 1;
	$("#image_pageNumber").val(page);
}

