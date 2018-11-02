<?php

namespace SylvainJule;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor as Extractor;
use League\ColorExtractor\Palette;

class ColorPalette {

	public static function extractColor($image, $limit = 10, $size = 400, $fallbackColor = '#ffffff') {
		$thumb     = $image->resize($size);
		$url       = $thumb->url();
		$palette   = Palette::fromFilename($url, Color::fromHexToInt($fallbackColor));
		$extractor = new Extractor($palette);
		$colors    = $extractor->extract($limit);

		$toHex = function($value) {
			return Color::fromIntToHex($value);
		};
		$colors    = array_map($toHex, $colors);
		return $colors;
	}

    private static $cache = null;

    private static function cache(): \Kirby\Cache\Cache {
        if(!static::$cache) {
            static::$cache = kirby()->cache('sylvainjule.color-palette');
        }
        return static::$cache;
    }

    public static function getFilesIndex($force = false) {
        $index = $force ? null : static::cache()->get('files.index');
        if(!$index) {
        	$index = site()->index()->images();
            static::cache()->set('files.index', $index, 15);
        }
        return $index;
    }

}