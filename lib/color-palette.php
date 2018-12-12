<?php

namespace SylvainJule;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor as Extractor;
use League\ColorExtractor\Palette;

class ColorPalette {

	public static function extractColor($image, $limit = 10, $size = 400, $fallbackColor = '#ffffff') {
		$thumb     = $image->resize($size)->save();
		$root      = $thumb->root();
		$palette   = Palette::fromFilename($root, Color::fromHexToInt($fallbackColor));
		$extractor = new Extractor($palette);
		$colors    = $extractor->extract($limit);

		$toHex = function($value) {
			return Color::fromIntToHex($value);
		};
		$colors    = array_map($toHex, $colors);
		return $colors;
	}

}