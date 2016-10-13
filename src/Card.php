<?php
/**
 * Date: 11.10.16
 * Time: 13:40
 */

namespace CardGenerator;


use CardGenerator\Base\Color;
use CardGenerator\Base\Size;
use CardGenerator\Elements\ApplyToImage;
use CardGenerator\Elements\Border;
use CardGenerator\Elements\CsvInterface;
use CardGenerator\Elements\Image;
use CardGenerator\Elements\Rectangle;
use CardGenerator\Elements\Text;

class Card
{
    protected $path;
    protected $size;
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
        $this->size = new Size((int)$width, (int)$height);
        $this->initBlankImage();
        foreach ($visualBlocks as $blockData) {
            if($blockData['type'] === 'border'){
                $this->visualBlocks[] = Border::make()
                    ->width($blockData['width'])
                    ->size($blockData['w'], $blockData['h'])
                    ->position($blockData['x'], $blockData['y'])
                    ->color(new Color(explode(' ', $blockData['color'])));
            }elseif ($blockData['type'] === 'image'){
                $this->visualBlocks[] = Image::make()
                    ->size($blockData['w'], $blockData['h'])
                    ->position($blockData['x'], $blockData['y'])
                    ->path($blockData['path'])
                    ->type($blockData['type'])
                    ->opacity($blockData['opacity']);
            }elseif ($blockData['type'] === 'rectangle'){
                $this->visualBlocks[] = Rectangle::make()
                    ->size($blockData['w'], $blockData['h'])
                    ->position($blockData['x'], $blockData['y'])
                    ->color(new Color(explode(' ', $blockData['color'])));
            }elseif ($blockData['type'] === 'text'){
                $this->visualBlocks[] = Text::make()
                    ->position($blockData['x'], $blockData['y'])
                    ->text($blockData['text'])
                    ->font($blockData['font'])
                    ->fontSize($blockData['fontSize'])
                    ->angle($blockData['angle'])
                    ->color(new Color(explode(' ', $blockData['color'])));
            }

        }
    }

    public function render()
    {
        /** @var ApplyToImage $block */
        foreach ($this->visualBlocks as $block) {
            $block->putOnImage($this->image);
        }
        imagepng($this->image, $this->path, 9);
        imagedestroy($this->image);
    }

    protected function initBlankImage()
    {
        $this->image = imagecreatetruecolor($this->size->w(), $this->size->h());
        $white = new Color([255, 255, 255, 0]);
        imagefilledrectangle($this->image, 0, 0, $this->size->w(), $this->size->h(), $white->allocateColor($this->image));
    }

    public function toCsv()
    {
        $f = fopen('res.csv', 'w');
        fputcsv($f, Card::getParamNames(), ';');
        fputcsv($f, [$this->size->w(), $this->size->h()], ';');
        /** @var CsvInterface $block */
        foreach ($this->visualBlocks as $block) {
            fputcsv($f, $block->getParamNames(), ';');
            fputcsv($f, $block->toCsvArray(), ';');
        }
        fclose($f);
    }

    public static function getParamNames()
    {
        return [
            'Ширина',
            'Высота',
        ];
    }
}