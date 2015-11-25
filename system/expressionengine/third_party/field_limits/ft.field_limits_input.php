<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include_once(PATH_THIRD . 'field_limits/addon.setup.php');

/**
 * Field Limits input field type
 *
 * @package field_limits
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://github.com/tjdraper/ee-field-limits
 * @copyright Copyright (c) 2015, BuzzingPixel, LLC
 */

use FieldLimits\Helper;
use FieldLimits\Service;

Class Field_limits_input_ft extends EE_Fieldtype
{
	// Set EE fieldtype info
	public $info = array(
		'name' => 'Field Limits - Input',
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
		return $name === 'channel' or $name === 'grid' or $name === 'blocks/1';
	}

	/**
	 * Settings
	 *
	 * @param array $data Existing setting data
	 * @return array
	 */
	public function display_settings($data)
	{
		$assets = new Helper\Assets();
		$assets->add('settings');

		$fields = new Helper\Fields($data, 'field_limits_input');

		$fields->maxLength();

		$fields->fieldFormatting();
	}

	/**
	 * Display grid settings
	 *
	 * @param array $data Existing setting data
	 * @return array
	 */
	public function grid_display_settings($data)
	{
		$assets = new Helper\Assets();
		$assets->add('settings');

		$fields = new Helper\Fields($data, 'field_limits_input');

		$settings = array();

		$settings[] = $fields->gridMaxLength();

		$settings[] = $fields->gridFieldFormatting();

		return $settings;
	}

	/**
	 * Display Low Variables settings
	 *
	 * @param array $data Existing setting data
	 * @return array
	 */
	public function display_var_settings($data)
	{
		ee()->lang->loadfile('field_limits');

		$assets = new Helper\Assets();
		$assets->add('settings');

		$fields = new Helper\Fields($data, 'field_limits_input');

		$settings = array();

		$settings[] = $fields->lowVarsMaxLength();

		$settings[] = $fields->lowVarsFieldFormatting();

		return $settings;
	}

	/**
	 * Save settings
	 *
	 * @param array $data
	 * @return array
	 */
	public function save_settings($data)
	{
		$settingsArray = new Helper\SettingsArray();

		return $settingsArray->get($data, 'field_limits_input');
	}

	/**
	 * Save Low Variables settings
	 *
	 * @param array $data
	 * @return array
	 */
	public function save_var_settings($data)
	{
		$settingsArray = new Helper\SettingsArray();

		return $settingsArray->get($data, 'field_limits_input');
	}

	/**
	 * Default field settings
	 */
	private $defaultFieldSettings = array(
		'max_length' => null,
		'format' => null
	);

	/**
	 * Display field
	 *
	 * @param mixed $data
	 * @return string
	 */
	public function display_field($data)
	{
		$assets = new Helper\Assets();
		$assets->add('field');

		$data = str_replace("&#039;", "'", $data);
		$data = str_replace('&quot;', '"', $data);

		ee()->javascript->output(
			'fieldLimits.vars.fieldTypeNames = fieldLimits.vars.fieldTypeNames || [];' .
			'fieldLimits.vars.fieldTypeNames.push("field_limits_input");'
		);

		$fieldSettings = new Helper\FieldSettings();

		$settings = $fieldSettings->get(
			$this->settings,
			$this->defaultFieldSettings
		);

		$settings['field_name'] = $this->field_name;
		$settings['value'] = $data;
		$settings['required'] = isset($this->settings['field_required']) and
			$this->settings['field_required'] === 'y';
		$settings['isGrid'] = isset($this->settings['grid_field_id']);

		return ee()->load->view('input', $settings, true);
	}

	/**
	 * Display Low Variables field
	 *
	 * @param mixed $data
	 * @return string
	 */
	public function display_var_field($data)
	{
		ee()->load->add_package_path(FIELD_LIMITS_PATH);

		return $this->display_field($data);
	}

	/**
	 * Validate field data
	 *
	 * @param array $data Submitted field data
	 * @return mixed
	 */
	public function validate($data)
	{
		if (! $data) {
			return true;
		}

		$fieldSettings = new Helper\FieldSettings();

		$settings = $fieldSettings->get(
			$this->settings,
			$this->defaultFieldSettings
		);

		$errors = '';

		if ($settings['max_length'] and strlen($data) > $settings['max_length']) {
			$errors .= lang('field_limits_char_count_not_greater_than') .
				$settings['max_length'] . '<br>';
		}

		if ($errors) {
			return $errors;
		}

		return true;
	}

	/**
	 * Validate Low Variables field
	 *
	 * @param string $data
	 * @return mixed
	 */
	public function save_var_field($data)
	{
		ee()->lang->loadfile('field_limits');

		$validation = $this->validate($data);

		if ($validation !== true) {
			$this->error_msg = $validation;

			return false;
		}

		return $data;
	}

	/**
	 * Replace tag
	 *
	 * @param string $fieldData
	 * @param array $tagParams
	 * @return string
	 */
	public function replace_tag($fieldData, $tagParams = array())
	{
		$fieldSettings = new Helper\FieldSettings();
		$tag = new Service\Tag();

		$settings = $fieldSettings->get(
			$this->settings,
			$this->defaultFieldSettings
		);

		return $tag->parse($fieldData, $tagParams, $settings);
	}

	/**
	 * Display Low Variables tag
	 *
	 * @param string $fieldData
	 * @param array $tagParams
	 * @return string
	 */
	public function display_var_tag($fieldData, $tagParams = array())
	{
		return $this->replace_tag($fieldData, $tagParams);
	}
}
