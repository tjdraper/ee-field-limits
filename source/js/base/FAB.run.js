(function(F) {
	'use strict';

	// Run F functions
	var runFAB = function() {
		// Make sure everything is ready
		if (! F.ready) {
			setTimeout(function() {
				runFAB();
			}, 100);

			return;
		}

		// Run constructors
		F.fn.constructors.forEach(function(fnName) {
			F.fn.clone(fnName)._construct();
		});

		// Run any init function requested by exec
		F.exec.forEach(function(i) {
			F[i].init();
		});

		// Run the controller
		if (F.controller) {
			// Check if an array for this pageType has been defined
			var pageTypeArray = F.controller[F.$get('pageType')];

			if (pageTypeArray) {
				pageTypeArray.forEach(function(fnName) {
					F.fn.clone(fnName).init();
				});
			}
		}
	};

	// Run initialization on DOM ready state
	$(function() {
		runFAB();
	});
})(window.FAB);