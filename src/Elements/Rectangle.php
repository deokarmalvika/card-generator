<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 15:54
 */

namespace CardGenerator\Elements;


use CardGenerator\Base\Color;
use CardGenerator\Base\Position;
use CardGenerator\Base\Size;
use CardGenerator\Colorable;

class Rectangle extends CardObject implements Arrayable, CsvInterface, ApplyToImage, CardObjectInterface
{
    use Colorable;

    /**
     * Border constructor.
     */
    public function __construct()
    {
        parent::__construct(new Position(0, 0), new Size(0, 0));
        $this->color(new Color());
    }

    public static function make()
    {
        return new static();
    }

    /**
     * @param resource $image
     */
    public function putOnImage($image)
    {
        $color = $this->getColor()->allocateColor($image);
        if ($color !== false) {
            imagefilledrectangle(
                $image,
                $this->position->x(),
                $this->position->y(),
                $this->position->x() + $this->size->w(),
                $this->position->y() + $this->size->h(),
                $color
            );
        }
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'color' => $this->getColor()->toArray()
        ]);
    }


    public function getParamNames()
    {
        return [
            'Тип блока',
            'Позиция (X)',
            'Позиция (Y)',
            'Ширина',
            'Высота',
            'Цвет (красный)',
            'Цвет (зеленый)',
            'Цвет (синий)',
            'Цвет (прозрачность)',
        ];
    }

    public function toCsvArray()
    {
        return array_merge([
            'rectangle',
        ], $this->position, $this->size->toArray(), $this->color->toArray());
    }
}