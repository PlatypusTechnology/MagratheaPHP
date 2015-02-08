jQuery(function($) {
	
	// menu functions:
	$(document).on( "click", ".submenu > a", function(){
		var parent = $(this).parent("li");
		var slideArea = $(parent).find("ul:first");
		if( $(slideArea).is(":visible")){
			$(slideArea).slideUp("easeInQuart");
		} else {
			$(slideArea).slideDown("easeOutQuart");
		}
	});
});

(function(jQuery){
  jQuery( document ).ready( function() {
    prettyPrint();
  }); 
}(jQuery))
