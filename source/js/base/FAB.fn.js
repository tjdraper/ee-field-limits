(function(F) {
	'use strict';

	// Define FAB controller functions
	F.fn = {
		made: {},
		constructors: [],

		/**
		 * Make a controller
		 *
		 * @param {string} fnName - Name of the controller
		 * @param {object} methods - Properties and methods of controller
		 */
		make: function(fnName, methods) {
			// Push into the constructors array if a constructor exists
			if (methods._construct) {
				F.fn.constructors.push(fnName);
			}

			// Create a copy for cloning
			F.fn.made[fnName] = $.extend(true, {}, methods);

			// Create the controller
			F[fnName] = methods;
		},

		/**
		 * Clone method for creating unique controller instances
		 *
		 * @param {string} fnName - Name of controller to clone
		 * @param {bool} [construct] - Whether to run the cloned constructor
		 * @return {object} - Controller
		 */
		clone: function(fnName, construct) {
			// Create a copy of the controller
			var fn = $.extend(true, {}, F.fn.made[fnName]);

			// If construct is true, run the constructor
			if (construct) {
				fn._construct();
			}

			// Return the clone
			return fn;
		}
	};
})(window.FAB);