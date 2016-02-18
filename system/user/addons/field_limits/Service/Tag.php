<?php

/**
 * Field Limits field type
 *
 * @package field_limits
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://github.com/tjdraper/ee-field-limits
 * @copyright Copyright (c) 2015, BuzzingPixel, LLC
 */

namespace FieldLimits\Service;

class Tag
{
	/**
	 * Tag
	 *
	 * @param string $fieldData The channel_data table data
	 * @param array $tagParams
	 * @param array $settings
	 * @return string
	 */
	public function parse($fieldData, $tagParams, $settings)
	{
		$allowedTypographys = array(
			'all',
			'xhtml',
			'br',
			'lite'
		);

		$format = false;

		if (
			isset($tagParams['format']) and
			in_array($tagParams['format'], $allowedTypographys)
		) {
			$format = $tagParams['format'];
		} elseif (
			! isset($tagParams['format']) and
			isset($settings['format']) and
			in_array($settings['format'], $allowedTypographys)
		) {
			$format = $settings['format'];
		}

		if ($format) {
			ee()->load->library('typography');
			ee()->typography->initialize();

			$fieldData = ee()->typography->parse_type($fieldData, array(
				'text_format' => $format,
				'html_format' => 'all',
				'auto_links' => 'n',
				'allow_img_url' => 'y'
			));
		}

		return $fieldData;
	}
}