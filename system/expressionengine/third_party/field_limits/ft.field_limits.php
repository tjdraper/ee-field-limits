<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include_once(PATH_THIRD . 'field_limits/addon.setup.php');

/**
 * Field Limits field type
 *
 * @package field_limits
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://github.com/tjdraper/ee-field-limits
 * @copyright Copyright (c) 2015, BuzzingPixel, LLC
 */

Class Field_limits_ft extends EE_Fieldtype
{
	// Set EE fieldtype info
	public $info = array(
		'name' => FIELD_LIMITS_NAME,
		'version' => FIELD_LIMITS_VER
	);

	public function __construct()
	{
		// Make sure Field Limits is really being requested
		if (
			ee()->uri->segment(1) === 'cp' &&
			in_array(FIELD_LIMITS_PATH, ee()->config->_config_paths)
		) {
			ee()->lang->loadfile('field_limits');
		}

		// Make sure the parent constructor runs
		parent::__construct();
	}

	/**
	 * Enable Blocks and Grid options
	 *
	 * @param string $name
	 * @return bool
	 */
	public function accepts_content_type($name)
	{
		return $name === 'channel' || $name === 'grid' || $name === 'blocks/1';
	}

	/**
	 * Add settings assets
	 */
	public function addSettingsAssets()
	{
		if (! ee()->session->cache('fieldLimits', 'settingsAssetsLoaded')) {
			ee()->cp->load_package_css('fieldLimits.min');
			ee()->cp->load_package_js('fieldLimits.min');

			ee()->javascript->output(
				'window.fieldLimits = window.fieldLimits || {};' .
				'fieldLimits.vars = fieldLimits.vars || {};' .
				'fieldLimits.lang = fieldLimits.lang || {};' .
				'fieldLimits.vars.pageType = "settings";'
			);

			ee()->session->set_cache(
				'fieldLimits',
				'settingsAssetsLoaded',
				true
			);
		}
	}

	/**
	 * Settings
	 *
	 * @param string $data Existing setting data
	 * @return array
	 */
	public function display_settings($data)
	{
		$this->addSettingsAssets();

		ee()->table->add_row(
			lang('field_limit_rows', 'field_limit_rows') .
				'<br>' .
				lang('field_limit_rows_explain'),
			form_input(array(
				'id' => 'field_limit_rows',
				'name' => 'field_limit_rows',
				'type' => 'number',
				'value' => ''
			))
		);

		ee()->table->add_row(
			lang('field_limit_max_length', 'field_limit_max_length'),
			form_input(array(
				'id' => 'field_limit_max_length',
				'name' => 'field_limit_max_length',
				'type' => 'number',
				'value' => ''
			))
		);

		ee()->table->add_row(
			lang('field_limit_format', 'field_limit_format'),
			form_dropdown('field_limit_format', array(
				'' => lang('field_limit_none'),
				'all' => lang('field_limit_all'),
				'xhtml' => lang('field_limit_xhtml'),
				'br' => lang('field_limit_br') . ' &lt;br /&gt;',
				'lite' => lang('field_limit_lite')
			))
		);

		ee()->table->add_row(
			lang('field_limit_content', 'field_limit_content'),
			form_dropdown('field_limit_content', array(
				'' => lang('field_limit_any'),
				'num' => lang('field_limit_number'),
				'int' => lang('field_limit_int'),
				'float' => lang('field_limit_float')
			))
		);
	}

	/**
	 * Display grid settings
	 *
	 * @param string $data Existing field data
	 * @return array
	 */
	public function grid_display_settings($data)
	{
		$this->addSettingsAssets();

		$settings = array();

		$settings[] = lang('field_limit_rows', 'grid_field_limit_rows') .
			'<br>' .
			lang('field_limit_rows_explain') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limit_rows',
				'name' => 'field_limit_rows',
				'type' => 'number',
				'value' => ''
			)) .
			'</div>';

		$settings[] = lang('field_limit_max_length', 'grid_field_limit_max_length') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limit_max_length',
				'name' => 'field_limit_max_length',
				'type' => 'number',
				'value' => ''
			)) .
			'</div>';

		$settings[] = lang('field_limit_format', 'field_limit_format') .
			'<div class="grid-input">' .
			form_dropdown('field_limit_format', array(
				'' => lang('field_limit_none'),
				'all' => lang('field_limit_all'),
				'xhtml' => lang('field_limit_xhtml'),
				'br' => lang('field_limit_br') . ' &lt;br /&gt;',
				'lite' => lang('field_limit_lite')
			)) .
			'</div>';

		$settings[] = lang('field_limit_content', 'grid_field_limit_content') .
			'<div class="grid-input">' .
			form_dropdown('field_limit_content', array(
				'' => lang('field_limit_any'),
				'num' => lang('field_limit_number'),
				'int' => lang('field_limit_int'),
				'float' => lang('field_limit_float')
			)) .
			'</div>';

		return $settings;
	}

	/**
	 * Display field
	 *
	 * @param mixed $data
	 * @return string
	 */
	public function display_field($data)
	{
		return '';
	}
}