(function(F) {
	'use strict';

	F.fn.make('stopNumberScroll', {
		init: function() {
			$('form').on('mousewheel', ':input[type=number]', function() {
				this.blur();
			});
		}
	});
})(window.FAB);
