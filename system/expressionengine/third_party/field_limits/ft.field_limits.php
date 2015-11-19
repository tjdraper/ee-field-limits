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
			lang('field_limits_rows', 'field_limits_rows') .
				'<br>' .
				lang('field_limits_rows_explain'),
			form_input(array(
				'id' => 'field_limits_rows',
				'name' => 'field_limits_rows',
				'type' => 'number',
				'value' => ''
			))
		);

		ee()->table->add_row(
			lang('field_limits_max_length', 'field_limits_max_length'),
			form_input(array(
				'id' => 'field_limits_max_length',
				'name' => 'field_limits_max_length',
				'type' => 'number',
				'value' => ''
			))
		);

		ee()->table->add_row(
			lang('field_limits_format', 'field_limits_format'),
			form_dropdown('field_limits_format', array(
				'' => lang('field_limits_none'),
				'all' => lang('field_limits_all'),
				'xhtml' => lang('field_limits_xhtml'),
				'br' => lang('field_limits_br') . ' &lt;br /&gt;',
				'lite' => lang('field_limits_lite')
			))
		);

		ee()->table->add_row(
			lang('field_limits_content', 'field_limits_content'),
			form_dropdown('field_limits_content', array(
				'' => lang('field_limits_any'),
				'num' => lang('field_limits_number'),
				'int' => lang('field_limits_int'),
				'float' => lang('field_limits_float')
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

		$settings[] = lang('field_limits_rows', 'grid_field_limits_rows') .
			'<br>' .
			lang('field_limits_rows_explain') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_rows',
				'name' => 'field_limits_rows',
				'type' => 'number',
				'value' => ''
			)) .
			'</div>';

		$settings[] = lang('field_limits_max_length', 'grid_field_limits_max_length') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_max_length',
				'name' => 'field_limits_max_length',
				'type' => 'number',
				'value' => ''
			)) .
			'</div>';

		$settings[] = lang('field_limits_format', 'grid_field_limits_format') .
			'<div class="grid-input">' .
			form_dropdown('field_limits_format', array(
				'' => lang('field_limits_none'),
				'all' => lang('field_limits_all'),
				'xhtml' => lang('field_limits_xhtml'),
				'br' => lang('field_limits_br') . ' &lt;br /&gt;',
				'lite' => lang('field_limits_lite')
			)) .
			'</div>';

		$settings[] = lang('field_limits_content', 'grid_field_limits_content') .
			'<div class="grid-input">' .
			form_dropdown('field_limits_content', array(
				'' => lang('field_limits_any'),
				'num' => lang('field_limits_number'),
				'int' => lang('field_limits_int'),
				'float' => lang('field_limits_float')
			)) .
			'</div>';

		return $settings;
	}

	/**
	 * Validate field settings
	 *
	 * @param array $data Field data
	 */
	public function validate_settings($data)
	{
		ee()->form_validation->set_rules(
			array(
				array(
					'field' => 'field_limits_rows',
					'label' => 'lang:field_limits_rows',
					'rules' => 'is_natural'
				),
				array(
					'field' => 'field_limits_max_length',
					'label' => 'lang:field_limits_max_length',
					'rules' => 'is_natural'
				)
			)
		);
	}

	/**
	 * Validate grid settings
	 *
	 * @param array $data Field data
	 * @return string|bool
	 */
	public function grid_validate_settings($data)
	{
		$errorMessage = array();

		if (
			isset($data['field_limits_rows']) &&
			$data['field_limits_rows'] &&
			! ctype_digit($data['field_limits_rows'])
		) {
			$errorMessage[] = lang('field_limits_rows_must_be_number');
		}

		if (
			isset($data['field_limits_max_length']) &&
			$data['field_limits_max_length'] &&
			! ctype_digit($data['field_limits_max_length'])
		) {
			$errorMessage[] = lang('field_limits_max_length_must_be_number');
		}

		if ($errorMessage) {
			return implode('<br>', $errorMessage);
		}

		return true;
	}

	public function save_settings($data)
	{
		$saveData = array();

		foreach ($data as $saveKey => $save) {
			if (strncmp('field_limits_', $saveKey, 13) === 0) {
				$saveData[$saveKey] = $save;
			}
		}

		return $saveData;
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