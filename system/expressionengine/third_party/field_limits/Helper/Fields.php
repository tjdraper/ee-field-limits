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

class Fields
{
	private $data;
	private $prefix;

	/**
	 * Fields constructor
	 *
	 * @param array $data Existing field data
	 * @param string $prefix Field type name
	 */
	public function __construct($data, $prefix)
	{
		$this->data = $data;
		$this->prefix = $prefix;
	}

	/**
	 * Add max length settings field
	 */
	public function maxLength()
	{
		ee()->table->add_row(
			lang('field_limits_max_length', "{$this->prefix}_max_length"),
			form_input(array(
				'id' => "{$this->prefix}_max_length",
				'name' => "{$this->prefix}_max_length",
				'type' => 'number',
				'value' => isset($this->data['max_length']) ? $this->data['max_length'] : '',
				'placeholder' => lang('field_limits_max_length')
			))
		);
	}

	/**
	 * Add grid max length settings field
	 *
	 * @return string
	 */
	public function gridMaxLength()
	{
		return lang('field_limits_max_length', "grid_{$this->prefix}_max_length") .
			'<div class="grid-input">' .
			form_input(array(
				'id' => "grid_{$this->prefix}_max_length",
				'name' => "{$this->prefix}_max_length",
				'type' => 'number',
				'value' => isset($this->data['max_length']) ? $this->data['max_length'] : '',
				'placeholder' => lang('field_limits_max_length')
			)) .
			'</div>';
	}

	/**
	 * Add Low Variables max length settings field
	 *
	 * @return array
	 */
	public function lowVarsMaxLength()
	{
		return array(
			lang('field_limits_max_length', "variable_settings[{$this->prefix}][{$this->prefix}_max_length]"),
			form_input(array(
				'id' => "variable_settings[{$this->prefix}][{$this->prefix}_max_length]",
				'name' => "variable_settings[{$this->prefix}][{$this->prefix}_max_length]",
				'type' => 'number',
				'value' => isset($this->data['max_length']) ? $this->data['max_length'] : '',
				'placeholder' => lang('field_limits_max_length')
			))
		);
	}

	/**
	 * Add field formatting settings field
	 */
	public function fieldFormatting()
	{
		ee()->table->add_row(
			lang('field_limits_format', "{$this->prefix}_format"),
			form_dropdown(
				"{$this->prefix}_format",
				array(
					'' => lang('field_limits_none'),
					'all' => lang('field_limits_all'),
					'xhtml' => lang('field_limits_xhtml'),
					'br' => lang('field_limits_br') . ' &lt;br /&gt;',
					'lite' => lang('field_limits_lite')
				),
				isset($this->data['format']) ? $this->data['format'] : ''
			)
		);
	}

	/**
	 * Add grid field formatting settings field
	 *
	 * @return string
	 */
	public function gridFieldFormatting()
	{
		return lang('field_limits_format', "grid_{$this->prefix}_format") .
			'<div class="grid-input">' .
			form_dropdown(
				"{$this->prefix}_format",
				array(
					'' => lang('field_limits_none'),
					'all' => lang('field_limits_all'),
					'xhtml' => lang('field_limits_xhtml'),
					'br' => lang('field_limits_br') . ' &lt;br /&gt;',
					'lite' => lang('field_limits_lite')
				),
				isset($this->data['format']) ? $this->data['format'] : ''
			) .
			'</div>';
	}

	/**
	 * Add Low Variables field formatting settings field
	 *
	 * @return array
	 */
	public function lowVarsFieldFormatting()
	{
		return array(
			lang('field_limits_format', "variable_settings[{$this->prefix}][{$this->prefix}_format]"),
			form_dropdown(
				"variable_settings[{$this->prefix}][{$this->prefix}_format]",
				array(
					'' => lang('field_limits_none'),
					'all' => lang('field_limits_all'),
					'xhtml' => lang('field_limits_xhtml'),
					'br' => lang('field_limits_br') . ' &lt;br /&gt;',
					'lite' => lang('field_limits_lite')
				),
				isset($this->data['format']) ? $this->data['format'] : ''
			)
		);
	}

	/**
	 * Add field content settings field
	 */
	public function fieldContent()
	{
		ee()->table->add_row(
			lang('field_limits_content', "{$this->prefix}_content"),
			form_dropdown(
				"{$this->prefix}_content",
				array(
					'num' => lang('field_limits_number'),
					'int' => lang('field_limits_int'),
				),
				isset($this->data['content']) ? $this->data['content'] : ''
			)
		);
	}

	/**
	 * Add grid field content settings field
	 *
	 * @return string
	 */
	public function gridFieldContent()
	{
		return lang('field_limits_content', "grid_{$this->prefix}_content") .
			'<div class="grid-input">' .
			form_dropdown(
				"{$this->prefix}_content",
				array(
					'num' => lang('field_limits_number'),
					'int' => lang('field_limits_int'),
				),
				isset($this->data['content']) ? $this->data['content'] : ''
			) .
			'</div>';
	}

	/**
	 * Add Low Variables content settings field
	 *
	 * @return array
	 */
	public function lowVarsFieldContent()
	{
		return array(
			lang('field_limits_content', "variable_settings[{$this->prefix}][{$this->prefix}_content]"),
			form_dropdown(
				"variable_settings[{$this->prefix}][{$this->prefix}_content]",
				array(
					'num' => lang('field_limits_number'),
					'int' => lang('field_limits_int'),
				),
				isset($this->data['content']) ? $this->data['content'] : ''
			)
		);
	}

	/**
	 * Add min number settings field
	 */
	public function minNumber()
	{
		ee()->table->add_row(
			lang('field_limits_min', "{$this->prefix}_min"),
			form_input(array(
				'id' => "{$this->prefix}_min",
				'name' => "{$this->prefix}_min",
				'type' => 'number',
				'value' => isset($this->data['min']) ? $this->data['min'] : '',
				'placeholder' => lang('field_limits_min')
			))
		);
	}

	/**
	 * Add grid min number settings field
	 *
	 * @return string
	 */
	public function gridMinNumber()
	{
		return lang('field_limits_min', "grid_{$this->prefix}_min") .
		'<div class="grid-input">' .
			form_input(array(
				'id' => "grid_{$this->prefix}_min",
				'name' => "{$this->prefix}_min",
				'type' => 'number',
				'value' => isset($this->data['min']) ? $this->data['min'] : '',
				'placeholder' => lang('field_limits_min')
			)) .
			'</div>';
	}

	/**
	 * Add Low Variables min number settings field
	 *
	 * @return array
	 */
	public function lowVarsMinNumber()
	{
		return array(
			lang('field_limits_min', "variable_settings[{$this->prefix}][{$this->prefix}_min]"),
			form_input(array(
				'id' => "variable_settings[{$this->prefix}][{$this->prefix}_min]",
				'name' => "variable_settings[{$this->prefix}][{$this->prefix}_min]",
				'type' => 'number',
				'value' => isset($this->data['min']) ? $this->data['min'] : '',
				'placeholder' => lang('field_limits_min')
			))
		);
	}

	/**
	 * Add max number settings field
	 */
	public function maxNumber()
	{
		ee()->table->add_row(
			lang('field_limits_max', "{$this->prefix}_max"),
			form_input(array(
				'id' => "{$this->prefix}_max",
				'name' => "{$this->prefix}_max",
				'type' => 'number',
				'value' => isset($this->data['max']) ? $this->data['max'] : '',
				'placeholder' => lang('field_limits_max')
			))
		);
	}

	/**
	 * Add grid max number settings field
	 *
	 * @return string
	 */
	public function gridMaxNumber()
	{
		return lang('field_limits_max', "grid_{$this->prefix}_max") .
			'<div class="grid-input">' .
			form_input(array(
				'id' => "grid_{$this->prefix}_max",
				'name' => "{$this->prefix}_max",
				'type' => 'number',
				'value' => isset($this->data['max']) ? $this->data['max'] : '',
				'placeholder' => lang('field_limits_max')
			)) .
			'</div>';
	}

	/**
	 * Add Low Variables max number settings field
	 *
	 * @return array
	 */
	public function lowVarsMaxNumber()
	{
		return array(
			lang('field_limits_max', "variable_settings[{$this->prefix}][{$this->prefix}_max]"),
			form_input(array(
				'id' => "variable_settings[{$this->prefix}][{$this->prefix}_max]",
				'name' => "variable_settings[{$this->prefix}][{$this->prefix}_max]",
				'type' => 'number',
				'value' => isset($this->data['max']) ? $this->data['max'] : '',
				'placeholder' => lang('field_limits_max')
			))
		);
	}

	/**
	 * Add step settings field
	 */
	public function step()
	{
		ee()->table->add_row(
			lang('field_limits_step', "{$this->prefix}_step"),
			form_input(array(
				'id' => "{$this->prefix}_step",
				'name' => "{$this->prefix}_step",
				'type' => 'number',
				'value' => isset($this->data['step']) ? $this->data['step'] : '',
				'placeholder' => lang('field_limits_step')
			))
		);
	}

	/**
	 * Add grid step settings field
	 *
	 * @return string
	 */
	public function gridStep()
	{
		return lang('field_limits_step', "grid_{$this->prefix}_step") .
			'<div class="grid-input">' .
			form_input(array(
				'id' => "grid_{$this->prefix}_step",
				'name' => "{$this->prefix}_step",
				'type' => 'number',
				'value' => isset($this->data['step']) ? $this->data['step'] : '',
				'placeholder' => lang('field_limits_step')
			)) .
			'</div>';
	}

	/**
	 * Add Low Variables step settings field
	 *
	 * @return array
	 */
	public function lowVarsStep()
	{
		return array(
			lang('field_limits_step', "variable_settings[{$this->prefix}][{$this->prefix}_step]"),
			form_input(array(
				'id' => "variable_settings[{$this->prefix}][{$this->prefix}_step]",
				'name' => "variable_settings[{$this->prefix}][{$this->prefix}_step]",
				'type' => 'number',
				'value' => isset($this->data['step']) ? $this->data['step'] : '',
				'placeholder' => lang('field_limits_step')
			))
		);
	}

	/**
	 * Add rows settings field
	 */
	public function rows()
	{
		ee()->table->add_row(
			lang('field_limits_rows', "{$this->prefix}_rows"),
			form_input(array(
				'id' => "{$this->prefix}_rows",
				'name' => "{$this->prefix}_rows",
				'type' => 'number',
				'value' => isset($this->data['rows']) ? $this->data['rows'] : '',
				'placeholder' => lang('field_limits_rows')
			))
		);
	}

	/**
	 * Add grid rows settings field
	 *
	 * @return string
	 */
	public function gridRows()
	{
		return lang('field_limits_rows', "grid_{$this->prefix}_rows") .
		'<div class="grid-input">' .
		form_input(array(
			'id' => "grid_{$this->prefix}_rows",
			'name' => "{$this->prefix}_rows",
			'type' => 'number',
			'value' => isset($this->data['rows']) ? $this->data['rows'] : '',
			'placeholder' => lang('field_limits_rows')
		)) .
		'</div>';
	}

	/**
	 * Add Low Variables row settings field
	 *
	 * @return array
	 */
	public function lowVarsRow()
	{
		return array(
			lang('field_limits_rows', "variable_settings[{$this->prefix}][{$this->prefix}_rows]"),
			form_input(array(
				'id' => "variable_settings[{$this->prefix}][{$this->prefix}_rows",
				'name' => "variable_settings[{$this->prefix}][{$this->prefix}_rows]",
				'type' => 'number',
				'value' => isset($this->data['rows']) ? $this->data['rows'] : '',
				'placeholder' => lang('field_limits_rows')
			))
		);
	}
}
