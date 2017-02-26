<?php
namespace Brush;

use Brush\Contracts\BrushContract;

class Brush implements BrushContract{

	/**
	 * Make an image with given config.
	 * 
	 * @param  string $path 
	 * 
	 * @return Brush
	 */
	public static function make($path){
	    $fileName = $path;
	    $image = imagecreatefromjpeg($fileName);
		self::resize($image, $fileName);
	    self::mark($tmpImage);
	    self::putHeader();
	    self::changeQuality($tmpImage, $fileName);
	    imagedestroy($tmpImage);
	}

	/**
	 * Put watermark to image.
	 * 
	 * @param  gdImage $tmpImage 
	 * 
	 * @return void
	 */
	public static function mark($tmpImage)
	{
		if(config('brush.put_watermark'))
	    {
			$watermark = imagecreatefrompng((config('brush.watermark_path')));
			$watermarkWidth = imagesx($watermark);
			$watermarkHeight = imagesy($watermark);
			imagecopy($tmpImage, $watermark, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight);
		}
	}

	/**
	 * Resize the image.
	 * 
	 * @param  gdImage $image 
	 * 
	 * @return void
	 */
	public static function resize($image, $fileName)
	{
		list($width, $height) = getimagesize($fileName);
	   	if(config('brush.do_resize')){
	   		$percent = config('brush.size_ratio');
	   		$newwidth = $width * $percent;
	    	$newheight = $height * $percent;
	   	}
	    else{
	   		$newwidth = $width * 1;
	    	$newheight = $height * 1;
	    }

    	$tmpImage = imagecreatetruecolor($newwidth, $newheight);
    	imagecopyresized($tmpImage, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	}

	/**
	 * Change quality of the image.
	 * 
	 * @return void
	 */
	public static function changeQuality()
	{
		if(config('brush.change_quality'))
	    	imagejpeg($tmpImage, $fileName, config('brush.quality'));
	    else
	    	imagejpeg($tmpImage, $fileName, 100);
	}

	/**
	 * Put image header.
	 * 
	 * @return void
	 */
	public static function putHeader()
	{
		header("Content-type: image/jpeg"); 
	}
}