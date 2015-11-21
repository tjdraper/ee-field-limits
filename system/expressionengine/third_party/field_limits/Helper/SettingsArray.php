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

class SettingsArray
{
	/**
	 * Add assets to CP
	 *
	 * @param array $data Setting data
	 * @param string $prefix
	 *
	 * @return array
	 */
	public function get($data, $prefix)
	{
		$saveData = array();

		$prefix .= '_';

		$offset = strlen($prefix);

		foreach ($data as $saveKey => $save) {
			if (strncmp($prefix, $saveKey, $offset) === 0) {
				$saveData[substr($saveKey, $offset)] = $save;
			}
		}

		return $saveData;
	}
}