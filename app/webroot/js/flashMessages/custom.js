(function($){
	$(document).ready(function() {
		var $flashElement = $('.flash-message');
		$flashElement.find('button.close').on('click',function() {
			$flashElement.removeClass('fadeInDown').addClass('fadeOutUp').slideUp('slow',function(){$flashElement.remove()});
			return false;
		});
		$flashElement.delay(8000).slideUp('slow',function(){$flashElement.remove()});
		return true;
	});
})(jQuery);