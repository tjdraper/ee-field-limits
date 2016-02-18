/* global jQuery, Grid */

(function(F) {
	'use strict';

	F.fn.make('fieldCharLimit', {
		init: function() {
			var scope = this,
				$fieldTypeNames = F.$get('fieldTypeNames');

			$('.js-field-limits-limited').each(function() {
				scope.setLimits($(this));
			});

			if ($fieldTypeNames) {
				$fieldTypeNames = jQuery.unique($fieldTypeNames);

				$fieldTypeNames.forEach(function(i) {
					// Bind field initialization on Grid
					Grid.bind(i, 'display', function($cell) {
						$cell.find('.js-field-limits-limited').each(function() {
							scope.setLimits($(this));
						});

						scope.setGridRequired($cell);
					});
				});
			}
		},
		setLimits: function($el) {
			if ($el.data('limits-set')) {
				return;
			}

			var $input = $el.children('.js-field-limits-input'),
				$countWrapper = $el.children('.js-field-limits-count-wrap'),
				$counter = $countWrapper.children('.js-field-limits-count'),
				limit = $el.data('limit'),
				warningLevel = limit * 0.65;

			$input.on('keyup', function() {
				if ($input.val().length > limit) {
					$input.val($input.val().substr(0, limit));
				}

				$counter.text($input.val().length);

				if ($input.val().length >= warningLevel) {
					$countWrapper.addClass('field-limits-count--warning');
				} else {
					$countWrapper.removeClass('field-limits-count--warning');
				}

				if ($input.val().length >= limit) {
					$countWrapper.addClass('field-limits-count--limit-reached');
				} else {
					$countWrapper.removeClass('field-limits-count--limit-reached');
				}
			});

			$el.data('limits-set', true);
		},
		setGridRequired: function($cell) {
			var $input = $cell.find('.js-field-limits-input');

			if ($input.data('grid-required')) {
				$input.attr('required', true);
			}
		}
	});
})(window.FAB);
