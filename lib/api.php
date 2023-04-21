<?php

return array(
  'routes' => array(
      array(
              'pattern' => 'color-palette/get-files',
              'method'  => 'GET',
              'action' => function () {
                  $uri      = get('uri');
                  $template = get('template');
                  $page     = kirby()->page($uri);
                  $files    = $template !== 'undefined' ? $page->images()->template($template) : $page->images();
                  $data     = [];

                  $thumb = array(
                    'width'  => 100,
                    'height' => 100
                  );

                  foreach ($files as $index => $file) {
                      $image = $file->panel()->image($thumb);
                      $uuid  = $file->filename();
                      $data[] = array(
                          'filename' => $file->filename(),
                          'text'     => $file->filename(),
                          'link'     => $file->panel()->url(true),
                          'id'       => $file->id(),
                          'uuid'     => $uuid,
                          'url'      => $file->url(),
                          'info'     => false,
                          'image'    => $image,
                          'icon'     => $file->panel()->image($image),
                          'type'     => $file->type(),
                      );
                  }

                  return $data;
              }
          ),
      array(
            'pattern' => 'color-palette/extract-image-colors',
            'method'  => 'GET',
            'action'  => function() {
                $filename = get('filename');
                $uri      = get('uri');
                $limit    = get('limit');
                $page     = kirby()->page($uri);
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
