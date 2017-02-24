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
	public static function make($path);

	/**
	 * Put watermark to image.
	 * 
	 * @param  gdImage $tmpImage 
	 * 
	 * @return void
	 */
	public static function mark($tmpImage);

	/**
	 * Resize the image.
	 * 
	 * @param  gdImage $image 
	 * 
	 * @return void
	 */
	public static function resize($image);

	/**
	 * Change quality of the image.
	 * 
	 * @return void
	 */
	public static function changeQuality();

	/**
	 * Put image header.
	 * 
	 * @return void
	 */
	public static function putHeader();
}