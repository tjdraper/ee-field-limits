// Make sure FAB is defined
window.FABNAMESPACE = window.FABNAMESPACE || 'FAB';
window[window.FABNAMESPACE] = window.window[window.FABNAMESPACE] || {};

window[window.FABNAMESPACE].fieldLimitsDependenciesReady = function() {
	'use strict';

	var F = window[window.FABNAMESPACE];

	return window.Grid !== undefined &&
		window.$ !== undefined &&
		F.controller !== undefined &&
		F.model !== undefined;
};
