$(document).ready(function(){
	$(".MagratheaImagesDrop").html('<form action="/plugins/MagratheaImages/Control/upload_image.php" class="dropzone"><div class="fallback"><input name="file" type="file" multiple /></div></form>');
});

function addDropzone(element){
	var mag_dropzone = new Dropzone(element, { 
		url: "/plugins/MagratheaImages/Control/upload_image.php" 
	});
	return mag_dropzone;
}