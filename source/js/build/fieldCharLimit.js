/* global Grid */

(function(F) {
	'use strict';

	F.fn.make('fieldCharLimit', {
		init: function() {
			var scope = this;

			$('.js-field-limits-limited').each(function() {
				scope.setLimits($(this));
			});

			// Bind field initialization on Grid
			Grid.bind('field_limits', 'display', function($cell) {
				$cell.find('.js-field-limits-limited').each(function() {
					scope.setLimits($(this));
				});
			});
		},
		setLimits: function($el) {
			var $input = $el.children('.js-field-limits-input'),
				$countWrapper = $el.children('.js-field-limits-count-wrap'),
				$counter = $countWrapper.children('.js-field-limits-count'),
				limit = $el.data('limit'),
				warningLevel = limit * 0.7;

			$input.on('keyup', function() {
				if ($input.val().length > limit) {
					$input.val($input.val().substr(0, limit));
				}

				$counter.text($input.val().length);

				if ($input.val().length >= warningLevel) {
					$countWrapper.addClass('--warning');
				} else {
					$countWrapper.removeClass('--warning');
				}

				if ($input.val().length >= limit) {
					$countWrapper.addClass('--limit-reached');
				} else {
					$countWrapper.removeClass('--limit-reached');
				}
			});
		}
	});
})(window.FAB);