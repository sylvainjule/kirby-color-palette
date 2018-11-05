<?php

return array(
	'routes' => array(
		array(
	        'pattern' => 'color-palette/extract-image-colors',
	        'method'  => 'GET',
	        'action'  => function() {
	            $filename = get('filename');
	            $uri      = get('uri');
	            $limit    = get('limit');
	            $page     = site()->childrenAndDrafts()->find($uri);
	            $file     = $page->file($filename);

	        	try {
	        		$colors = SylvainJule\ColorPalette::extractColor($file, $limit);
	        		$response = array(
			            'status' => 'success',
			            'colors' => $colors,
			        );
			        return $response;
	        	}
	        	catch (Exception $e) {
	        		$response = array(
			            'status' => 'error',
			            'message'  => $e->getMessage()
			        );
			        return $response;
	        	}
	        }
	    ),
	)
);