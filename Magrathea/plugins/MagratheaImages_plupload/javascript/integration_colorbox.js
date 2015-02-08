function openImage(imageurl){
	$.colorbox({href:imageurl});
}

function openGallery(hidden_field, resultDiv){
	var page = "plugins/MagratheaImages_plupload/Control/image_gallery_select.php";
	$.colorbox({href: page});
	callback_selectImage = function(image_id){
		var getImagePage = "plugins/MagratheaImages_plupload/Control/showImageThumb.php?image_id="+image_id;
		$('#'+hidden_field).val(image_id);
		$.ajax(getImagePage).done(
			function (data){
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