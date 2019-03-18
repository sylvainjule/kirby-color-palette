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
			'unselect' => function ($unselect = false) {
                return $unselect;
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
            },
		),
		'computed' => array(
			'uri' => function() {
				return $this->model()->uri();
			},
			'parent' => function () {
	            return $this->model()->apiUrl(true);
	        },
			'files' => function () {
	            return $this->model()->images();
	        },
		),
    ),
);