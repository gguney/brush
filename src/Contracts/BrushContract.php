<?php
namespace GGuney\Brush\Contracts;

interface BrushContract{

	public function __construct($path);

	/**
	 * @return void
	 */
	public function clear();

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
	 * @return Brush
	 */
	
	public function mark();


	/**
	 * Resize the image.
	 * 
	 * @return Brush
	 */
	public function resize();


	/**
	 * Change quality of the image.
	 * 
	 * @return Brush
	 */
	public function changeQuality($quality);


	/**
	 * Put image header.
	 * 
	 * @return void
	 */
	public function putHeader();


    public function __call($method, $args);

    /**  PHP 5.3.0 ve sonrası  */
    public static function __callStatic($method, $args);
}