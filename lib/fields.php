<?php

return array(
	'color-palette' => array(
		'props'    => array(
			'options' => function ($options = []) {
                return $options;
            },
			'display' => function ($display = 'single') {
                return $display;
            },
			'size' => function ($size = 'medium') {
                return $size;
            },
			'unset' => function ($unset = false) {
                return $unset;
            },
            'default' => function($default = false) {
            	return $default;
            },
            'extractor' => function($extractor = false) {
            	return $extractor;
            },
            'limit' => function($limit = 10) {
            	return $limit;
            },
            'value' => function ($value = null) {
            	$yaml = Yaml::decode($value);
                return count($yaml) ? $yaml : $value;
            }
		),
		'computed' => array(
			'parent' => function () {
	            return $this->model()->apiUrl(true);
	        },
		),
    ),
);