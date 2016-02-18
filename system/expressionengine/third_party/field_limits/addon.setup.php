<?php

defined('FIELD_LIMITS_VER') || define('FIELD_LIMITS_VER', '1.0.0-b.7');

// Set up autoloading
spl_autoload_register(function ($class) {
	$ns = explode('\\', $class);

	// Make sure a FieldLimits class is being requested
	if ($ns[0] !== 'FieldLimits') {
		return;
	}

	// Remove FieldLimits from the path
	unset($ns[0]);

	// Put the file path together
	$ns = implode('/', $ns);

	// Load the file
	$file = PATH_THIRD . 'field_limits/' . $ns . '.php';

	if (file_exists($file)) {
		include_once $file;
	}
});

return array(
	'author' => 'TJ Draper',
	'author_url' => 'https://buzzingpixel.com',
	'description' => 'Fieldtypes for text input/textarea limits',
	'name' => 'Field Limits',
	'namespace' => 'BuzzingPixel\FieldLimits',
	'version' => FIELD_LIMITS_VER,
	'fieldtypes' => array(
		'field_limits' => array(
			'name' => 'Field Limits - Input',
			'compatibility' => 'text'
		),
		'field_limits_number' => array(
			'name' => 'Field Limits - Number',
			'compatibility' => 'text'
		),
		'field_limits_textarea' => array(
			'name' => 'Field Limits - Textarea',
			'compatibility' => 'text'
		)
	)
);
