(function($){
	var setting = {};
	var methods = {
		init: function(options){
			setting.offset = options.offset;
			return this.each(function(){
				var el = this;
				methods.resize(el);
	         	$(window).bind('resize.fullHeight', function(){
	         		methods.resize(el);
	         	});
	       	});
		},
		resize: function(el){
			var winHeight = parseInt($(window).height())-setting.offset;
			var parrallaxHeight = parseInt($(el).height());
			if(winHeight > parrallaxHeight){
				$(el).height(winHeight+'px');
			}
		}
	}

	$.fn.fullHeight = function(method){
		if ( methods[method] ) {
	      	return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
	    } else if ( typeof method === 'object' || ! method ) {
	      	return methods.init.apply( this, arguments );
	    } 
	}
})(jQuery);