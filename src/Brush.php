<?php
namespace GGuney\Brush;

use GGuney\Brush\Contracts\BrushContract;

class Brush implements BrushContract
{

    protected $fileName;
    protected $image;
    protected $tmpImage;
    protected $type;
    protected $width;
    protected $height;

    /**
     * Brush constructor.
     *
     * @param $path
     * @return void
     */
    public function __construct($path)
    {
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
        $this->tmpImage = imagecreatetruecolor($this->width , $this->height);
        imagecopyresized($this->tmpImage, $this->image, 0, 0, 0, 0, $this->width , $this->height, $this->width, $this->height);
    }

    /**
     * Clear the tmp image
     *
     * @return void
     */
    public function clear()
    {
        imagedestroy($this->tmpImage);
    }

    /**
     * Make an image with given config.
     *
     * @param  string $path
     *
     * @return Brush
     */
    public static function make($path)
    {
        return new Brush($path);
    }

    /**
     * Put watermark to image.
     *
     * @return void
     */
    public function mark()
    {
        if (config('brush.put_watermark')) {
            $watermark = imagecreatefrompng((config('brush.watermark_path')));
            $watermarkWidth = imagesx($watermark);
            $watermarkHeight = imagesy($watermark);

            $tmpX = imagesx($this->tmpImage) - 100;
            $watermarkRatio = $watermarkHeight / $watermarkWidth;
            //$tmpY = imagesy($this->tmpImage);
            $tmpY = $watermarkRatio * $tmpX;
            $yLocation = (imagesy($this->tmpImage) - $tmpY) / 2;
            $tmpWatermark = imagecreatetruecolor($tmpX, $tmpY);
            imagealphablending($tmpWatermark, false);
            imagesavealpha($tmpWatermark, true);
            $transparent = imagecolorallocatealpha($tmpWatermark, 255, 255, 255, 127);
            imagefilledrectangle($tmpWatermark, 0, 0, $tmpX, $tmpY, $transparent);
            imagecopyresampled($tmpWatermark, $watermark, 0, 0, 0, 0, $tmpX, $tmpY, $watermarkWidth, $watermarkHeight);
            imagecopy($this->tmpImage, $tmpWatermark, 50, $yLocation, 0, 0, $tmpX, $tmpY);
            imagedestroy($tmpWatermark);

            return $this;
        } else {
            return $this;
        }
    }

    /**
     * Resize the image.
     *
     * @return void
     */
    public function resize()
    {
        $newwidth = $this->width * 1;
        $newheight = $this->height * 1;
        if (config('brush.do_resize')) {
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
    public function changeQuality($quality)
    {
        $this->putHeader();
        if($quality != null){
            imagejpeg($this->tmpImage, $this->fileName, $quality);
        }else if (config('brush.change_quality')) {
            imagejpeg($this->tmpImage, $this->fileName, config('brush.quality'));
        }
        return $this;
    }

    /**
     * Put image header.
     *
     * @return void
     */
    public function putHeader()
    {
        header("Content-type: " . $this->type);
    }

    /**
     * Magic method
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([get_called_class(), $method], $args);
    }

    /**
     * Magic static method
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return call_user_func_array([get_called_class(), $method], $args);
    }
}