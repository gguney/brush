<?php 
namespace Brush\Contracts;

interface BrushContract{

	/**
	 * Make an image with given config.
	 * 
	 * @param  string $path 
	 * 
	 * @return Brush
	 */
	public static function make($path)
}