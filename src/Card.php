<?php
/**
 * Date: 11.10.16
 * Time: 13:40
 */

namespace CardGenerator;


class Card
{
    protected $path;
    protected $width;
    protected $height;
    protected $visualBlocks;

    protected $image = null;

    /**
     * Card constructor.
     *
     * @param string $path
     * @param int    $width
     * @param int    $height
     * @param array  $visualBlocks
     */
    public function __construct($path, $width, $height, array $visualBlocks)
    {
        $this->path = $path;
        $this->visualBlocks = $visualBlocks;
        $this->width = (int)$width;
        $this->height = (int)$height;
        $this->image = imagecreatetruecolor($this->width, $this->height);
        $this->initBlankImage();
    }

    public function render()
    {
        /** @var VisualBlock $block */
        foreach($this->visualBlocks as $blockData){
            $block = new VisualBlock($this->image, $blockData);
            $block->setOnImage();
        }
        imagepng($this->image, $this->path, 9);
        imagedestroy($this->image);
    }

    protected function initBlankImage()
    {
        $this->image = imagecreatetruecolor($this->width, $this->height);
        $white = GdHelper::colorFromArray($this->image, [255, 255, 255, 0]);
        imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $white);
    }
}