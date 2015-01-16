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

	// changed by PV for ajax config
	$(document).on("click", "header .arrow", function(e){
		e.preventDefault();
		$(this).parents(".mag_section").find("content").slideToggle("fast",function(){ });   
	});
	$(document).on("mouseenter mouseleave", "header.hide_opt", function(){ $(this).find(".toggle").fadeToggle("fast"); });
	

});

$(window).load(function() {  
  $("#loader").fadeOut();
});

