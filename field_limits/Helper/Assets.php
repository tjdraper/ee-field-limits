<?php

/**
 * Field Limits field type
 *
 * @package field_limits
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://github.com/tjdraper/ee-field-limits
 * @copyright Copyright (c) 2015, BuzzingPixel, LLC
 */

namespace FieldLimits\Helper;

/**
 * Class Assets
 */
class Assets
{
	/**
	 * Add assets to CP
	 */
	public function add()
	{
		// Check if we've already added the assets
		if (ee()->session->cache('fieldLimits', 'assetsLoaded')) {
			return;
		}

		// Some vars we're going to need
		$pathThirdThemes = PATH_THIRD_THEMES;
		$urlThirdThemes = URL_THIRD_THEMES;

		// Set default cache busting values
		$cssFileTime = $jsFileTime = uniqid('', false);


		/**
		 * Add CSS
		 */

		// Set the path to the CSS
		$cssPath = "{$pathThirdThemes}field_limits/css/style.min.css";

		// If the css file exists, get the file time as the cache busting value
		if (is_file($cssPath)) {
			$cssFileTime = filemtime($cssPath);
		}

		// Build the URL to the css
		$css = "{$urlThirdThemes}field_limits/css/style.min.css";

		// Create the CSS tag
		$cssTag = "<link rel=\"stylesheet\" href=\"{$css}?v={$cssFileTime}\">";

		// Add the CSS tag
		ee()->cp->add_to_head($cssTag);


		/**
		 * Add CSS
		 */

		// Set the path the the javascript
		$jsPath = "{$pathThirdThemes}field_limits/js/script.min.js";

		// If the js file exists, get the file time as the cache busting value
		if (is_file($jsPath)) {
			$jsFileTime = filemtime($jsPath);
		}

		// Build the URL to the js
		$js = "{$urlThirdThemes}field_limits/js/script.min.js";

		// Create the JS tag
		$jsTag = "<script type=\"text/javascript\" src=\"{$js}?v={$jsFileTime}\"></script>";

		// Add the JS tag
		ee()->cp->add_to_foot($jsTag);


		/**
		 * Save a cache that we have added the assets
		 */

		ee()->session->set_cache(
			'fieldLimits',
			'assetsLoaded',
			true
		);
	}
}
