<?php
namespace Brush;

class Brush{

	/**
	 * Make an image with given config.
	 * 
	 * @param  string $path 
	 * 
	 * @return Brush
	 */
	public static function make($path){

	    $fileName = $path;
	    $percent = config('brush.size_ratio');

	    // Content type
	    // 
	    //header('Content-Type: image/jpeg');

	    // Get new sizes
	    list($width, $height) = getimagesize($fileName);
	    $newwidth = $width * $percent;
	    $newheight = $height * $percent;

	    // Load
	    $thumb = imagecreatetruecolor($newwidth, $newheight);
	    $source = imagecreatefromjpeg($fileName);
	    $stamp = imagecreatefrompng((config('brush.watermark_path')));

	    // Set the margins for the stamp and get the height/width of the stamp image
	    $marge_right = 10;
	    $marge_bottom = 10;
	    $sx = imagesx($stamp);
	    $sy = imagesy($stamp);

	    // Copy the stamp image onto our photo using the margin offsets and the photo 
	    // width to calculate positioning of the stamp. 
	    imagecopy($source, $stamp, imagesx($source) - $sx - $marge_right, imagesy($source) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

	    /*    */
	    // File and new size
	    // Resize
	    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	    // Output
	    header("Content-type: image/jpeg"); 
	    imagejpeg($thumb, $fileName, config('brush.reduce_rate'));
	    imagedestroy($thumb);
	    return $this;
	}

}