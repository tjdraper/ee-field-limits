<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include_once(PATH_THIRD . 'field_limits/addon.setup.php');

/**
 * Field Limits textarea field type
 *
 * @package field_limits
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://github.com/tjdraper/ee-field-limits
 * @copyright Copyright (c) 2015, BuzzingPixel, LLC
 */

use FieldLimits\Helper;
use FieldLimits\Service;

Class Field_limits_textarea_ft extends EE_Fieldtype
{
	// Set EE fieldtype info
	public $info = array(
		'name' => 'Field Limits - Textarea',
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
	 * Settings
	 *
	 * @param string $data Existing setting data
	 * @return array
	 */
	public function display_settings($data)
	{
		$assets = new Helper\Assets();
		$assets->add('settings');

		$fields = new Helper\Fields($data, 'field_limits_textarea');

		$fields->rows();

		$fields->maxLength();

		$fields->fieldFormatting();
	}

	/**
	 * Display grid settings
	 *
	 * @param string $data Existing field data
	 * @return array
	 */
	public function grid_display_settings($data)
	{
		$assets = new Helper\Assets();
		$assets->add('settings');

		$fields = new Helper\Fields($data, 'field_limits_textarea');

		$settings = array();

		$settings[] = $fields->gridRows();

		$settings[] = $fields->gridMaxLength();

		$settings[] = $fields->gridFieldFormatting();

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

		return $settingsArray->get($data, 'field_limits_textarea');
	}

	/**
	 * Default field settings
	 */
	private $defaultFieldSettings = array(
		'rows' => null,
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
			'fieldLimits.vars.fieldTypeNames.push("field_limits_textarea");'
		);

		$fieldSettings = new Helper\FieldSettings();

		$settings = $fieldSettings->get(
			$this->settings,
			$this->defaultFieldSettings
		);

		$settings['field_name'] = $this->field_name;
		$settings['value'] = $data;
		$settings['required'] = $this->settings['field_required'] === 'y';
		$settings['isGrid'] = isset($this->settings['grid_field_id']);

		return ee()->load->view('textarea', $settings, true);
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
	 * Replace tag pair
	 *
	 * @param string $fieldData The channel_data table data
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
}