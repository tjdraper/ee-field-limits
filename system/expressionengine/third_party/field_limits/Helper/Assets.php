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

class Assets
{
	/**
	 * Add assets to CP
	 */
	public function add($pageType)
	{
		if (! ee()->session->cache('fieldLimits', 'assetsLoaded')) {
			ee()->cp->load_package_css('fieldLimits.min');
			ee()->cp->load_package_js('fieldLimits.min');

			ee()->javascript->output(
				'window.fieldLimits = window.fieldLimits || {};' .
				'fieldLimits.vars = fieldLimits.vars || {};' .
				'fieldLimits.lang = fieldLimits.lang || {};' .
				'fieldLimits.vars.pageType = "' . $pageType . '";'
			);

			ee()->session->set_cache(
				'fieldLimits',
				'assetsLoaded',
				true
			);
		}
	}
}