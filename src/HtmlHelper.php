<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 18:33
 */

namespace NewInventor\CardGenerator;


class HtmlHelper
{
    protected static $defaultImageData = [
        'block-type' => 'image',
        'image' => '',
        'opacity' => '',
        'x' => '',
        'y' => '',
        'w' => '',
        'h' => '',
    ];

    protected static $defaultTextData = [
        'block-type' => 'text',
        'text' => '',
        'color' => '',
        'font' => '',
        'font-size' => '',
        'angle' => '',
        'x' => '',
        'y' => '',
    ];

    protected static $defaultRectangleData = [
        'block-type' => 'rectangle',
        'color' => '',
        'x' => '',
        'y' => '',
        'w' => '',
        'h' => '',
    ];

    protected static $defaultBorderData = [
        'block-type' => 'border',
        'width' => '0',
        'color' => '',
        'x' => '',
        'y' => '',
        'w' => '',
        'h' => '',
    ];

    public static function formGroup($name, $title, $value, $type, $id){
        return "<div class='form-group'>" .
        "<label for='$name-$id'>$title</label>" .
        self::input($name, $value, $type, $id) .
        '</div>';
    }

    public static function input($name, $value, $type, $id){
        return "<input type='$type' id='$name-$id' name='blocks[$id][$name]' value='$value'/>";
    }

    public static function minusButton()
    {
        return "<button type='button' data-delete-object>-</button>";
    }
    
    public static function imageBlock($id = '%', array $data = []){
        $data = array_merge(self::$defaultImageData, $data);
        $res = "<div data-object-group='$id'><h3>Картинка</h3>" . self::minusButton();
        $res .= self::input('block-type', $data['block-type'], 'hidden', $id) .
            self::formGroup('image', 'Картинка', $data['image'], 'file', $id) .
            self::formGroup('opacity', 'Прозрачность', $data['opacity'], 'text', $id) .
            self::formGroup('x', 'X', $data['x'], 'text', $id) .
            self::formGroup('y', 'Y', $data['y'], 'text', $id) .
            self::formGroup('w', 'W', $data['w'], 'text', $id) .
            self::formGroup('h', 'H', $data['h'], 'text', $id);
        $res .= '</div>';

        return $res;
    }

    public static function textBlock($id = '%', array $data = [])
    {
        $data = array_merge(self::$defaultTextData, $data);
        $res = "<div data-object-group='$id'><h3>Текст</h3>" . self::minusButton();
        $res .= self::input('block-type', $data['block-type'], 'hidden', $id) .
            self::formGroup('text', 'Текст', $data['text'], 'text', $id) .
            self::formGroup('color', 'Цвет', $data['color'], 'text', $id) .
            self::formGroup('font', 'Шрифт', $data['font'], 'text', $id) .
            self::formGroup('font-size', 'Размер шрифта', $data['font-size'], 'text', $id) .
            self::formGroup('angle', 'Угол поворота', $data['angle'], 'text', $id) .
            self::formGroup('x', 'X', $data['x'], 'text', $id) .
            self::formGroup('y', 'Y', $data['y'], 'text', $id);
        $res .= '</div>';

        return $res;
    }

    public static function rectangleBlock($id = '%', array $data = [])
    {
        $data = array_merge(self::$defaultRectangleData, $data);
        $res = "<div data-object-group='$id'><h3>Прямоугольник</h3>" . self::minusButton();
        $res .= self::input('block-type', $data['block-type'], 'hidden', $id) .
            self::formGroup('color', 'Цвет', $data['color'], 'text', $id) .
            self::formGroup('x', 'X', $data['x'], 'text', $id) .
            self::formGroup('y', 'Y', $data['y'], 'text', $id) .
            self::formGroup('w', 'W', $data['w'], 'text', $id) .
            self::formGroup('h', 'H', $data['h'], 'text', $id);
        $res .= '</div>';

        return $res;
    }

    public static function borderBlock($id = '%', array $data = [])
    {
        $data = array_merge(self::$defaultBorderData, $data);
        $res = "<div data-object-group='$id'><h3>Рамка</h3>" . self::minusButton();
        $res .= self::input('block-type', $data['block-type'], 'hidden', $id) .
            self::formGroup('width', 'Толщина', $data['width'], 'text', $id) .
            self::formGroup('color', 'Цвет', $data['color'], 'text', $id) .
            self::formGroup('x', 'X', $data['x'], 'text', $id) .
            self::formGroup('y', 'Y', $data['y'], 'text', $id) .
            self::formGroup('w', 'W', $data['w'], 'text', $id) .
            self::formGroup('h', 'H', $data['h'], 'text', $id);
        $res .= '</div>';

        return $res;
    }
}