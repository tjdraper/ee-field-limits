<?php

if (! defined('FIELD_LIMITS_AUTHOR')) {
	define('FIELD_LIMITS_AUTHOR', 'TJ Draper');
	define('FIELD_LIMITS_AUTHOR_URL', 'https://www.buzzingpixel.com');
	define('FIELD_LIMITS_DESC', 'A fieldtype for text input/textarea limits');
	define('FIELD_LIMITS_NAME', 'Field Limits');
	define('FIELD_LIMITS_PATH', PATH_THIRD . 'field_limits/');
	define('FIELD_LIMITS_THEMES', URL_THIRD_THEMES . 'field_limits/');
	define('FIELD_LIMITS_VER', '1.0.0-b.2');
}

$config['name'] = FIELD_LIMITS_NAME;
$config['version'] = FIELD_LIMITS_VER;

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
	$file = FIELD_LIMITS_PATH . $ns . '.php';

	if (file_exists($file)) {
		include_once $file;
	}
});