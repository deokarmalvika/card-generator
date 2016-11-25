<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 18:33
 */

namespace NewInventor\CardGenerator\Helpers;


class HtmlHelper
{
    protected static $defaultImageData = [
        'block-type' => 'image',
        'image' => '',
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
        'line-height' => '',
        'align' => 'left',
        'baseline' => 'bottom',
        'direction' => 'ltr',
        'x' => '',
        'y' => '',
        'w' => '',
        'h' => '',
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

    public static function formGroup($name, $title, $value, $type)
    {
        return "<div class='form-group'>" .
        "<label for='$name'>$title</label>" .
        self::input($name, $value, $type) .
        '</div>';
    }

    public static function input($name, $value, $type)
    {
        return "<input type='{$type}' id='$name' class='form-control' name='$name' value='$value'/>";
    }

    public static function textareaFormGroup($name, $title, $value)
    {
        return "<div class='form-group'>" .
        "<label for='$name'>$title</label>" .
        self::textarea($name, $value) .
        '</div>';
    }

    public static function textarea($name, $value)
    {
        return "<textarea id='{$name}' name='{$name}' class='form-control'>{$value}</textarea>";
    }

    public static function selectFormGroup($name, $title, $options, $value)
    {
        return "<div class='form-group'>" .
        "<label for='$name'>$title</label>" .
        self::select($name, $options, $value) .
        '</div>';
    }

    public static function select($name, array $options, $value)
    {
        $res = "<select id='$name' name='$name' class='form-control'>";
        foreach ($options as $id => $title) {
            $res .= "<option value='{$id}'";
            if ($value === $id) {
                $res .= " selected='selected'";
            }
            $res .= ">{$title}</option>";
        }
        $res .= '</select>';

        return $res;
    }

    public static function minusButton()
    {
        return "<button type='button' data-delete-object>-</button>";
    }

    public static function imageBlock(array $data = [])
    {
        $data = array_merge(self::$defaultImageData, $data);
        $res = "<form data-block-form='image' id='block-form' class='form'>";
        $res .= self::input('url', '%url%', 'hidden') .
            self::formGroup('save-dimensions', 'Сохранить пропорции', $data['image'], 'checkbox') .
            self::formGroup('x', 'X', $data['x'], 'text') .
            self::formGroup('y', 'Y', $data['y'], 'text') .
            self::formGroup('w', 'Ширина', $data['w'], 'text') .
            self::formGroup('h', 'Высота', $data['h'], 'text');
        $res .= '</form>';

        return $res;
    }

    public static function textBlock(array $data = [])
    {
        $data = array_merge(self::$defaultTextData, $data);
        $res = "<form data-block-form='text' id='block-form' class='form'>";
        $res .= self::input('font', '%font%', 'hidden') .
            self::textareaFormGroup('text', 'Текст', $data['text']) .
            self::formGroup('color', 'Цвет', $data['color'], 'text') .
            self::formGroup('x', 'X', $data['x'], 'text') .
            self::formGroup('y', 'Y', $data['y'], 'text') .
            self::formGroup('w', 'Ширина', $data['w'], 'text') .
            self::formGroup('font-size', 'Размер шрифта', $data['font-size'], 'text') .
            self::formGroup('line-height', 'Высота строки', $data['line-height'], 'text') .
            self::selectFormGroup('align', 'Выравнивание', [
                'start' => 'Начало',
                'end' => 'Конец',
                'left' => 'По левому краю',
                'center' => 'По середине',
                'right' => 'По Правому краю'
            ], $data['align']) .
            self::selectFormGroup('baseline', 'Базовая линия', [
                'top' => 'По верху',
                'hanging' => 'По основе',
                'middle' => 'По центру',
                'alphabetic' => 'По основе снизу',
                'ideographic' => 'Идеографично',
                'bottom' => 'По низу'
            ], $data['baseline']) .
            self::selectFormGroup('direction', 'Направление', [
                'ltr' => 'Слева направо',
                'rtl' => 'Справа налево',
                'inherit' => 'Унаследованное'
            ], $data['baseline']);
        $res .= '</div>';

        return $res;
    }

    public static function rectangleBlock(array $data = [])
    {
        $data = array_merge(self::$defaultRectangleData, $data);
        $res = "<form data-block-form='rectangle' id='block-form' class='form'>";
        $res .= self::formGroup('color', 'Цвет', $data['color'], 'text') .
            self::formGroup('x', 'X', $data['x'], 'text') .
            self::formGroup('y', 'Y', $data['y'], 'text') .
            self::formGroup('w', 'Ширина', $data['w'], 'text') .
            self::formGroup('h', 'Высота', $data['h'], 'text');
        $res .= '</form>';

        return $res;
    }

    public static function borderBlock(array $data = [])
    {
        $data = array_merge(self::$defaultBorderData, $data);
        $res = "<form data-block-form='border' id='block-form' class='form'>";
        $res .= self::formGroup('width', 'Толщина', $data['width'], 'text') .
            self::formGroup('color', 'Цвет', $data['color'], 'text') .
            self::formGroup('x', 'X', $data['x'], 'text') .
            self::formGroup('y', 'Y', $data['y'], 'text') .
            self::formGroup('w', 'Ширина', $data['w'], 'text') .
            self::formGroup('h', 'Высота', $data['h'], 'text');
        $res .= '</form>';

        return $res;
    }

    public static function fontPreviewBlock()
    {
        return "<tr data-font-preview='%fontName%' data-toggle='modal' data-target='#addBlock'><td>%fontName%</td><td style='font: 14px %fontName%;'>АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ<br>абвгдеёжзийклмнопрстуфхцчшщъыьэюя<br>ABCDEFGHIJKLMNOPQRSTUVWXYZ<br>abcdefghijklmnopqrstuvwxyz</td></tr>";
    }

    public static function imagePreviewBlock()
    {
        return "<tr data-image-preview='%url%' data-toggle='modal' data-target='#addBlock'><td><img src='%url%'/></td></tr>";
    }
}