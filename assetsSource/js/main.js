// Make sure FAB is defined
window.FABNAMESPACE = window.FABNAMESPACE || 'FAB';
window[window.FABNAMESPACE] = window.window[window.FABNAMESPACE] || {};

function runMain(F) {
	'use strict';

	// Make sure dependencies are loaded
	if (! F.fieldLimitsDependenciesReady()) {
		setTimeout(function() {
			runMain(F);
		}, 10);
		return;
	}

	var fields = [
		'field_limits',
		'field_limits_number',
		'field_limits_textarea'
	];

	// Stop number scroll wheel
	$('body').on('mousewheel', ':input[type=number]', function() {
		this.blur();
	});

	$('.js-field-limits-limited').each(function() {
		var $el = $(this);

		$el.data('field-limits-limit-set', true);

		F.controller.construct('FieldCharLimit', {
			el: this
		});
	});

	fields.forEach(function(i) {
		window.Grid.bind(i, 'display', function($cell) {
			$cell.find('.js-field-limits-limited').each(function() {
				var $el = $(this);

				if ($el.data('fieldLimitsLimitSet')) {
					return;
				}

				$el.data('fieldLimitsLimitSet', true);

				F.controller.construct('FieldCharLimit', {
					el: this
				});
			});
		});
	});
}

// Run main
runMain(window[window.FABNAMESPACE]);
