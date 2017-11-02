// Make sure FAB is defined
window.FABNAMESPACE = window.FABNAMESPACE || 'FAB';
window[window.FABNAMESPACE] = window.window[window.FABNAMESPACE] || {};

function runFieldCharLimit(F) {
	'use strict';

	// Make sure dependencies are loaded
	if (! F.fieldLimitsDependenciesReady()) {
		setTimeout(function() {
			runFieldCharLimit(F);
		}, 10);
		return;
	}

	F.controller.make('FieldCharLimit', {
		$input: $(),
		$countWrapper: $(),
		$counter: $(),
		limit: 0,
		warningLevel: 0,
		init: function() {
			var self = this;
			var $el = self.$el;

			self.$input = $el.children('.js-field-limits-input');
			self.$countWrapper = $el.children('.js-field-limits-count-wrap');
			self.$counter = self.$countWrapper.children('.js-field-limits-count');
			self.limit = $el.data('limit');
			self.warningLevel = self.limit * 0.65;

			self.runCheck();

			self.$input.on('keyup change', function() {
				self.runCheck();
			});
		},
		runCheck: function() {
			var self = this;
			var $input = self.$input;
			var limit = self.limit;
			var $counter = self.$counter;
			var warningLevel = self.warningLevel;
			var $countWrapper = self.$countWrapper;

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
		}
	});
}

runFieldCharLimit(window[window.FABNAMESPACE]);
