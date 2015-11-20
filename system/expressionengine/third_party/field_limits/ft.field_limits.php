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
	public function addAssets($pageType)
	{
		if (! ee()->session->cache('fieldLimits', 'settingsAssetsLoaded')) {
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
		$this->addAssets('settings');

		ee()->table->add_row(
			lang('field_limits_rows', 'field_limits_rows') .
				'<br>' .
				lang('field_limits_rows_explain'),
			form_input(array(
				'id' => 'field_limits_rows',
				'name' => 'field_limits_rows',
				'type' => 'number',
				'value' => isset($data['field_limits_rows']) ? $data['field_limits_rows'] : '',
				'placeholder' => lang('field_limits_rows')
			))
		);

		ee()->table->add_row(
			lang('field_limits_max_length', 'field_limits_max_length'),
			form_input(array(
				'id' => 'field_limits_max_length',
				'name' => 'field_limits_max_length',
				'type' => 'number',
				'value' => isset($data['field_limits_max_length']) ? $data['field_limits_max_length'] : '',
				'placeholder' => lang('field_limits_max_length')
			))
		);

		ee()->table->add_row(
			lang('field_limits_format', 'field_limits_format'),
			form_dropdown(
				'field_limits_format',
				array(
					'' => lang('field_limits_none'),
					'all' => lang('field_limits_all'),
					'xhtml' => lang('field_limits_xhtml'),
					'br' => lang('field_limits_br') . ' &lt;br /&gt;',
					'lite' => lang('field_limits_lite')
				),
				isset($data['field_limits_format']) ? $data['field_limits_format'] : ''
			)
		);

		ee()->table->add_row(
			lang('field_limits_content', 'field_limits_content'),
			form_dropdown(
				'field_limits_content',
				array(
					'' => lang('field_limits_any'),
					'num' => lang('field_limits_number'),
					'int' => lang('field_limits_int'),
					'float' => lang('field_limits_float')
				),
				isset($data['field_limits_content']) ? $data['field_limits_content'] : ''
			)
		);

		ee()->table->add_row(
			lang('field_limits_default_val', 'field_limits_default_val'),
			form_input(array(
				'id' => 'field_limits_default_val',
				'name' => 'field_limits_default_val',
				'type' => 'text',
				'value' => isset($data['field_limits_default_val']) ? $data['field_limits_default_val'] : '',
				'placeholder' => lang('field_limits_default_val')
			))
		);

		ee()->table->add_row(
			lang('field_limits_min', 'field_limits_min') .
				'<br>' .
				lang('field_limits_only_integer'),
			form_input(array(
				'id' => 'field_limits_min',
				'name' => 'field_limits_min',
				'type' => 'number',
				'value' => isset($data['field_limits_min']) ? $data['field_limits_min'] : '',
				'placeholder' => lang('field_limits_min')
			))
		);

		ee()->table->add_row(
			lang('field_limits_max', 'field_limits_max') .
				'<br>' .
				lang('field_limits_only_integer'),
			form_input(array(
				'id' => 'field_limits_max',
				'name' => 'field_limits_max',
				'type' => 'number',
				'value' => isset($data['field_limits_max']) ? $data['field_limits_max'] : '',
				'placeholder' => lang('field_limits_max')
			))
		);

		ee()->table->add_row(
			lang('field_limits_step', 'field_limits_step') .
				'<br>' .
				lang('field_limits_only_integer'),
			form_input(array(
				'id' => 'field_limits_step',
				'name' => 'field_limits_step',
				'type' => 'number',
				'value' => isset($data['field_limits_step']) ? $data['field_limits_step'] : '',
				'placeholder' => lang('field_limits_step')
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
		$this->addAssets('settings');

		$settings = array();

		$settings[] = lang('field_limits_rows', 'grid_field_limits_rows') .
			'<br>' .
			lang('field_limits_rows_explain') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_rows',
				'name' => 'field_limits_rows',
				'type' => 'number',
				'value' => isset($data['field_limits_rows']) ? $data['field_limits_rows'] : '',
				'placeholder' => lang('field_limits_rows')
			)) .
			'</div>';

		$settings[] = lang('field_limits_max_length', 'grid_field_limits_max_length') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_max_length',
				'name' => 'field_limits_max_length',
				'type' => 'number',
				'value' => isset($data['field_limits_max_length']) ? $data['field_limits_max_length'] : '',
				'placeholder' => lang('field_limits_max_length')
			)) .
			'</div>';

		$settings[] = lang('field_limits_format', 'grid_field_limits_format') .
			'<div class="grid-input">' .
			form_dropdown(
				'field_limits_format',
				array(
					'' => lang('field_limits_none'),
					'all' => lang('field_limits_all'),
					'xhtml' => lang('field_limits_xhtml'),
					'br' => lang('field_limits_br') . ' &lt;br /&gt;',
					'lite' => lang('field_limits_lite')
				),
				isset($data['field_limits_format']) ? $data['field_limits_format'] : ''
			) .
			'</div>';

		$settings[] = lang('field_limits_content', 'grid_field_limits_content') .
			'<div class="grid-input">' .
			form_dropdown(
				'field_limits_content',
				array(
					'' => lang('field_limits_any'),
					'num' => lang('field_limits_number'),
					'int' => lang('field_limits_int'),
					'float' => lang('field_limits_float')
				),
				isset($data['field_limits_content']) ? $data['field_limits_content'] : ''
			) .
			'</div>';

		$settings[] = lang('field_limits_default_val', 'grid_field_limits_default_val') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_default_val',
				'name' => 'field_limits_default_val',
				'type' => 'number',
				'value' => isset($data['field_limits_default_val']) ? $data['field_limits_default_val'] : '',
				'placeholder' => lang('field_limits_default_val')
			)) .
			'</div>';

		$settings[] = lang('field_limits_min', 'grid_field_limits_min') .
			'<br>' .
			lang('field_limits_only_integer') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_min',
				'name' => 'field_limits_min',
				'type' => 'number',
				'value' => isset($data['field_limits_min']) ? $data['field_limits_min'] : '',
				'placeholder' => lang('field_limits_min')
			)) .
			'</div>';

		$settings[] = lang('field_limits_max', 'grid_field_limits_max') .
			'<br>' .
			lang('field_limits_only_integer') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_max',
				'name' => 'field_limits_max',
				'type' => 'number',
				'value' => isset($data['field_limits_max']) ? $data['field_limits_max'] : '',
				'placeholder' => lang('field_limits_max')
			)) .
			'</div>';

		$settings[] = lang('field_limits_step', 'grid_field_limits_step') .
			'<br>' .
			lang('field_limits_only_integer') .
			'<div class="grid-input">' .
			form_input(array(
				'id' => 'grid_field_limits_step',
				'name' => 'field_limits_step',
				'type' => 'number',
				'value' => isset($data['field_limits_step']) ? $data['field_limits_step'] : '',
				'placeholder' => lang('field_limits_step')
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

	private $defaultFieldSettings = array(
		'field_limits_rows' => null,
		'field_limits_max_length' => null,
		'field_limits_format' => null,
		'field_limits_content' => null,
		'field_limits_default_val' => null,
		'field_limits_min' => null,
		'field_limits_max' => null,
		'field_limits_step' => null
	);

	private function getFieldSettings ($fieldSettings)
	{
		$settings = $this->defaultFieldSettings;

		$intValueKeys = array(
			'field_limits_rows',
			'field_limits_max_length',
			'field_limits_min',
			'field_limits_max',
			'field_limits_step'
		);

		foreach ($fieldSettings as $key => $val) {
			if (strncmp('field_limits_', $key, 13) === 0) {
				if (in_array($key, $intValueKeys)) {
					$val = (int) $val;
				}

				$settings[$key] = $val;
			}
		}

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
		$this->addAssets('field');

		$settings = $this->getFieldSettings($this->settings);

		$output = '<div class="field-limits-field';

		if ($settings['field_limits_max_length']) {
			$output .= ' js-field-limits-limited';
		}

		$output .= '"';

		if ($settings['field_limits_max_length']) {
			$output .= 'data-limit="' . $settings['field_limits_max_length'] . '"';
		}

		$output .= '>';

		$inputSettings = array(
			'name' => $this->field_name,
			'value' => $data ?: $settings['field_limits_default_val'],
			'class' => 'field-limits-field__input js-field-limits-input'
		);

		if ($settings['field_limits_max_length']) {
			$inputSettings['maxlength'] = $settings['field_limits_max_length'];
		}

		if ($this->settings['field_required'] === 'y') {
			$inputSettings['required'] = true;
		}

		if ($settings['field_limits_rows'] < 2) {
			if ($settings['field_limits_content'] === 'int') {
				$inputSettings['type'] = 'number';

				if ($settings['field_limits_min']) {
					$inputSettings['min'] = $settings['field_limits_min'];
				}

				if ($settings['field_limits_max']) {
					$inputSettings['max'] = $settings['field_limits_max'];
				}

				if ($settings['field_limits_step']) {
					$inputSettings['step'] = $settings['field_limits_step'];
				}
			} else {
				$inputSettings['type'] = 'text';
			}

			$output .= form_input($inputSettings);
		} else {
			$inputSettings['rows'] = $settings['field_limits_rows'];
			$inputSettings['cols'] = false;

			$output .= form_textarea($inputSettings);
		}

		if ($settings['field_limits_max_length']) {
			$output .= '<div class="field-limits-count js-field-limits-count-wrap">';
			$output .= '<span class="js-field-limits-count">' . strlen($data) . '</span> / ';
			$output .= '<span class="js-field-limits-limit">' . $settings['field_limits_max_length'] . '</span>';
			$output .= '</div>';
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * Validate field data
	 *
	 * @param $data Submitted field data
	 */
	public function validate($data)
	{
		$errors = '';

		$settings = $this->getFieldSettings($this->settings);

		if ($settings['field_limits_rows'] < 2) {
			if ($settings['field_limits_content'] === 'int') {
				if (! ctype_digit($data)) {
					$errors .= 'This field must contain a whole number' . '<br>';
				}

				if ($settings['field_limits_min']) {
					if ((int) $data < $settings['field_limits_min']) {
						$errors .= 'This field must be greater than ' . $settings['field_limits_min'] . '<br>';
					}
				}

				if ($settings['field_limits_max']) {
					if ((int) $data > $settings['field_limits_max']) {
						$errors .= 'This field must be less than ' . $settings['field_limits_max'] . '<br>';
					}
				}
			}

			if ($settings['field_limits_content'] === 'num' and ! is_numeric($data)) {
				$errors .= 'This field must contain numeric values only' . '<br>';
			}

			if ($settings['field_limits_content'] === 'float' and (ctype_digit($data) or ! is_numeric($data))) {
				$errors .= 'This field must contain a decimal numeric value' . '<br>';
			}
		}

		if (
			$settings['field_limits_max_length'] and
			strlen($data) > $settings['field_limits_max_length']
		) {
			$errrors .= 'This field character count must not be greater than ' . $settings['field_limits_max_length'] . '<br>';
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
		$allowedTypographys = array(
			'all',
			'xhtml',
			'br',
			'lite'
		);

		$format = false;

		$settings = $this->getFieldSettings($this->settings);

		if (
			isset($tagParams['format']) and
			in_array($tagParams['format'], $allowedTypographys)
		) {
			$format = $tagParams['format'];
		} elseif (
			! isset($tagParams['format']) and
			in_array($settings['field_limits_format'], $allowedTypographys)
		) {
			$format = $settings['field_limits_format'];
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