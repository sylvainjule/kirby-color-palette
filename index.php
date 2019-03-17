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
        'de' => require_once __DIR__ . '/lib/languages/de.php',
        'fr' => require_once __DIR__ . '/lib/languages/fr.php',
    ),
));