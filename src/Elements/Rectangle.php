<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 15:54
 */

namespace NewInventor\CardGenerator\Elements;


use NewInventor\CardGenerator\Base\Color;
use NewInventor\CardGenerator\Base\Position;
use NewInventor\CardGenerator\Base\Size;
use NewInventor\CardGenerator\Colorable;

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
        ], $this->position->toArray(), $this->size->toArray(), $this->color->toArray());
    }

    /**
     * @param array $data
     *
     * @return Rectangle
     */
    public static function fromCsv(array $data = [])
    {
        $rectangle = Rectangle::make();
        if (array_shift($data) !== 'rectangle') {
            return $rectangle;
        }
        $rectangle
            ->position(array_shift($data), array_shift($data))
            ->size(array_shift($data), array_shift($data))
            ->color(new Color($data));
        return $rectangle;
    }
}