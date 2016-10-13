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
        ], $this->position->toArray(), $this->size->toArray(), $this->color->toArray());
    }

    /**
     * @param array $data
     *
     * @return Border
     */
    public static function fromCsv(array $data = [])
    {
        $border = Border::make();
        if(array_shift($data) !== 'border'){
            return $border;
        }
        $border
            ->width(array_shift($data))
            ->position(array_shift($data), array_shift($data))
            ->size(array_shift($data), array_shift($data))
            ->color(new Color($data));
        return $border;
    }
}