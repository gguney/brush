<?php
namespace Brush;

use Brush\Contracts\BrushContract;

class Brush implements BrushContract{

	protected $fileName;
	protected $image;
	protected $tmpImage;
	protected $type;
	protected $width;
	protected $height;

	public function __construct($path){
		$this->fileName = $path;
		$size = getimagesize($path); 
		$this->width = $size[0];
		$this->height = $size[1];
		$this->type = $size['mime'];
		switch ($this->type) {
			case 'image/png':
				$this->image = imagecreatefrompng($path);
				break;
			case 'image/jpeg':
				$this->image = imagecreatefromjpeg($path);
				break;			
			default:
				throw new Exception("Image type is not supported", 1);
				break;
		}
	}
	public function brush()
	{
		$this->putHeader();
		imagedestroy($this->tmpImage);
	}
	/**
	 * Make an image with given config.
	 * 
	 * @param  string $path 
	 * 
	 * @return Brush
	 */
	public static function make($path){
	    return new Brush($path);
	    /*
		$tmpImage = self::resize($image);
	    $tmpImage = self::mark($tmpImage);
	    $tmpImage = self::changeQuality($tmpImage);
	    imagedestroy($tmpImage);
	    **/
	}

	/**
	 * Put watermark to image.
	 * 
	 * @return void
	 */
	public function mark()
	{
		if(config('brush.put_watermark'))
	    {
			$watermark = imagecreatefrompng((config('brush.watermark_path')));
			$watermarkWidth = imagesx($watermark);
			$watermarkHeight = imagesy($watermark);
			imagecopy($this->tmpImage, $watermark, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight);
    		return $this;
		}
	}

	/**
	 * Resize the image.
	 * 
	 * @param  gdImage $image 
	 * 
	 * @return void
	 */
	public function resize()
	{
		$newwidth = $this->width * 1;
	   	$newheight = $this->height * 1;
	   	if(config('brush.do_resize')){
	   		$percent = config('brush.size_ratio');
	   		$newwidth = imagesx($this->image) * $percent;
	    	$newheight = imagesy($this->image) * $percent;
	   	}
    	$this->tmpImage = imagecreatetruecolor($newwidth, $newheight);
    	imagecopyresized($this->tmpImage, $this->image, 0, 0, 0, 0, $newwidth, $newheight, $this->width, $this->height);
    	return $this;
	}

	/**
	 * Change quality of the image.
	 * 
	 * @return void
	 */
	public function changeQuality()
	{
		if(config('brush.change_quality'))
	    	imagejpeg($this->tmpImage, $this->fileName, config('brush.quality'));
	    else
	    	imagejpeg($this->tmpImage, $this->fileName, 100);
	    return $this;
	}

	/**
	 * Put image header.
	 * 
	 * @return void
	 */
	public function putHeader()
	{
		header("Content-type: ".$this->type); 
	}

    public function __call($method, $args)
    {
        return call_user_func_array(
                    array(get_called_class(), $method),
                    $args
                );
    }

    /**  PHP 5.3.0 ve sonrası  */
    public function __callStatic($method, $args)
    {
        return call_user_func_array(
                    array(get_called_class(), $method),
                    $args
                );
    }
}