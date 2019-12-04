<?php

return array(
	'color-palette' => array(
		'extends'  => 'radio',
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
            'template' > function($template = null) {
            	return $template;
            },
            'autotemplate' > function($autotemplate = null) {
            	return $autotemplate;
            }
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
	        'options' => function() {
	        	$options = $this->options;
	        	$cache   = kirby()->cache('sylvainjule.color-palette');

	        	if($options == 'query') {
	        		return $this->getOptions();
	        	}

	        	if($this->autotemplate) {
	        		if($image = $this->model()->images()->template($this->autotemplate)->first()) {
	        			if($image->filename() == $cache->get('image.filename')) {
	        				$options = $cache->get('image.options');
	        			}
	        			else {
		        			$options = SylvainJule\ColorPalette::extractColor($image, $this->limit);
		        			$cache->set('image.filename', $image->filename());
		        			$cache->set('image.options', $options);
		        		}
	        		}
	        	}
	        	return $options;
	        },
	        'default' => function() {
	        	return $this->default;
	        },
	        'value' => function () {
            	return $this->value;
       		}
		),
    ),
);
