<?php

return array(
	'routes' => array(
		array(
	        'pattern' => 'color-palette/extract-image-colors',
	        'method'  => 'GET',
	        'action'  => function() {
	            $id            = get('id');
	            $limit         = get('limit');
	            $filesIndex    = SylvainJule\ColorPalette::getFilesIndex();
	            $file          = $filesIndex->find($id);

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