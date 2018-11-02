<?php

if (!class_exists('SylvainJule\ColorPalette')) {
	require_once __DIR__ . '/lib/color-palette.php';
}

Kirby::plugin('sylvainjule/color-palette', array(
	'options' => array(
		'cache' => true,
	),
	'fields' => require_once __DIR__ . '/lib/fields.php',
	'api'    => require_once __DIR__ . '/lib/api.php',
    'translations' => array(
        'en' => require_once __DIR__ . '/lib/languages/en.php',
        'fr' => require_once __DIR__ . '/lib/languages/fr.php',
    ),
));