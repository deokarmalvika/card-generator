<?php
/**
 * Date: 11.10.16
 * Time: 13:40
 */

namespace NewInventor\CardGenerator;


use NewInventor\CardGenerator\Base\Color;
use NewInventor\CardGenerator\Base\Size;
use NewInventor\ConfigTool\Config;
use NewInventor\CardGenerator\Elements\ApplyToImage;
use NewInventor\CardGenerator\Elements\Border;
use NewInventor\CardGenerator\Elements\CardObject;
use NewInventor\CardGenerator\Elements\CsvInterface;
use NewInventor\CardGenerator\Elements\Image;
use NewInventor\CardGenerator\Elements\Rectangle;
use NewInventor\CardGenerator\Elements\Text;

class Card
{
    protected $size;
    protected $visualBlocks;

    protected $image = null;

    protected static $availBlockTypes = ['border', 'image', 'rectangle', 'text'];

    /**
     * Card constructor.
     *
     * @param int    $width
     * @param int    $height
     * @param array  $visualBlocks
     */
    public function __construct($width, $height, array $visualBlocks)
    {
        $this->size = new Size((int)$width, (int)$height);
        $this->initBlankImage();
        foreach ($visualBlocks as $blockData) {
            if(is_a($blockData, CardObject::class)){
                $this->visualBlocks[] = $blockData;
                continue;
            }
            if($blockData['block-type'] === 'border'){
                $this->visualBlocks[] = Border::make()
                    ->width($blockData['width'])
                    ->size($blockData['w'], $blockData['h'])
                    ->position($blockData['x'], $blockData['y'])
                    ->color(new Color(explode(' ', $blockData['color'])));
            }elseif ($blockData['block-type'] === 'image'){
                $this->visualBlocks[] = Image::make()
                    ->size($blockData['w'], $blockData['h'])
                    ->position($blockData['x'], $blockData['y'])
                    ->path($blockData['path'])
                    ->type($blockData['type'])
                    ->opacity($blockData['opacity']);
            }elseif ($blockData['block-type'] === 'rectangle'){
                $this->visualBlocks[] = Rectangle::make()
                    ->size($blockData['w'], $blockData['h'])
                    ->position($blockData['x'], $blockData['y'])
                    ->color(new Color(explode(' ', $blockData['color'])));
            }elseif ($blockData['block-type'] === 'text'){
                $this->visualBlocks[] = Text::make()
                    ->position($blockData['x'], $blockData['y'])
                    ->text($blockData['text'])
                    ->font($blockData['font'])
                    ->fontSize($blockData['font-size'])
                    ->angle($blockData['angle'])
                    ->color(new Color(explode(' ', $blockData['color'])));
            }

        }
    }

    public function render($folder = '')
    {
        /** @var ApplyToImage $block */
        foreach ($this->visualBlocks as $block) {
            $block->putOnImage($this->image);
        }
        $baseUrl = Config::get('main.basePath', $_SERVER['DOCUMENT_ROOT']);
        if(!@mkdir($baseUrl . '/ready/' . $folder) && !is_dir($baseUrl . '/ready/' . $folder)){
            throw new \Exception('no folder');
        }
        $path = '/ready/' . $folder .'result_' . time() . '_' . mt_rand() . '.png';
        imagepng($this->image, $baseUrl . $path, 9);
        imagedestroy($this->image);

        return Config::get('main.baseUrl') . $path;
    }

    protected function initBlankImage()
    {
        $this->image = imagecreatetruecolor($this->size->w(), $this->size->h());
        $white = new Color([255, 255, 255, 0]);
        imagefilledrectangle($this->image, 0, 0, $this->size->w(), $this->size->h(), $white->allocateColor($this->image));
    }

    public function toCsv($showNames = true)
    {
        $path = '/ready/result_' . time() . '_' . mt_rand() . '.csv';
        $f = fopen(Config::get('main.basePath', $_SERVER['DOCUMENT_ROOT']) . $path, 'w');
        if($showNames) {
            fputcsv($f, Card::getParamNames(), ';');
        }
        fputcsv($f, [$this->size->w(), $this->size->h()], ';');
        /** @var CsvInterface $block */
        foreach ($this->visualBlocks as $block) {
            if($showNames) {
                fputcsv($f, $block->getParamNames(), ';');
            }
            fputcsv($f, $block->toCsvArray(), ';');
        }
        fclose($f);

        return Config::get('main.baseUrl') . $path;
    }

    public static function getParamNames()
    {
        return [
            'Ширина',
            'Высота',
        ];
    }

    /**
     * @param array $data
     * @param string $zipPath
     *
     * @return Card
     */
    public static function fromCsv(array $data, $zipPath)
    {
        if($data === []){
            return new Card(0, 0, []);
        }
        $cardWidth = 0;
        $cardHeight = 0;
        $blocks = [];
        foreach($data as $key => $row){
            if((int)$row[0] === 0 && !in_array($row[0], self::$availBlockTypes, true)){
                continue;
            }
            if($cardWidth === 0 || $cardHeight === 0){
                list($cardWidth, $cardHeight) = $row;
                continue;
            }
            if($row[0] === 'rectangle'){
                $blocks[] = Rectangle::fromCsv($row);
            }elseif($row[0] === 'image'){
                $blocks[] = Image::fromCsv($row, $zipPath);
            }elseif($row[0] === 'border'){
                $blocks[] = Border::fromCsv($row);
            }elseif($row[0] === 'text'){
                $blocks[] = Text::fromCsv($row, $zipPath);
            }
        }

        return new Card($cardWidth, $cardHeight, $blocks);
    }
}