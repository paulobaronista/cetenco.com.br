(function($){
	$.fn.menu = function(action, options) {
		var defaults = {
			cHeight: 25,
			oHeight: 130,
			duration: 600,
			easing: 'easeOutBounce'
		};

		var options = $.extend(defaults, options);

		if (action == 'open') {
			return this.each(function() {
				obj = $(this);
				obj.stop().animate({height: options.oHeight+'px'},{queue:false, duration: options.duration, easing: options.easing});
			});
		} else if (action == 'close'){
			return this.each(function() {
				obj = $(this);
				obj.stop().animate({height:options.cHeight+'px'},{queue:false, duration: options.duration, easing: options.easing});
			});
		}
	}
})(jQuery);