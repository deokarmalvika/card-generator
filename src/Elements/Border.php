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

class Border extends CardObject implements Arrayable, CsvInterface, ApplyToImage, CardObjectInterface
{
    use Colorable;
    protected $width = 0;

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
     * @param int $width
     *
     * @return $this
     */
    public function width($width = 0)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param resource $image
     */
    public function putOnImage($image)
    {
        $color = $this->getColor()->allocateColor($image);
        if ($this->width !== 0 && $color !== false) {
            for ($i = 0; $i < $this->width; $i++) {
                imagerectangle(
                    $image,
                    $this->position->x() + $i,
                    $this->position->y() + $i,
                    $this->position->x() + $this->size->w() - $i,
                    $this->position->y() + $this->size->h() - $i,
                    $color
                );
            }
        }
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'width' => $this->width,
            'color' => $this->getColor()->toArray()
        ]);
    }

    public function getParamNames()
    {
        return [
            'Тип блока',
            'Толщина',
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
            'border',
            $this->width
        ], $this->position, $this->size->toArray(), $this->color->toArray());
    }
}