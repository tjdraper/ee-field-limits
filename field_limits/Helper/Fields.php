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
		return array(
			'title' => 'field_limits_max_length',
			'fields' => array(
				"{$this->prefix}_max_length" => array(
					'type' => 'html',
					'content' => form_input(array(
						'id' => "{$this->prefix}_max_length",
						'name' => "{$this->prefix}_max_length",
						'type' => 'number',
						'value' => isset($this->data['max_length']) ? $this->data['max_length'] : '',
						'placeholder' => lang('field_limits_max_length')
					))
				)
			)
		);
	}

	/**
	 * Add Low Variables max length settings field
	 *
	 * @return array
	 */
	public function lowVarsMaxLength()
	{
		return array(
			lang('field_limits_max_length'),
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
		return array(
			'title' => 'field_limits_format',
			'fields' => array(
				"{$this->prefix}_format" => array(
					'type' => 'html',
					'content' => form_dropdown(
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
				)
			)
		);
	}

	/**
	 * Add Low Variables field formatting settings field
	 *
	 * @return array
	 */
	public function lowVarsFieldFormatting()
	{
		return array(
			lang('field_limits_format'),
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
		return array(
			'title' => 'field_limits_content',
			'fields' => array(
				"{$this->prefix}_content" => array(
					'type' => 'html',
					'content' => form_dropdown(
						"{$this->prefix}_content",
						array(
							'num' => lang('field_limits_number'),
							'int' => lang('field_limits_int'),
						),
						isset($this->data['content']) ? $this->data['content'] : ''
					)
				)
			)
		);
	}

	/**
	 * Add Low Variables content settings field
	 *
	 * @return array
	 */
	public function lowVarsFieldContent()
	{
		return array(
			lang('field_limits_content'),
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
		return array(
			'title' => 'field_limits_min',
			'fields' => array(
				"{$this->prefix}_min" => array(
					'type' => 'html',
					'content' => form_input(array(
						'id' => "{$this->prefix}_min",
						'name' => "{$this->prefix}_min",
						'type' => 'number',
						'value' => isset($this->data['min']) ? $this->data['min'] : '',
						'placeholder' => lang('field_limits_min')
					))
				)
			)
		);
	}

	/**
	 * Add Low Variables min number settings field
	 *
	 * @return array
	 */
	public function lowVarsMinNumber()
	{
		return array(
			lang('field_limits_min'),
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
		return array(
			'title' => 'field_limits_max',
			'fields' => array(
				"{$this->prefix}_max" => array(
					'type' => 'html',
					'content' => form_input(array(
						'id' => "{$this->prefix}_max",
						'name' => "{$this->prefix}_max",
						'type' => 'number',
						'value' => isset($this->data['max']) ? $this->data['max'] : '',
						'placeholder' => lang('field_limits_max')
					))
				)
			)
		);
	}

	/**
	 * Add Low Variables max number settings field
	 *
	 * @return array
	 */
	public function lowVarsMaxNumber()
	{
		return array(
			lang('field_limits_max'),
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
		return array(
			'title' => 'field_limits_step',
			'fields' => array(
				"{$this->prefix}_step" => array(
					'type' => 'html',
					'content' => form_input(array(
						'id' => "{$this->prefix}_step",
						'name' => "{$this->prefix}_step",
						'type' => 'number',
						'value' => isset($this->data['step']) ? $this->data['step'] : '',
						'placeholder' => lang('field_limits_step')
					))
				)
			)
		);
	}

	/**
	 * Add Low Variables step settings field
	 *
	 * @return array
	 */
	public function lowVarsStep()
	{
		return array(
			lang('field_limits_step'),
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
		return array(
			'title' => 'field_limits_rows',
			'fields' => array(
				"{$this->prefix}_rows" => array(
					'type' => 'html',
					'content' => form_input(array(
						'id' => "{$this->prefix}_rows",
						'name' => "{$this->prefix}_rows",
						'type' => 'number',
						'value' => isset($this->data['rows']) ? $this->data['rows'] : '',
						'placeholder' => lang('field_limits_rows')
					))
				)
			)
		);
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
