<?php 
namespace GGuney\Brush;

class Image{
	protected $width;
	protected $height;
	protected $path;

	public function __construct($path)
	{
		$this->path = $path;
		$this->setWidth();
		$this->setHeight();
	}
    /**
     * Gets the value of path.
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the value of path.
     *
     * @param mixed $path the path
     *
     * @return self
     */
    protected function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets the value of width.
     *
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets the value of width.
     *
     * @param mixed $width the width
     *
     * @return self
     */
    protected function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Gets the value of height.
     *
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets the value of height.
     *
     * @param mixed $height the height
     *
     * @return self
     */
    protected function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }
}
