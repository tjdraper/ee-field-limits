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

class FieldSettings
{
	/**
	 * Get settings
	 *
	 * @param array $fieldSettings Setting data
	 * @param array $defaultFieldSettings
	 * @return array
	 */
	public function get($fieldSettings, $defaultFieldSettings)
	{
		$intValueKeys = array(
			'rows',
			'max_length',
			'min',
			'max',
			'step'
		);

		$keys = array_keys($defaultFieldSettings);

		foreach ($fieldSettings as $key => $val) {
			if (in_array($key, $keys)) {
				if (in_array($key, $intValueKeys)) {
					$val = (int) $val;
				}

				$defaultFieldSettings[$key] = $val;
			}
		}

		return $defaultFieldSettings;
	}
}