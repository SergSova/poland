(function($){
	$.fn.myScrollBar = function(options){
		var el = this;
		var collection = this.find('li');
		$(window).scroll(function(){
			collection.each(function(){
				var offset = $(this).position().top + $(el).position().top + $(this).height()*2;
				var back = document.elementFromPoint(10, offset);
				var backBgColor = $(back).css('backgroundColor');
				if(backBgColor == options.color){
					$(this).addClass(options.class);
				}else{
					$(this).removeClass(options.class);
				}
			});
		});
	}
})(jQuery);