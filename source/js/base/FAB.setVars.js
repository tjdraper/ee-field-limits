(function(F) {
	'use strict';

	// Define FAB vars functions
	var runVars = function() {
		// Set data-set variables
		$('[data-set]').each(function() {
			var $el = $(this),
				key = $el.data('set'),
				val = $el.data('value'),
				arrayObjTest = key.slice(-2),
				arrayObjKey = key.slice(0, -2);

			if (arrayObjTest === '[]') {
				if (! F.vars[arrayObjKey]) {
					F.vars[arrayObjKey] = [];
				}

				F.vars[arrayObjKey].push(val);
			} else if (arrayObjTest === '{}') {
				val = val.split(':');

				if (! F.vars[arrayObjKey]) {
					F.vars[arrayObjKey] = {};
				}

				F.vars[arrayObjKey][val[0]] = val[1];
			} else {
				F.vars[key] = val;
			}
		});

		/**
		 * Method for setting F vars
		 *
		 * @param {string} varName - Name of the variable to set
		 * @param {*} value - Value to set for this global var
		 */
		F.$set = function(varName, value) {
			F.vars[varName] = value;
		};

		/**
		 * Method for getting F vars
		 *
		 * @param {string} getVar - Name of variable to get
		 * @param {*} [defaultVal] - Default value to return if no var
		 * @return {*} - Variable value, default value, or null
		 */
		F.$get = function(getVar, defaultVal) {
			if (
				F.vars[getVar] !== null &&
				F.vars[getVar] !== undefined
			) {
				return F.vars[getVar];
			}

			return defaultVal || null;
		};

		// Set run variables from DOM
		$('[data-exec]').each(function() {
			var name = $(this).data('exec');

			if (name && F.exec.indexOf(name) === -1) {
				F.exec.push(name);
			}
		});
	};

	// Run setVars when DOM ready
	$(function() {
		runVars();
	});
})(window.FAB);