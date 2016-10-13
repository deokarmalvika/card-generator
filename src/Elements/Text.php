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

class Text extends CardObject implements Arrayable, CsvInterface, ApplyToImage, CardObjectInterface
{
    use Colorable;
    protected $text = '';
    protected $font = '';
    protected $fontSize = 12;
    protected $angle = 0;

    /**
     * Text constructor.
     */
    public function __construct()
    {
        parent::__construct(new Position(0, 0), new Size(0, 0));
        $this->color(new Color([0, 0, 0, 0]));
    }

    public static function make()
    {
        return new static();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param string $font
     *
     * @return $this
     */
    public function font($font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * @return int
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * @param int $fontSize
     *
     * @return $this
     */
    public function fontSize($fontSize)
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * @param $angle
     *
     * @return $this
     */
    public function angle($angle)
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * @param resource $image
     */
    public function putOnImage($image)
    {
        $color = $this->color->allocateColor($image);
        if ($color !== false && $this->text !== '' && $this->font !== '' && $this->fontSize > 0) {
            imagettftext(
                $image,
                $this->fontSize,
                $this->angle,
                $this->position->x(),
                $this->position->y(),
                $color,
                $this->font,
                $this->text
            );
        }
    }

    public function toArray()
    {
        return [
            'color' => $this->color->toArray(),
            'text' => $this->text,
            'font' => $this->font,
            'fontSize' => $this->fontSize,
            'angle' => $this->angle,
            'position' => $this->position->toArray()
        ];
    }

    public function getParamNames()
    {
        return [
            'Тип блока',
            'Текст',
            'Шрифт',
            'Размер шрифта',
            'Угол наклона',
            'Позиция (X)',
            'Позиция (Y)',
            'Цвет (красный)',
            'Цвет (зеленый)',
            'Цвет (синий)',
            'Цвет (прозрачность)',
        ];
    }

    public function toCsvArray()
    {
        return array_merge([
            'text',
            $this->text,
            $this->font,
            $this->fontSize,
            $this->angle,
        ], $this->position, $this->color->toArray());
    }
}