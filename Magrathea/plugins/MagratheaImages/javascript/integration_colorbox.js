function openImage(imageurl){
	console.info("loading: "+imageurl);
	$.colorbox({href:imageurl});
}

function openGallery(hidden_field, resultDiv){
	console.info("loading...");
	var page = magrathea_images_external_url+"/plugins/MagratheaImages/Control/image_gallery_select.php";
	$.colorbox({href: page, width: '700px', height: '500px'});
	callback_selectImage = function(image_id){
		var getImagePage = magrathea_images_external_url+"/plugins/MagratheaImages/Control/showImageThumb.php?image_id="+image_id;
		$('#'+hidden_field).val(image_id);
		$.ajax(getImagePage).done(
			function (data){
				console.info(data);
				$('#'+resultDiv).html(data);
			}
		);
	};
}

var callback_selectImage = null;
function selectImage(image_id){
	$.colorbox.close();
	if(callback_selectImage!==null){
		callback_selectImage(image_id);
	}
}