$(document).bind('pageinit',function(){
	alert(111);
	// Slide Fade Effect
	$.fn.slideFadeToggle  = function(speed, easing, callback) {
		return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
	};
	
	if ($(".J-menu").length > 0) {
		$(".J-menu").on('tap',function(event){
			//toggle menu
			$(".menu").slideFadeToggle();
			//$(this).find(".menu-icon").toggleClass("on");
		});
	}
});